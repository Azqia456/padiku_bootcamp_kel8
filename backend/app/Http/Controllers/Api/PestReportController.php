<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PestReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PestReportController extends Controller
{
    public function index()
    {
        $reports = PestReport::where('user_id', Auth::id())->with('planting')->get();
        return response()->json($reports);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'planting_id' => 'nullable|exists:plantings,id',
            'pest_type' => 'required|string',
            'description' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'severity' => 'required|in:low,medium,high',
            'report_date' => 'required|date',
        ]);

        $report = PestReport::create([
            'user_id' => Auth::id(),
            'planting_id' => $validated['planting_id'] ?? null,
            'pest_type' => $validated['pest_type'],
            'description' => $validated['description'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'severity' => $validated['severity'],
            'report_date' => $validated['report_date'],
        ]);

        return response()->json($report, 201);
    }

    public function show(string $id)
    {
        $report = PestReport::where('user_id', Auth::id())->with('planting')->findOrFail($id);
        return response()->json($report);
    }

    public function update(Request $request, string $id)
    {
        $report = PestReport::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'status' => 'sometimes|in:reported,in_progress,resolved',
            'action_taken' => 'nullable|string',
        ]);

        $report->update($validated);

        return response()->json($report);
    }

    public function destroy(string $id)
    {
        $report = PestReport::where('user_id', Auth::id())->findOrFail($id);
        $report->delete();

        return response()->json(['message' => 'Pest report deleted successfully']);
    }
}
