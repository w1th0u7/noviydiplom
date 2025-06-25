<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'booking_date',
        'persons',
        'total_price',
        'status',
        'notes',
        'bookable_type',
        'bookable_id',
        'calculator_data',
        'calculator_country',
        'calculator_resort',
        'calculator_tour_type',
        'calculator_hotel_class',
        'calculator_meal',
        'calculator_nights',
    ];

    /**
     *
     * @var array
     */
    protected $casts = [
        'booking_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    /**
     * Получить пользователя, сделавшего бронирование.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить забронированный объект (тур или экскурсию).
     */
    public function bookable()
    {
        return $this->morphTo();
    }

    /**
     * Проверить, является ли бронирование ожидающим подтверждения.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Проверить, является ли бронирование подтвержденным.
     */
    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    /**
     * Проверить, является ли бронирование отмененным.
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    /**
     * Проверить, является ли бронирование завершенным.
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Подтвердить бронирование.
     */
    public function confirm()
    {
        $this->status = 'confirmed';
        return $this->save();
    }

    /**
     * Отменить бронирование.
     */
    public function cancel()
    {
        $this->status = 'cancelled';
        return $this->save();
    }

    /**
     * Завершить бронирование.
     */
    public function complete()
    {
        $this->status = 'completed';
        return $this->save();
    }

    /**
     * Проверить, является ли бронирование из калькулятора.
     */
    public function isFromCalculator()
    {
        return is_null($this->bookable_type) && is_null($this->bookable_id);
    }

    /**
     * Получить название забронированного объекта.
     */
    public function getBookableName()
    {
        if ($this->isFromCalculator()) {
            // Формируем название на основе данных калькулятора
            $parts = [];
            
            if ($this->calculator_country) {
                $parts[] = $this->calculator_country;
            }
            
            if ($this->calculator_resort) {
                $parts[] = $this->calculator_resort;
            }
            
            if (!empty($parts)) {
                return implode(', ', $parts);
            }
            
            return 'Рассчитан через калькулятор';
        }
        
        if ($this->bookable) {
            return $this->bookable->name ?? 'Неизвестный объект';
        }
        
        return 'Объект не найден';
    }

    /**
     * Получить изображение для бронирования из калькулятора.
     */
    public function getCalculatorImage()
    {
        if (!$this->isFromCalculator()) {
            return null;
        }

        // Соответствие стран и изображений
        $countryImages = [
            'Турция' => 'img/tours/beach.jpg',
            'Египет' => 'img/tours/more.jpg', 
            'ОАЭ' => 'img/tours/resort.jpg',
            'Таиланд' => 'img/tours/plyazh.jpg',
            'Россия' => 'img/tours/city.jpg',
            'Франция' => 'img/tours/city.jpg',
            'Италия' => 'img/tours/city.jpg',
            'Испания' => 'img/tours/beach.jpg',
            'Греция' => 'img/tours/more.jpg',
            'Кипр' => 'img/tours/beach.jpg',
        ];

        // Если есть соответствие стране, используем его
        if ($this->calculator_country && isset($countryImages[$this->calculator_country])) {
            return $countryImages[$this->calculator_country];
        }

        // Если нет соответствия стране, используем изображение по типу тура
        $tourTypeImages = [
            'пляжный отдых' => 'img/tours/beach.jpg',
            'экскурсионный' => 'img/tours/city.jpg', 
            'горнолыжный' => 'img/tours/mountain.jpg',
            'лечебный' => 'img/tours/resort.jpg',
            'круизный' => 'img/tours/more.jpg',
            'паломнический' => 'img/tours/city.jpg',
        ];

        if ($this->calculator_tour_type && isset($tourTypeImages[$this->calculator_tour_type])) {
            return $tourTypeImages[$this->calculator_tour_type];
        }

        // По умолчанию возвращаем изображение placeholder
        return 'img/tours/placeholder.jpg';
    }
}
