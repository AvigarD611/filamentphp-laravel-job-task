<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Seed users for each role
        $users = [
            'Super Admin' => 'superadmin@example.com',
            'Admin' => 'admin@example.com',
            'Editor' => 'editor@example.com',
            'Viewer' => 'viewer@example.com',
        ];

        foreach ($users as $roleName => $email) {
            $user = User::firstOrCreate([
                'name' => $roleName,
                'email' => $email,
            ], [
                'password' => bcrypt('password'), // Default password for seeded users
            ]);

            // Assign role to the user
            $user->assignRole($roleName);
        }

        $this->command->info('Users seeded successfully with roles!');
    }
}
