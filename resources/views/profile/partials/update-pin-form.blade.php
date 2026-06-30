<div class="card p-6">
    <div class="flex items-center gap-3 mb-6">
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-purple-500 text-white shadow-lg shadow-violet-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
        </div>
        <div>
            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">PIN Persetujuan</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Gunakan PIN 6 digit untuk menyetujui atau menolak pengajuan cuti & izin</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 dark:bg-red-900/20 dark:border-red-800 px-4 py-3">
            <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.pin.update') }}" class="space-y-4">
        @csrf

        @if(auth()->user()->hasPin())
        <div>
            <x-input-label for="current_pin" value="PIN Saat Ini" />
            <x-text-input id="current_pin" name="current_pin" type="password" inputmode="numeric" pattern="[0-9]*" maxlength="6" class="mt-1 block w-full" placeholder="Masukkan PIN saat ini" autocomplete="off" />
            @error('current_pin') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        @endif

        <div>
            <x-input-label for="pin" value="{{ auth()->user()->hasPin() ? 'PIN Baru' : 'PIN Persetujuan' }}" />
            <x-text-input id="pin" name="pin" type="password" inputmode="numeric" pattern="[0-9]*" maxlength="6" class="mt-1 block w-full" placeholder="6 digit angka" autocomplete="off" />
            @error('pin') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <x-input-label for="pin_confirmation" value="Konfirmasi PIN" />
            <x-text-input id="pin_confirmation" name="pin_confirmation" type="password" inputmode="numeric" pattern="[0-9]*" maxlength="6" class="mt-1 block w-full" placeholder="Ulangi PIN" autocomplete="off" />
            @error('pin_confirmation') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <button type="submit" class="btn-primary text-xs px-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                {{ auth()->user()->hasPin() ? 'Ubah PIN' : 'Buat PIN' }}
            </button>
        </div>
    </form>
</div>
