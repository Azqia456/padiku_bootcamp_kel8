<?php

namespace App\Http\Controllers;

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
        return view('dashboard.map', compact('plantings'));
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
}
