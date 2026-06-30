@push('topbar-left')
    <div>
        <h1 class="text-lg font-bold text-gray-900 dark:text-gray-100">Dashboard</h1>
        <p class="text-xs text-gray-400 mt-0.5">Ringkasan seluruh data dan aktivitas</p>
    </div>
@endpush

<x-app-layout title="Dashboard">

@if($karyawanView ?? false)

    @if($employee && $karyawanData)
    {{-- Karyawan Profile Header --}}
    <div class="card p-6">
        <div class="flex items-center gap-4">
            @if($employee->foto)
                <img src="{{ asset('storage/employees/' . $employee->foto) }}" alt="{{ $employee->nama }}" class="h-14 w-14 rounded-2xl object-contain bg-gray-50 shadow-lg shrink-0">
            @else
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 text-white font-bold text-xl shadow-lg shrink-0">
                    {{ strtoupper(substr($employee->nama, 0, 1)) }}
                </div>
            @endif
            <div>
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $employee->nama }}</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $employee->position ?? '-' }} • {{ $employee->nik }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500">{{ $employee->division?->nama ?? '-' }} • {{ $employee->lokasi_kerja ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="card p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12"/></svg>
                </div>
                <span class="badge-success">Tahunan</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $karyawanData['sisa_cuti'] }} <span class="text-sm font-medium text-gray-400">/ {{ $karyawanData['jatah_cuti'] }}</span></p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Sisa Cuti Tahunan</p>
        </div>

        <div class="card p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="badge-info">Bulan Ini</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $karyawanData['total_hadir_bulan_ini'] }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Kehadiran Bulan Ini</p>
        </div>

        <div class="card p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                </div>
                <span class="badge-warning">Menunggu</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $karyawanData['pending_count'] }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pengajuan Menunggu</p>
        </div>

        <div class="card p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <span class="badge-danger">Bulan Ini</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $karyawanData['total_absen_bulan_ini'] }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Tidak Hadir Bulan Ini</p>
        </div>
    </div>

    {{-- Bottom Row --}}
    <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Pengajuan Saya --}}
        <div class="card p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">Pengajuan Saya</h3>
                <a href="{{ route('hris.cuti-izin') }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700 hover:underline">Lihat Semua</a>
            </div>
            @if(count($karyawanData['pending_requests']) > 0)
                <div class="space-y-2.5">
                    @foreach($karyawanData['pending_requests'] as $p)
                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                            <div>
                                <p class="text-xs font-semibold text-gray-900 dark:text-gray-100">{{ $p['jenis'] }}</p>
                                <p class="text-[11px] text-gray-500 dark:text-gray-400">{{ $p['tanggal'] }} • {{ $p['durasi'] }}</p>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="text-[10px] font-medium px-2 py-0.5 rounded-full {{ $p['status_koor'] === 'disetujui' ? 'bg-emerald-100 text-emerald-700' : ($p['status_koor'] === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                    Koor: {{ $p['status_koor'] }}
                                </span>
                                <span class="text-[10px] font-medium px-2 py-0.5 rounded-full {{ $p['status_hr'] === 'disetujui' ? 'bg-emerald-100 text-emerald-700' : ($p['status_hr'] === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                    HR: {{ $p['status_hr'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-8 text-center">
                    <svg class="w-8 h-8 mx-auto text-green-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm text-gray-400 dark:text-gray-500">Tidak ada pengajuan menunggu</p>
                </div>
            @endif
        </div>

        {{-- Absensi Terbaru --}}
        <div class="card p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">Absensi Terbaru</h3>
                <a href="{{ route('hris.absensi') }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700 hover:underline">Lihat Semua</a>
            </div>
            @if(count($karyawanData['recent_attendance']) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="table-header">
                                <th class="px-3 py-2 text-[10px]">Tanggal</th>
                                <th class="px-3 py-2 text-[10px]">Masuk</th>
                                <th class="px-3 py-2 text-[10px]">Keluar</th>
                                <th class="px-3 py-2 text-[10px]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                            @foreach($karyawanData['recent_attendance'] as $a)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-900 transition-colors">
                                    <td class="px-3 py-2 text-xs text-gray-600 dark:text-gray-400">{{ $a['date'] }}</td>
                                    <td class="px-3 py-2 text-xs font-mono text-gray-600 dark:text-gray-400">{{ $a['time_in'] }}</td>
                                    <td class="px-3 py-2 text-xs font-mono text-gray-600 dark:text-gray-400">{{ $a['time_out'] }}</td>
                                    <td class="px-3 py-2">
                                        @if($a['status'] === 'tepat waktu')
                                            <span class="badge-success text-[10px] px-1.5 py-0.5">Hadir</span>
                                        @elseif($a['status'] === 'terlambat')
                                            <span class="badge-warning text-[10px] px-1.5 py-0.5">Telat</span>
                                        @elseif($a['status'] === 'tidak hadir')
                                            <span class="badge-danger text-[10px] px-1.5 py-0.5">Alpha</span>
                                        @elseif($a['status'] === 'izin')
                                            <span class="badge-info text-[10px] px-1.5 py-0.5">Izin</span>
                                        @elseif($a['status'] === 'sakit')
                                            <span class="badge-warning text-[10px] px-1.5 py-0.5">Sakit</span>
                                        @elseif($a['status'] === 'cuti')
                                            <span class="badge-info text-[10px] px-1.5 py-0.5">Cuti</span>
                                        @else
                                            <span class="badge-secondary text-[10px] px-1.5 py-0.5">{{ $a['status'] }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-8 text-center">
                    <svg class="w-8 h-8 mx-auto text-gray-300 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>
                    <p class="text-sm text-gray-400 dark:text-gray-500">Belum ada riwayat absensi</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Payroll Terakhir --}}
    @if($karyawanData['latest_payroll'])
    <div class="mt-6">
        <div class="card p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">Slip Gaji Terakhir</h3>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $karyawanData['latest_payroll']['periode'] }}</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-green-500 text-white shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3"/></svg>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="rounded-xl bg-gray-50 dark:bg-gray-800 p-4 text-center">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Gaji Pokok</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-gray-100">Rp {{ number_format($karyawanData['latest_payroll']['gaji_pokok'], 0, ',', '.') }}</p>
                </div>
                <div class="rounded-xl bg-emerald-50 dark:bg-emerald-900/10 p-4 text-center">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Take Home Pay</p>
                    <p class="text-lg font-bold text-emerald-600 dark:text-emerald-400">Rp {{ number_format($karyawanData['latest_payroll']['take_home_pay'], 0, ',', '.') }}</p>
                </div>
                <div class="rounded-xl bg-blue-50 dark:bg-blue-900/10 p-4 text-center flex items-center justify-center">
                    <a href="{{ route('history.index') }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700 hover:underline">
                        Lihat Riwayat
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    @else
    {{-- No employee linked --}}
    <div class="card p-12 text-center">
        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-100 dark:bg-gray-800">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
        </div>
        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Akun Belum Terhubung</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Akun Anda belum terhubung ke data karyawan. Silakan hubungi admin.</p>
    </div>
    @endif

