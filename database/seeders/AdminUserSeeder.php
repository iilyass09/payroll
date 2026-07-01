<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'gonzaga@johen.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['username' => 'gm'],
            [
                'name' => 'General Manager',
                'email' => 'gm@johen.com',
                'password' => Hash::make('password'),
                'role' => 'direksi',
            ]
        );

        User::where('username', 'admin')->where('role', 'karyawan')->update(['role' => 'admin']);
        User::where('username', 'gm')->where('role', 'karyawan')->update(['role' => 'direksi']);
    }
}
