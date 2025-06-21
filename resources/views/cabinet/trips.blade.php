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
                    
                    $bookableType = isset($booking->bookable_type) && $booking->bookable_type == 'App\\Models\\Tour' ? 'Тур' : 'Экскурсия';
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
                                    asset('img/tours/' . ($booking->bookable->image ?? 'placeholder.jpg')) : 
                                    asset('img/excursions/' . ($booking->bookable->image ?? 'placeholder.jpg')) }}" 
                                    alt="{{ $booking->bookable->name }}" class="booking-image">
                            @else
                                <img src="{{ asset('img/tours/placeholder.jpg') }}" alt="Изображение недоступно" class="booking-image">
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
                                    <i class="fas fa-eye"></i> Подробнее
                                </a>
                                
                                @if($booking->status == 'pending' || $booking->status == 'confirmed')
                                    <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" class="cancel-form">
                                        @csrf
                                        <button type="submit" class="btn-cancel" onclick="return confirm('Вы уверены, что хотите отменить бронирование?')">
                                            <i class="fas fa-times"></i> Отменить
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
                <a href="{{ route('tours.index') }}" class="btn-primary">
                    <i class="fas fa-search"></i> Выбрать тур
                </a>
                <a href="{{ route('excursions') }}" class="btn-secondary">
                    <i class="fas fa-map-marked-alt"></i> Выбрать экскурсию
                </a>
            </div>
        </div>
    @endif
</div>
@endsection 