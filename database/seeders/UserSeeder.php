<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Oscar Yusti',
            'email' => 'oyusti@gmail.com',
            'password' => bcrypt('Pass1234**'),
        ]);

        User::factory()
            ->count(10)
            ->create();
    }
}
