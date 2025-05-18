@extends('layouts.cabinet')

@section('title', 'Мои поездки')

@section('page-title', 'Мои поездки')

@section('content')
<div class="trips-content">
    @if(isset($trips) && count($trips) > 0)
        <div class="trips-list">
            @foreach($trips as $trip)
                <div class="trip-card">
                    <div class="trip-image">
                        <img src="{{ asset($trip->image) }}" alt="{{ $trip->name }}">
                    </div>
                    <div class="trip-info">
                        <h3>{{ $trip->name }}</h3>
                        <div class="trip-details">
                            <span class="trip-date">{{ $trip->start_date }} - {{ $trip->end_date }}</span>
                            <span class="trip-price">{{ $trip->price }} ₽</span>
                        </div>
                        <p class="trip-description">{{ $trip->description }}</p>
                        <a href="{{ route('trip.detail', $trip->id) }}" class="trip-link">Подробнее</a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <img src="{{ asset('img/empty-trips.svg') }}" alt="Нет поездок">
            <p>У вас пока нет совершённых поездок</p>
        </div>
    @endif
</div>
@endsection 