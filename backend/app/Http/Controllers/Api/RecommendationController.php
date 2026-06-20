<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function index()
    {
        $recommendations = Recommendation::where('user_id', Auth::id())->with('planting')->orderBy('priority', 'desc')->get();
        return response()->json($recommendations);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'planting_id' => 'nullable|exists:plantings,id',
            'category' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'action_steps' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'valid_until' => 'nullable|date',
        ]);

        $recommendation = Recommendation::create([
            'user_id' => Auth::id(),
            'planting_id' => $validated['planting_id'] ?? null,
            'category' => $validated['category'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'action_steps' => $validated['action_steps'],
            'priority' => $validated['priority'],
            'valid_until' => $validated['valid_until'] ?? null,
        ]);

        return response()->json($recommendation, 201);
    }

    public function show(string $id)
    {
        $recommendation = Recommendation::where('user_id', Auth::id())->with('planting')->findOrFail($id);
        return response()->json($recommendation);
    }

    public function update(Request $request, string $id)
    {
        $recommendation = Recommendation::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'is_applied' => 'sometimes|boolean',
        ]);

        if (isset($validated['is_applied']) && $validated['is_applied']) {
            $validated['applied_at'] = now();
        }

        $recommendation->update($validated);

        return response()->json($recommendation);
    }

    public function destroy(string $id)
    {
        $recommendation = Recommendation::where('user_id', Auth::id())->findOrFail($id);
        $recommendation->delete();

        return response()->json(['message' => 'Recommendation deleted successfully']);
    }
}