@else
    {{-- Admin / Direksi Dashboard --}}

    {{-- Ringkasan Menu --}}
    <div x-data="{ openDivisiModal: false, openMeetingModal: false }">
    <div class="grid grid-cols-1 md:grid-cols-2 {{ auth()->user()->isDireksi() ? 'xl:grid-cols-4' : 'xl:grid-cols-3' }} gap-5">
        <div @click="openDivisiModal = true" class="card p-5 hover:shadow-md hover:border-blue-100 dark:hover:border-blue-900 transition-all group cursor-pointer">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-indigo-500 text-white shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900 dark:text-gray-100">Data SDM</p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-500">Karyawan & Divisi</p>
                </div>
            </div>
            <div class="flex items-center gap-4 text-sm">
                <div>
                    <span class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $stats['total_employees'] }}</span>
                    <span class="text-gray-400 dark:text-gray-500 ml-1">Karyawan</span>
                </div>
                <div>
                    <span class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $stats['total_divisions'] }}</span>
                    <span class="text-gray-400 dark:text-gray-500 ml-1">Divisi</span>
                </div>
            </div>
        </div>

        @if(auth()->user()->isDireksi())
        <a href="{{ route('history.index') }}" class="card p-5 hover:shadow-md hover:border-blue-100 dark:hover:border-blue-900 transition-all group">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-green-500 text-white shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3"/></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900 dark:text-gray-100">Keuangan</p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-500">Payroll, Bonus & Insentif</p>
                </div>
            </div>
            <div class="flex items-center gap-4 text-sm">
                <div>
                    <span class="text-lg font-bold text-gray-900 dark:text-gray-100">Rp {{ number_format($stats['total_payroll'], 0, ',', '.') }}</span>
                    <span class="text-gray-400 dark:text-gray-500 ml-1 block text-[11px] -mt-0.5">Total Payroll</span>
                </div>
            </div>
        </a>
        @endif

        <div @click="openMeetingModal = true" class="card p-5 hover:shadow-md hover:border-blue-100 dark:hover:border-blue-900 transition-all group cursor-pointer">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-teal-500 to-cyan-500 text-white shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900 dark:text-gray-100">Total Meeting</p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-500">Meeting bulan ini</p>
                </div>
            </div>
            <div class="flex items-center gap-4 text-sm">
                <div>
                    <span class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $meetingStats['total_meetings'] }}</span>
                    <span class="text-gray-400 dark:text-gray-500 ml-1">Meeting</span>
                </div>
            </div>
        </div>

        <div class="card p-5 opacity-70">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-violet-500 text-white shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900 dark:text-gray-100">Data Asset</p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-500">Kendaraan, Digital, SIM Card, dll</p>
                </div>
            </div>
            <div class="flex items-center gap-4 text-sm">
                <div>
                    <span class="text-lg font-bold text-gray-400 dark:text-gray-500">—</span>
                    <span class="text-gray-400 dark:text-gray-500 ml-1">Belum tersedia</span>
                </div>
            </div>
        </div>
    </div>

    {{-- DIVISI MODAL --}}
    <div x-show="openDivisiModal" x-cloak
         class="fixed inset-0 z-50 flex items-start justify-center p-4 pt-10 bg-gray-900/60 backdrop-blur-sm overflow-y-auto"
         @click="openDivisiModal = false">
        <div @click.stop class="relative w-full max-w-2xl rounded-2xl bg-white dark:bg-gray-800 p-8 shadow-2xl my-10">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Pilih Divisi</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Klik divisi untuk melihat daftar karyawan</p>
                </div>
                <button @click="openDivisiModal = false" class="rounded-xl p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('hris.employees.index') }}"
                   class="flex items-center justify-between p-4 rounded-xl border-2 border-primary-100 dark:border-primary-900/50 bg-primary-50/50 dark:bg-primary-900/10 hover:border-primary-300 dark:hover:border-primary-700 transition-all group">
                    <div>
                        <p class="text-sm font-bold text-gray-900 dark:text-gray-100">Semua Karyawan</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Seluruh divisi</p>
                    </div>
                    <span class="text-lg font-bold text-primary-600 dark:text-primary-400">{{ $stats['total_employees'] }}</span>
                </a>

                @foreach($divisionStats as $ds)
                <a href="{{ route('hris.employees.index', ['division' => $ds['id']]) }}"
                   class="flex items-center justify-between p-4 rounded-xl border-2 border-gray-100 dark:border-gray-700 hover:border-primary-200 dark:hover:border-primary-800 hover:bg-primary-50/30 dark:hover:bg-primary-900/5 transition-all group">
                    <div>
                        <p class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $ds['nama'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $ds['total'] }} karyawan</p>
                    </div>
                    <span class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $ds['total'] }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- MEETING MODAL --}}
    <div x-show="openMeetingModal" x-cloak
         class="fixed inset-0 z-50 flex items-start justify-center p-4 pt-10 bg-gray-900/60 backdrop-blur-sm overflow-y-auto"
         @click="openMeetingModal = false">
        <div @click.stop class="relative w-full max-w-2xl rounded-2xl bg-white dark:bg-gray-800 p-8 shadow-2xl my-10">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Meeting per Divisi</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total meeting bulan ini</p>
                </div>
                <button @click="openMeetingModal = false" class="rounded-xl p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex items-center justify-between p-4 rounded-xl border-2 border-teal-100 dark:border-teal-900/50 bg-teal-50/50 dark:bg-teal-900/10 transition-all group">
                    <div>
                        <p class="text-sm font-bold text-gray-900 dark:text-gray-100">Semua Divisi</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Total meeting</p>
                    </div>
                    <span class="text-lg font-bold text-teal-600 dark:text-teal-400">{{ $meetingStats['total_meetings'] }}</span>
                </div>

                @foreach($meetingStats['per_division'] as $md)
                <div class="flex items-center justify-between p-4 rounded-xl border-2 border-gray-100 dark:border-gray-700 transition-all group">
                    <div>
                        <p class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $md['nama'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">0 meeting</p>
                    </div>
                    <span class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $md['total'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>

    {{-- 2x2 Grid --}}
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Kontrak Akan Berakhir --}}
        <div class="card p-5 flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">Kontrak Akan Berakhir</h3>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Karyawan dengan kontrak segera habis</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-rose-500 to-red-500 text-white shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            @if($expiringContractCount > 0)
                <div class="flex-1 space-y-2.5 overflow-y-auto max-h-[200px]">
                    @foreach($expiringContracts as $ec)
                        @php $isUrgent = $ec['days_remaining'] < 3; @endphp
                        <div class="flex items-center justify-between p-2.5 rounded-lg {{ $isUrgent ? 'bg-rose-50 dark:bg-rose-900/10 border-rose-100 dark:border-rose-900/30' : 'bg-amber-50 dark:bg-amber-900/10 border-amber-100 dark:border-amber-900/30' }}">
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $ec['employee'] }}</p>
                                <p class="text-[11px] {{ $isUrgent ? 'text-rose-600 dark:text-rose-400' : 'text-amber-600 dark:text-amber-400' }}">{{ $ec['posisi'] }} • Berakhir {{ $ec['tanggal_berakhir'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pt-3 mt-3 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <span class="text-xs font-semibold text-rose-600 dark:text-rose-400">{{ $expiringContractCount }} kontrak akan berakhir</span>
                    <a href="{{ route('hris.kontrak-kerja') }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700 hover:underline">
                        Lihat Selengkapnya &rarr;
                    </a>
                </div>
            @else
                <div class="flex-1 flex items-center justify-center">
                    <div class="text-center">
                        <svg class="w-8 h-8 mx-auto text-green-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm text-gray-400 dark:text-gray-500">Semua kontrak masih berlaku</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Pengajuan Reimbursement --}}
        <div class="card p-5 flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">Pengajuan Reimbursement</h3>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Pengajuan dana yang perlu diproses</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-cyan-500 to-teal-500 text-white shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                </div>
            </div>
            <div class="flex-1 flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-8 h-8 mx-auto text-green-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm text-gray-400 dark:text-gray-500">Tidak ada pengajuan reimbursement</p>
                </div>
            </div>
        </div>

        {{-- Pengajuan Cuti & Izin --}}
        <div class="card p-5 flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">Pengajuan Cuti & Izin</h3>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Cuti & Izin perlu persetujuan</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 text-white shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                </div>
            </div>
            @if($pendingLeaveCount > 0)
                <div class="flex-1 space-y-2.5 overflow-y-auto max-h-[200px]">
                    @foreach($pendingLeaveRequests as $pl)
                        <div class="flex items-center justify-between p-2.5 rounded-lg bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-900/30">
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $pl['employee'] }}</p>
                                <p class="text-[11px] text-gray-500 dark:text-gray-400">{{ $pl['jenis'] }} • {{ $pl['tanggal'] }}</p>
                            </div>
                            <a href="{{ route('hris.cuti-izin') }}" class="shrink-0 text-[10px] font-semibold text-amber-600 hover:text-amber-700 hover:underline ml-2">
                                Proses
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="pt-3 mt-3 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <span class="text-xs font-semibold text-amber-600 dark:text-amber-400">{{ $pendingLeaveCount }} pengajuan menunggu</span>
                    <a href="{{ route('hris.cuti-izin') }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700 hover:underline">
                        Lihat Selengkapnya &rarr;
                    </a>
                </div>
            @else
                <div class="flex-1 flex items-center justify-center">
                    <div class="text-center">
                        <svg class="w-8 h-8 mx-auto text-green-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm text-gray-400 dark:text-gray-500">Semua sudah diproses</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Pembayaran Mendatang --}}
        <div class="card p-5 flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">Pembayaran Mendatang</h3>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Tagihan & langganan yang perlu diperhatikan</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 text-white shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                </div>
            </div>

            @php
                $internetDays = 5;
                $isUrgent = $internetDays <= 3;
                $internetWarnClass = $isUrgent ? 'bg-rose-50 dark:bg-rose-900/10 border-rose-100 dark:border-rose-900/30' : 'bg-amber-50 dark:bg-amber-900/10 border-amber-100 dark:border-amber-900/30';
                $internetTextClass = $isUrgent ? 'text-rose-600 dark:text-rose-400' : 'text-amber-600 dark:text-amber-400';
                $internetBgIcon = $isUrgent ? 'bg-rose-100 dark:bg-rose-900/20' : 'bg-amber-100 dark:bg-amber-900/20';
                $internetIconClass = $isUrgent ? 'text-rose-600 dark:text-rose-400' : 'text-amber-600 dark:text-amber-400';
            @endphp
            <div class="flex-1 space-y-2.5">
                <div class="flex items-center justify-between p-3 rounded-lg {{ $internetWarnClass }}">
                    <div class="flex items-center gap-3 min-w-0 flex-1">
                        <div class="shrink-0 w-8 h-8 flex items-center justify-center rounded-lg {{ $internetBgIcon }}">
                            <svg class="w-4 h-4 {{ $internetIconClass }}" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 011.06 0z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-gray-900 dark:text-gray-100">Internet</p>
                            <p class="text-[11px] {{ $internetTextClass }}">Mendekati masa tenggang — {{ $internetDays }} hari lagi</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-3 mt-3 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <span class="text-xs font-semibold {{ $isUrgent ? 'text-rose-600 dark:text-rose-400' : 'text-amber-600 dark:text-amber-400' }}">1 pembayaran perlu diperhatikan</span>
                <span class="text-xs font-semibold text-gray-400 cursor-default">Lihat Selengkapnya &rarr;</span>
            </div>
        </div>
    </div>

@endif

</x-app-layout>
