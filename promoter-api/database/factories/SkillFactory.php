<?php

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skill>
 */
class SkillFactory extends Factory
{
    protected $model = Skill::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $skills = [
            'Event Planning',
            'Sound Engineering',
            'Lighting Design',
            'Social Media Management',
            'Public Relations',
            'Stage Management',
            'Audience Engagement',
            'Marketing Strategy',
            'Graphic Design',
            'Photography',
            'Branding',
            'Catering Management',
            'Talent Booking',
            'Logistics Coordination',
            'Crowd Control',
            'Ticketing and Registration',
            'Event Security',
            'Creative Direction',
            'Vendor Coordination',
            'Sponsorship Management',
        ];

        return [
            'name' => $this->faker->randomElement($skills),
            'description' => $this->faker->sentence(),
        ];
    }
}
