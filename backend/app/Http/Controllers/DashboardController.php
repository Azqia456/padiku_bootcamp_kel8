<?php

namespace App\Http\Controllers;

use App\Models\FertilizerSchedule;
use App\Models\Notification;
use App\Models\Planting;
use App\Models\PestReport;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics for Karawang monitoring
        $totalPlantings = Planting::count();
        $totalArea = Planting::sum('area_hectares') ?? 0;
        $totalPestReports = PestReport::count();
        $activePestReports = PestReport::where('status', '!=', 'resolved')->count();
        $totalFarmers = User::where('user_type', 'petani')->count();
        
        // Get plantings by district for map
        $plantingsByDistrict = Planting::selectRaw('users.district, COUNT(*) as count, SUM(plantings.area_hectares) as total_area')
            ->join('users', 'plantings.user_id', '=', 'users.id')
            ->groupBy('users.district')
            ->get();
        
        // Get recent pest reports
        $recentPestReports = PestReport::with(['user', 'planting'])
            ->orderBy('report_date', 'desc')
            ->take(10)
            ->get();
        
        // Get production statistics by status
        $productionByStatus = Planting::selectRaw('status, COUNT(*) as count, SUM(area_hectares) as total_area')
            ->groupBy('status')
            ->get();
        
        return view('dashboard.index', compact(
            'totalPlantings',
            'totalArea',
            'totalPestReports',
            'activePestReports',
            'totalFarmers',
            'plantingsByDistrict',
            'recentPestReports',
            'productionByStatus'
        ));
    }
    
    public function map()
    {
        $plantings = Planting::with('user')->get();
        
        // Get planting data grouped by district for Karawang - for the interactive map
        $plantingData = Planting::selectRaw('
                users.district,
                COUNT(*) as total_plantings,
                SUM(area_hectares) as total_area,
                SUM(CASE WHEN status = "planted" THEN 1 ELSE 0 END) as planted_count,
                SUM(CASE WHEN status = "growing" THEN 1 ELSE 0 END) as growing_count,
                SUM(CASE WHEN status = "harvested" THEN 1 ELSE 0 END) as harvested_count,
                MIN(planting_date) as first_planting,
                MAX(expected_harvest_date) as last_harvest
            ')
            ->join('users', 'plantings.user_id', '=', 'users.id')
            ->where('users.district', 'like', '%Karawang%')
            ->groupBy('users.district')
            ->get();

        // Calculate dominant phase and additional data for each district
        foreach ($plantingData as $data) {
            $total = $data->total_plantings;
            if ($total > 0) {
                $plantedPct = ($data->planted_count / $total) * 100;
                $growingPct = ($data->growing_count / $total) * 100;
                $harvestedPct = ($data->harvested_count / $total) * 100;

                // Determine dominant phase
                if ($plantedPct >= 50) {
                    $data->dominant_phase = 'planted';
                    $data->phase_label = 'Baru Tanam';
                } elseif ($growingPct >= 50) {
                    $data->dominant_phase = 'growing';
                    $data->phase_label = 'Masa Pertumbuhan';
                } elseif ($harvestedPct >= 50) {
                    $data->dominant_phase = 'harvested';
                    $data->phase_label = 'Selesai Panen';
                } else {
                    // Mixed phase - check if ready to harvest (near expected harvest date)
                    $nearHarvest = Planting::whereHas('user', function($q) use ($data) {
                        $q->where('district', $data->district);
                    })->where('expected_harvest_date', '<=', now()->addDays(7))
                    ->where('expected_harvest_date', '>=', now())
                    ->count();
                    
                    if ($nearHarvest > 0) {
                        $data->dominant_phase = 'ready';
                        $data->phase_label = 'Siap Panen';
                    } else {
                        $data->dominant_phase = 'growing';
                        $data->phase_label = 'Masa Pertumbuhan';
                    }
                }
            } else {
                $data->dominant_phase = 'planted';
                $data->phase_label = 'Baru Tanam';
            }

            // Get most common rice variety
            $data->common_variety = Planting::selectRaw('rice_variety, COUNT(*) as count')
                ->whereHas('user', function($q) use ($data) {
                    $q->where('district', $data->district);
                })
                ->groupBy('rice_variety')
                ->orderByDesc('count')
                ->first();

            // Calculate average plant age
            $plantings = Planting::whereHas('user', function($q) use ($data) {
                $q->where('district', $data->district);
            })->get();

            $totalAge = 0;
            $count = 0;
            foreach ($plantings as $planting) {
                if ($planting->planting_date) {
                    $totalAge += $planting->planting_date->diffInDays(now());
                    $count++;
                }
            }
            $data->avg_age_days = $count > 0 ? round($totalAge / $count) : 0;
            $data->avg_age_months = round($data->avg_age_days / 30);

            // Estimate harvest (5 tons per hectare average)
            $data->estimated_yield = $data->total_area * 5;
        }
        
        return view('dashboard.map', compact('plantings', 'plantingData'));
    }
    
    public function statistics()
    {
        $monthlyProduction = Planting::selectRaw('YEAR(planting_date) as year, MONTH(planting_date) as month, COUNT(*) as count, SUM(area_hectares) as total_area')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();
        
        $pestReportTrends = PestReport::selectRaw('YEAR(report_date) as year, MONTH(report_date) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();
        
        return view('dashboard.statistics', compact('monthlyProduction', 'pestReportTrends'));
    }
    
    public function foodBalance()
    {
        // Calculate food balance based on production
        $totalProduction = (Planting::where('status', 'harvested')->sum('area_hectares') ?? 0) * 5; // Assuming 5 tons per hectare
        $totalConsumption = User::where('user_type', 'petani')->count() * 0.3; // Assuming 0.3 tons per person per year
        $balance = $totalProduction - $totalConsumption;
        
        return view('dashboard.food-balance', compact('totalProduction', 'totalConsumption', 'balance'));
    }
    
    public function dataAnalysis()
    {
        $pestTypes = PestReport::selectRaw('pest_type, COUNT(*) as count')
            ->groupBy('pest_type')
            ->orderBy('count', 'desc')
            ->get();
        
        $severityDistribution = PestReport::selectRaw('severity, COUNT(*) as count')
            ->groupBy('severity')
            ->get();
        
        $riceVarieties = Planting::selectRaw('rice_variety, COUNT(*) as count, SUM(area_hectares) as total_area')
            ->groupBy('rice_variety')
            ->orderBy('count', 'desc')
            ->get();
        
        return view('dashboard.data-analysis', compact('pestTypes', 'severityDistribution', 'riceVarieties'));
    }

    public function farmers()
    {
        $farmers = User::where('user_type', 'petani')
            ->withCount('plantings')
            ->orderBy('name')
            ->get();

        return view('dashboard.farmers', compact('farmers'));
    }

    public function plantings()
    {
        $plantings = Planting::with('user')
            ->orderBy('planting_date', 'desc')
            ->get();

        return view('dashboard.plantings', compact('plantings'));
    }

    public function pestMonitoring()
    {
        $pestReports = PestReport::with(['user', 'planting'])
            ->orderBy('report_date', 'desc')
            ->get();

        $activeCount = PestReport::where('status', '!=', 'resolved')->count();

        $severityStats = PestReport::selectRaw('severity, COUNT(*) as count')
            ->groupBy('severity')
            ->orderByDesc('count')
            ->get();

        // Get pest reports grouped by district for Karawang - for the interactive map
        $pestData = PestReport::selectRaw('
                users.district,
                COUNT(*) as total_reports,
                SUM(CASE WHEN severity = "low" THEN 1 ELSE 0 END) as low_count,
                SUM(CASE WHEN severity = "medium" THEN 1 ELSE 0 END) as medium_count,
                SUM(CASE WHEN severity = "high" THEN 1 ELSE 0 END) as high_count,
                SUM(CASE WHEN severity = "critical" THEN 1 ELSE 0 END) as critical_count,
                COUNT(DISTINCT pest_reports.user_id) as affected_farmers
            ')
            ->join('users', 'pest_reports.user_id', '=', 'users.id')
            ->where('users.district', 'like', '%Karawang%')
            ->groupBy('users.district')
            ->get();

        // Calculate severity percentage for each district
        foreach ($pestData as $data) {
            $totalSeverity = ($data->low_count * 1) + ($data->medium_count * 2) + ($data->high_count * 3) + ($data->critical_count * 4);
            $maxSeverity = $data->total_reports * 4;
            $data->severity_percentage = $maxSeverity > 0 ? ($totalSeverity / $maxSeverity) * 100 : 0;

            // Get affected area
            $data->affected_area = Planting::whereHas('user', function($q) use ($data) {
                $q->where('district', $data->district);
            })->sum('area_hectares');

            // Get most common pest type
            $data->common_pest = PestReport::selectRaw('pest_type, COUNT(*) as count')
                ->whereHas('user', function($q) use ($data) {
                    $q->where('district', $data->district);
                })
                ->groupBy('pest_type')
                ->orderByDesc('count')
                ->first();

            // Get recommendation based on severity
            if ($data->severity_percentage < 25) {
                $data->recommendation = 'Lakukan monitoring rutin dan terapkan praktik IPM (Integrated Pest Management).';
            } elseif ($data->severity_percentage < 50) {
                $data->recommendation = 'Tingkatkan frekuensi monitoring dan siapkan kontrol biologis serta mekanis.';
            } elseif ($data->severity_percentage < 75) {
                $data->recommendation = 'Segera lakukan pengendalian hama terpadu dengan insektisida selektif jika perlu.';
            } else {
                $data->recommendation = 'Status darurat! Koordinasikan dengan dinas pertanian untuk penanganan massal.';
            }
        }

        return view('dashboard.pest-monitoring', compact('pestReports', 'activeCount', 'severityStats', 'pestData'));
    }

    public function fertilizer()
    {
        $schedules = FertilizerSchedule::with(['user', 'planting'])
            ->orderBy('scheduled_date', 'desc')
            ->get();

        return view('dashboard.fertilizer', compact('schedules'));
    }

    public function earlyWarning()
    {
        $criticalPests = PestReport::whereIn('severity', ['high', 'critical'])
            ->where('status', '!=', 'resolved')
            ->with(['user', 'planting'])
            ->orderBy('report_date', 'desc')
            ->get();

        $recentNotifications = Notification::where('type', 'warning')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $upcomingHarvests = Planting::where('expected_harvest_date', '<=', now()->addDays(14))
            ->where('expected_harvest_date', '>=', now())
            ->where('status', '!=', 'harvested')
            ->with('user')
            ->orderBy('expected_harvest_date')
            ->get();

        return view('dashboard.early-warning', compact('criticalPests', 'recentNotifications', 'upcomingHarvests'));
    }
}
