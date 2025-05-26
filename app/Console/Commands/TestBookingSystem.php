<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Tour;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class TestBookingSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:test {email? : Email пользователя}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Тестирование системы бронирования';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Запуск теста системы бронирования...');
        
        // Определяем пользователя для теста
        $email = $this->argument('email');
        
        if ($email) {
            $user = User::where('email', $email)->first();
            if (!$user) {
                $this->error("Пользователь с email {$email} не найден");
                return 1;
            }
        } else {
            // Берем первого доступного пользователя
            $user = User::first();
            if (!$user) {
                $this->error("В системе нет пользователей для теста");
                return 1;
            }
        }
        
        $this->info("Использую пользователя: {$user->name} (ID: {$user->id})");
        
        // Находим тур для бронирования
        $tour = Tour::first();
        if (!$tour) {
            $this->error("В системе нет туров для бронирования");
            return 1;
        }
        
        $this->info("Использую тур: {$tour->name} (ID: {$tour->id})");
        
        try {
            DB::beginTransaction();
            
            // Создаем бронирование
            $booking = new Booking();
            $booking->user_id = $user->id;
            $booking->guest_name = $user->name;
            $booking->guest_email = $user->email;
            $booking->guest_phone = '1234567890';
            $booking->booking_date = now()->addDays(10);
            $booking->persons = 2;
            $booking->total_price = $tour->price * 2;
            $booking->status = 'pending';
            $booking->notes = 'Тестовое бронирование';
            $booking->bookable_type = 'App\\Models\\Tour';
            $booking->bookable_id = $tour->id;
            
            $booking->save();
            
            DB::commit();
            
            $this->info("Бронирование успешно создано с ID: {$booking->id}");
            
            // Проверяем, что бронирование доступно через связь
            $freshBooking = Booking::with('bookable')->find($booking->id);
            
            if ($freshBooking && $freshBooking->bookable) {
                $this->info("Проверка полиморфной связи: УСПЕШНО");
                $this->info("Бронирование связано с: {$freshBooking->bookable->name}");
                
                $this->table(
                    ['ID', 'Пользователь', 'Тур/Экскурсия', 'Тип', 'Дата', 'Статус', 'Цена'],
                    [[
                        $freshBooking->id,
                        $user->name,
                        $freshBooking->bookable->name,
                        class_basename($freshBooking->bookable_type),
                        $freshBooking->booking_date->format('Y-m-d'),
                        $freshBooking->status,
                        $freshBooking->total_price
                    ]]
                );
            } else {
                $this->error("Проверка полиморфной связи: ОШИБКА");
                if ($freshBooking) {
                    $this->warn("Бронирование найдено, но связанный объект отсутствует");
                    $this->warn("bookable_type: {$freshBooking->bookable_type}, bookable_id: {$freshBooking->bookable_id}");
                } else {
                    $this->error("Бронирование не найдено в базе данных");
                }
            }
            
            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Ошибка при создании бронирования: " . $e->getMessage());
            $this->error("Стек вызовов: " . $e->getTraceAsString());
            return 1;
        }
    }
} 