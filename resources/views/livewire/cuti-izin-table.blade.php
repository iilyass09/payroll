<div x-data="{ confirmAction: false, confirmTitle: '', confirmMessage: '', confirmHandler: null }">
    @if($karyawanView)
        {{-- Karyawan Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
            <div class="stat-card group">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-green-500 text-white shadow-lg shadow-emerald-200 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12"/></svg>
                    </div>
                    <span class="badge-success">Sisa</span>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $sisaCuti }} <span class="text-sm font-medium text-gray-400">/ {{ $jatahCuti }}</span></p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Sisa Cuti Tahunan</p>
            </div>

            <div class="stat-card group">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-indigo-500 text-white shadow-lg shadow-blue-200 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12"/></svg>
                    </div>
                    <span class="badge-info">Cuti</span>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalCutiSaya }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Cuti Tahunan Saya</p>
            </div>

            <div class="stat-card group">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 text-white shadow-lg shadow-amber-200 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="badge-warning">Izin</span>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalIzinSaya }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Izin Saya</p>
            </div>

            <div class="stat-card group">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-purple-500 text-white shadow-lg shadow-violet-200 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                    </div>
                    <span class="badge-warning">Menunggu</span>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex-1 text-center">
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $menungguCuti }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Cuti</p>
                    </div>
                    <div class="w-px h-8 bg-gray-200 dark:bg-gray-700"></div>
                    <div class="flex-1 text-center">
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $menungguIzin }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Izin</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 px-6 py-4 border-b border-gray-50 dark:border-gray-800">
                <div>
                    <h2 class="text-base font-semibold text-gray-900 dark:text-gray-100">Riwayat Pengajuan Saya</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $employee?->nama ?? '-' }}</p>
                </div>
                <button wire:click="openPengajuanModal" class="btn-primary text-xs py-2 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Ajukan Cuti / Izin
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="table-header">
                            <th class="px-6 py-3 w-12 text-center">No</th>
                            <th class="px-6 py-3">Jenis</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Durasi</th>
                            <th class="px-6 py-3">Keterangan</th>
                            <th class="px-6 py-3">Atasan</th>
                            <th class="px-6 py-3">Persetujuan Atasan</th>
                            <th class="px-6 py-3">Persetujuan HR</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @forelse($leaveRequests as $lr)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-900 transition-colors">
                                <td class="table-cell text-center text-gray-500 dark:text-gray-400">{{ $leaveRequests->firstItem() + $loop->index }}</td>
                                <td class="table-cell">
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $lr->jenis === 'cuti_tahunan' ? 'Cuti Tahunan' : 'Izin' }}</span>
                                </td>
                                <td class="table-cell text-gray-600 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($lr->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($lr->tanggal_selesai)->format('d M Y') }}
                                </td>
                                <td class="table-cell text-gray-600 dark:text-gray-400">{{ $lr->durasi }}</td>
                                <td class="table-cell text-gray-600 dark:text-gray-400 max-w-[200px] truncate">{{ $lr->keterangan ?? '-' }}</td>
                                <td class="table-cell text-gray-600 dark:text-gray-400">{{ $lr->atasan?->nama ?? '-' }}</td>
                                <td class="table-cell">
                                    @if($lr->persetujuan_koor === 'disetujui')
                                        <span class="badge-success">Disetujui</span>
                                    @elseif($lr->persetujuan_koor === 'ditolak')
                                        <span class="badge-danger">Ditolak</span>
                                    @else
                                        <span class="badge-warning">Menunggu</span>
                                    @endif
                                </td>
                                <td class="table-cell">
                                    @if($lr->persetujuan_hr === 'disetujui')
                                        <span class="badge-success">Disetujui</span>
                                    @elseif($lr->persetujuan_hr === 'ditolak')
                                        <span class="badge-danger">Ditolak</span>
                                    @else
                                        <span class="badge-warning">Menunggu</span>
                                    @endif
                                </td>
                                <td class="table-cell">
                                    @if($lr->persetujuan_koor === 'menunggu' || $lr->persetujuan_hr === 'menunggu')
                                    <button wire:click="hapus({{ $lr->id }})"
                                            wire:confirm="Yakin ingin menghapus pengajuan ini?"
                                            class="p-1.5 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors"
                                            title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-50 dark:bg-gray-900 mb-3">
                                            <svg class="w-8 h-8 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>
                                        </div>
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Belum ada pengajuan</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Ajukan cuti atau izin untuk memulai</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($leaveRequests->hasPages())
                <div class="px-6 py-3 border-t border-gray-50 dark:border-gray-800">
                    {{ $leaveRequests->links() }}
                </div>
            @endif
        </div>

        {{-- PENGAJUAN MODAL --}}
        <div x-data="{ open: $wire.entangle('showPengajuanModal') }"
             x-show="open" x-cloak
             class="fixed inset-0 z-50 flex items-start justify-center p-4 pt-10 bg-gray-900/60 backdrop-blur-sm overflow-y-auto"
             @click="open = false">
            <div @click.stop class="relative w-full max-w-lg rounded-2xl bg-white dark:bg-gray-800 p-8 shadow-2xl my-10">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Ajukan Cuti / Izin</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Isi form pengajuan di bawah ini</p>
                    </div>
                    <button wire:click="closePengajuanModal" class="rounded-xl p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form wire:submit.prevent="submitPengajuan" class="space-y-4">
                    <div>
                        <x-input-label value="Jenis *" />
                        <div class="mt-2 grid grid-cols-2 gap-3">
                            @if($sisaCuti > 0)
                            <label class="relative flex cursor-pointer flex-col items-center gap-2 rounded-xl border-2 p-4 text-center text-sm font-medium transition-all"
                                   :class="'cuti_tahunan' === $wire.pengajuanJenis ? 'border-emerald-500 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-300' : 'border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:border-gray-300 dark:hover:border-gray-500'">
                                <input type="radio" wire:model="pengajuanJenis" value="cuti_tahunan" class="sr-only">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12"/></svg>
                                <span>Cuti Tahunan</span>
                            </label>
                            @else
                            <div class="relative flex flex-col items-center gap-2 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 p-4 text-center text-sm font-medium text-gray-400 dark:text-gray-500 opacity-60 cursor-not-allowed">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12"/></svg>
                                <span>Cuti Tahunan</span>
                                <span class="text-[10px] text-red-500 font-semibold">Jatah cuti sudah habis</span>
                            </div>
                            @endif
                            <label class="relative flex cursor-pointer flex-col items-center gap-2 rounded-xl border-2 p-4 text-center text-sm font-medium transition-all"
                                   :class="'izin' === $wire.pengajuanJenis ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : 'border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:border-gray-300 dark:hover:border-gray-500'">
                                <input type="radio" wire:model="pengajuanJenis" value="izin" class="sr-only">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Izin</span>
                            </label>
                        </div>
                        @error('pengajuanJenis') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <x-input-label for="tgl-mulai" value="Tanggal Mulai *" />
                            <x-text-input id="tgl-mulai" wire:model="pengajuanTanggalMulai" type="date" class="mt-1 block w-full" />
                            @error('pengajuanTanggalMulai') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <x-input-label for="tgl-selesai" value="Tanggal Selesai *" />
                            <x-text-input id="tgl-selesai" wire:model="pengajuanTanggalSelesai" type="date" class="mt-1 block w-full" />
                            @error('pengajuanTanggalSelesai') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <x-input-label for="keterangan" value="Keterangan *" />
                        <textarea id="keterangan" wire:model="pengajuanKeterangan" rows="3" class="mt-1 block w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2.5 text-sm text-gray-900 dark:text-gray-100 focus:border-primary-400 focus:ring-2 focus:ring-primary-100 outline-none transition-all duration-200" placeholder="Alasan pengajuan..."></textarea>
                        @error('pengajuanKeterangan') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" wire:click="closePengajuanModal" class="btn-secondary text-xs">Batal</button>
                        <button type="submit" class="btn-primary text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            Kirim Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        {{-- Admin/Direksi Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
            <div class="stat-card group">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-200 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>
                    </div>
                    <span class="badge-info">Total</span>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalPengajuan }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Total Pengajuan</p>
            </div>

            <div class="stat-card group">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-green-500 text-white shadow-lg shadow-emerald-200 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12"/></svg>
                    </div>
                    <span class="badge-success">Cuti</span>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalCuti }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Cuti Tahunan</p>
            </div>

            <div class="stat-card group">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 text-white shadow-lg shadow-amber-200 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="badge-warning">Izin</span>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalIzin }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Izin</p>
            </div>

            <div class="stat-card group">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-purple-500 text-white shadow-lg shadow-violet-200 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                    </div>
                    <span class="badge-warning">Menunggu</span>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $menunggu }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Menunggu Persetujuan</p>
            </div>
        </div>

        <div class="card">
            {{-- Filter bar --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 px-6 py-4 border-b border-gray-50 dark:border-gray-800">
                <div class="flex items-center gap-3 flex-1 flex-wrap">
                    @php $myEmployee = auth()->user()->employee; @endphp
                    @if($myEmployee)
                    <button wire:click="openPengajuanModal" class="btn-primary text-xs py-2 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Ajukan Cuti / Izin
                    </button>
                    @endif
                    <div class="relative flex-1 min-w-[200px] max-w-xs">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Cari nama atau NIK..."
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 pl-9 pr-3 py-2 text-xs font-medium text-gray-600 dark:text-gray-400 focus:border-primary-400 focus:ring-2 focus:ring-primary-100 outline-none transition-all duration-200"
                        >
                    </div>

                    <select wire:model.live="filterJenis" class="rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-xs font-medium text-gray-600 dark:text-gray-400 focus:border-primary-400 focus:ring-2 focus:ring-primary-100 outline-none transition-all duration-200">
                        <option value="">Semua Jenis</option>
                        <option value="cuti_tahunan">Cuti Tahunan</option>
                        <option value="izin">Izin</option>
                    </select>

                    <select wire:model.live="filterStatus" class="rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-xs font-medium text-gray-600 dark:text-gray-400 focus:border-primary-400 focus:ring-2 focus:ring-primary-100 outline-none transition-all duration-200">
                        <option value="">Semua Status</option>
                        <option value="menunggu">Menunggu</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="table-header">
                            <th class="px-6 py-3 w-12 text-center">No</th>
                            <th class="px-6 py-3">Nama Karyawan</th>
                            <th class="px-6 py-3">Jabatan</th>
                            <th class="px-6 py-3">Jenis</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Durasi</th>
                            <th class="px-6 py-3">Atasan</th>
                            <th class="px-6 py-3">Persetujuan Atasan</th>
                            <th class="px-6 py-3">Persetujuan HR</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @forelse($leaveRequests as $lr)
                            @php
                                $isAtasan = $userEmployee && $userEmployee->id === $lr->atasan_id;
                                $canApproveKoor = $isAtasan;
                                $canApproveHr = $user->id === 4 || $isHr;
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-900 transition-colors">
                                <td class="table-cell text-center text-gray-500 dark:text-gray-400">{{ $leaveRequests->firstItem() + $loop->index }}</td>
                                <td class="table-cell">
                                    <div class="flex items-center gap-2">
                                        @if($lr->employee?->foto)
                                            <img src="{{ asset('storage/employees/' . $lr->employee->foto) }}" alt="{{ $lr->employee->nama }}" class="w-8 h-8 rounded-lg object-contain bg-gray-50">
                                        @else
                                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary-100 dark:bg-primary-900/50 text-primary-600 dark:text-primary-400 font-semibold text-xs">
                                                {{ strtoupper(substr($lr->employee->nama ?? '?', 0, 1)) }}
                                            </div>
                                        @endif
                                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ $lr->employee->nama ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="table-cell text-gray-600 dark:text-gray-400">{{ $lr->employee?->position ?? '-' }}</td>
                                <td class="table-cell">
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $lr->jenis === 'cuti_tahunan' ? 'Cuti Tahunan' : 'Izin' }}</span>
                                </td>
                                <td class="table-cell text-gray-600 dark:text-gray-400 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($lr->tanggal_mulai)->format('d/m') }} - {{ \Carbon\Carbon::parse($lr->tanggal_selesai)->format('d/m/Y') }}
                                </td>
                                <td class="table-cell text-gray-600 dark:text-gray-400">{{ $lr->durasi }}</td>
                                <td class="table-cell text-gray-600 dark:text-gray-400">{{ $lr->atasan?->nama ?? '-' }}</td>
                                <td class="table-cell">
                                    @if($lr->persetujuan_koor === 'disetujui')
                                        <span class="badge-success">Disetujui</span>
                                    @elseif($lr->persetujuan_koor === 'ditolak')
                                        <span class="badge-danger">Ditolak</span>
                                    @else
                                        <div class="flex items-center gap-1">
                                            <span class="badge-warning">Menunggu</span>
                                            @if($canApproveKoor)
                                            <button @click="confirmAction = true; confirmTitle = 'Setujui Pengajuan'; confirmMessage = 'Apakah Anda yakin ingin menyetujui pengajuan ini?'; confirmHandler = () => $wire.setujui({{ $lr->id }}, 'persetujuan_koor')" class="p-1 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 rounded-md transition-colors" title="Setujui">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </button>
                                            <button @click="confirmAction = true; confirmTitle = 'Tolak Pengajuan'; confirmMessage = 'Apakah Anda yakin ingin menolak pengajuan ini?'; confirmHandler = () => $wire.tolak({{ $lr->id }}, 'persetujuan_koor')" class="p-1 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-md transition-colors" title="Tolak">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="table-cell">
                                    @if($lr->persetujuan_hr === 'disetujui')
                                        <span class="badge-success">Disetujui</span>
                                    @elseif($lr->persetujuan_hr === 'ditolak')
                                        <span class="badge-danger">Ditolak</span>
                                    @else
                                        <div class="flex items-center gap-1">
                                            <span class="badge-warning">Menunggu</span>
                                            @if($canApproveHr)
                                            <button @click="confirmAction = true; confirmTitle = 'Setujui Pengajuan'; confirmMessage = 'Apakah Anda yakin ingin menyetujui pengajuan ini?'; confirmHandler = () => $wire.setujui({{ $lr->id }}, 'persetujuan_hr')" class="p-1 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 rounded-md transition-colors" title="Setujui">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </button>
                                            <button @click="confirmAction = true; confirmTitle = 'Tolak Pengajuan'; confirmMessage = 'Apakah Anda yakin ingin menolak pengajuan ini?'; confirmHandler = () => $wire.tolak({{ $lr->id }}, 'persetujuan_hr')" class="p-1 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-md transition-colors" title="Tolak">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="table-cell">
                                    @can('delete-data')
                                    <button wire:click="hapusAdmin({{ $lr->id }})"
                                            wire:confirm="Yakin ingin menghapus pengajuan ini?"
                                            class="p-1.5 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors"
                                            title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    </button>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-50 dark:bg-gray-900 mb-3">
                                            <svg class="w-8 h-8 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>
                                        </div>
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Belum ada pengajuan</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Belum ada data pengajuan cuti atau izin</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($leaveRequests->hasPages())
                <div class="px-6 py-3 border-t border-gray-50 dark:border-gray-800">
                    {{ $leaveRequests->links() }}
                </div>
            @endif
        </div>
    @endif

    {{-- NOTIFICATION TOAST --}}
    <div x-data="{ show: false, message: '', type: 'success' }"
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 4000)"
         x-show="show" x-cloak
         class="fixed bottom-6 right-6 z-[100] flex items-center gap-3 rounded-xl px-5 py-3.5 text-sm font-medium shadow-xl"
         :class="type === 'success' ? 'bg-emerald-600 text-white' : 'bg-red-600 text-white'">
        <template x-if="type === 'success'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></template>
        <template x-if="type === 'error'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg></template>
         <span x-text="message"></span>
        <button @click="show = false" class="ml-2 hover:opacity-80"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
    </div>

    {{-- Confirmation Modal --}}
    <div x-show="confirmAction" x-cloak
         class="fixed inset-0 z-50 flex items-start justify-center p-4 pt-10 bg-gray-900/60 backdrop-blur-sm overflow-y-auto"
         @click="confirmAction = false">
        <div @click.stop class="relative w-full max-w-sm rounded-2xl bg-white dark:bg-gray-800 p-8 shadow-2xl my-10">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2" x-text="confirmTitle"></h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6" x-text="confirmMessage"></p>
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                <button @click="confirmAction = false" class="btn-secondary text-xs px-6">Batal</button>
                <button @click="confirmHandler(); confirmAction = false" class="btn-primary text-xs px-6">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>
</div>
