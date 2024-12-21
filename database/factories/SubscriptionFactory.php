<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'started_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'canceled_at' => $this->faker->optional()->dateTimeBetween('-6 months', 'now'),
            'is_active' => $this->faker->boolean,
        ];
    }
}
