<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Excursion;

class CreateTestExcursion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'excursion:create-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test excursion with start_date and end_date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $excursion = Excursion::create([
                'name' => 'Обзорная экскурсия по Центральному региону',
                'description' => 'Познавательная экскурсия по достопримечательностям Центрального региона России.',
                'location' => 'Центральный регион',
                'region' => 'Центральный',
                'duration' => 3,
                'price' => 3513,
                'image' => 'img/excursions/all-1.jpg',
                'audience_type' => 'all',
                'available_seats' => 30,
                'start_date' => '2025-06-29',
                'end_date' => '2025-12-31',
            ]);
            
            $this->info("Excursion created successfully with ID: " . $excursion->id);
        } catch (\Exception $e) {
            $this->error("Error creating excursion: " . $e->getMessage());
        }
    }
} 