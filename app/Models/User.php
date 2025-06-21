<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; 

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'api_token',
    ];

    /**
     * 
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', 
    ];


    /**
     * Check if the user is an administrator.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Получить бронирования пользователя.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Получить заявки, назначенные менеджеру.
     */
    public function assignedInquiries()
    {
        return $this->hasMany(Inquiry::class, 'assigned_manager_id');
    }

    /**
     * Проверяет, является ли пользователь менеджером
     */
    public function isManager()
    {
        return $this->role === 'manager';
    }

    // Optionally, add this if you need an attribute accessor for isAdmin (less common)
    

}