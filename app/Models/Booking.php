<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * Атрибуты, которые можно массово назначать.
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
    ];

    /**
     * Атрибуты, которые следует преобразовывать.
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
}
