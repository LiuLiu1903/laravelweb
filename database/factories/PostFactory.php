<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(5),
            'slug' => $this->faker->unique()->slug,
            'description' => $this->faker->paragraph,
            'content' => $this->faker->text(2000),
            'publish_date' => $this->faker->optional()->dateTimeThisYear,
            'status' => $this->faker->numberBetween(0, 2)
        ];
    }
}