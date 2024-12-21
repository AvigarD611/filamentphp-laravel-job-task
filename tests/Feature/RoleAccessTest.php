<?php

namespace Tests\Feature;

use App\Library\Enums\Permissions;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed the database with roles and permissions
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_admin_can_access_ads_page()
    {
        $user = User::factory()->create()->assignRole('Admin');

        $this->assertTrue($user->hasPermissionTo(Permissions::VIEW_AD));

        $this->actingAs($user)
            ->get('/admin/ads')
            ->assertStatus(200);
    }

    public function test_viewer_cannot_access_users_page()
    {
        $user = User::factory()->create()->assignRole('Viewer');

        $this->actingAs($user)
            ->get('/admin/users')
            ->assertStatus(403);
    }

}
