<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make-admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Назначает пользователя администратором по email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("Пользователь с email {$email} не найден!");
            return 1;
        }
        
        $user->role = 'admin';
        $user->save();
        
        $this->info("Пользователь {$user->name} ({$email}) успешно назначен администратором!");
        return 0;
    }
}
