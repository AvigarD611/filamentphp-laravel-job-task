<?php

namespace Tests\Feature;

use App\Filament\Resources\AdResource\Pages\CreateAd;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdValidationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles and permissions
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_validation_errors_when_creating_an_ad()
    {
        $user = User::factory()->create()->assignRole('Admin');

        $this->actingAs($user);

        Livewire::test(CreateAd::class)
            ->set('data.title', '') // Missing title
            ->set('data.url', 'invalid-url') // Invalid URL
            ->call('create')
            ->assertHasErrors(['data.title' => 'required', 'data.url' => 'url']);
    }
}
