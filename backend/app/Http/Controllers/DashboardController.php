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
        
        return view('dashboard.index', compact(
            'totalPlantings', 'totalArea', 'totalPestReports', 'activePestReports', 'totalFarmers', 
            'plantingsByDistrict', 'recentPestReports', 'productionByStatus', 'monthlyProduction', 
            'recentFarmers', 'totalFertilizer'
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
        
        // Hapus foto jika ada
        if ($farmer->profile_photo_path) {
            Storage::disk('public')->delete($farmer->profile_photo_path);
        }
        
        $farmer->delete();
        return response()->json(['success' => true, 'message' => 'Petani berhasil dihapus!']);
    }

    // Method Monitor Hama (Diperbaiki namanya)
    public function pestMonitoring()
    {
        $pestReports = PestReport::with(['user', 'planting'])->get();
        $activeCount = $pestReports->where('status', '!=', 'resolved')->count();
        
        // Data untuk statistik per wilayah
        $pestData = PestReport::selectRaw('
                users.district,
                COUNT(*) as total_reports,
                COUNT(DISTINCT users.id) as affected_farmers,
                SUM(plantings.area_hectares) as affected_area,
                CASE 
                    WHEN COUNT(*) = 0 THEN 0
                    ELSE (SUM(CASE WHEN severity IN (\'high\', \'critical\') THEN 1 ELSE 0 END) / COUNT(*)) * 100 
                END as severity_percentage
            ')
            ->join('users', 'pest_reports.user_id', '=', 'users.id')
            ->leftJoin('plantings', 'pest_reports.planting_id', '=', 'plantings.id')
            ->groupBy('users.district')
            ->get();
            
        // Tambahkan common pest untuk setiap district (sederhana)
        $pestData->transform(function ($item) {
            $item->common_pest = PestReport::whereHas('user', function($q) use ($item) {
                $q->where('district', $item->district);
            })->select('pest_type')->groupBy('pest_type')->orderByRaw('COUNT(*) DESC')->first();
            return $item;
        });
        
        // Statistik tingkat keparahan
        $severityStats = PestReport::selectRaw('severity, COUNT(*) as count')
            ->groupBy('severity')
            ->get();
            
        return view('dashboard.pest-monitoring', compact('pestReports', 'activeCount', 'pestData', 'severityStats'));
    }

    // Method Early Warning (Diperbaiki agar tidak error)
    public function earlyWarning()
    {
        // Mengambil data hama dengan tingkat keparahan tinggi untuk warning
        $criticalPests = PestReport::whereIn('severity', ['high', 'critical'])
            ->where('status', '!=', 'resolved')
            ->with(['user', 'planting'])
            ->latest()
            ->get();
            
        // Panen dalam 14 hari ke depan
        $upcomingHarvests = Planting::where('expected_harvest_date', '>=', now())
            ->where('expected_harvest_date', '<=', now()->addDays(14))
            ->with('user')
            ->orderBy('expected_harvest_date')
            ->get();
            
        // Notifikasi peringatan (ambil dari tabel notifications)
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
        $plantingData = Planting::selectRaw('users.district, COUNT(*) as total_plantings, SUM(plantings.area_hectares) as total_area')
            ->join('users', 'plantings.user_id', '=', 'users.id')
            ->groupBy('users.district')
            ->get();
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
            // Update foto jika ada
            if ($request->hasFile('profile_photo')) {
                // Hapus foto lama jika ada
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

            // Update atau buat planting
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

            // Reload farmer dengan plantings sum
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
        return view('dashboard.fertilizer', compact('schedules', 'farmers', 'plantings'));
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
}