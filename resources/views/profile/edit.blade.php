@push('topbar-left')
    <div>
        <h1 class="text-lg font-bold text-gray-900 dark:text-gray-100">Pengaturan Akun</h1>
        <p class="text-xs text-gray-400 mt-0.5">Kelola informasi profil dan keamanan akun Anda</p>
    </div>
@endpush

<x-app-layout title="Pengaturan">


    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="card p-6">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="card p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="card p-6">
                <div class="text-center mb-6">
                    <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-500 to-violet-500 text-white font-bold text-2xl mx-auto shadow-lg shadow-primary-200">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mt-4">{{ Auth::user()->name }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                    <span class="badge-success mt-2 inline-flex">Akun Aktif</span>
                </div>
            </div>

            <div class="card p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>

</x-app-layout>


