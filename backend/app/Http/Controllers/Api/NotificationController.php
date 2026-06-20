<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return response()->json($notifications);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
            'type' => 'required|in:info,warning,success,alert',
        ]);

        $notification = Notification::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'message' => $validated['message'],
            'type' => $validated['type'],
        ]);

        return response()->json($notification, 201);
    }

    public function show(string $id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($notification);
    }

    public function update(Request $request, string $id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'is_read' => 'sometimes|boolean',
        ]);

        if (isset($validated['is_read']) && $validated['is_read']) {
            $validated['read_at'] = now();
        }

        $notification->update($validated);

        return response()->json($notification);
    }

    public function destroy(string $id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->delete();

        return response()->json(['message' => 'Notification deleted successfully']);
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())->where('is_read', false)->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return response()->json(['message' => 'All notifications marked as read']);
    }
}
