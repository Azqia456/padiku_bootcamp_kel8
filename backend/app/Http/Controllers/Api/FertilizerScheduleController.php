<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FertilizerSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FertilizerScheduleController extends Controller
{
    public function index()
    {
        $schedules = FertilizerSchedule::where('user_id', Auth::id())->with('planting')->orderBy('scheduled_date', 'asc')->get();
        return response()->json($schedules);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'planting_id' => 'required|exists:plantings,id',
            'fertilizer_type' => 'required|string',
            'amount_kg' => 'required|numeric',
            'scheduled_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $schedule = FertilizerSchedule::create([
            'user_id' => Auth::id(),
            'planting_id' => $validated['planting_id'],
            'fertilizer_type' => $validated['fertilizer_type'],
            'amount_kg' => $validated['amount_kg'],
            'scheduled_date' => $validated['scheduled_date'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json($schedule, 201);
    }

    public function show(string $id)
    {
        $schedule = FertilizerSchedule::where('user_id', Auth::id())->with('planting')->findOrFail($id);
        return response()->json($schedule);
    }

    public function update(Request $request, string $id)
    {
        $schedule = FertilizerSchedule::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'status' => 'sometimes|in:scheduled,applied,skipped',
            'applied_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $schedule->update($validated);

        return response()->json($schedule);
    }

    public function destroy(string $id)
    {
        $schedule = FertilizerSchedule::where('user_id', Auth::id())->findOrFail($id);
        $schedule->delete();

        return response()->json(['message' => 'Fertilizer schedule deleted successfully']);
    }
}
