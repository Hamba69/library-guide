<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Topic>
 */
class TopicFactory extends Factory
{
    public function definition(): array
    {
        return [
            'subject_id'              => Subject::factory(),
            'title'                   => fake()->randomElement([
                'Set Theory', 'Algebra & Equations', 'Trigonometry', 'Statistics & Probability',
                'Cell Biology', 'Genetics & Heredity', 'Photosynthesis', 'Human Body Systems',
                'Acids, Bases & Salts', 'Organic Chemistry', 'Atomic Structure',
                'Map Reading & Interpretation', 'Climate & Weather', 'Population Studies',
                'Newton\'s Laws of Motion', 'Electricity & Magnetism', 'Waves & Sound',
                'Computer Hardware & Software', 'Internet & Networking', 'Spreadsheets',
                'Crop Production', 'Soil Science',
            ]),
            'competency_description'  => fake()->paragraph(3),
        ];
    }
}
