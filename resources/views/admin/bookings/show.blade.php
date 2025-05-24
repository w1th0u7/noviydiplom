@extends('layouts.admin')

@section('title', 'Просмотр бронирования #' . $booking->id)

@section('header-title', 'Просмотр бронирования #' . $booking->id)

@section('content')
<div class="admin-booking-details">
    <div class="admin-content-header">
        <h2>Детали бронирования #{{ $booking->id }}</h2>
        <div>
            <a href="{{ route('admin.bookings.index') }}" class="admin-btn secondary-btn">
                <i class="fas fa-arrow-left"></i> К списку бронирований
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="booking-details-grid">
        <div class="booking-card">
            <div class="booking-card-header">
                <h3>Основная информация</h3>
                
                @php
                    $statusClass = 'status-' . $booking->status;
                    $statusText = [
                        'pending' => 'Ожидает подтверждения',
                        'confirmed' => 'Подтверждено',
                        'cancelled' => 'Отменено',
                        'completed' => 'Завершено'
                    ][$booking->status] ?? 'Неизвестный статус';
                @endphp
                
                <span class="booking-status {{ $statusClass }}">{{ $statusText }}</span>
            </div>
            
            <div class="booking-info-group">
                <div class="booking-info-item">
                    <span class="info-label">Дата бронирования</span>
                    <span class="info-value">{{ $booking->booking_date->format('d.m.Y') }}</span>
                </div>
                
                <div class="booking-info-item">
                    <span class="info-label">Количество человек</span>
                    <span class="info-value">{{ $booking->persons }}</span>
                </div>
                
                <div class="booking-info-item">
                    <span class="info-label">Общая стоимость</span>
                    <span class="info-value">{{ number_format($booking->total_price, 0, ',', ' ') }} ₽</span>
                </div>
                
                <div class="booking-info-item">
                    <span class="info-label">Дата создания</span>
                    <span class="info-value">{{ $booking->created_at->format('d.m.Y H:i') }}</span>
                </div>
                
                <div class="booking-info-item">
                    <span class="info-label">Последнее обновление</span>
                    <span class="info-value">{{ $booking->updated_at->format('d.m.Y H:i') }}</span>
                </div>
            </div>
        </div>
        
        <div class="booking-card">
            <h3>Информация о клиенте</h3>
            
            <div class="booking-info-group">
                <div class="booking-info-item">
                    <span class="info-label">Имя</span>
                    <span class="info-value">{{ $booking->guest_name }}</span>
                </div>
                
                <div class="booking-info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $booking->guest_email }}</span>
                </div>
                
                <div class="booking-info-item">
                    <span class="info-label">Телефон</span>
                    <span class="info-value">{{ $booking->guest_phone }}</span>
                </div>
                
                <div class="booking-info-item">
                    <span class="info-label">Пользователь</span>
                    <span class="info-value">
                        @if($booking->user)
                            {{ $booking->user->name }} (ID: {{ $booking->user->id }})
                        @else
                            Не авторизован
                        @endif
                    </span>
                </div>
            </div>
        </div>
        
        <div class="booking-card">
            <h3>Информация о {{ $booking->bookable_type == 'App\\Models\\Tour' ? 'туре' : 'экскурсии' }}</h3>
            
            <div class="booking-info-group">
                @if($booking->bookable)
                    <div class="booking-info-item">
                        <span class="info-label">Название</span>
                        <span class="info-value">{{ $booking->bookable->name }}</span>
                    </div>
                    
                    <div class="booking-info-item">
                        <span class="info-label">Локация</span>
                        <span class="info-value">{{ $booking->bookable->location }}</span>
                    </div>
                    
                    @if($booking->bookable_type == 'App\\Models\\Tour')
                        <div class="booking-info-item">
                            <span class="info-label">Продолжительность</span>
                            <span class="info-value">{{ $booking->bookable->duration_text }}</span>
                        </div>
                        
                        <div class="booking-info-item">
                            <span class="info-label">Тип</span>
                            <span class="info-value">{{ $booking->bookable->type }}</span>
                        </div>
                    @else
                        <div class="booking-info-item">
                            <span class="info-label">Продолжительность</span>
                            <span class="info-value">{{ $booking->bookable->duration }} {{ trans_choice('час|часа|часов', $booking->bookable->duration) }}</span>
                        </div>
                        
                        <div class="booking-info-item">
                            <span class="info-label">Тип аудитории</span>
                            <span class="info-value">
                                @switch($booking->bookable->audience_type)
                                    @case('preschool')
                                        Дошкольники
                                        @break
                                    @case('school')
                                        Школьники
                                        @break
                                    @case('adult')
                                        Взрослые
                                        @break
                                    @case('all')
                                        Для всех
                                        @break
                                    @default
                                        {{ $booking->bookable->audience_type }}
                                @endswitch
                            </span>
                        </div>
                    @endif
                    
                    <div class="booking-info-item">
                        <span class="info-label">Цена за человека</span>
                        <span class="info-value">{{ number_format($booking->bookable->price, 0, ',', ' ') }} ₽</span>
                    </div>
                    
                    <div class="booking-info-item">
                        <span class="info-label">Доступных мест</span>
                        <span class="info-value">{{ $booking->bookable->available_seats }}</span>
                    </div>
                @else
                    <div class="booking-info-item no-data">
                        {{ $booking->bookable_type == 'App\\Models\\Tour' ? 'Тур' : 'Экскурсия' }} был(а) удален(а)
                    </div>
                @endif
            </div>
        </div>
        
        @if($booking->notes)
            <div class="booking-card">
                <h3>Примечания</h3>
                <div class="booking-notes">
                    {{ $booking->notes }}
                </div>
            </div>
        @endif
    </div>
    
    <div class="booking-actions">
        @if($booking->status == 'pending')
            <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST" class="action-form">
                @csrf
                <button type="submit" class="admin-btn confirm-btn">
                    <i class="fas fa-check"></i> Подтвердить
                </button>
            </form>
        @endif
        
        @if($booking->status == 'pending' || $booking->status == 'confirmed')
            <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" class="action-form">
                @csrf
                <button type="submit" class="admin-btn cancel-btn" onclick="return confirm('Вы уверены, что хотите отменить бронирование?')">
                    <i class="fas fa-times"></i> Отменить
                </button>
            </form>
        @endif
        
        @if($booking->status == 'confirmed')
            <form action="{{ route('admin.bookings.complete', $booking->id) }}" method="POST" class="action-form">
                @csrf
                <button type="submit" class="admin-btn complete-btn" onclick="return confirm('Отметить бронирование как завершенное?')">
                    <i class="fas fa-check-double"></i> Завершить
                </button>
            </form>
        @endif
        
        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="action-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="admin-btn delete-btn" onclick="return confirm('Вы уверены, что хотите удалить это бронирование?')">
                <i class="fas fa-trash"></i> Удалить
            </button>
        </form>
    </div>
