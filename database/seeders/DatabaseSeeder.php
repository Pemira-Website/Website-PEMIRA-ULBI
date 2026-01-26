<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create admin user for Filament
        User::updateOrCreate(
            ['email' => 'admin@pemira.com'],
            [
                'name' => 'Admin PEMIRA',
                'password' => bcrypt('pemira2026'),
            ]
        );

        // Seed pemilih data
        $this->call(PemilihSeeder::class);
    }
}
