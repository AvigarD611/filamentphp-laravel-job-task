<?php

namespace Database\Factories;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdTemplate>
 */
class AdTemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->optional()->paragraph,
            'status' => $this->faker->randomElement(['draft', 'active', 'archived']),
            'canva_url' => $this->faker->url,
            'ad_id' => Ad::factory(),
        ];
    }
}
