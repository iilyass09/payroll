<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'General Manager',
            'email' => 'gonzaga@johen.com',
            'password' => Hash::make('password'),
        ]);
    }
}
