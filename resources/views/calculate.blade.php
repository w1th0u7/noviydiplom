@extends('layouts.calculator')

@section('title', 'Рассчитайте стоимость путешествия мечты | Rodina-tur')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/calculate.css') }}">
<script src="https://api-maps.yandex.ru/2.1/?apikey=YOUR_API_KEY&lang=ru_RU"></script>
@endsection

@section('content')

<div class="container">
    <!-- Уведомления -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible" style="background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; padding: 15px; margin-bottom: 20px; color: #155724; position: relative;">
            <i class="fas fa-check-circle" style="margin-right: 8px;"></i>
            {{ session('success') }}
            <button type="button" class="close-alert" style="position: absolute; top: 10px; right: 15px; background: none; border: none; font-size: 18px; cursor: pointer; color: #155724;" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
    @endif
    
    @if(session('global_alert'))
        <div class="alert alert-info alert-dismissible" style="background-color: #e6f3ff; border: 1px solid #0050a0; border-radius: 5px; padding: 15px; margin-bottom: 20px; color: #0050a0; position: relative;">
            <i class="fas fa-info-circle" style="margin-right: 8px;"></i>
            {{ session('global_alert') }}
            <button type="button" class="close-alert" style="position: absolute; top: 10px; right: 15px; background: none; border: none; font-size: 18px; cursor: pointer; color: #0050a0;" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
    @endif
    
    @if(session('booking_notification'))
        <div class="alert alert-info alert-dismissible" style="background-color: #e6f3ff; border: 1px solid #0050a0; border-radius: 5px; padding: 15px; margin-bottom: 20px; color: #0050a0; position: relative;">
            <h4 style="margin-bottom: 10px; color: #0050a0;">
                <i class="fas fa-info-circle" style="margin-right: 8px;"></i>
                {{ session('booking_notification')['title'] }}
            </h4>
            <p style="margin: 0;">{{ session('booking_notification')['message'] }}</p>
            <button type="button" class="close-alert" style="position: absolute; top: 10px; right: 15px; background: none; border: none; font-size: 18px; cursor: pointer; color: #0050a0;" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
    @endif

    <div class="calculator-banner">
        <h1>Умный калькулятор путешествий</h1>
        <p>Спланируйте идеальное путешествие и узнайте точную стоимость в несколько кликов</p>
    </div>
    
    <div class="calculator-container calculator-content">
        <div class="calculator-header">
            <h1>Куда хотите отправиться?</h1>
            <p>Выберите параметры вашего будущего путешествия</p>
        </div>
        
        <div class="calculator-body">
            <div id="errorMessage" class="error-message"></div>
            
            <!-- Выбор типа тура -->
            <div class="tour-type-selector">
                <div class="tour-type active" data-type="beach">
                    <i class="fas fa-umbrella-beach"></i>
                    <span class="tour-type-label">Пляжный отдых</span>
                </div>
                <div class="tour-type" data-type="excursion">
                    <i class="fas fa-monument"></i>
                    <span class="tour-type-label">Экскурсионный</span>
                    </div>
                <div class="tour-type" data-type="skiing">
                    <i class="fas fa-skiing"></i>
                    <span class="tour-type-label">Горнолыжный</span>
                    </div>
                <div class="tour-type" data-type="health">
                    <i class="fas fa-spa"></i>
                    <span class="tour-type-label">Оздоровительный</span>
                </div>
                <div class="tour-type" data-type="cruise">
                    <i class="fas fa-ship"></i>
                    <span class="tour-type-label">Круиз</span>
                </div>
            </div>
            
            <form id="tourForm" onsubmit="return false;">
                @csrf
                <input type="hidden" id="tourType" name="tourType" value="beach">
                
                <div class="calculator-form">
                    <div>
                                                    <div class="form-group">
                            <label for="country">Страна</label>
                            <select id="country" name="country" class="form-control" required>
                                                        <option value="">Выберите страну</option>
                                @foreach($countries ?? ['Россия' => 'Россия', 'Турция' => 'Турция', 'Египет' => 'Египет', 'ОАЭ' => 'ОАЭ', 'Таиланд' => 'Таиланд'] as $key => $country)
                                    <option value="{{ $key }}">{{ $country }}</option>
                                @endforeach
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="form-group">
                            <label for="resort">Курорт</label>
                            <select id="resort" name="resort" class="form-control" required>
                                <option value="">Выберите курорт</option>
                                <!-- Курорты будут загружены динамически -->
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                            <label for="departureCity">Город вылета</label>
                            <select id="departureCity" name="departureCity" class="form-control" required>
                                <option value="">Выберите город</option>
                                <option value="Москва">Москва</option>
                                <option value="Санкт-Петербург">Санкт-Петербург</option>
                                <option value="Казань">Казань</option>
                                <option value="Екатеринбург">Екатеринбург</option>
                                <option value="Новосибирск">Новосибирск</option>
                                <option value="Краснодар">Краснодар</option>
                                <option value="Сочи">Сочи</option>
                                                        </select>
                        </div>
                                                    </div>
                                                    
                    <div>
                                                    <div class="form-group">
                            <label for="departureDate">Дата вылета</label>
                            <input type="date" id="departureDate" name="departureDate" class="form-control" required>
                                                    </div>
                                                    
                                                    <div class="form-group">
                            <label>Количество ночей</label>
                            <div class="nights-slider-container">
                                <div class="nights-label">
                                    <span>1 ночь</span>
                                    <span id="nightsDisplay" class="nights-display">7</span>
                                    <span>21 ночь</span>
                                                    </div>
                                <input type="range" min="1" max="21" value="7" class="slider" id="nightsSlider" name="nights">
                                                </div>
                                            </div>
                                            
                        <div class="form-group">
                            <label>Количество туристов</label>
                            <div class="tourists-container">
                                <div class="tourists-control">
                                    <button type="button" id="decreaseTourists" class="btn-counter">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" id="tourists" name="tourists" min="1" max="10" value="2" readonly>
                                    <button type="button" id="increaseTourists" class="btn-counter">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div id="childrenContainer" class="children-container" style="display: none;">
                                    <p>Укажите возраст детей</p>
                                    <div id="childrenAges" class="children-ages">
                                        <!-- Возраст детей будет добавлен динамически -->
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="tour-options">
                    <h3>Класс отеля</h3>
                    <input type="hidden" id="hotelClass" name="hotelClass" value="стандарт">
                    <div class="hotel-categories">
                        <div class="hotel-category" data-value="эконом">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <div>Эконом</div>
                        </div>
                        <div class="hotel-category active" data-value="стандарт">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <div>Стандарт</div>
                        </div>
                        <div class="hotel-category" data-value="комфорт">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <div>Комфорт</div>
                        </div>
                        <div class="hotel-category" data-value="люкс">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <div>Люкс</div>
                        </div>
                    </div>
                </div>
                
                <div class="tour-options">
                    <h3>Питание</h3>
                    <input type="hidden" id="meal" name="meal" value="завтрак">
                    <div class="options-grid">
                        <div class="meal-type" data-value="без питания">
                            <i class="fas fa-utensils"></i>
                            <span>Без питания (RO)</span>
                        </div>
                        <div class="meal-type active" data-value="завтрак">
                            <i class="fas fa-coffee"></i>
                            <span>Завтрак (BB)</span>
                        </div>
                        <div class="meal-type" data-value="полупансион">
                            <i class="fas fa-hamburger"></i>
                            <span>Полупансион (HB)</span>
                        </div>
                        <div class="meal-type" data-value="полный пансион">
                            <i class="fas fa-concierge-bell"></i>
                            <span>Полный пансион (FB)</span>
                        </div>
                        <div class="meal-type" data-value="все включено">
                            <i class="fas fa-cocktail"></i>
                            <span>Всё включено (AI)</span>
                        </div>
                        <div class="meal-type" data-value="ультра всё включено">
                            <i class="fas fa-glass-cheers"></i>
                            <span>Ультра всё включено (UAI)</span>
                        </div>
                    </div>
                </div>
                
                <div class="tour-options">
                    <h3>Дополнительные опции</h3>
                    <div class="options-grid">
                        <div class="checkbox-wrapper">
                            <input type="checkbox" id="insurance" name="insurance" value="1">
                            <label for="insurance">Страховка</label>
                        </div>
                        <div class="checkbox-wrapper">
                            <input type="checkbox" id="transfer" name="transfer" value="1">
                            <label for="transfer">Трансфер</label>
                        </div>
                        <div class="checkbox-wrapper">
                            <input type="checkbox" id="excursions" name="excursions" value="1">
                            <label for="excursions">Экскурсии</label>
                        </div>
                    </div>
                </div>

                <!-- Добавляем новую опцию - Близость к морю -->
                <div class="tour-options">
                    <h3>Близость к морю</h3>
                    <input type="hidden" id="seaProximity" name="seaProximity" value="any">
                    <div class="options-grid">
                        <div class="sea-proximity-type active" data-value="any">
                            <i class="fas fa-globe-americas"></i>
                            <span>Любая</span>
                        </div>
                        <div class="sea-proximity-type" data-value="first-line">
                            <i class="fas fa-water"></i>
                            <span>1-я линия</span>
                        </div>
                        <div class="sea-proximity-type" data-value="up-to-500">
                            <i class="fas fa-shoe-prints"></i>
                            <span>До 500 метров</span>
                        </div>
                        <div class="sea-proximity-type" data-value="over-500">
                            <i class="fas fa-walking"></i>
                            <span>Более 500 метров</span>
                        </div>
                    </div>
                </div>

                <div class="calculator-actions">
                    <button type="button" id="calculateButton" class="btn btn-primary">
                        <i class="fas fa-calculator"></i>
                        Рассчитать стоимость
                    </button>
                </div>
            </form>
            
            <div id="calculationResult" class="calculation-result">
                <div class="result-header">
                    <div>
                        <h3 class="result-title">Результаты расчета</h3>
                        <p id="tourSummary"></p>
                    </div>
                    <div class="total-price">
                        <span>Итого:</span>
                        <span id="totalPriceValue">0 ₽</span>
                    </div>
                </div>
                
                <div class="price-breakdown">
                    <div class="price-item">
                        <div class="price-label">Проживание</div>
                        <div id="accommodationPrice" class="price-value">0 ₽</div>
                    </div>
                    <div class="price-item">
                        <div class="price-label">Перелет</div>
                        <div id="flightPrice" class="price-value">0 ₽</div>
                    </div>
                    <div class="price-item">
                        <div class="price-label">Питание</div>
                        <div id="mealPrice" class="price-value">0 ₽</div>
                    </div>
                    <div id="additionalServices"></div>
                </div>
                
                <div class="calculator-actions">
                    <button type="button" id="bookTourButton" class="btn btn-primary">
                        <i class="fas fa-bookmark"></i>
                        Забронировать тур
                    </button>
                    <button type="button" id="shareButton" class="btn btn-secondary">
                        <i class="fas fa-share-alt"></i>
                        Поделиться
                    </button>
                    <button type="button" id="printButton" class="btn btn-outline">
                        <i class="fas fa-print"></i>
                        Распечатать
                    </button>
                </div>
            </div>
            
            <div id="loader" class="loader"></div>
            
            <div id="hotelsSection" style="display: none;">
                <h2 class="section-title">Рекомендуемые отели</h2>
                
                <div class="hotel-filters">
                    <div class="filter-chip active" data-filter="all">Все</div>
                    <div class="filter-chip" data-filter="beach">У пляжа</div>
                    <div class="filter-chip" data-filter="pool">С бассейном</div>
                    <div class="filter-chip" data-filter="center">В центре</div>
                    <div class="filter-chip" data-filter="family">Для семей</div>
                </div>
                
                <!-- Добавляем фильтры по близости к морю -->
                <div class="hotel-filters sea-filters">
                    <span class="filter-group-label">Близость к морю:</span>
                    <div class="filter-chip" data-sea-filter="first-line">1-я линия</div>
                    <div class="filter-chip" data-sea-filter="up-to-500">До 500 метров</div>
                    <div class="filter-chip" data-sea-filter="over-500">Более 500 метров</div>
                </div>
                
                <div id="hotelCards" class="hotel-cards"></div>
            </div>
            
            <div id="mapSection" class="resort-map-container" style="display: none;">
                <h2 class="section-title">Карта курорта</h2>
                <div id="resortMap" style="width: 100%; height: 400px;"></div>
            </div>
            
            <div class="popular-destinations">
                <h2 class="section-title">Популярные направления</h2>
                
                <div class="destinations-grid">
                    <div class="destination-card">
                        <img src="/img/BKPQSJucT0c 1.jpg" alt="Сочи">
                        <div class="destination-content">
                            <div class="destination-name">Сочи</div>
                            <div class="destination-price">от 25 000 ₽</div>
                        </div>
                    </div>
                    <div class="destination-card">
                        <img src="/img/image 6.jpg" alt="Турция">
                        <div class="destination-content">
                            <div class="destination-name">Турция</div>
                            <div class="destination-price">от 60 000 ₽</div>
                        </div>
                    </div>
                    <div class="destination-card">
                        <img src="/img/image 7.jpg" alt="Египет">
                        <div class="destination-content">
                            <div class="destination-name">Египет</div>
                            <div class="destination-price">от 70 000 ₽</div>
                        </div>
                    </div>
                    <div class="destination-card">
                        <img src="/img/image 8.jpg" alt="ОАЭ">
                        <div class="destination-content">
                            <div class="destination-name">ОАЭ</div>
                            <div class="destination-price">от 85 000 ₽</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно для просмотра деталей тура -->
