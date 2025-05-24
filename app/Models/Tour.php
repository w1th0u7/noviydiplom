<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'type',
        'season',
        'description',
        'image',
        'data',
        'start_date',
        'end_date',
        'price',
        'location',
        'duration',
        'features',
        'audience_type',
        'min_age',
        'max_age',
        'available_seats',
    ];

    // Автоматическое преобразование для определенных атрибутов
    protected $casts = [
        'data' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'float',
        'features' => 'array',
        'duration' => 'integer',
        'available_seats' => 'integer',
        'min_age' => 'integer',
        'max_age' => 'integer',
    ];

    // Метод для получения относительного пути к изображению
    public function getImagePathAttribute()
    {
        if ($this->image && !str_starts_with($this->image, 'http')) {
            return asset('storage/' . $this->image);
        }
        return $this->image;
    }
    
    // Метод для получения строки с длительностью в днях и ночах
    public function getDurationTextAttribute()
    {
        $days = $this->duration;
        $nights = $days - 1;
        return "{$days} дней / {$nights} ночей";
    }
    
    /**
     * Получить все бронирования этого тура
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function bookings()
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
    
    /**
     * Проверить доступность тура на указанную дату
     * 
     * @param \DateTime|string $date
     * @return bool
     */
    public function isAvailableOn($date)
    {
        if (!$date instanceof \DateTime) {
            $date = new \DateTime($date);
        }
        
        // Проверяем, что дата входит в период проведения тура
        if ($this->start_date && $this->end_date) {
            $tourStart = new \DateTime($this->start_date);
            $tourEnd = new \DateTime($this->end_date);
            
            if ($date < $tourStart || $date > $tourEnd) {
                return false;
            }
        }
        
        $bookingsCount = $this->bookings()
            ->whereDate('booking_date', $date->format('Y-m-d'))
            ->whereIn('status', ['pending', 'confirmed'])
            ->sum('persons');
            
        return $bookingsCount < $this->available_seats;
    }
    
    /**
     * Получить количество оставшихся мест на указанную дату
     * 
     * @param \DateTime|string $date
     * @return int
     */
    public function getAvailableSeatsOn($date)
    {
        if (!$date instanceof \DateTime) {
            $date = new \DateTime($date);
        }
        
        // Проверяем, что дата входит в период проведения тура
        if ($this->start_date && $this->end_date) {
            $tourStart = new \DateTime($this->start_date);
            $tourEnd = new \DateTime($this->end_date);
            
            if ($date < $tourStart || $date > $tourEnd) {
                return 0;
            }
        }
        
        $bookingsCount = $this->bookings()
            ->whereDate('booking_date', $date->format('Y-m-d'))
            ->whereIn('status', ['pending', 'confirmed'])
            ->sum('persons');
            
        return max(0, $this->available_seats - $bookingsCount);
    }
}


