@extends('layouts.basic')

@section('title', 'Подтверждение бронирования | Родина-тур')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/pages/booking.css') }}">
<style>
    .booking-confirmation {
        padding: 50px 0;
    }
    
    .confirmation-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-bottom: 30px;
    }
    
    .confirmation-header {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .confirmation-header h1 {
        color: #333;
        font-size: 28px;
        margin-bottom: 10px;
    }
    
    .confirmation-header .status {
        display: inline-block;
        padding: 8px 15px;
        border-radius: 30px;
        font-weight: 500;
        margin-top: 10px;
    }
    
    .status-pending {
        background-color: #ffc107;
        color: #212529;
    }
    
    .status-confirmed {
        background-color: #28a745;
        color: white;
    }
    
    .status-cancelled {
        background-color: #dc3545;
        color: white;
    }
    
    .status-completed {
        background-color: #6c757d;
        color: white;
    }
    
    .confirmation-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }
    
    .detail-section {
        margin-bottom: 20px;
    }
    
    .detail-section h3 {
        color: #333;
        font-size: 18px;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 1px solid #eee;
    }
    
    .detail-item {
        display: flex;
        margin-bottom: 10px;
    }
    
    .detail-label {
        font-weight: 500;
        min-width: 150px;
        color: #555;
    }
    
    .detail-value {
        color: #333;
    }
    
    .booking-actions {
        text-align: center;
        margin-top: 30px;
    }
    
    .booking-button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #0050a0;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: 500;
        text-decoration: none;
        margin: 0 10px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .booking-button:hover {
        background-color: #003b75;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.2);
        color: white;
        text-decoration: none;
    }
    
    .cancel-button {
        background-color: #dc3545;
    }
    
    .cancel-button:hover {
        background-color: #c82333;
    }
    
    @media (max-width: 768px) {
        .confirmation-details {
            grid-template-columns: 1fr;
            gap: 15px;
        }
    }
    
    /* Стили для блока уведомления */
    .notification-card {
        background-color: #f7f9ff;
        border-left: 4px solid #0050a0;
        padding: 25px;
        margin-bottom: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        animation: fadeInUp 0.4s ease-out;
        position: relative;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .notification-title {
        color: #0050a0;
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
    }
    
    .notification-title i {
        margin-right: 12px;
        font-size: 22px;
        color: #0050a0;
    }
    
    .notification-message {
        color: #444;
        line-height: 1.6;
        font-size: 16px;
    }
    
    .notification-card:before {
        content: '';
        position: absolute;
        top: -5px;
        left: 20px;
        width: 10px;
        height: 10px;
        background: #0050a0;
        border-radius: 50%;
    }
    
    /* Стиль для удалённых элементов */
    .deleted-item {
        color: #dc3545;
        font-style: italic;
    }
</style>
@endsection

@section('content')
<section class="booking-confirmation">
    <div class="max">
        <div class="confirmation-card">
            <div class="confirmation-header">
                <h1>Бронирование #{{ $booking->id }}</h1>
                
                @php
                    $statusClass = 'status-' . $booking->status;
                    $statusText = [
                        'pending' => 'Ожидает подтверждения',
                        'confirmed' => 'Подтверждено',
                        'cancelled' => 'Отменено',
                        'completed' => 'Завершено'
                    ][$booking->status] ?? 'Неизвестный статус';
                @endphp
                
                <div class="status {{ $statusClass }}">{{ $statusText }}</div>
                
                @if(session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('global_alert'))
                    <div class="alert alert-info mt-3" style="background-color: #e6f3ff; border: 1px solid #0050a0; border-radius: 5px; padding: 15px; margin-top: 15px; color: #0050a0;">
                        <i class="fas fa-info-circle" style="margin-right: 8px;"></i>
                        {{ session('global_alert') }}
                    </div>
                @endif
            </div>

            {{-- Отображение уведомления о бронировании --}}
            @if(session('booking_notification'))
            <div class="notification-card">
                <div class="notification-title">
                    <i class="fas fa-info-circle"></i> {{ session('booking_notification')['title'] }}
                </div>
                <div class="notification-message">
                    {{ session('booking_notification')['message'] }}
                </div>
            </div>
            @else
                {{-- Жёстко прописанное уведомление, если сессия не работает --}}
                <div class="notification-card">
                    <div class="notification-title">
                        <i class="fas fa-info-circle"></i> Заявка успешно создана!
                    </div>
                    <div class="notification-message">
                        В ближайшее время с Вами свяжется менеджер для уточнения деталей бронирования и подтверждения паспортных данных.
                    </div>
                </div>
            @endif
            
            <div class="confirmation-details">
                <div class="detail-section">
                    <h3>Информация о бронировании</h3>
                    
                    <div class="detail-item">
                        <span class="detail-label">Дата бронирования:</span>
                        <span class="detail-value">{{ $booking->booking_date->format('d.m.Y') }}</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Количество человек:</span>
                        <span class="detail-value">{{ $booking->persons }}</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Общая стоимость:</span>
                        <span class="detail-value">{{ number_format($booking->total_price, 0, ',', ' ') }} ₽</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Дата создания:</span>
                        <span class="detail-value">{{ $booking->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                </div>
                
                <div class="detail-section">
                    <h3>Контактная информация</h3>
                    
                    <div class="detail-item">
                        <span class="detail-label">Имя:</span>
                        <span class="detail-value">{{ $booking->guest_name }}</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value">{{ $booking->guest_email }}</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Телефон:</span>
                        <span class="detail-value">{{ $booking->guest_phone }}</span>
                    </div>
                </div>
            </div>
            
            <div class="detail-section">
                @if($booking->isFromCalculator())
                    <h3>Информация об индивидуальном туре</h3>
                    
                    <div class="detail-item">
                        <span class="detail-label">Тип:</span>
                        <span class="detail-value">Индивидуальный тур</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Источник:</span>
                        <span class="detail-value">Рассчитан через калькулятор</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Статус:</span>
                        <span class="detail-value">Ожидает уточнения деталей менеджером</span>
                    </div>
                @else
                    <h3>Информация о {{ $booking->bookable_type == 'App\\Models\\Tour' ? 'туре' : 'экскурсии' }}</h3>
                    
                    @if($booking->bookable)
                        <div class="detail-item">
                            <span class="detail-label">Название:</span>
                            <span class="detail-value">{{ $booking->bookable->name }}</span>
                        </div>
                        
                        <div class="detail-item">
                            <span class="detail-label">Локация:</span>
                            <span class="detail-value">{{ $booking->bookable->location }}</span>
                        </div>
                        
                        @if($booking->bookable_type == 'App\\Models\\Tour')
                            <div class="detail-item">
                                <span class="detail-label">Продолжительность:</span>
                                <span class="detail-value">{{ $booking->bookable->duration_text }}</span>
                            </div>
                        @else
                            <div class="detail-item">
                                <span class="detail-label">Продолжительность:</span>
                                <span class="detail-value">{{ $booking->bookable->duration }} {{ trans_choice('час|часа|часов', $booking->bookable->duration) }}</span>
                            </div>
                        @endif
                    @else
                        <div class="detail-item">
                            <span class="detail-label">Информация:</span>
                            <span class="detail-value deleted-item">Объект был удалён из системы</span>
                        </div>
                    @endif
                @endif
            </div>
            
            @if($booking->notes)
                <div class="detail-section">
                    <h3>Примечания</h3>
                    <p>{{ $booking->notes }}</p>
                </div>
            @endif
            
            <div class="booking-actions">
                @if($booking->isFromCalculator())
                    <a href="{{ route('calculate') }}" class="booking-button">
                        Вернуться к калькулятору
                    </a>
                @elseif($booking->bookable)
                    <a href="{{ $booking->bookable_type == 'App\\Models\\Tour' ? route('tours.show', $booking->bookable->id) : route('excursions.show', $booking->bookable->id) }}" class="booking-button">
                        Вернуться к {{ $booking->bookable_type == 'App\\Models\\Tour' ? 'туру' : 'экскурсии' }}
                    </a>
                @else
                    <a href="{{ $booking->bookable_type == 'App\\Models\\Tour' ? route('tours.index') : route('excursions') }}" class="booking-button">
                        К списку {{ $booking->bookable_type == 'App\\Models\\Tour' ? 'туров' : 'экскурсий' }}
                    </a>
                @endif
                
                @if(Auth::check())
                    <a href="{{ route('trips') }}" class="booking-button" style="margin-top: 10px;">
                        Мои бронирования
                    </a>
                @endif
                
                @if(Auth::check() && ($booking->status == 'pending' || $booking->status == 'confirmed'))
                    <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="booking-button cancel-button" onclick="return confirm('Вы уверены, что хотите отменить бронирование?')">
                            Отменить бронирование
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection 