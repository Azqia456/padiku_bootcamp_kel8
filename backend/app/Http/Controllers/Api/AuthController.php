<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('mobile-app')->plainTextToken;

            // Fetch statistics
            $totalLaporan = \App\Models\PestReport::where('user_id', $user->id)->count();
            $lahanAktif = \App\Models\Planting::where('user_id', $user->id)
                ->where('status', '!=', 'harvested')
                ->sum('area_hectares');

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                    'stats' => [
                        'total_laporan' => $totalLaporan,
                        'lahan_aktif' => (float) $lahanAktif,
                    ]
                ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password'
        ], 401);
    }
}
