<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User;

// Импортируйте класс User
use Illuminate\Support\Facades\Hash;
use Faker\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ToursAndExcursionsSeeder::class,
        ]);
        
        // Создаем пользователя-админа только если он еще не существует
        $userEmail = 'unique_email666@example.com';
        
        if (!User::where('email', $userEmail)->exists()) {
            $faker = Factory::create();
            
            $user = User::create([
                'name' => 'Artem',
                'email' => $userEmail,
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]);
        }
    }
}

