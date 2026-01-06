<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StudentProfile;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentProfile>
 */
class StudentProfileFactory extends Factory
{
    protected $model = StudentProfile::class;

    public function definition(): array
    {
        $skills = fake()->randomElements(['Python','PHP','Laravel','React','SQL','Research','Data Analysis','Machine Learning','Docker'], 3);

        return [
            'user_id' => User::factory(),
            'profile_photo_path' => null,
            'student_id' => 'S' . fake()->unique()->numerify('#######'),
            'phone' => fake()->phoneNumber(),
            'course' => fake()->randomElement(['BSc Computer Science','BEng Civil','MSc Data Science','BBA']),
            'year' => fake()->numberBetween(1, 5),
            'bio' => fake()->paragraph(),
            'skills' => $skills,
            'experience' => [],
            'projects' => [],
            'cv_path' => null,
            'linkedin' => 'https://linkedin.com/in/' . fake()->userName(),
            'github' => 'https://github.com/' . fake()->userName(),
            'portfolio' => null,
            'gpa' => round(fake()->randomFloat(2, 2.0, 4.0), 2),
            'available_for_hire' => fake()->boolean(60),
        ];
    }
}
