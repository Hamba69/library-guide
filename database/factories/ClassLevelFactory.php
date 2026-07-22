<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassLevel>
 */
class ClassLevelFactory extends Factory
{
    public function definition(): array
    {
        static $index = 0;
        $levels = ['Senior One', 'Senior Two', 'Senior Three', 'Senior Four'];

        return [
            'name'        => $levels[$index++ % count($levels)],
            'description' => fake()->sentence(12),
        ];
    }
}
