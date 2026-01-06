<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ResearchProject;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResearchProject>
 */
class ResearchProjectFactory extends Factory
{
    protected $model = ResearchProject::class;

    public function definition(): array
    {
        $tags = fake()->randomElements(['AI','Robotics','Sustainability','Infrastructure','CV','NLP','IoT'], 3);
        $authors = [fake()->name(), fake()->name()];
        $start = fake()->dateTimeBetween('-3 years', '-1 year');
        $end = fake()->optional()->dateTimeBetween($start, 'now');

        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(6),
            'type' => fake()->randomElement(['Thesis','Project','Study','Prototype']),
            'description' => fake()->paragraphs(3, true),
            'status' => fake()->randomElement(['Ongoing','Completed','Published']),
            'authors' => $authors,
            'supervisor' => fake()->name(),
            'department' => fake()->randomElement(['Computer Science','Engineering','Physics','Biology']),
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end ? $end->format('Y-m-d') : null,
            'tags' => $tags,
            'publication_link' => null,
            'doi' => null,
            'conference' => null,
            'journal' => null,
            'abstract' => fake()->paragraphs(2, true),
            'file_path' => null,
            'views' => fake()->numberBetween(0, 5000),
        ];
    }
}
