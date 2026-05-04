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
            ['email' => env('ADMIN_EMAIL', 'admin@simi.local')],
            [
                'name' => env('ADMIN_NAME', 'Administrator SIMI'),
                'username' => env('ADMIN_USERNAME', 'admin'),
                'email' => env('ADMIN_EMAIL', 'admin@simi.local'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'admin12345')),
                'role' => 'admin',
                'organization' => env('ADMIN_ORGANIZATION', 'SIMI'),
            ]
        );
    }
}