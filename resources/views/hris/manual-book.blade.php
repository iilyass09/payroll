@push('topbar-left')
    <div>
        <h1 class="text-lg font-bold text-gray-900 dark:text-gray-100">Pengaturan</h1>
        <p class="text-xs text-gray-400 mt-0.5">Manajemen dokumen & jobdesk karyawan</p>
    </div>
@endpush

<x-app-layout title="Pengaturan">

<div x-data="{ showPdfModal: false, openPdf: '' }">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($books as $book)
        @php
            $color = $book['icon_color'];
            $coverBg = [
                'red' => 'bg-gradient-to-br from-red-600 via-red-500 to-rose-600',
                'blue' => 'bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600',
                'emerald' => 'bg-gradient-to-br from-emerald-600 via-emerald-500 to-teal-600'
            ][$color] ?? 'bg-gradient-to-br from-gray-600 via-gray-500 to-slate-600';
            $spineBg = [
                'red' => 'bg-red-700',
                'blue' => 'bg-blue-700',
                'emerald' => 'bg-emerald-700'
            ][$color] ?? 'bg-gray-700';
        @endphp
        <div @click="openPdf = '{{ $book['file'] }}'; showPdfModal = true"
             class="group relative cursor-pointer bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-gray-200 dark:border-gray-700 overflow-hidden">

            <div class="p-5">
                <div class="flex items-center gap-4 mb-4">
                    <div class="{{ $coverBg }} p-3 rounded-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-1">{{ $book['title'] }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $book['description'] }}</p>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 dark:bg-gray-700 px-2.5 py-1 text-xs font-medium text-gray-600 dark:text-gray-300">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        PDF
                    </span>
                    <div class="text-blue-600 dark:text-blue-400 group-hover:text-blue-700 dark:group-hover:text-blue-300 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- PDF Preview Modal --}}
    <div x-show="showPdfModal" x-cloak
         class="fixed inset-0 z-50 flex items-start justify-center p-4 pt-10 bg-gray-900/60 backdrop-blur-sm overflow-y-auto"
         @click="showPdfModal = false">
        <div @click.stop class="relative w-full max-w-4xl rounded-2xl bg-white dark:bg-gray-800 shadow-2xl my-10">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 capitalize" x-text="'Manual Book — ' + openPdf.replace('.pdf', '').replace('book-', '')">Dokumen Manual</h3>
                <button @click="showPdfModal = false" class="rounded-xl p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <iframe :src="'/storage/manual-books/' + openPdf" class="w-full h-[80vh] rounded-b-2xl" frameborder="0"></iframe>
        </div>
    </div>
</div>

</x-app-layout>
