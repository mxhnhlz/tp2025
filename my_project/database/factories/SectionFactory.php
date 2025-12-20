<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $icons = ['Lock', 'AlertTriangle', 'Eye', 'Smartphone'];
        $colors = [
            'from-blue-500 to-cyan-500',
            'from-red-500 to-orange-500',
            'from-purple-500 to-pink-500',
            'from-green-500 to-emerald-500',
        ];

        return [
            'title' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(),
            'color' => $colors[$this->faker->numberBetween(0, 3)],
            'icon' => $icons[$this->faker->numberBetween(0, 3)],
            'is_locked' => $this->faker->boolean(25), // 25% вероятность блокировки
            'order' => $this->faker->numberBetween(1, 10),
        ];
    }

}
