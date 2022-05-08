<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'creative_id' => CreativeFactory::new(),
            'name' => $this->faker->sentence,
            'from' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'to' => $this->faker->dateTimeBetween('now', '+1 years'),
            'total_budget' => $this->faker->randomNumber(4),
            'daily_budget' => $this->faker->randomNumber(2),
        ];
    }
}
