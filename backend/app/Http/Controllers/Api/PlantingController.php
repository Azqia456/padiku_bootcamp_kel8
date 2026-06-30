<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Planting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlantingController extends Controller
{
    public function index()
    {
        $plantings = Planting::where('user_id', Auth::id())->with(['pestReports', 'recommendations', 'fertilizerSchedules'])->get();
        return response()->json($plantings);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'location_name' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'area_hectares' => 'required|numeric',
            'planting_date' => 'required|date',
            'rice_variety' => 'required|string',
            'expected_harvest_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $user = Auth::user();
        $plantingDate = \Carbon\Carbon::parse($validated['planting_date']);
        $district = $user->district ?? 'Cikampek';

        $conflicts = Planting::whereHas('user', function($q) use ($district) {
                $q->where('district', $district);
            })
            ->whereBetween('planting_date', [
                $plantingDate->copy()->subDays(7), 
                $plantingDate->copy()->addDays(7)
            ])
            ->count();

        if ($conflicts >= 1) {
            return response()->json([
                'message' => 'Gagal menyimpan: Potensi panen serempak (' . $conflicts . ' lahan) di Kec. ' . $district . ' pada minggu ini. Silakan geser tanggal tanam Anda.'
            ], 422);
        }

        $planting = Planting::create([
            'user_id' => $user->id,
            'location_name' => $validated['location_name'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'area_hectares' => $validated['area_hectares'],
            'planting_date' => $validated['planting_date'],
            'rice_variety' => $validated['rice_variety'],
            'expected_harvest_date' => $validated['expected_harvest_date'] ?? $plantingDate->copy()->addDays(90)->format('Y-m-d'),
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json($planting, 201);
    }

    public function checkConflict(Request $request)
    {
        $request->validate([
            'planting_date' => 'required|date'
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['conflict' => false]);
        }

        $plantingDate = \Carbon\Carbon::parse($request->planting_date);
        $district = $user->district ?? 'Cikampek';

        $conflicts = Planting::whereHas('user', function($q) use ($district) {
                $q->where('district', $district);
            })
            ->whereBetween('planting_date', [
                $plantingDate->copy()->subDays(7), 
                $plantingDate->copy()->addDays(7)
            ])
            ->count();

        if ($conflicts >= 1) {
            return response()->json([
                'conflict' => true,
                'message' => '⚠️ Gagal: Terdapat potensi panen serempak (' . $conflicts . ' lahan) di Kec. ' . $district . ' pada minggu ini. Silakan geser tanggal tanam Anda.',
                'recommendation_date' => $plantingDate->copy()->addDays(7)->format('Y-m-d')
            ]);
        }

        // Expected harvest date is 90 days from planting date
        $expectedHarvestDate = $plantingDate->copy()->addDays(90)->format('Y-m-d');

        return response()->json([
            'conflict' => false,
            'expected_harvest_date' => $expectedHarvestDate,
            'message' => '✅ Aman: Tidak ada konflik penanaman di Kec. ' . $district . ' pada minggu ini. Anda diperbolehkan menanam.'
        ]);
    }

    public function show(string $id)
    {
        $planting = Planting::where('user_id', Auth::id())->with(['pestReports', 'recommendations', 'fertilizerSchedules'])->findOrFail($id);
        return response()->json($planting);
    }

    public function update(Request $request, string $id)
    {
        $planting = Planting::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'location_name' => 'sometimes|string',
            'latitude' => 'sometimes|numeric',
            'longitude' => 'sometimes|numeric',
            'area_hectares' => 'sometimes|numeric',
            'planting_date' => 'sometimes|date',
            'rice_variety' => 'sometimes|string',
            'status' => 'sometimes|in:planned,growing,harvested',
            'expected_harvest_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $planting->update($validated);

        return response()->json($planting);
    }

    public function destroy(string $id)
    {
        $planting = Planting::where('user_id', Auth::id())->findOrFail($id);
        $planting->delete();

        return response()->json(['message' => 'Planting deleted successfully']);
    }
}
