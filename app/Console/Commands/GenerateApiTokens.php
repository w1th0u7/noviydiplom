<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Str;

class GenerateApiTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-api-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate API tokens for all users who do not have one';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Starting API token generation...");
        
        // Сначала выведем информацию о всех пользователях
        $allUsers = User::all();
        $this->info("Total users in database: " . $allUsers->count());
        
        foreach ($allUsers as $user) {
            $this->info("User: {$user->name}, Email: {$user->email}, Current token: " . ($user->api_token ?: 'NULL'));
        }
        
        // Теперь генерируем токены только для тех, у кого их нет
        $users = User::whereNull('api_token')->get();
        $this->info("Found {$users->count()} users without API tokens.");
        
        $count = 0;
        foreach ($users as $user) {
            $user->api_token = (string)Str::uuid();
            $user->save();
            $this->info("Generated token for {$user->name}: {$user->api_token}");
            $count++;
        }
        
        $this->info("Successfully generated API tokens for {$count} users.");
    }
}
