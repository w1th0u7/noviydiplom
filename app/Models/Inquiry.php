<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'message',
        'status',
        'assigned_manager_id',
        'processed_at'
    ];

    protected $dates = [
        'processed_at',
        'created_at',
        'updated_at'
    ];

    /**
     * Получить менеджера, назначенного на заявку.
     */
    public function assignedManager()
    {
        return $this->belongsTo(User::class, 'assigned_manager_id');
    }

    /**
     * Проверка, является ли заявка новой
     */
    public function isNew()
    {
        return $this->status === 'new';
    }

    /**
     * Проверка, назначена ли заявка менеджеру
     */
    public function isAssigned()
    {
        return $this->status === 'assigned';
    }

    /**
     * Проверка, обработана ли заявка
     */
    public function isProcessed()
    {
        return $this->status === 'processed';
    }

    /**
     * Назначить заявку менеджеру
     */
    public function assignTo(User $manager)
    {
        $this->assigned_manager_id = $manager->id;
        $this->status = 'assigned';
        $this->save();
    }

    /**
     * Отметить заявку как обработанную
     */
    public function markAsProcessed()
    {
        $this->status = 'processed';
        $this->processed_at = now();
        $this->save();
    }

    /**
     * Получить статус в читаемом виде
     */
    public function getStatusText()
    {
        switch ($this->status) {
            case 'new':
                return 'Новая';
            case 'assigned':
                return 'Назначена';
            case 'processed':
                return 'Обработана';
            default:
                return 'Неизвестно';
        }
    }
}
