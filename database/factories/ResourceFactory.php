<?php

namespace Database\Factories;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resource>
 */
class ResourceFactory extends Factory
{
    public function definition(): array
    {
        $type = fake()->randomElement(['Link', 'PDF', 'Video', 'Simulation']);

        $urls = [
            'Link'       => fake()->url(),
            'PDF'        => 'https://www.africaeducation.org/resources/' . fake()->slug() . '.pdf',
            'Video'      => 'https://www.youtube.com/watch?v=' . fake()->regexify('[A-Za-z0-9_-]{11}'),
            'Simulation' => 'https://phet.colorado.edu/sims/' . fake()->slug(),
        ];

        return [
            'topic_id'      => Topic::factory(),
            'title'         => fake()->sentence(5),
            'resource_type' => $type,
            'url'           => $urls[$type],
            'annotation'    => fake()->paragraph(2),
            'is_verified'   => fake()->boolean(70), // 70 % chance of being verified
        ];
    }

    public function verified(): static
    {
        return $this->state(fn (array $attributes) => ['is_verified' => true]);
    }
}
