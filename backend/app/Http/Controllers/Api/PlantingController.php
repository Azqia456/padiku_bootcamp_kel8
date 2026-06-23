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

        $planting = Planting::create([
            'user_id' => Auth::id(),
            'location_name' => $validated['location_name'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'area_hectares' => $validated['area_hectares'],
            'planting_date' => $validated['planting_date'],
            'rice_variety' => $validated['rice_variety'],
            'expected_harvest_date' => $validated['expected_harvest_date'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json($planting, 201);
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
