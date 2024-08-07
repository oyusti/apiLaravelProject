<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $post = Post::factory()
            ->count(20)
            ->hasImages(1, function (array $attributes, Post $post) {
                return ['imageable_id' => $post->id,
                        'imageable_type' => Post::class];
            })
            //->has(Tag::factory()->count(3), 'tags')
            ->create()
            ->each(function (Post $post) {
                $post->tags()->attach([
                    rand(1,4),
                    rand(5,8),
                ]);
            });

        
    }
}
