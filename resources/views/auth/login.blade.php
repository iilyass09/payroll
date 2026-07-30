<x-guest-layout>
    <div
        x-data="cardTilt()"
        x-on:mousemove="tilt"
        x-on:mouseleave="reset"
        x-bind:style="`transform: perspective(1000px) rotateX(${tiltX}deg) rotateY(${tiltY}deg)`"
        class="login-card rounded-2xl p-8 sm:p-10 transition-[transform,box-shadow] duration-200 ease-out will-change-transform"
    >
        {{-- Interactive Logo --}}
        <div x-data="logoInteract()" class="text-center mb-8">
            <div class="relative inline-flex items-center justify-center mb-4 group cursor-pointer select-none">
                {{-- Ambient logo glow --}}
                <div class="login-logo-glow absolute inset-0 rounded-2xl bg-gradient-to-br from-primary-400 via-primary-500 to-blue-600"></div>
                {{-- Glow ring --}}
                <div
                    x-show="glow"
                    x-transition:enter="transition-all duration-700 ease-out"
                    x-transition:enter-start="opacity-0 scale-50"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="absolute inset-0 rounded-2xl bg-gradient-to-br from-primary-400 via-primary-500 to-blue-600 opacity-30 blur-2xl scale-125"
                ></div>
                {{-- Ripple on click --}}
                <div
                    x-show="ripple"
                    x-transition:enter="transition-all duration-500 ease-out"
                    x-transition:enter-start="opacity-50 scale-75"
                    x-transition:enter-end="opacity-0 scale-[2.5]"
                    x-transition:leave="transition-all duration-0"
                    class="absolute inset-0 rounded-full bg-primary-500/20"
                ></div>
                <div
                    @mouseenter="glow = true"
                    @mouseleave="glow = false"
                    @click="rippleEffect"
                    :class="{ 'scale-110 -rotate-3': glow }"
                    class="relative transition-all duration-500 ease-out motion-reduce:transition-none motion-reduce:scale-100 motion-reduce:rotate-0"
                >
                    <img src="{{ asset('logo.png') }}" alt="Johen Sukses Abadi" width="64" height="64" class="login-logo-pulse h-16 w-auto relative z-10 block drop-shadow-sm">
                </div>
            </div>
            <h1 class="text-xl font-display font-bold text-gray-900 dark:text-gray-100 tracking-tight">Masuk</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Masuk ke akun Johen Anda</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5"
              x-data="{ loading: false }"
              x-on:submit="loading = true; $nextTick(() => { $el.querySelector('button[type=submit]').disabled = true })">
            @csrf

            {{-- Username --}}
            <div class="login-stagger-1 motion-reduce:opacity-100">
                <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1.5">Username</label>
                <div class="login-input-wrapper">
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 dark:text-gray-500 transition-colors duration-300" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus autocomplete="username" spellcheck="false"
                            class="login-input pl-10"
                            placeholder="Masukkan username…">
                    </div>
                </div>
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div x-data="{ show: false }" class="login-stagger-2 motion-reduce:opacity-100">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1.5">Password</label>
                <div class="login-input-wrapper">
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 dark:text-gray-500 pointer-events-none transition-colors duration-300" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                        <input :type="show ? 'text' : 'password'" id="password" name="password" required autocomplete="current-password"
                            class="login-input pl-10 pr-11"
                            placeholder="Masukkan password…">
                        <button type="button" @click="show = !show" :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'" class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500">
                            <svg x-show="!show" x-cloak class="w-5 h-5" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                            <svg x-show="show" x-cloak class="w-5 h-5" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </button>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Remember & Forgot --}}
            <div class="login-stagger-3 motion-reduce:opacity-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 sm:gap-0">
                <label for="remember_me" class="flex items-center gap-2 cursor-pointer group select-none">
                    <input id="remember_me" type="checkbox" class="rounded-lg border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500 transition-all duration-200 motion-reduce:transition-none" name="remember">
                    <span class="text-sm text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-200 transition-colors">Ingat saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-primary-600 hover:text-primary-500 transition-colors" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            {{-- Submit --}}
            <div class="login-stagger-4 motion-reduce:opacity-100">
                <button type="submit" class="login-btn" :disabled="loading" :class="{ 'loading': loading }">
                    <template x-if="!loading">
                        <svg class="w-4 h-4 relative z-10" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                    </template>
                    <template x-if="loading">
                        <svg class="w-4 h-4 relative z-10 animate-spin motion-reduce:animate-none" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                    </template>
                    <span class="relative z-10" x-text="loading ? 'Memproses…' : 'Masuk'"></span>
                </button>
            </div>

            {{-- Register link --}}
            <div class="login-stagger-5 motion-reduce:opacity-100">
                @if (Route::has('register'))
                    <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-semibold text-primary-600 hover:text-primary-500 transition-colors">Daftar</a>
                    </p>
                @endif
            </div>
        </form>
    </div>

    <script>
        function logoInteract() {
            return {
                glow: false,
                ripple: false,
                rippleEffect() {
                    this.ripple = true;
                    setTimeout(() => { this.ripple = false; }, 600);
                }
            }
        }

        function cardTilt() {
            return {
                tiltX: 0,
                tiltY: 0,
                tilt(e) {
                    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                    const rect = e.currentTarget.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    this.tiltY = ((x - centerX) / centerX) * 6;
                    this.tiltX = ((centerY - y) / centerY) * 6;
                },
                reset() {
                    this.tiltX = 0;
                    this.tiltY = 0;
                }
            }
        }
    </script>
</x-guest-layout>
