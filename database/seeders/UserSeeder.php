<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        DB::table('users')->truncate();
        DB::table('subscriptions')->truncate();

        $now = Carbon::now();

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

        $this->command->info('Users with specific roles seeded successfully!');

        // This is not the best practise -> N+1. It will be better to make it with 1 insert query in each table
        // Total Subscribers 30 Days Ago: 50 users
        for ($i = 1; $i <= 50; $i++) {
            $user = User::create([
                'name' => "Subscriber$i",
                'email' => "subscriber$i@example.com",
                'password' => bcrypt('password'),
            ]);
            $user->assignRole('Viewer');

            $startedAt = $now->copy()->subDays(rand(31, 60)); // Started 31-60 days ago
            $canceledAt = null; // Default: still active

            // Randomly assign churned users
            if ($i <= 10) {
                $canceledAt = $now->copy()->subDays(rand(1, 29)); // Ensure churned within the last 30 days
            }

            Subscription::create([
                'user_id' => $user->id,
                'started_at' => $startedAt,
                'canceled_at' => $canceledAt,
                'is_active' => is_null($canceledAt), // Active if not canceled
            ]);
        }

        $this->command->info("Users with subscriptions seeded successfully!");
    }
}
