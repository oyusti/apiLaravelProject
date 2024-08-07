<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->word(20);
        return [
            'title' => $name,
            'slug' => Str::slug($name),
            'extract' => fake()->text(200),
            'body' => fake()->text(2000),
            'status' => fake()->randomElement([Post::DRAFT, Post::PUBLISHED]),
            'category_id' => Category::all()->random()->id,
            'user_id' => User::all()->random()->id,
        ];
    }
}