</div>

<style>
    .booking-details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .booking-card {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }
    
    .booking-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .booking-card h3 {
        margin: 0 0 15px 0;
        color: #333;
        font-size: 18px;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }
    
    .booking-status {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        color: white;
    }
    
    .status-pending {
        background-color: #ffc107;
        color: #212529;
    }
    
    .status-confirmed {
        background-color: #28a745;
    }
    
    .status-cancelled {
        background-color: #dc3545;
    }
    
    .status-completed {
        background-color: #6c757d;
    }
    
    .booking-info-group {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
    }
    
    .booking-info-item {
        display: flex;
        flex-direction: column;
    }
    
    .info-label {
        font-size: 14px;
        color: #777;
        margin-bottom: 4px;
    }
    
    .info-value {
        font-size: 16px;
        color: #333;
    }
    
    .no-data {
        color: #dc3545;
        font-style: italic;
    }
    
    .booking-notes {
        white-space: pre-line;
        color: #555;
        line-height: 1.5;
    }
    
    .booking-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }
    
    .action-form {
        display: inline-block;
    }
    
    .admin-btn {
        padding: 8px 15px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        border: none;
        display: inline-flex;
        align-items: center;
        color: white;
        text-decoration: none;
        transition: background-color 0.2s;
    }
    
    .admin-btn i {
        margin-right: 5px;
    }
    
    .confirm-btn {
        background-color: #28a745;
    }
    
    .confirm-btn:hover {
        background-color: #218838;
    }
    
    .cancel-btn {
        background-color: #dc3545;
    }
    
    .cancel-btn:hover {
        background-color: #c82333;
    }
    
    .complete-btn {
        background-color: #6f42c1;
    }
    
    .complete-btn:hover {
        background-color: #5e37a6;
    }
    
    .delete-btn {
        background-color: #dc3545;
    }
    
    .delete-btn:hover {
        background-color: #c82333;
    }
    
    .secondary-btn {
        background-color: #6c757d;
    }
    
    .secondary-btn:hover {
        background-color: #5a6268;
    }
    
    @media (max-width: 768px) {
        .booking-details-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection 