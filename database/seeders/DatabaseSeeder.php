<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tour;
use Illuminate\Database\Seeder;
use App\Models\User;

// Импортируйте класс User
use Illuminate\Support\Facades\Hash;
use Faker\Factory;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        $user = User::create([
            'name' => 'Artem',
            'email' => 'unique_email@example.com', // Убедитесь, что это значение уникально
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);

        for ($i = 0; $i < 10; $i++) {
            Tour::create([
                'name' => $faker->unique()->word(),
                'season' => $faker->date(),
                'description' => $faker->word(200),
                'image' => $faker->word(),
                'data' => $faker->dateTime(),
                'price' => $faker->randomFloat(0, 2000, 20000),
            ]);
        }

        for ($i = 0; $i < 50; $i++) {
            Post::create([
                'title' => $faker->unique()->word(),
                'content' => $faker->unique()->text(200),
                'user_id' => $user->id,
            ]);
        }
    }
}

