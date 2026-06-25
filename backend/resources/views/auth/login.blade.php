<x-guest-layout>
    <div class="flex justify-center mb-8">
        <img src="{{ asset('images/logo_padi.png') }}" alt="PADIKU" class="h-[120px] w-auto object-contain">
    </div>

    <p class="text-center text-sm text-gray-500 mb-6 -mt-4">Panel Admin · Dinas Pertanian Karawang</p>

    <x-auth-session-status class="mb-4 text-sm text-[#0A5C34] text-center" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="user_type" value="dinas_pertanian">

        <div>
            <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email admin"
                       required autofocus autocomplete="username"
                       class="auth-input @error('email') border-red-500 @enderror">
            </div>
            @error('email')<p class="auth-error">{{ $message }}</p>@enderror
        </div>

        <div>
            <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </span>
                <input id="password" type="password" name="password" placeholder="Kata sandi"
                       required autocomplete="current-password"
                       class="auth-input has-suffix @error('password') border-red-500 @enderror">
                <button type="button" id="togglePassword" tabindex="-1"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 p-1">
                    <svg id="eyeOff" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                    <svg id="eyeOn" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            @error('password')<p class="auth-error">{{ $message }}</p>@enderror
            @error('user_type')<p class="auth-error">{{ $message }}</p>@enderror
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="w-full h-12 bg-[#0A5C34] hover:bg-[#084a2b] text-white font-semibold rounded-xl transition-colors text-base shadow-sm">
                Masuk
            </button>
        </div>
    </form>

    <script>
        document.getElementById('togglePassword').addEventListener('click', () => {
            const input = document.getElementById('password');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            document.getElementById('eyeOff').classList.toggle('hidden', isHidden);
            document.getElementById('eyeOn').classList.toggle('hidden', !isHidden);
        });
    </script>
</x-guest-layout>
