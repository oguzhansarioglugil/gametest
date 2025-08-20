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
        $this->call([
            HardwareBrandSeeder::class,
            HardwareModelSeeder::class,
            GameSeeder::class,
        ]);

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test',
            'surname' => 'User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'birth_date' => '1990-01-01',
        ]);
    }
}
