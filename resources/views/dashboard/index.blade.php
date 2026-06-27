@push('topbar-left')
    <div>
        <h1 class="text-lg font-bold text-gray-900 dark:text-gray-100">Dashboard</h1>
        <p class="text-xs text-gray-400 mt-0.5">Ringkasan seluruh data dan aktivitas</p>
    </div>
@endpush

<x-app-layout title="Dashboard">

    {{-- Ringkasan Menu --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
        <a href="{{ route('hris.employees.index') }}" class="card p-5 hover:shadow-md hover:border-blue-100 transition-all group">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-indigo-500 text-white shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900 dark:text-gray-100">Data SDM</p>
                    <p class="text-[11px] text-gray-400">Karyawan & Divisi</p>
                </div>
            </div>
            <div class="flex items-center gap-4 text-sm">
                <div>
                    <span class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $stats['total_employees'] }}</span>
                    <span class="text-gray-400 ml-1">Karyawan</span>
                </div>
                <div>
                    <span class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $stats['total_divisions'] }}</span>
                    <span class="text-gray-400 ml-1">Divisi</span>
                </div>
            </div>
        </a>

        <a href="{{ route('history.index') }}" class="card p-5 hover:shadow-md hover:border-blue-100 transition-all group">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-green-500 text-white shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3"/></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900 dark:text-gray-100">Keuangan</p>
                    <p class="text-[11px] text-gray-400">Payroll, Bonus & Insentif</p>
                </div>
            </div>
            <div class="flex items-center gap-4 text-sm">
                <div>
                    <span class="text-lg font-bold text-gray-900 dark:text-gray-100">Rp {{ number_format($stats['total_payroll'], 0, ',', '.') }}</span>
                    <span class="text-gray-400 ml-1 block text-[11px] -mt-0.5">Total Payroll</span>
                </div>
            </div>
        </a>

        <div class="card p-5 opacity-70">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 text-white shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900 dark:text-gray-100">Operasional</p>
                    <p class="text-[11px] text-gray-400">Absensi, Cuti & Izin</p>
                </div>
            </div>
            <div class="flex items-center gap-4 text-sm">
                <div>
                    <span class="text-lg font-bold text-gray-400">—</span>
                    <span class="text-gray-400 ml-1">Belum tersedia</span>
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
                    <p class="text-[11px] text-gray-400">Kendaraan, Digital, SIM Card, dll</p>
                </div>
            </div>
            <div class="flex items-center gap-4 text-sm">
                <div>
                    <span class="text-lg font-bold text-gray-400">—</span>
                    <span class="text-gray-400 ml-1">Belum tersedia</span>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
