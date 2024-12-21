<?php

namespace Tests\Feature;

use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Models\User;
use App\Models\AdTemplate;
use App\Models\Ad;
use App\Filament\Resources\AdTemplateResource\Pages\CreateAdTemplate;
use App\Filament\Resources\AdTemplateResource\Pages\EditAdTemplate;

class AdTemplateCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles and permissions
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_admin_can_create_an_ad_template()
    {
        $user = User::factory()->create()->assignRole('Admin');
        $ad = Ad::factory()->create();

        $this->actingAs($user);

        Livewire::test(CreateAdTemplate::class)
            ->set('data.title', 'Test Template')
            ->set('data.description', 'This is a test template.')
            ->set('data.status', 'active')
            ->set('data.canva_url', 'https://example.com/canva')
            ->set('data.ad_id', $ad->id)
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('ad_templates', [
            'title' => 'Test Template',
            'description' => 'This is a test template.',
            'status' => 'active',
            'canva_url' => 'https://example.com/canva',
            'ad_id' => $ad->id,
        ]);
    }

    public function test_admin_can_update_an_ad_template()
    {
        $user = User::factory()->create()->assignRole('Admin');
        $ad = Ad::factory()->create();
        $template = AdTemplate::factory()->create([
            'title' => 'Old Template',
            'description' => 'Old Description',
            'status' => 'draft',
            'canva_url' => 'https://example.com/old-canva',
            'ad_id' => $ad->id,
        ]);

        $this->actingAs($user);

        Livewire::test(EditAdTemplate::class, ['record' => $template->id])
            ->set('data.title', 'Updated Template')
            ->set('data.description', 'Updated Description')
            ->set('data.status', 'archived')
            ->set('data.canva_url', 'https://example.com/updated-canva')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('ad_templates', [
            'id' => $template->id,
            'title' => 'Updated Template',
            'description' => 'Updated Description',
            'status' => 'archived',
            'canva_url' => 'https://example.com/updated-canva',
        ]);
    }
}
