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

            if ($user->status === 'pending') {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Anda sedang dalam proses verifikasi berkas oleh admin.'
                ], 403);
            }

            if ($user->status === 'rejected') {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran akun Anda ditolak oleh admin. Silakan daftarkan ulang berkas Anda.'
                ], 403);
            }

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

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'district' => 'required|string|max:100',
            'profile_photo' => 'nullable|image|max:4096',
            'document_file' => 'nullable|file|max:10240', // Max 10MB document
        ]);

        $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('farmers', 'public');
        }

        $documentPath = null;
        if ($request->hasFile('document_file')) {
            $documentPath = $request->file('document_file')->store('documents', 'public');
        }

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'district' => $request->district,
            'profile_photo_path' => $photoPath,
            'document_path' => $documentPath,
            'user_type' => 'petani',
            'status' => 'pending', // strict approval
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil. Akun Anda menunggu persetujuan admin.',
            'data' => [
                'user' => $user
            ]
        ], 201);
    }
}
