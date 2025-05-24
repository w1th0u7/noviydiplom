@extends('layouts.cabinet')

@section('title', 'Мои бронирования')

@section('page-title', 'Мои бронирования')

@section('content')
<div class="trips-content">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('global_alert'))
        <div class="alert alert-info">
            {{ session('global_alert') }}
        </div>
    @endif

    @if(isset($bookings) && $bookings->count() > 0)
        <div class="bookings-list">
            @foreach($bookings as $booking)
                @php
                    $statusClass = 'status-' . $booking->status;
                    $statusText = [
                        'pending' => 'Ожидает подтверждения',
                        'confirmed' => 'Подтверждено',
                        'cancelled' => 'Отменено',
                        'completed' => 'Завершено'
                    ][$booking->status] ?? 'Неизвестный статус';
                    
                    $bookableType = $booking->bookable_type == 'App\\Models\\Tour' ? 'Тур' : 'Экскурсия';
                @endphp
                
                <div class="booking-card">
                    <div class="booking-header">
                        <h3>
                            @if($booking->bookable)
                                {{ $bookableType }}: {{ $booking->bookable->name }}
                            @else
                                {{ $bookableType }}: <span class="deleted-item">Удалено</span>
                            @endif
                        </h3>
                        <span class="booking-status {{ $statusClass }}">{{ $statusText }}</span>
                    </div>
                    
                    <div class="booking-details">
                        <div class="booking-left">
                            @if($booking->bookable)
                                <img src="{{ $booking->bookable_type == 'App\\Models\\Tour' ? 
                                    ($booking->bookable->image_path ?? asset('images/placeholder.jpg')) : 
                                    asset('storage/' . ($booking->bookable->image ?? 'placeholder.jpg')) }}" 
                                    alt="{{ $booking->bookable->name }}" class="booking-image">
                            @else
                                <img src="{{ asset('images/placeholder.jpg') }}" alt="Изображение недоступно" class="booking-image">
                            @endif
                        </div>
                        <div class="booking-right">
                            <div class="booking-info-item">
                                <span class="info-label">Дата бронирования:</span>
                                <span class="info-value">{{ $booking->booking_date->format('d.m.Y') }}</span>
                            </div>
                            
                            <div class="booking-info-item">
                                <span class="info-label">Количество человек:</span>
                                <span class="info-value">{{ $booking->persons }}</span>
                            </div>
                            
                            <div class="booking-info-item">
                                <span class="info-label">Стоимость:</span>
                                <span class="info-value">{{ number_format($booking->total_price, 0, ',', ' ') }} ₽</span>
                            </div>
                            
                            <div class="booking-info-item">
                                <span class="info-label">Дата создания:</span>
                                <span class="info-value">{{ $booking->created_at->format('d.m.Y H:i') }}</span>
                            </div>
                            
                            <div class="booking-actions">
                                <a href="{{ route('bookings.confirmation', $booking->id) }}" class="btn-view">
                                    Подробнее
                                </a>
                                
                                @if($booking->status == 'pending' || $booking->status == 'confirmed')
                                    <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" class="cancel-form">
                                        @csrf
                                        <button type="submit" class="btn-cancel" onclick="return confirm('Вы уверены, что хотите отменить бронирование?')">
                                            Отменить
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <div class="pagination-container">
                {{ $bookings->links() }}
            </div>
        </div>
    @else
        <div class="empty-state">
            <img src="{{ asset('img/empty-trips.svg') }}" alt="Нет бронирований">
            <p>У вас пока нет активных бронирований</p>
            <div class="empty-actions">
                <a href="{{ route('tours.index') }}" class="btn-primary">Выбрать тур</a>
                <a href="{{ route('excursions') }}" class="btn-secondary">Выбрать экскурсию</a>
            </div>
        </div>
    @endif
</div>

<style>
    .bookings-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .booking-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .booking-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }
    
    .booking-header {
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
    }
    
    .booking-header h3 {
        margin: 0;
        font-size: 18px;
        color: #333;
    }
    
    .booking-status {
        padding: 5px 12px;
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
    
    .booking-details {
        padding: 20px;
        display: flex;
        gap: 20px;
    }
    
    .booking-left {
        flex: 0 0 200px;
    }
    
    .booking-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 6px;
    }
    
    .booking-right {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .booking-info-item {
        margin-bottom: 10px;
        display: flex;
    }
    
    .info-label {
        min-width: 170px;
        font-weight: 500;
        color: #555;
    }
    
    .info-value {
        color: #333;
    }
    
    .booking-actions {
        margin-top: auto;
        display: flex;
        gap: 10px;
    }
    
    .btn-view,
    .btn-cancel {
        padding: 8px 15px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-view {
        background-color: var(--accent-color);
        color: #333;
    }
    
    .btn-view:hover {
        background-color: #e9b800;
    }
    
    .btn-cancel {
        background-color: #f8f9fa;
        color: #dc3545;
        border: 1px solid #dc3545;
    }
    
    .btn-cancel:hover {
        background-color: #dc3545;
        color: white;
    }
    
    .cancel-form {
        display: inline-block;
    }
    
    .empty-actions {
        display: flex;
        gap: 15px;
        margin-top: 15px;
    }
    
    .btn-primary, .btn-secondary {
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .btn-primary {
        background-color: var(--accent-color);
        color: #333;
    }
    
    .btn-secondary {
        background-color: #f8f9fa;
        color: #333;
        border: 1px solid #ccc;
    }
    
    .btn-primary:hover {
        background-color: #e9b800;
    }
    
    .btn-secondary:hover {
        background-color: #eee;
    }
    
    .pagination-container {
        margin-top: 25px;
        display: flex;
        justify-content: center;
    }
    
    .alert {
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .deleted-item {
        color: #dc3545;
        font-style: italic;
    }
    
    @media (max-width: 768px) {
        .booking-details {
            flex-direction: column;
        }
        
        .booking-left {
            flex: 0 0 auto;
        }
        
        .booking-image {
            height: 180px;
        }
    }
</style>
@endsection 