<?php

namespace App\Http\Controllers;

use App\Models\FertilizerSchedule;
use App\Models\Notification;
use App\Models\Planting;
use App\Models\PestReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Storage; 

class DashboardController extends Controller
{
    public function index()
    {
        $totalPlantings = Planting::count();
        $totalArea = Planting::sum('area_hectares') ?? 0;
        $totalPestReports = PestReport::count();
        $activePestReports = PestReport::where('status', '!=', 'resolved')->count();
        $totalFarmers = User::where('user_type', 'petani')->count();
        
        $plantingsByDistrict = Planting::selectRaw('users.district, COUNT(*) as count, SUM(plantings.area_hectares) as total_area')
            ->join('users', 'plantings.user_id', '=', 'users.id')
            ->groupBy('users.district')
            ->get();
        
        $recentPestReports = PestReport::with(['user', 'planting'])
            ->orderBy('report_date', 'desc')
            ->take(10)
            ->get();
        
        $productionByStatus = Planting::selectRaw('status, COUNT(*) as count, SUM(area_hectares) as total_area')
            ->groupBy('status')
            ->get();

        $monthlyProduction = Planting::selectRaw('YEAR(planting_date) as year, MONTH(planting_date) as month, SUM(area_hectares) as total_area')
            ->whereNotNull('planting_date')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->take(6)
            ->get();

        $recentFarmers = User::where('user_type', 'petani')
            ->withCount('plantings')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $totalFertilizer = FertilizerSchedule::count();
        
        $foodTotalProduction = Planting::where('status', 'harvested')->sum('area_hectares') * 5;
        $foodTotalConsumption = $totalFarmers * 0.3;
        $foodBalance = $foodTotalProduction - $foodTotalConsumption;
        
        return view('dashboard.index', compact(
            'totalPlantings', 'totalArea', 'totalPestReports', 'activePestReports', 'totalFarmers', 
            'plantingsByDistrict', 'recentPestReports', 'productionByStatus', 'monthlyProduction', 
            'recentFarmers', 'totalFertilizer', 'foodTotalProduction', 'foodTotalConsumption', 'foodBalance'
        ));
    }

    public function storeFarmer(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'nik'           => 'required|string|size:16',
            'email'         => 'required|email|unique:users,email',
            'phone'         => 'required|string|max:20',
            'district'      => 'required|string|max:100',
            'village'       => 'required|string|max:100',
            'address'       => 'required|string',
            'area_hectares' => 'required|numeric',
            'rice_variety'  => 'required|string',
            'status'        => 'required|string',
            'notes'         => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $newFarmer = null;
        DB::transaction(function () use ($request, $validated, &$newFarmer) {
            $photoPath = null;
            if ($request->hasFile('profile_photo')) {
                $photoPath = $request->file('profile_photo')->store('farmers', 'public');
            }

            $user = User::create([
                'name'               => $validated['name'],
                'nik'                => $validated['nik'],
                'email'              => $validated['email'],
                'phone'              => $validated['phone'],
                'district'           => $validated['district'],
                'village'            => $validated['village'],
                'address'            => $validated['address'],
                'profile_photo_path' => $photoPath, 
                'user_type'          => 'petani',
                'password'           => Hash::make('password123'),
            ]);

            Planting::create([
                'user_id'       => $user->id,
                'area_hectares' => $validated['area_hectares'],
                'rice_variety'  => $validated['rice_variety'],
                'status'        => $validated['status'],
                'notes'         => $validated['notes'] ?? null,
                'location_name' => $validated['village'],
                'planting_date' => now(),
            ]);

            $newFarmer = User::where('id', $user->id)
                ->with(['plantings'])
                ->withSum('plantings', 'area_hectares')
                ->first();
        });

        return response()->json(['success' => true, 'message' => 'Berhasil!', 'farmer' => $newFarmer]);
    }

    public function destroyFarmer($id)
    {
        $farmer = User::where('user_type', 'petani')->findOrFail($id);
        
        if ($farmer->profile_photo_path) {
            Storage::disk('public')->delete($farmer->profile_photo_path);
        }
        
        $farmer->delete();
        return response()->json(['success' => true, 'message' => 'Petani berhasil dihapus!']);
    }

    public function pestMonitoring()
    {
        $pestReports = PestReport::with(['user', 'planting'])->orderBy('report_date', 'desc')->get();
        $activeCount = $pestReports->where('status', '!=', 'resolved')->count();
        
        $severityStats = PestReport::selectRaw('severity, COUNT(*) as count')
            ->groupBy('severity')
            ->orderByRaw("FIELD(severity, 'critical', 'high', 'medium', 'low')")
            ->get();

        $pestData = PestReport::selectRaw('
                plantings.location_name as district,
                COUNT(pest_reports.id) as total_reports,
                SUM(plantings.area_hectares) as affected_area,
                COUNT(DISTINCT pest_reports.user_id) as affected_farmers,
                (COUNT(CASE WHEN pest_reports.severity IN ("high","critical") THEN 1 END) / COUNT(pest_reports.id)) * 100 as severity_percentage
            ')
            ->join('plantings', 'pest_reports.planting_id', '=', 'plantings.id')
            ->groupBy('plantings.location_name')
            ->get()
            ->map(function ($item) {
                $item->common_pest = PestReport::join('plantings', 'pest_reports.planting_id', '=', 'plantings.id')
                    ->where('plantings.location_name', $item->district)
                    ->selectRaw('pest_type, COUNT(*) as c')
                    ->groupBy('pest_type')
                    ->orderByDesc('c')
                    ->first();
                return $item;
            });

        $villageReportCounts = PestReport::join('plantings', 'pest_reports.planting_id', '=', 'plantings.id')
            ->selectRaw('plantings.location_name as village, COUNT(DISTINCT pest_reports.user_id) as reporter_count')
            ->groupBy('plantings.location_name')
            ->get()
            ->pluck('reporter_count', 'village');

        return view('dashboard.pest-monitoring', compact(
            'pestReports', 'pestData', 'activeCount', 'severityStats', 'villageReportCounts'
        ));
    }

    public function earlyWarning()
    {
        $criticalPests = PestReport::whereIn('severity', ['high', 'critical'])
            ->where('status', '!=', 'resolved')
            ->with(['user', 'planting'])
            ->latest()
            ->get();

        $upcomingHarvests = Planting::where('expected_harvest_date', '>=', now())
            ->where('expected_harvest_date', '<=', now()->addDays(14))
            ->with('user')
            ->orderBy('expected_harvest_date')
            ->get();

        $recentNotifications = Notification::latest()->take(10)->get();

        return view('dashboard.early-warning', compact('criticalPests', 'upcomingHarvests', 'recentNotifications'));
    }

    public function plantings()
    {
        $plantings = Planting::with('user')->get();
        return view('dashboard.plantings', compact('plantings'));
    }

    public function storePlanting(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'location_name' => 'required|string|max:255',
            'area_hectares' => 'required|numeric|min:0.01',
            'planting_date' => 'required|date',
            'rice_variety' => 'required|string|max:100',
            'expected_harvest_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'planted';
        $validated['latitude'] = $request->latitude ?? -6.3024;
        $validated['longitude'] = $request->longitude ?? 107.3053;

        Planting::create($validated);
        return redirect()->back()->with('success', 'Data lahan tanam berhasil ditambahkan!');
    }

    public function checkHarvestConflict(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'planting_date' => 'required|date'
        ]);

        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json(['conflict' => false]);
        }

        $plantingDate = \Carbon\Carbon::parse($request->planting_date);
        
        $conflicts = Planting::whereHas('user', function($q) use ($user) {
                $q->where('district', $user->district);
            })
            ->whereBetween('planting_date', [
                $plantingDate->copy()->subDays(7), 
                $plantingDate->copy()->addDays(7)
            ])
            ->count();

        if ($conflicts >= 1) {
            return response()->json([
                'conflict' => true,
                'message' => '⚠️ Peringatan: Terdapat potensi panen serempak (' . $conflicts . ' lahan) di Kec. ' . $user->district . ' pada minggu ini. Disarankan menunda masa tanam.',
                'recommendation_date' => $plantingDate->copy()->addDays(7)->format('Y-m-d')
            ]);
        }

        return response()->json(['conflict' => false]);
    }

    public function storePestReport(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'planting_id' => 'required|exists:plantings,id',
            'pest_type' => 'required|string|max:100',
            'severity' => 'required|in:low,medium,high,critical',
            'description' => 'required|string',
            'report_date' => 'required|date',
        ]);

        $validated['status'] = 'active';
        $validated['latitude'] = $request->latitude ?? -6.3024;
        $validated['longitude'] = $request->longitude ?? 107.3053;

        PestReport::create($validated);
        return redirect()->back()->with('success', 'Laporan serangan hama berhasil dikirim!');
    }
    
    public function map()
    {
        $plantings = Planting::with('user')->get();
        $plantingData = Planting::selectRaw('
                users.district,
                COUNT(*) as total_plantings,
                SUM(plantings.area_hectares) as total_area,
                SUM(plantings.area_hectares * 5) as estimated_yield,
                AVG(DATEDIFF(NOW(), plantings.planting_date) / 30) as avg_age_months,
                (SELECT status FROM plantings p2
                    JOIN users u2 ON p2.user_id = u2.id
                    WHERE u2.district = users.district
                    GROUP BY p2.status ORDER BY COUNT(*) DESC LIMIT 1
                ) as dominant_phase
            ')
            ->join('users', 'plantings.user_id', '=', 'users.id')
            ->groupBy('users.district')
            ->get()
            ->map(function ($item) {
                $phaseLabels = [
                    'planted'    => 'Baru Tanam',
                    'growing'    => 'Pertumbuhan',
                    'harvested'  => 'Selesai Panen',
                    'ready'      => 'Siap Panen',
                ];
                $item->phase_label = $phaseLabels[$item->dominant_phase] ?? ucfirst($item->dominant_phase ?? '-');
                $item->avg_age_months = round($item->avg_age_months ?? 0, 1);

                $item->common_variety = Planting::join('users', 'plantings.user_id', '=', 'users.id')
                    ->where('users.district', $item->district)
                    ->selectRaw('rice_variety, COUNT(*) as c')
                    ->groupBy('rice_variety')
                    ->orderByDesc('c')
                    ->first();

                return $item;
            });

        return view('dashboard.map', compact('plantings', 'plantingData'));
    }
    
    public function statistics()
    {
        $monthlyProduction = Planting::selectRaw('YEAR(planting_date) as year, MONTH(planting_date) as month, COUNT(*) as count, SUM(area_hectares) as total_area')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
        return view('dashboard.statistics', compact('monthlyProduction'));
    }
    
    public function foodBalance()
    {
        $totalProduction = Planting::where('status', 'harvested')->sum('area_hectares') * 5;
        $totalConsumption = User::where('user_type', 'petani')->count() * 0.3;
        $balance = $totalProduction - $totalConsumption;
        return view('dashboard.food-balance', compact('totalProduction', 'totalConsumption', 'balance'));
    }
    
    public function dataAnalysis()
    {
        return view('dashboard.data-analysis');
    }

    public function farmers(Request $request)
    {
        $query = User::where('user_type', 'petani')
            ->with(['plantings'])
            ->withSum('plantings', 'area_hectares');

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $farmers = $query->orderBy('name')->get();
        $totalFarmersCount = User::where('user_type', 'petani')->count();

        return view('dashboard.farmers', compact('farmers', 'totalFarmersCount'));
    }

    public function editFarmer($id)
    {
        $farmer = User::where('user_type', 'petani')->with('plantings')->findOrFail($id);
        return response()->json($farmer);
    }

    public function updateFarmer(Request $request, $id)
    {
        $farmer = User::where('user_type', 'petani')->findOrFail($id);
        
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'nik'           => 'required|string|size:16',
            'email'         => 'required|email|unique:users,email,'.$id,
            'phone'         => 'required|string|max:20',
            'district'      => 'required|string|max:100',
            'village'       => 'required|string|max:100',
            'address'       => 'required|string',
            'area_hectares' => 'required|numeric',
            'rice_variety'  => 'required|string',
            'status'        => 'required|string',
            'notes'         => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $updatedFarmer = null;
        DB::transaction(function () use ($request, $validated, $farmer, &$updatedFarmer) {
            if ($request->hasFile('profile_photo')) {
                if ($farmer->profile_photo_path) {
                    Storage::disk('public')->delete($farmer->profile_photo_path);
                }
                $photoPath = $request->file('profile_photo')->store('farmers', 'public');
                $farmer->profile_photo_path = $photoPath;
            }

            $farmer->update([
                'name'     => $validated['name'],
                'nik'      => $validated['nik'],
                'email'    => $validated['email'],
                'phone'    => $validated['phone'],
                'district' => $validated['district'],
                'village'  => $validated['village'],
                'address'  => $validated['address'],
            ]);

            $planting = $farmer->plantings()->first();
            if ($planting) {
                $planting->update([
                    'area_hectares' => $validated['area_hectares'],
                    'rice_variety'  => $validated['rice_variety'],
                    'status'        => $validated['status'],
                    'notes'         => $validated['notes'] ?? null,
                ]);
            } else {
                Planting::create([
                    'user_id'       => $farmer->id,
                    'area_hectares' => $validated['area_hectares'],
                    'rice_variety'  => $validated['rice_variety'],
                    'status'        => $validated['status'],
                    'notes'         => $validated['notes'] ?? null,
                    'location_name' => $validated['village'],
                    'planting_date' => now(),
                ]);
            }

            $updatedFarmer = User::where('user_type', 'petani')
                ->with(['plantings'])
                ->withSum('plantings', 'area_hectares')
                ->find($id);
        });

        return response()->json([
            'success' => true,
            'message' => 'Data petani berhasil diperbarui!',
            'farmer' => $updatedFarmer
        ]);
    }

    public function fertilizer()
    {
        $schedules = FertilizerSchedule::with(['user', 'planting'])->latest()->get();
        $farmers = User::where('user_type', 'petani')->get();
        $plantings = Planting::with('user')->get();

        $alertVillages = PestReport::join('plantings', 'pest_reports.planting_id', '=', 'plantings.id')
            ->selectRaw('plantings.location_name as village, COUNT(DISTINCT pest_reports.user_id) as reporter_count')
            ->where('pest_reports.status', '!=', 'resolved')
            ->groupBy('plantings.location_name')
            ->having('reporter_count', '>=', 3)
            ->get();

        return view('dashboard.fertilizer', compact('schedules', 'farmers', 'plantings', 'alertVillages'));
    }

    public function storeFertilizerSchedule(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'planting_id' => 'nullable|exists:plantings,id',
            'fertilizer_type' => 'required|string|max:100',
            'amount_kg' => 'required|numeric|min:0',
            'scheduled_date' => 'required|date',
            'priority' => 'required|in:low,normal,high',
            'delivery_method' => 'required|in:delivered,pickup,kios',
            'officer_in_charge' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'status' => 'required|in:scheduled,pending,applied,cancelled',
        ]);

        FertilizerSchedule::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal distribusi pupuk berhasil ditambahkan!',
        ]);
    }

    public function sendFertilizerNotification(Request $request, $id)
    {
        $schedule = FertilizerSchedule::with('user')->findOrFail($id);
        
        $notification = Notification::create([
            'user_id' => $schedule->user_id,
            'title' => 'Jadwal Distribusi Pupuk: ' . $schedule->fertilizer_type,
            'message' => 'Halo ' . ($schedule->user->name ?? 'Petani') . ', pupuk Anda (' . $schedule->fertilizer_type . ') sebanyak ' . number_format($schedule->amount_kg, 1) . ' kg dijadwalkan didistribusikan pada ' . ($schedule->scheduled_date ? $schedule->scheduled_date->format('d M Y') : '-') . '. Silakan bersiap.',
            'type' => 'system',
            'is_read' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi pupuk berhasil dikirim ke petani ' . ($schedule->user->name ?? '')
        ]);
    }

    public function getNotificationsData()
    {
        $criticalPests = PestReport::with(['user', 'planting'])
            ->whereIn('severity', ['high', 'critical'])
            ->where('status', '!=', 'resolved')
            ->orderBy('report_date', 'desc')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'pest',
                    'title' => 'Serangan Hama Kritis: ' . $item->pest_type,
                    'message' => 'Dilaporkan oleh ' . ($item->user->name ?? 'Petani') . ' di Desa ' . ($item->planting->location_name ?? 'Lahan'),
                    'time' => $item->report_date ? $item->report_date->format('d M Y') : $item->created_at->format('d M Y')
                ];
            });

        $upcomingHarvests = Planting::with('user')
            ->whereBetween('expected_harvest_date', [now(), now()->addDays(14)])
            ->orderBy('expected_harvest_date', 'asc')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'harvest',
                    'title' => 'Panen Mendekat di Desa ' . $item->location_name,
                    'message' => 'Petani ' . ($item->user->name ?? 'Petani') . ' (Varietas: ' . $item->rice_variety . ')',
                    'time' => $item->expected_harvest_date ? $item->expected_harvest_date->format('d M Y') : ''
                ];
            });

        $recentNotifications = Notification::orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'system',
                    'title' => $item->title,
                    'message' => $item->message,
                    'time' => $item->created_at->format('d M Y, H:i')
                ];
            });

        $notifications = collect()
            ->concat($criticalPests)
            ->concat($upcomingHarvests)
            ->concat($recentNotifications);

        return response()->json([
            'notifications' => $notifications,
            'totalCount' => $notifications->count()
        ]);
    }
}
