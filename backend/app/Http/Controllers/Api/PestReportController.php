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
            'planting_id' => 'nullable',
            'pest_type' => 'required|string',
            'description' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'severity' => 'required|in:low,medium,high',
            'report_date' => 'required|date',
        ]);

        $user = Auth::user();
        
        // Find or create a planting for this user to associate the report with a village name
        $planting = \App\Models\Planting::where('user_id', $user->id)->first();
        if (!$planting) {
            $planting = \App\Models\Planting::create([
                'user_id' => $user->id,
                'location_name' => $user->village ?? 'Dawuan Tengah',
                'latitude' => $request->latitude ?? -6.3224,
                'longitude' => $request->longitude ?? 107.3376,
                'area_hectares' => 1.5,
                'rice_variety' => 'Ciherang',
                'planting_date' => now(),
                'status' => 'growing',
            ]);
        } else {
            $planting->update([
                'location_name' => $user->village ?? 'Dawuan Tengah',
            ]);
        }

        $report = PestReport::create([
            'user_id' => $user->id,
            'planting_id' => $planting->id,
            'pest_type' => $validated['pest_type'],
            'description' => $validated['description'],
            'latitude' => $request->latitude ?? -6.3224,
            'longitude' => $request->longitude ?? 107.3376,
            'severity' => $validated['severity'],
            'report_date' => $validated['report_date'],
        ]);

        // Create notification for admin (dinas_pertanian)
        $dinasUsers = \App\Models\User::where('user_type', 'dinas_pertanian')->get();
        foreach ($dinasUsers as $dinas) {
            \App\Models\Notification::create([
                'user_id' => $dinas->id,
                'title' => 'Laporan Serangan Hama Baru',
                'message' => 'Laporan serangan ' . $report->pest_type . ' baru saja masuk dari Desa ' . ($planting->location_name ?? 'Lahan') . ' oleh petani ' . $user->name . '.',
                'type' => 'warning',
                'is_read' => false,
            ]);
        }

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
