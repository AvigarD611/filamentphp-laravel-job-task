<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed the database with roles and permissions
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_user_can_be_assigned_a_role()
    {
        // Create a user
        $user = User::factory()->create()->assignRole('Admin');

        // Assert the user has the role
        $this->assertTrue($user->hasRole('Admin'));
    }
}
