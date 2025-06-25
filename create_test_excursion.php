<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Excursion;

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
    
    echo "Excursion created successfully with ID: " . $excursion->id . PHP_EOL;
} catch (Exception $e) {
    echo "Error creating excursion: " . $e->getMessage() . PHP_EOL;
} 