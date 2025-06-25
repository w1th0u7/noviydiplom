@extends('layouts.basic')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/pages/booking.css') }}">
<link rel="stylesheet" href="{{ asset('css/media.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/tours.css') }}">
<link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
@endsection

@section('content')
<section class="tour-detail">
    <div class="max">
        <div class="tour-header">
            <h1>{{ $tour->name }}</h1>
            <div class="tour-meta">
                <div class="location">
                    <span class="label">Место:</span> 
                    <span class="value">{{ $tour->location ?? 'Не указано' }}</span>
                </div>
                <div class="duration">
                    <span class="label">Продолжительность:</span> 
                    <span class="value">{{ $tour->duration ?? '—' }} дней</span>
                </div>
                <div class="price">
                    <span class="label">Цена:</span> 
                    <span class="value">{{ number_format($tour->price, 0, ',', ' ') }}₽</span>
                </div>
            </div>
        </div>

        <div class="tour-content">
            <div class="tour-image">
                @php
                    $imageUrl = '';
                    if ($tour->image) {
                        if (str_starts_with($tour->image, 'img/')) {
                            $imageUrl = asset($tour->image);
                        } elseif (str_starts_with($tour->image, 'http')) {
                            $imageUrl = $tour->image;
                        } else {
                            $cleanImage = str_replace('tours/', '', $tour->image);
                            $imageUrl = asset('img/tours/' . $cleanImage);
                        }
                    } else {
                        $imageUrl = asset('img/tours/placeholder.jpg');
                    }
                @endphp
                <img src="{{ $imageUrl }}" alt="{{ $tour->name }}">
            </div>
            
            <div class="tour-info">
                <div class="description">
                    <h2>Описание</h2>
                    <p>{{ $tour->description }}</p>
                </div>
                
                <div class="features">
                    <h2>Особенности тура</h2>
                    <ul>
                        @if(isset($tour->features) && is_array($tour->features))
                            @foreach($tour->features as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                        @else
                            <li>Информация об особенностях тура отсутствует</li>
                        @endif
                    </ul>
                </div>
                
                <div class="audience">
                    <h2>Подходит для</h2>
                    @if($tour->audience_type === 'preschool')
                        <p>Дошкольников ({{ $tour->min_age }}-{{ $tour->max_age }} лет)</p>
                    @elseif($tour->audience_type === 'school')
                        <p>Школьников ({{ $tour->min_age }}-{{ $tour->max_age }} лет)</p>
                    @elseif($tour->audience_type === 'adult')
                        <p>Взрослых (от {{ $tour->min_age }} лет)</p>
                    @else
                        <p>Всех возрастных групп</p>
                    @endif
                </div>
                
                <div class="available-seats">
                    <h2>Доступно мест</h2>
                    <p>{{ $tour->available_seats ?? 'Необходимо уточнить' }}</p>
                </div>
                
                @if($tour->start_date && $tour->end_date)
                <div class="tour-dates">
                    <h2>Период проведения</h2>
                    <p>{{ $tour->start_date->format('d.m.Y') }} - {{ $tour->end_date->format('d.m.Y') }}</p>
                    <div class="notice-important">
                        <i class="fas fa-info-circle"></i>
                        <p>Бронирование возможно только на даты внутри указанного периода</p>
                    </div>
                </div>
                @endif
                
                @if(!Auth::check())
                <div class="auth-notice">
                    <div class="notice-content">
                        <i class="fas fa-info-circle"></i>
                        <p>Для бронирования необходимо <a href="{{ route('login') }}">войти</a> или <a href="{{ route('register') }}">зарегистрироваться</a></p>
                    </div>
                </div>
                @endif
                
                <!-- Кнопка для показа формы бронирования -->
                <button class="show-booking-form">Забронировать тур</button>
                
                <!-- Форма бронирования (скрыта по умолчанию) -->
                <div class="booking-form" id="tour-booking-form">
                    <h3>Забронировать тур</h3>
                    
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($tour->start_date && $tour->end_date)
                        <div class="date-range-info">
                            <p>Выберите дату в диапазоне: <strong>{{ $tour->start_date->format('d.m.Y') }} - {{ $tour->end_date->format('d.m.Y') }}</strong></p>
                        </div>
                    @endif
                    
                    <!-- Основная форма бронирования -->
                    <form action="{{ url('/tours/' . $tour->id . '/book') }}" method="POST" id="booking-form" class="main-booking-form">
                        @csrf
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                        
                        <div class="form-group">
                            <label for="booking_date">Дата начала тура</label>
                            <input type="date" id="booking_date" name="booking_date" class="form-control" required 
                                @if($tour->start_date && $tour->end_date)
                                    min="{{ $tour->start_date->format('Y-m-d') }}"
                                    max="{{ $tour->end_date->format('Y-m-d') }}"
                                    value="{{ old('booking_date', $tour->start_date->format('Y-m-d')) }}"
                                @else
                                    min="{{ date('Y-m-d') }}"
                                    value="{{ old('booking_date') }}"
                                @endif
                                >
                            @error('booking_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="persons">Количество человек</label>
                            <input type="number" id="persons" name="persons" class="form-control" min="1" max="{{ $tour->available_seats }}" required value="{{ old('persons', 1) }}" data-price="{{ $tour->price }}">
                            @error('persons')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="guest_name">Ваше имя</label>
                            <input type="text" id="guest_name" name="guest_name" class="form-control" required value="{{ old('guest_name', Auth::user()->name ?? '') }}">
                            @error('guest_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="guest_email">Email</label>
                            <input type="email" id="guest_email" name="guest_email" class="form-control" required value="{{ old('guest_email', Auth::user()->email ?? '') }}">
                            @error('guest_email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="guest_phone">Телефон</label>
                            <input type="tel" id="guest_phone" name="guest_phone" class="form-control" required value="{{ old('guest_phone') }}">
                            @error('guest_phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="notes">Примечания</label>
                            <textarea id="notes" name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                        </div>
                        
                        <div class="total-price">
                            <p>Общая стоимость: <strong>{{ number_format($tour->price, 0, ',', ' ') }}₽</strong> × <span id="persons-count">1</span> = <strong><span id="total-price">{{ number_format($tour->price, 0, ',', ' ') }}</span>₽</strong></p>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="booking-submit">Отправить заявку</button>
                            <button type="button" class="close-booking-form" style="margin-top: 10px; background: none; border: none; color: #555; text-decoration: underline; cursor: pointer; display: block; text-align: center; width: 100%;">Отменить</button>
                        </div>
                    </form>
                
                <div class="tour-actions" style="margin-top: 20px;">
                    <a href="{{ route('tours.index') }}" class="btn btn-secondary">Назад к турам</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection 

@section('scripts')
<script src="{{ asset('js/booking.js') }}"></script>
@endsection 