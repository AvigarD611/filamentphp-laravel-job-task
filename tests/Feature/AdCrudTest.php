<?php

namespace Tests\Feature;

use App\Filament\Resources\AdResource\Pages\CreateAd;
use App\Filament\Resources\AdResource\Pages\ListAds;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Models\User;
use App\Models\Ad;
use App\Filament\Resources\AdResource\Pages\EditAd;

class AdCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles and permissions
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_admin_can_create_an_ad()
    {
        $user = User::factory()->create()->assignRole('Admin');

        $this->actingAs($user);

        Livewire::test(CreateAd::class)
            ->set('data.title', 'Test Ad')
            ->set('data.description', 'This is a test ad.')
            ->set('data.url', 'https://example.com')
            ->set('data.status', 'pending')
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('ads', [
            'title' => 'Test Ad',
            'description' => 'This is a test ad.',
            'url' => 'https://example.com',
            'status' => 'pending',
        ]);
    }

    public function test_admin_can_update_an_ad()
    {
        $user = User::factory()->create()->assignRole('Admin');
        $ad = Ad::factory()->create([
            'title' => 'Old Title',
            'description' => 'Old Description',
            'url' => 'https://example.com',
            'status' => 'pending',
        ]);

        $this->actingAs($user);

        Livewire::test(EditAd::class, ['record' => $ad->id])
            ->set('data.title', 'Updated Title')
            ->set('data.description', 'Updated Description')
            ->set('data.url', 'https://updated-url.com')
            ->set('data.status', 'completed')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('ads', [
            'id' => $ad->id,
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'url' => 'https://updated-url.com',
            'status' => 'completed',
        ]);
    }

    public function test_admin_can_view_ads_table()
    {
        $user = User::factory()->create()->assignRole('Admin');
        $ads = Ad::factory()->count(5)->create();

        $this->actingAs($user);

        Livewire::test(ListAds::class)
            ->assertCanSeeTableRecords($ads);
    }
}
