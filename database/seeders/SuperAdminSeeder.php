<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sekolypro.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('sekolypro'),
                'role' => 'super_admin',
            ]
        );
    }
}
