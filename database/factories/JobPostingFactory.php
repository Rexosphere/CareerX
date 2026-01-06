<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\JobPosting;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobPosting>
 */
class JobPostingFactory extends Factory
{
    protected $model = JobPosting::class;

    public function definition(): array
    {
        $types = ['Full-time', 'Part-time', 'Contract', 'Internship'];
        $categories = ['Engineering', 'Design', 'Data Science', 'Product', 'Marketing', 'Finance'];

        $min = fake()->numberBetween(30000, 70000);
        $max = $min + fake()->numberBetween(10000, 100000);

        return [
            'company_id' => null, // set in seeder when attaching to company
            'title' => fake()->jobTitle(),
            'company_name' => fake()->company(),
            'company_logo' => 'https://via.placeholder.com/120',
            'description' => fake()->paragraphs(3, true),
            'prerequisites' => fake()->sentences(2, true),
            'location' => fake()->city() . ', ' . fake()->country(),
            'type' => fake()->randomElement($types),
            'category' => fake()->randomElement($categories),
            'salary_range' => sprintf('%s-%s', number_format($min), number_format($max)),
            'requirements' => fake()->randomElements(['Teamwork','Communication','Problem solving','Golang','PHP','Laravel','React','SQL','Machine Learning'], 4),
            'is_active' => fake()->boolean(85),
            'application_deadline' => fake()->optional()->dateTimeBetween('now', '+120 days')?->format('Y-m-d'),
        ];
    }
}
