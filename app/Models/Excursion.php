<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Excursion extends Model
{
    use HasFactory;

    /**
     * 
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'location',
        'region',
        'duration',
        'price',
        'image',
        'audience_type',
        'min_age',
        'max_age',
        'available_seats',
        'features',
    ];

    /**
     * Аксессоры, которые добавляются к результату модели.
     *
     * @var array
     */
    protected $appends = ['image_path'];

    /**
     * Преобразование строки JSON в массив
     *
     * @param  string  $value
     * @return array
     */
    public function getFeaturesAttribute($value)
    {
        return json_decode($value, true) ?: [];
    }

    /**
     * Преобразование массива в строку JSON
     *
     * @param  array  $value
     * @return void
     */
    public function setFeaturesAttribute($value)
    {
        $this->attributes['features'] = json_encode($value);
    }

    /**
     * Получить путь к изображению экскурсии
     *
     * @return string
     */
    public function getImagePathAttribute()
    {
        if (!$this->image) {
            return 'img/excursions/placeholder.jpg';
        }
        
        // Если это уже полный URL, возвращаем как есть
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        
        // Если путь уже начинается с img/excursions/, возвращаем как есть
        if (str_starts_with($this->image, 'img/excursions/')) {
            return $this->image;
        }
        
        // Если путь начинается с excursions/, добавляем img/
        if (str_starts_with($this->image, 'excursions/')) {
            return 'img/' . $this->image;
        }
        
        // Во всех остальных случаях, считаем что это имя файла и добавляем полный путь
        return 'img/excursions/' . $this->image;
    }

    /**
     * Получить все экскурсии для дошкольников
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getPreschoolExcursions()
    {
        return self::where('audience_type', 'preschool')->orWhere('audience_type', 'all')->get();
    }

    /**
     * Получить все экскурсии для школьников
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getSchoolExcursions()
    {
        return self::where('audience_type', 'school')->orWhere('audience_type', 'all')->get();
    }

    /**
     * Получить все экскурсии для взрослых
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAdultExcursions()
    {
        return self::where('audience_type', 'adult')->orWhere('audience_type', 'all')->get();
    }

    /**
     * Получить все бронирования этой экскурсии
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function bookings()
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
    
    /**
     * Проверить доступность экскурсии на указанную дату
     * 
     * @param \DateTime|string $date
     * @return bool
     */
    public function isAvailableOn($date)
    {
        if (!$date instanceof \DateTime) {
            $date = new \DateTime($date);
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
        
        $bookingsCount = $this->bookings()
            ->whereDate('booking_date', $date->format('Y-m-d'))
            ->whereIn('status', ['pending', 'confirmed'])
            ->sum('persons');
            
        return max(0, $this->available_seats - $bookingsCount);
    }
}
