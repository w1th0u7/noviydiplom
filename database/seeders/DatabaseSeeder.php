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
        // Вызываем сидеры для туров и экскурсий
        $this->call([
            ToursTableSeeder::class,
            ExcursionsTableSeeder::class
        ]);
        
        // Создаем пользователя-админа
        $faker = Factory::create();

        $user = User::create([
            'name' => 'Artem',
            'email' => 'unique_email666@example.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);

        // Создаем посты для блога
        for ($i = 0; $i < 50; $i++) {
            Post::create([
                'title' => $faker->unique()->word(),
                'content' => $faker->unique()->text(200),
                'user_id' => $user->id,
            ]);
        }
    }
}

