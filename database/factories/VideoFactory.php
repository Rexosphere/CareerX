<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Video;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition(): array
    {
        $categories = ['CV Writing', 'Interview Prep', 'Industry Insights', 'Academia'];

        $yt = substr(str_replace(['+', '/', '='], '', base64_encode(fake()->uuid())), 0, 11);

        return [
            'title' => fake()->sentence(6),
            'description' => fake()->paragraphs(2, true),
            'youtube_id' => $yt,
            'thumbnail_url' => null,
            'category' => fake()->randomElement($categories),
            'playlist_id' => null,
            'duration' => fake()->numberBetween(60, 3600),
            'views' => fake()->numberBetween(0, 100000),
        ];
    }
}
