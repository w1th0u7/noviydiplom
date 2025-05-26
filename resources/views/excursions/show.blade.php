@extends('layouts.basic')

@section('title', $excursion['name'] ?? $excursion->name . ' | Родина-тур')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/pages/excursions.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/booking.css') }}">
@endsection

@section('content')
<section class="excursion-detail">
    <div class="max">
        <div class="excursion-header">
            <img class="excursion-header-image" src="{{ isset($excursion['image']) ? asset('storage/' . $excursion['image']) : asset('storage/' . ($excursion->image_path ?? 'excursions/placeholder.jpg')) }}" alt="{{ $excursion['name'] ?? $excursion->name }}">
            <div class="excursion-title-card">
                <h1>{{ $excursion['name'] ?? $excursion->name }}</h1>
                <div class="excursion-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ $excursion['location'] ?? $excursion->location }}</span>
                </div>
                <div class="badges">
                    @php
                        $audienceType = $excursion['audience_type'] ?? $excursion->audience_type;
                        $badgeClass = 'badge-' . $audienceType;
                        $audienceLabel = [
                            'preschool' => 'Для дошкольников',
                            'school' => 'Для школьников',
                            'adult' => 'Для взрослых',
                            'all' => 'Для всех возрастов'
                        ][$audienceType] ?? 'Универсальная';
                    @endphp
                    <span class="excursion-badge {{ $badgeClass }}">{{ $audienceLabel }}</span>
                    <span class="excursion-badge" style="background-color: #6c757d; color: white;">
                        <i class="far fa-clock"></i> {{ $excursion['duration'] ?? $excursion->duration }} {{ ($excursion['duration'] ?? $excursion->duration) == 1 ? 'день' : 'дня' }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="excursion-details-grid">
            <div class="excursion-description">
                <h2>Описание экскурсии</h2>
                <p>{{ $excursion['description'] ?? $excursion->description }}</p>
                
                <div class="excursion-features">
                    <h3>Особенности экскурсии</h3>
                    <ul class="feature-list">
                        @foreach($excursion['features'] ?? $excursion->features as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <div class="excursion-sidebar">
                <div class="booking-card">
                    <h3>Забронировать экскурсию</h3>
                    
                    <div class="price-box">
                        <span class="price">{{ number_format($excursion['price'] ?? $excursion->price, 0, ',', ' ') }}</span>
                        <span class="price-unit">₽/чел.</span>
                    </div>
                    
                    <!-- Кнопка для показа формы бронирования -->
                    @if(Auth::check())
                        <button class="show-booking-form">Забронировать экскурсию</button>
                    @else
                        <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="booking-button">Войдите для бронирования</a>
                    @endif
                    
                    <!-- Форма бронирования (скрыта по умолчанию) -->
                    <div class="booking-form" style="display: none;">
                        <h3>Оставить заявку на экскурсию</h3>
                        
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        @if(!Auth::check())
                        <div class="auth-notice">
                            <div class="notice-content">
                                <i class="fas fa-info-circle"></i>
                                <p>Для бронирования необходимо <a href="{{ route('login') }}">войти</a> или <a href="{{ route('register') }}">зарегистрироваться</a></p>
                            </div>
                        </div>
                        @else
                        <form action="{{ route('excursions.book', $excursion['id'] ?? $excursion->id) }}" method="POST">
                            @csrf
                            
                            <div class="form-group">
                                <label for="booking_date">Дата экскурсии</label>
                                <input type="date" id="booking_date" name="booking_date" required min="{{ date('Y-m-d') }}" value="{{ old('booking_date') }}">
                                @error('booking_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="persons">Количество человек</label>
                                <input type="number" id="persons" name="persons" required min="1" max="{{ $excursion['available_seats'] ?? $excursion->available_seats }}" value="{{ old('persons', 1) }}" data-price="{{ $excursion['price'] ?? $excursion->price }}">
                                @error('persons')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="guest_name">Ваше имя</label>
                                <input type="text" id="guest_name" name="guest_name" required value="{{ old('guest_name', Auth::user()->name ?? '') }}">
                                @error('guest_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="guest_email">Email</label>
                                <input type="email" id="guest_email" name="guest_email" required value="{{ old('guest_email', Auth::user()->email ?? '') }}">
                                @error('guest_email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="guest_phone">Телефон</label>
                                <input type="tel" id="guest_phone" name="guest_phone" required value="{{ old('guest_phone') }}">
                                @error('guest_phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="notes">Примечания</label>
                                <textarea id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            </div>
                            
                            <div class="total-price">
                                <p>Общая стоимость: <strong>{{ number_format($excursion['price'] ?? $excursion->price, 0, ',', ' ') }}₽</strong> × <span id="persons-count">1</span> = <strong><span id="total-price">{{ number_format($excursion['price'] ?? $excursion->price, 0, ',', ' ') }}</span>₽</strong></p>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="booking-button">Отправить заявку</button>
                                <button type="button" class="close-booking-form">Отменить</button>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
                
                <div class="info-card">
                    <h4>Детали экскурсии</h4>
                    <ul class="info-list">
                        <li>
                            <span class="info-label">Регион:</span>
                            <span class="info-value">{{ $excursion['region'] ?? $excursion->region }}</span>
                        </li>
                        <li>
                            <span class="info-label">Продолжительность:</span>
                            <span class="info-value">{{ $excursion['duration'] ?? $excursion->duration }} {{ ($excursion['duration'] ?? $excursion->duration) == 1 ? 'день' : 'дня' }}</span>
                        </li>
                        @if(isset($excursion['min_age']) || isset($excursion->min_age))
                        <li>
                            <span class="info-label">Возраст:</span>
                            <span class="info-value">
                                @if(isset($excursion['min_age']) && isset($excursion['max_age']))
                                    от {{ $excursion['min_age'] }} до {{ $excursion['max_age'] }} лет
                                @elseif(isset($excursion->min_age) && isset($excursion->max_age))
                                    от {{ $excursion->min_age }} до {{ $excursion->max_age }} лет
                                @elseif(isset($excursion['min_age']) || isset($excursion->min_age))
                                    от {{ $excursion['min_age'] ?? $excursion->min_age }} лет
                                @elseif(isset($excursion['max_age']) || isset($excursion->max_age))
                                    до {{ $excursion['max_age'] ?? $excursion->max_age }} лет
                                @else
                                    Без ограничений
                                @endif
                            </span>
                        </li>
                        @endif
                        <li>
                            <span class="info-label">Размер группы:</span>
                            <span class="info-value">до {{ $excursion['available_seats'] ?? $excursion->available_seats }} человек</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        @if(isset($similarExcursions) && count($similarExcursions) > 0)
        <div class="similar-excursions">
            <h2>Похожие экскурсии</h2>
            <div class="similar-grid">
                @foreach($similarExcursions as $similarExcursion)
                <div class="excursion-card">
                    <div class="excursion-image">
                        <img src="{{ isset($similarExcursion['image']) ? asset('storage/' . $similarExcursion['image']) : asset('storage/' . ($similarExcursion->image_path ?? 'excursions/placeholder.jpg')) }}" alt="{{ $similarExcursion['name'] ?? $similarExcursion->name }}">
                        <div class="excursion-duration">{{ $similarExcursion['duration'] ?? $similarExcursion->duration }} {{ ($similarExcursion['duration'] ?? $similarExcursion->duration) == 1 ? 'день' : 'дня' }}</div>
                    </div>
                    <div class="excursion-info">
                        <h3>{{ $similarExcursion['name'] ?? $similarExcursion->name }}</h3>
                        <div class="excursion-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $similarExcursion['location'] ?? $similarExcursion->location }}</span>
                        </div>
                        <div class="excursion-description">
                            {{ Str::limit($similarExcursion['description'] ?? $similarExcursion->description, 100) }}
                        </div>
                        <div class="excursion-price">
                            <strong>{{ number_format($similarExcursion['price'] ?? $similarExcursion->price, 0, '.', ' ') }} ₽</strong>
                            <span>на человека</span>
                        </div>
                    </div>
                    <a href="{{ isset($similarExcursion['id']) ? route('excursions.show', $similarExcursion['id']) : route('excursions.show', $similarExcursion->id) }}" class="excursion-button">Подробнее</a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Подключение JavaScript для управления формой -->
<script src="{{ asset('js/booking.js') }}"></script>
@endsection 