<div id="tour-detail-modal" class="tour-modal">
    <div class="tour-modal-content">
        <span class="tour-modal-close">&times;</span>
        <div class="tour-modal-header">
            <h2 id="tour-title">Название тура</h2>
            <div class="tour-rating">
                <div class="stars" id="tour-stars"></div>
                <span class="rating-value" id="tour-rating">4.5</span>
                <span class="reviews-count" id="tour-reviews">(42 отзыва)</span>
            </div>
        </div>
        
        <div class="tour-modal-body">
            <div class="tour-gallery">
                <div class="tour-main-image-container">
                    <img id="tour-main-image" src="" alt="Фото тура">
                </div>
                <div class="tour-thumbnails">
                    <img class="thumbnail active" src="" alt="Миниатюра 1">
                    <img class="thumbnail" src="" alt="Миниатюра 2">
                    <img class="thumbnail" src="" alt="Миниатюра 3">
                    <img class="thumbnail" src="" alt="Миниатюра 4">
                </div>
            </div>
            
            <div class="tour-details">
                <div class="tour-info-grid">
                    <div class="tour-info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <span class="label">Расположение</span>
                            <span id="tour-location">Анталия, Турция</span>
                        </div>
                    </div>
                    <div class="tour-info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <div>
                            <span class="label">Дата</span>
                            <span id="tour-date">10 июля - 17 июля 2023</span>
                        </div>
                    </div>
                    <div class="tour-info-item">
                        <i class="fas fa-moon"></i>
                        <div>
                            <span class="label">Длительность</span>
                            <span id="tour-duration">7 ночей</span>
                        </div>
                    </div>
                    <div class="tour-info-item">
                        <i class="fas fa-users"></i>
                        <div>
                            <span class="label">Туристы</span>
                            <span id="tour-group-size">2 человека</span>
                        </div>
                    </div>
                    <div class="tour-info-item">
                        <i class="fas fa-water"></i>
                        <div>
                            <span class="label">До моря</span>
                            <span id="tour-sea-distance">1-я линия</span>
                        </div>
                    </div>
                </div>
                
                <div class="tour-description">
                    <h3>Описание тура</h3>
                    <p id="tour-description-text">
                        Насладитесь незабываемым отдыхом на лазурном побережье. Вас ждут первоклассные отели, чистейшие пляжи с бирюзовой водой и богатое культурное наследие.
                    </p>
                </div>
                
                <div class="tour-features">
                    <h3>Включено в стоимость</h3>
                    <ul id="tour-features-list">
                        <li><i class="fas fa-check"></i> Проживание в отеле 5* (7 ночей)</li>
                        <li><i class="fas fa-check"></i> Питание "всё включено"</li>
                        <li><i class="fas fa-check"></i> Авиаперелет туда-обратно</li>
                        <li><i class="fas fa-check"></i> Групповой трансфер из/в аэропорт</li>
                        <li><i class="fas fa-check"></i> Медицинская страховка</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="tour-modal-footer">
            <div class="tour-price">
                <span>Стоимость тура:</span>
                <span id="tour-price-value" class="price-value">84 800 ₽</span>
            </div>
            <div class="tour-buttons">
                <button class="btn btn-primary btn-book-tour">
                    <i class="fas fa-bookmark"></i> Забронировать
                </button>
                <button class="btn btn-secondary btn-add-favorite">
                    <i class="far fa-heart"></i> В избранное
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
