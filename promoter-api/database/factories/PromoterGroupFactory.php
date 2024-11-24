<?php

namespace Database\Factories;

use App\Models\PromoterGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PromoterGroup>
 */
class PromoterGroupFactory extends Factory
{
    protected $model = PromoterGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $promoterGroupThemes = [
            'Latte-Art Baristas',
            'Event Lighting Experts',
            'Sustainable Event Organizers',
            'Social Media Gurus',
            'Luxury Wedding Planners',
            'Tech Meetup Coordinators',
            'Live Music Promoters',
            'Craft Beer Enthusiasts',
            'Food Truck Collaborators',
            'Wellness Retreat Hosts',
        ];

        return [
            'name' => $this->faker->randomElement($promoterGroupThemes),
            'description' => $this->faker->sentence(),
        ];
    }
}
