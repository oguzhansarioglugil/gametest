<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Test kullanıcıları oluştur (eğer yoksa)
        $users = [
            [
                'name' => 'Admin',
                'surname' => 'User',
                'username' => 'admin',
                'email' => 'turklojenofficial@gmail.com',
                'password' => Hash::make('123456'),
                'birth_date' => '1990-01-01',
                'role' => 'admin',
                'experience_points' => 750,
            ],
            [
                'name' => 'Test',
                'surname' => 'User',
                'username' => 'testuser',
                'email' => 'test@test.com',
                'password' => Hash::make('123456'),
                'birth_date' => '1995-05-15',
                'role' => 'user',
                'experience_points' => 1200,
            ],
            [
                'name' => 'Super',
                'surname' => 'Admin',
                'username' => 'superadmin',
                'email' => 'admin@gametest.com',
                'password' => Hash::make('123456'),
                'birth_date' => '1985-12-25',
                'role' => 'super_admin',
                'experience_points' => 2800,
            ],
        ];

        foreach ($users as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );

            // Rank'i güncelle
            $user->updateRank();
            echo "Kullanıcı güncellenді: {$user->name} - Rank: {$user->rank} - XP: {$user->experience_points}\n";
        }

        // Mevcut tüm kullanıcıların rank'lerini güncelle
        $allUsers = User::all();
        foreach ($allUsers as $user) {
            $user->updateRank();
        }

        echo "Tüm kullanıcıların rank'leri güncellendi.\n";
    }
}
