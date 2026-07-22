<?php

namespace Database\Factories;

use App\Models\ClassLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'class_level_id' => ClassLevel::factory(),
            'name'           => fake()->randomElement([
                'Mathematics', 'Biology', 'Chemistry', 'Physics',
                'Geography', 'History', 'English Language', 'Kiswahili',
                'Computer Studies', 'Agriculture',
            ]),
            'code' => strtoupper(fake()->lexify('???')) . '-S' . fake()->numberBetween(1, 4),
        ];
    }
}
