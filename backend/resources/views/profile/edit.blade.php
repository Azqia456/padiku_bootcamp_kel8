@php $activeMenu = 'profile'; @endphp
@extends('layouts.admin')

@section('title', 'Pengaturan Profil')

@section('content')
<x-page-banner
    title="Pengaturan Profil & Keamanan"
    subtitle="Kelola data akun Anda dan atur parameter keamanan login"
    image="bg_profil.jpg"
/>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Forms -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Profile Information Card -->
        <div class="bg-white rounded-premium shadow-premium p-6 border border-slate-100">
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Update Password Card -->
        <div class="bg-white rounded-premium shadow-premium p-6 border border-slate-100">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <!-- Right Column: Status Keamanan & Danger Zone -->
    <div class="space-y-6">
        <!-- Status Keamanan Panel -->
        <div class="bg-white rounded-premium shadow-premium p-6 border border-slate-100">
            <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Status Keamanan Akun
            </h3>
            
            <div class="space-y-4 text-xs font-semibold">
                <div class="flex justify-between items-center py-2 border-b border-slate-50">
                    <span class="text-slate-400">Hak Akses</span>
                    <span class="bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full uppercase tracking-wider text-[10px]">
                        {{ Auth::user()->user_type ? str_replace('_', ' ', Auth::user()->user_type) : 'Admin' }}
                    </span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-50">
                    <span class="text-slate-400">Status Login</span>
                    <span class="text-slate-800 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Aktif
                    </span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-50">
                    <span class="text-slate-400">Alamat IP Saat Ini</span>
                    <span class="text-slate-800 font-mono">{{ request()->ip() }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-50">
                    <span class="text-slate-400">Terdaftar Sejak</span>
                    <span class="text-slate-800">{{ Auth::user()->created_at ? Auth::user()->created_at->format('d M Y') : '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-50">
                    <span class="text-slate-400">Terakhir Login</span>
                    <span class="text-slate-800 text-right">{{ Auth::user()->last_login_at ? Auth::user()->last_login_at->format('d M Y, H:i') : 'Sesi Pertama' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-50">
                    <span class="text-slate-400">IP Terakhir Login</span>
                    <span class="text-slate-800 font-mono">{{ Auth::user()->last_login_ip ?? '-' }}</span>
                </div>
            </div>
            
            <div class="mt-5 bg-emerald-50/50 rounded-xl p-3.5 border border-emerald-100 flex items-start gap-2.5">
                <svg class="w-4 h-4 text-emerald-700 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-[11px] text-emerald-800 font-medium leading-relaxed">
                    Sistem mendeteksi koneksi Anda aman. Pastikan password Anda kuat dan diganti secara berkala demi keamanan data pertanian Karawang.
                </p>
            </div>
        </div>

        </div>
    </div>
</div>
@endsection
