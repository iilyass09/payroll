<div wire:poll.3s="poll">
    @if($showProgress)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
            <div class="relative w-full max-w-lg rounded-2xl bg-white dark:bg-gray-800 p-8 shadow-2xl">
                <div class="text-center">
                    @if(!$allDone)
                        <div class="mx-auto w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-100 to-violet-100 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-primary-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Mengirim Slip Gaji</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Mohon tunggu, jangan tutup halaman ini</p>
                    @else
                        <div class="mx-auto w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-100 to-green-100 flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $failed === 0 ? 'Semua Email Terkirim!' : 'Proses Selesai' }}</h3>
                    @endif

                    <div class="mt-6 mb-2">
                        <span class="text-5xl font-extrabold {{ $allDone ? 'text-emerald-600' : 'text-primary-600' }}">{{ $percent }}%</span>
                    </div>
                    <div class="text-[10px] text-gray-300 dark:text-gray-600">last poll: {{ $lastPoll }}</div>

                    <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                        <div class="h-3 rounded-full shadow-sm {{ $allDone ? 'bg-emerald-500' : 'bg-gradient-to-r from-primary-500 to-violet-500 shadow-primary-200' }}"
                             style="width: {{ $percent }}%"></div>
                    </div>

                    <div class="flex items-center justify-center gap-6 mt-4">
                        <span class="inline-flex items-center gap-1.5 text-sm font-medium text-emerald-700">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            {{ $sent }} Terkirim
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-sm font-medium text-amber-700">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            {{ $pending }} Pending
                        </span>
                        @if($failed > 0)
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium text-red-700">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                {{ $failed }} Gagal
                            </span>
                        @endif
                    </div>
                    <p class="mt-4 text-xs text-gray-400 dark:text-gray-500">({{ $sent + $failed }} dari {{ $total }} karyawan)</p>

                    <div class="mt-6 flex justify-center gap-3">
                        @if(!$allDone)
                            <button wire:click="close" class="btn-secondary text-sm">Sembunyikan</button>
                        @else
                            <a href="{{ route('payroll.email-logs', $import) }}" class="btn-primary text-sm">Lihat Detail</a>
                            <button wire:click="close" class="btn-secondary text-sm">Tutup</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($showDone)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
            <div class="relative w-full max-w-md rounded-2xl bg-white dark:bg-gray-800 p-8 shadow-2xl">
                <div class="text-center">
                    @if($failed === 0)
                        <div class="mx-auto w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-100 to-green-100 flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Semua Email Terkirim!</h3>
                    @else
                        <div class="mx-auto w-20 h-20 rounded-2xl bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Proses Selesai</h3>
                    @endif
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Periode {{ $import->periode }}</p>

                    <div class="mt-6 bg-gray-50 dark:bg-gray-800 rounded-xl p-4 space-y-2 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Total Karyawan</span>
                            <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $total }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Berhasil Terkirim</span>
                            <span class="font-semibold text-emerald-600">{{ $sent }}</span>
                        </div>
                        @if($failed > 0)
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Gagal</span>
                                <span class="font-semibold text-red-600">{{ $failed }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 flex justify-center gap-3">
                        <a href="{{ route('payroll.email-logs', $import) }}" class="btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                            </svg>
                            Lihat Detail
                        </a>
                        <button wire:click="close" class="btn-secondary">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>


