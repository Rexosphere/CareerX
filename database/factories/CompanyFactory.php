<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        $name = fake()->unique()->company();

        return [
            'name' => $name,
            'email' => fake()->unique()->companyEmail(),
            'password' => Hash::make('password'),
            'logo_path' => 'https://via.placeholder.com/200?text=' . urlencode(substr($name, 0, 12)),
            'description' => fake()->paragraphs(2, true),
            'status' => 'active', // Active by default for tests
            'verification_token' => null,
            'verified_at' => now()->subDays(fake()->numberBetween(0, 400)),
        ];
    }
}
