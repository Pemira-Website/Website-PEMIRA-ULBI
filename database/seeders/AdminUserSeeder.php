<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the application's admin user.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@pemira.com'],
            [
                'name' => 'Admin PEMIRA',
                'password' => bcrypt('pemira2026'),
            ]
        );
    }
}
