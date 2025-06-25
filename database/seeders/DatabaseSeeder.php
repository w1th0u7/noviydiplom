<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User;
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

        $adminEmail = 'admin@example.com';
        
        if (!User::where('email', $adminEmail)->exists()) {
            $admin = User::create([
                'name' => 'Администратор',
                'email' => $adminEmail,
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
                'role' => 'admin',
            ]);
            
            echo "Создан пользователь-администратор:\n";
            echo "Email: {$adminEmail}\n";
            echo "Пароль: admin123\n";
        }
        
        // Создаем обычного пользователя если он еще не существует

        $userEmail = 'unique_email666@example.com';
        
        if (!User::where('email', $userEmail)->exists()) {
            $faker = Factory::create();
            
            $user = User::create([
                'name' => 'Artem',
                'email' => $userEmail,
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'role' => 'user',
            ]);
        }
    }
}

