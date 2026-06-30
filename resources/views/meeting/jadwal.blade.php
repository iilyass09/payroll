<x-app-layout title="Jadwal Meeting">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-lg font-bold text-gray-900 dark:text-gray-100">Jadwal Meeting</h1>
            <p class="text-xs text-gray-400 mt-0.5">Daftar jadwal meeting</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('meeting.jadwal', ['view' => 'list', 'month' => $month, 'year' => $year]) }}"
               class="btn-ghost text-xs {{ $view === 'list' ? 'bg-gray-100 dark:bg-gray-800' : '' }}">List</a>
            <a href="{{ route('meeting.jadwal', ['view' => 'month', 'month' => $month, 'year' => $year]) }}"
               class="btn-ghost text-xs {{ $view === 'month' ? 'bg-gray-100 dark:bg-gray-800' : '' }}">Bulan</a>
        </div>
    </div>

    <div class="card p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('meeting.jadwal', ['month' => $month - 1, 'year' => $month == 1 ? $year - 1 : $year, 'view' => $view]) }}"
               class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                {{ \Carbon\Carbon::create($year, $month)->translatedFormat('F Y') }}
            </h2>
            <a href="{{ route('meeting.jadwal', ['month' => $month + 1, 'year' => $month == 12 ? $year + 1 : $year, 'view' => $view]) }}"
               class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        {{-- Legend --}}
        <div class="flex flex-wrap items-center gap-4 mb-4 text-xs text-gray-500">
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> Di Booking</span>
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span> Berlangsung</span>
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span> Antrian</span>
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Selesai</span>
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span> Mingguan</span>
        </div>

        {{-- Calendar Grid --}}
        @if($view === 'month')
            @php
                $startOfMonth = \Carbon\Carbon::create($year, $month)->startOfMonth();
                $endOfMonth = \Carbon\Carbon::create($year, $month)->endOfMonth();
                $startOfCalendar = $startOfMonth->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
                $endOfCalendar = $endOfMonth->copy()->endOfWeek(\Carbon\Carbon::SATURDAY);
                $days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
            @endphp

            <div class="grid grid-cols-7 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                @foreach($days as $day)
                    <div class="px-3 py-2 text-xs font-semibold text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 text-center border-b border-gray-200 dark:border-gray-700">{{ $day }}</div>
                @endforeach

                @for($date = $startOfCalendar; $date <= $endOfCalendar; $date->addDay())
                    @php
                        $isToday = $date->isToday();
                        $isCurrentMonth = $date->month === $month;
                        $dayMeetings = $meetings->filter(function ($m) use ($date) {
                            if ($m->recurring_day) {
                                return strtolower($date->englishDayOfWeek) === strtolower($m->recurring_day);
                            }
                            return $m->date && $m->date->isSameDay($date);
                        });
                    @endphp
                    <div class="min-h-[100px] px-2 py-1.5 border-b border-r border-gray-100 dark:border-gray-800 {{ $isCurrentMonth ? 'bg-white dark:bg-gray-900' : 'bg-gray-50 dark:bg-gray-950' }} {{ $isToday ? 'ring-2 ring-blue-500 ring-inset' : '' }}">
                        <p class="text-xs font-medium mb-1 {{ $isToday ? 'text-blue-600' : ($isCurrentMonth ? 'text-gray-900 dark:text-gray-100' : 'text-gray-400 dark:text-gray-600') }}">
                            {{ $date->day }}
                        </p>
                        <div class="space-y-0.5">
                            @foreach($dayMeetings->take(3) as $meeting)
                                <div @click="$dispatch('open-detail', { id: {{ $meeting->id }} })"
                                     class="text-[10px] px-1.5 py-0.5 rounded cursor-pointer font-medium
                                        {{ $meeting->status === 'completed' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : '' }}
                                        {{ $meeting->status === 'ongoing' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}
                                        {{ $meeting->status === 'booked' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : '' }}
                                        {{ $meeting->status === 'cancelled' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' : '' }}
                                        {{ $meeting->recurring_type ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300' : '' }}">
                                    @if($meeting->recurring_type) ⟳ @endif
                                    {{ \Carbon\Carbon::parse($meeting->start_time)->format('H:i') }} {{ $meeting->title }}
                                </div>
                            @endforeach
                            @if($dayMeetings->count() > 3)
                                <p class="text-[10px] text-gray-400 pl-1">+{{ $dayMeetings->count() - 3 }} lainnya</p>
                            @endif
                        </div>
                    </div>
                @endfor
            </div>
        @else
            {{-- List View --}}
            <div class="space-y-3">
                @forelse($meetings->sortBy('date') as $meeting)
                    <div @click="$dispatch('open-detail', { id: {{ $meeting->id }} })"
                         class="flex items-center gap-4 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer transition-colors border border-gray-100 dark:border-gray-800">
                        <div class="flex-shrink-0 w-16 text-center">
                            <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $meeting->date ? $meeting->date->format('d') : '⟳' }}</p>
                            <p class="text-[10px] text-gray-500">{{ $meeting->date ? $meeting->date->format('M') : 'Ulang' }}</p>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">
                                @if($meeting->recurring_type) ⟳ @endif
                                {{ $meeting->title }}
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ \Carbon\Carbon::parse($meeting->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($meeting->end_time)->format('H:i') }}
                                · {{ $meeting->room }}
                            </p>
                        </div>
                        @php
                            $statusLabels = ['booked' => 'Di Booking', 'ongoing' => 'Berlangsung', 'queue' => 'Antrian', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'];
                            $statusClasses = ['booked' => 'badge-info', 'ongoing' => 'badge-warning', 'queue' => 'badge-warning', 'completed' => 'badge-success', 'cancelled' => 'badge-danger'];
                        @endphp
                        <span class="{{ $statusClasses[$meeting->status] ?? 'badge-info' }} text-[10px]">
                            {{ $statusLabels[$meeting->status] ?? $meeting->status }}
                        </span>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-12">
                        <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800 mb-4">
                            <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-1">Belum Ada Jadwal Meeting</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada jadwal meeting bulan ini</p>
                    </div>
                @endforelse
            </div>
        @endif
    </div>

    {{-- Meeting Detail Modal --}}
    @php
        $meetingsJson = $meetings->map(fn($m) => [
            'id' => $m->id,
            'title' => $m->title,
            'room' => $m->room,
            'team' => $m->team ?? '-',
            'start_time' => $m->start_time,
            'end_time' => $m->end_time,
            'actual_end_time' => $m->actual_end_time ? $m->actual_end_time->format('H:i') . ' WIB' : '-',
            'status' => $m->status,
            'description' => $m->description ?? '-',
            'recurring_type' => $m->recurring_type,
            'creator' => $m->creator?->name ?? '-',
        ])->toJson();
    @endphp
    <div x-data="{ open: false, meeting: null }"
         @open-detail.window="
            open = true;
            meeting = {{ $meetingsJson }}.find(m => m.id === $event.detail.id)
         "
         x-show="open" x-cloak
         class="fixed inset-0 z-50 flex items-start justify-center p-4 pt-10 bg-gray-900/60 backdrop-blur-sm overflow-y-auto"
         @click="open = false">
        <div @click.stop class="relative w-full max-w-lg rounded-2xl bg-white dark:bg-gray-800 p-8 shadow-2xl my-10">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100" x-text="meeting?.title"></h3>
                </div>
                <button @click="open = false" class="rounded-xl p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="space-y-4" x-show="meeting">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Ruangan</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="meeting?.room"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Tim</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="meeting?.team"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Jam Mulai</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="meeting?.start_time"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Jam Selesai (Est.)</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="meeting?.end_time"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Jam Selesai Aktual</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="meeting?.actual_end_time"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Status</p>
                        <p class="text-sm font-medium" x-text="meeting?.status"></p>
                    </div>
                </div>
                <div x-show="meeting?.recurring_type">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Jenis</p>
                    <p class="text-sm font-medium text-purple-600 dark:text-purple-400">
                        ⟳ <span x-text="meeting?.recurring_type === 'weekly' ? 'Mingguan' : meeting?.recurring_type"></span>
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Dibuat Oleh</p>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="meeting?.creator"></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
