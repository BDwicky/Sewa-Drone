<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@primafam.me')],
            ['name' => 'Admin', 'password' => Hash::make(env('ADMIN_PASSWORD', 'GantiSandiMin8Karakter'))],
        );
    }
}
