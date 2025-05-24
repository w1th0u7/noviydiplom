@extends('layouts.basic')

@section('title', 'Мои бронирования | Родина-тур')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/pages/booking.css') }}">
<style>
    .my-bookings {
        padding: 50px 0;
    }
    
    .bookings-header {
        margin-bottom: 30px;
    }
    
    .bookings-header h1 {
        color: #333;
        font-size: 32px;
        margin-bottom: 10px;
    }
    
    .bookings-header p {
        color: #555;
        font-size: 16px;
    }
    
    .bookings-list {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .booking-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        transition: transform 0.3s, box-shadow 0.3s;
        position: relative;
        overflow: hidden;
    }
    
    .booking-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    }
    
    .booking-status {
        position: absolute;
        top: 0;
        right: 0;
        padding: 8px 15px;
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
    
    .booking-title {
        font-size: 20px;
        margin-bottom: 15px;
        padding-right: 100px;
    }
    
    .booking-title a {
        color: #0050a0;
        text-decoration: none;
    }
    
    .booking-title a:hover {
        text-decoration: underline;
    }
    
    .booking-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .booking-info-item {
        display: flex;
        flex-direction: column;
    }
    
    .info-label {
        font-size: 14px;
        color: #777;
        margin-bottom: 5px;
    }
    
    .info-value {
        font-size: 16px;
        color: #333;
        font-weight: 500;
    }
    
    .booking-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 15px;
    }
    
    .booking-button {
        display: inline-block;
        padding: 8px 15px;
        background-color: #0050a0;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        margin-left: 10px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .booking-button:hover {
        background-color: #003b75;
        color: white;
        text-decoration: none;
    }
    
    .cancel-button {
        background-color: #dc3545;
    }
    
    .cancel-button:hover {
        background-color: #c82333;
    }
    
    .empty-bookings {
        text-align: center;
        padding: 50px 0;
    }
    
    .empty-bookings h2 {
        color: #555;
        margin-bottom: 20px;
    }
    
    .empty-bookings p {
        color: #777;
        margin-bottom: 30px;
    }
    
    .pagination-container {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }
    
    @media (max-width: 768px) {
        .booking-info {
            grid-template-columns: 1fr;
            gap: 10px;
        }
    }
</style>
@endsection

@section('content')
<section class="my-bookings">
    <div class="max">
        <div class="bookings-header">
            <h1>Мои бронирования</h1>
            <p>История ваших бронирований туров и экскурсий</p>
            
            @if(session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger mt-3">
                    {{ session('error') }}
                </div>
            @endif
        </div>
        
        @if($bookings->count() > 0)
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
                    @endphp
                    
                    <div class="booking-card">
                        <div class="booking-status {{ $statusClass }}">{{ $statusText }}</div>
                        
                        <h2 class="booking-title">
                            <a href="{{ route('bookings.confirmation', $booking->id) }}">
                                {{ $booking->bookable->name }} (Бронирование #{{ $booking->id }})
                            </a>
                        </h2>
                        
                        <div class="booking-info">
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
                        </div>
                        
                        <div class="booking-actions">
                            <a href="{{ route('bookings.confirmation', $booking->id) }}" class="booking-button">
                                Подробнее
                            </a>
                            
                            @if($booking->status == 'pending' || $booking->status == 'confirmed')
                                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="booking-button cancel-button" onclick="return confirm('Вы уверены, что хотите отменить бронирование?')">
                                        Отменить
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="pagination-container">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="empty-bookings">
                <h2>У вас пока нет бронирований</h2>
                <p>Забронируйте тур или экскурсию, и они появятся здесь</p>
                <div>
                    <a href="{{ route('tours.all') }}" class="booking-button">Посмотреть туры</a>
                    <a href="{{ route('excursions') }}" class="booking-button">Посмотреть экскурсии</a>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection 