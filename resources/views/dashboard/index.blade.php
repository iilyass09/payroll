@push('topbar-left')
    <div>
        <h1 class="text-lg font-bold text-gray-900 dark:text-gray-100">Dashboard</h1>
        <p class="text-xs text-gray-400 mt-0.5">Ringkasan payroll</p>
    </div>
@endpush

<x-app-layout title="Dashboard">

<div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
    <div class="card p-5">
        <div class="flex items-center gap-3 mb-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 15.75V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
            </div>
            <span class="badge-info">Total</span>
        </div>
        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalImports }}</p>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total Import Payroll</p>
    </div>

    <div class="card p-5">
        <div class="flex items-center gap-3 mb-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <span class="badge-success">Total</span>
        </div>
        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalEmployees }}</p>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total Karyawan</p>
    </div>

    <div class="card p-5">
        <div class="flex items-center gap-3 mb-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3"/></svg>
            </div>
            <span class="badge-warning">Total</span>
        </div>
        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">Rp {{ number_format($totalPayroll, 0, ',', '.') }}</p>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total Nominal Payroll</p>
    </div>
</div>

@if($recentImports->count() > 0)
<div class="card mt-6 p-5">
    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-4">Import Terbaru</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="table-header">
                    <th class="px-3 py-2 text-[10px] text-left">Periode</th>
                    <th class="px-3 py-2 text-[10px] text-left">File</th>
                    <th class="px-3 py-2 text-[10px] text-left">Karyawan</th>
                    <th class="px-3 py-2 text-[10px] text-left">Total</th>
                    <th class="px-3 py-2 text-[10px] text-left">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                @foreach($recentImports as $import)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    <td class="px-3 py-2.5 text-xs font-medium text-gray-900 dark:text-gray-100">{{ $import->periode }}</td>
                    <td class="px-3 py-2.5 text-xs text-gray-600 dark:text-gray-400">{{ $import->file_name }}</td>
                    <td class="px-3 py-2.5 text-xs text-gray-600 dark:text-gray-400">{{ $import->total_employee }}</td>
                    <td class="px-3 py-2.5 text-xs font-medium text-gray-900 dark:text-gray-100">Rp {{ number_format($import->total_payroll, 0, ',', '.') }}</td>
                    <td class="px-3 py-2.5 text-xs text-gray-500 dark:text-gray-400">{{ $import->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

</x-app-layout>
