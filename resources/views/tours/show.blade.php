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
                <img src="{{ asset('storage/' . ($tour->image ?? 'tours/placeholder.jpg')) }}" alt="{{ $tour->name }}">
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
                <div class="booking-form">
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
                    
                    <!-- ВАЖНО: Форма без JavaScript-обработки, с прямой отправкой -->
                    <form action="/tours/{{ $tour->id }}/book" method="POST" id="booking-form">
                        @csrf
                        
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
                    
                    <!-- Отладочная форма с методом GET -->
                    <div style="margin-top: 20px; padding: 15px; border: 1px dashed #f00; background-color: #fff8f8;">
                        <h4 style="color: #d00;">Тестовая форма (GET метод)</h4>
                        <form action="{{ url('/test-booking') }}" method="GET">
                            <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                            
                            <div class="form-group">
                                <label>Дата начала тура</label>
                                <input type="date" name="booking_date" class="form-control" 
                                    @if($tour->start_date && $tour->end_date)
                                        value="{{ $tour->start_date->format('Y-m-d') }}"
                                    @else
                                        value="{{ date('Y-m-d') }}"
                                    @endif
                                    required>
                            </div>
                            
                            <div class="form-group">
                                <label>Количество человек</label>
                                <input type="number" name="persons" class="form-control" value="1" min="1" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Телефон</label>
                                <input type="tel" name="guest_phone" class="form-control" value="79001234567" required>
                            </div>
                            
                            <button type="submit" class="btn btn-danger">Тестовое бронирование через GET</button>
                        </form>
                    </div>
                    
                    <!-- Чистая HTML форма POST без Laravel-хелперов -->
                    <div style="margin-top: 20px; padding: 15px; border: 1px dashed #00f; background-color: #f0f0ff;">
                        <h4 style="color: #00d;">Чистая HTML-форма (POST метод)</h4>
                        <form action="/tours/{{ $tour->id }}/book" method="POST">
                            <!-- Вставляем CSRF-токен вручную -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            
                            <div class="form-group">
                                <label>Дата начала тура</label>
                                <input type="date" name="booking_date" class="form-control" 
                                    @if($tour->start_date && $tour->end_date)
                                        value="{{ $tour->start_date->format('Y-m-d') }}"
                                    @else
                                        value="{{ date('Y-m-d') }}"
                                    @endif
                                    required>
                            </div>
                            
                            <div class="form-group">
                                <label>Количество человек</label>
                                <input type="number" name="persons" class="form-control" value="1" min="1" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Ваше имя</label>
                                <input type="text" name="guest_name" class="form-control" value="{{ Auth::user()->name ?? '' }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="guest_email" class="form-control" value="{{ Auth::user()->email ?? '' }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Телефон</label>
                                <input type="tel" name="guest_phone" class="form-control" value="79001234567" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Отправить через чистый HTML</button>
                        </form>
                    </div>
                    
                    <!-- Экстремально простая форма (POST метод) -->
                    <div style="margin-top: 20px; padding: 15px; border: 2px solid #f00; background-color: #fff0f0;">
                        <h4 style="color: #f00; font-weight: bold;">Экстремально простая форма (POST)</h4>
                        <form action="/tours/{{ $tour->id }}/book" method="POST" style="display: block; margin: 0;">
                            @csrf
                            
                            <input type="hidden" name="booking_date" value="{{ $tour->start_date->format('Y-m-d') }}">
                            <input type="hidden" name="persons" value="1">
                            <input type="hidden" name="guest_name" value="{{ Auth::user()->name ?? 'Гость' }}">
                            <input type="hidden" name="guest_email" value="{{ Auth::user()->email ?? 'guest@example.com' }}">
                            <input type="hidden" name="guest_phone" value="79001234567">
                            
                            <button type="submit" style="background-color: #f00; color: white; padding: 10px 20px; border: none; cursor: pointer; font-weight: bold;">
                                ПРОСТОЕ БРОНИРОВАНИЕ
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="tour-actions" style="margin-top: 20px;">
                    <a href="{{ route('tours.index') }}" class="btn btn-secondary">Назад к турам</a>
                    
                    <!-- Для отладки: набор форм для разных методов бронирования -->
                    @if(Auth::check())
                    <div style="margin-top: 20px; border: 2px dashed #333; padding: 15px; background-color: #f9f9f9;">
                        <h3 style="margin-top: 0; color: #333;">Отладочная панель бронирования</h3>
                        
                        <!-- Форма 1: Простой POST запрос -->
                        <div style="margin-bottom: 15px; padding: 10px; border: 1px solid #007bff; background-color: #e7f5ff;">
                            <h4 style="margin-top: 0; color: #007bff;">1. Прямой POST запрос</h4>
                            <form action="/tours/{{ $tour->id }}/book" method="POST" style="margin: 0;">
                                @csrf
                                <input type="hidden" name="booking_date" value="{{ $tour->start_date->format('Y-m-d') }}">
                                <input type="hidden" name="persons" value="1">
                                <input type="hidden" name="guest_name" value="{{ Auth::user()->name }}">
                                <input type="hidden" name="guest_email" value="{{ Auth::user()->email }}">
                                <input type="hidden" name="guest_phone" value="79001234567">
                                <button type="submit" style="background-color: #007bff; color: white; border: none; padding: 10px 15px; cursor: pointer;">
                                    POST без JavaScript
                                </button>
                            </form>
                        </div>
                        
                        <!-- Форма 2: POST с использованием route() -->
                        <div style="margin-bottom: 15px; padding: 10px; border: 1px solid #28a745; background-color: #e7f7ef;">
                            <h4 style="margin-top: 0; color: #28a745;">2. POST через route()</h4>
                            <form action="{{ route('tours.book', $tour->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                <input type="hidden" name="booking_date" value="{{ $tour->start_date->format('Y-m-d') }}">
                                <input type="hidden" name="persons" value="1">
                                <input type="hidden" name="guest_name" value="{{ Auth::user()->name }}">
                                <input type="hidden" name="guest_email" value="{{ Auth::user()->email }}">
                                <input type="hidden" name="guest_phone" value="79001234567">
                                <button type="submit" style="background-color: #28a745; color: white; border: none; padding: 10px 15px; cursor: pointer;">
                                    POST через route()
                                </button>
                            </form>
                        </div>
                        
                        <!-- Форма 3: GET запрос через test-booking -->
                        <div style="margin-bottom: 15px; padding: 10px; border: 1px solid #ffc107; background-color: #fff9e6;">
                            <h4 style="margin-top: 0; color: #ffc107;">3. GET запрос</h4>
                            <a href="{{ url('/test-booking?tour_id=' . $tour->id . '&booking_date=' . $tour->start_date->format('Y-m-d') . '&persons=1&guest_name=' . Auth::user()->name . '&guest_email=' . Auth::user()->email . '&guest_phone=79001234567') }}" style="display: inline-block; background-color: #ffc107; color: #333; border: none; padding: 10px 15px; text-decoration: none;">
                                GET запрос (работающий)
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Простой JavaScript для показа/скрытия формы -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  // Простой код для показа/скрытия формы
  const showFormButtons = document.querySelectorAll(".show-booking-form");
  showFormButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const bookingForm = document.querySelector(".booking-form");
      if (bookingForm) {
        bookingForm.style.display = "block";
        this.style.display = "none";
      }
    });
  });
  
  // Закрытие формы бронирования
  const closeButtons = document.querySelectorAll(".close-booking-form");
  closeButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const bookingForm = document.querySelector(".booking-form");
      const showButton = document.querySelector(".show-booking-form");
      
      if (bookingForm && showButton) {
        bookingForm.style.display = "none";
        showButton.style.display = "block";
      }
    });
  });
  
  // Отслеживание отправки основной формы
  const mainForm = document.getElementById("booking-form");
  if (mainForm) {
    mainForm.addEventListener("submit", function(e) {
      console.log("Форма отправляется...");
      console.log("URL формы:", this.action);
      console.log("Метод:", this.method);
      // НЕ останавливаем отправку формы, просто логируем
    });
  }
  
  // Расчет итоговой стоимости
  const personsInput = document.getElementById("persons");
  if (personsInput) {
    personsInput.addEventListener("change", function() {
      const personsCount = document.getElementById("persons-count");
      const totalPrice = document.getElementById("total-price");
      const price = parseFloat(this.dataset.price) || 0;
      const persons = parseInt(this.value) || 1;
      
      if (personsCount && totalPrice) {
        personsCount.textContent = persons;
        totalPrice.textContent = new Intl.NumberFormat("ru-RU").format(price * persons);
      }
    });
  }
});
</script>
@endsection 