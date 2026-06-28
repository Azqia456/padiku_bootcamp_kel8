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
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
        ]);

        DB::transaction(function () use ($request, $validated) {
            // 2. Logika penyimpanan foto
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
                'location_name' => $validated['village'],
                'planting_date' => now(),
            ]);
        });

        return redirect()->route('dashboard.farmers')->with('success', 'Petani dan data lahan berhasil ditambahkan!');
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
        return response()->json(['success' => true, 'message' => 'Data lahan tanam berhasil ditambahkan!']);
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
        return response()->json(['success' => true, 'message' => 'Laporan serangan hama berhasil dikirim!']);
    }
    
    public function map()
    {
        $plantings = Planting::with('user')->get();
        $plantingData = Planting::selectRaw('users.district, COUNT(*) as total_plantings, SUM(area_hectares) as total_area')
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
            ->withSum('plantings', 'area_hectares');

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $farmers = $query->orderBy('name')->get();
        $totalFarmersCount = User::where('user_type', 'petani')->count();

        return view('dashboard.farmers', compact('farmers', 'totalFarmersCount'));
    }

    public function destroyFarmer($id)
    {
        User::where('user_type', 'petani')->findOrFail($id)->delete();
        return redirect()->route('dashboard.farmers')->with('success', 'Petani berhasil dihapus!');
    }

    public function plantings()
    {
        $plantings = Planting::with('user')->get();
        return view('dashboard.plantings', compact('plantings'));
    }

    public function pestMonitoring()
    {
        $pestReports = PestReport::with(['user', 'planting'])->get();
        return view('dashboard.pest-monitoring', compact('pestReports'));
    }

    public function fertilizer()
    {
        $schedules = FertilizerSchedule::with(['user', 'planting'])->get();
        return view('dashboard.fertilizer', compact('schedules'));
    }

    public function earlyWarning()
    {
        return view('dashboard.early-warning');
    }
}