@extends('layouts.basic')

@section('title', 'Расписание туров | Родина-тур')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/media.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/schedule.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/responsive.css') }}">
@endsection

@section('content')
<section class="schedule-page">
    <div class="max">
        <div class="zag-btn">
            <h2>Расписание туров</h2>
            <p>Выбирайте из множества направлений и дат</p>
        </div>
        
        <div class="schedule-filter">
            <div class="filter-group">
                <label for="tour-type">Тип тура:</label>
                <select id="tour-type" class="filter-select">
                    <option value="all">Все типы</option>
                    @foreach($tourTypes as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="filter-group">
                <label for="month">Месяц:</label>
                <select id="month" class="filter-select">
                    <option value="all">Все месяцы</option>
                    <option value="01">Январь</option>
                    <option value="02">Февраль</option>
                    <option value="03">Март</option>
                    <option value="04">Апрель</option>
                    <option value="05">Май</option>
                    <option value="06">Июнь</option>
                    <option value="07">Июль</option>
                    <option value="08">Август</option>
                    <option value="09">Сентябрь</option>
                    <option value="10">Октябрь</option>
                    <option value="11">Ноябрь</option>
                    <option value="12">Декабрь</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="price">Цена до:</label>
                <input type="range" id="price" min="10000" max="100000" step="5000" value="100000">
                <span id="price-value">100 000 ₽</span>
            </div>
            
            <button id="filter-apply" class="filter-button">Применить</button>
            <button id="filter-reset" class="filter-button filter-reset">Сбросить</button>
        </div>
        
        <div class="tour-schedule-grid">
            @foreach($tours as $tour)
            <div class="tour-card" data-type="{{ $tour->type }}" data-date="{{ $tour->start_date->format('Y-m-d') }}" data-price="{{ $tour->price }}">
                <div class="tour-image">
                    <img src="{{ asset(str_starts_with($tour->image, 'img/') ? $tour->image : 'storage/' . $tour->image) }}" alt="{{ $tour->name }}">
                    <div class="tour-type">{{ $tour->type }}</div>
                </div>
                <div class="tour-info">
                    <h3>{{ $tour->name }}</h3>
                    <div class="tour-dates">
                        <i class="fas fa-calendar-alt"></i>
                        <span>{{ $tour->start_date->format('d.m.Y') }} - {{ $tour->end_date->format('d.m.Y') }}</span>
                    </div>
                    <div class="tour-duration">
                        <i class="fas fa-clock"></i>
                        <span>{{ $tour->duration_text }}</span>
                    </div>
                    <div class="tour-seats">
                        <i class="fas fa-users"></i>
                        <span>Свободных мест: {{ $tour->available_seats }}</span>
                    </div>
                    <div class="tour-price">
                        <strong>{{ number_format($tour->price, 0, '.', ' ') }} ₽</strong>
                        <span>на человека</span>
                    </div>
                </div>
                <a href="{{ route('tours.show', $tour->id) }}" class="tour-button">Подробнее</a>
            </div>
            @endforeach
        </div>
        
        @if($tours->isEmpty())
        <div class="no-tours-message">
            <p>К сожалению, туры, соответствующие вашим критериям, не найдены.</p>
            <p>Попробуйте изменить параметры фильтра или вернитесь позже.</p>
        </div>
        @endif
        
        <div class="pagination">
            <a href="#" class="pagination-arrow disabled"><i class="fas fa-chevron-left"></i></a>
            <a href="#" class="pagination-number active">1</a>
            <a href="#" class="pagination-number">2</a>
            <a href="#" class="pagination-number">3</a>
            <a href="#" class="pagination-arrow"><i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tourCards = document.querySelectorAll('.tour-card');
        const tourTypeFilter = document.getElementById('tour-type');
        const monthFilter = document.getElementById('month');
        const priceFilter = document.getElementById('price');
        const priceValue = document.getElementById('price-value');
        const filterApply = document.getElementById('filter-apply');
        const filterReset = document.getElementById('filter-reset');
        
        // Initial price display
        priceFilter.addEventListener('input', function() {
            priceValue.textContent = Number(this.value).toLocaleString('ru-RU') + ' ₽';
        });
        
        // Apply filters
        filterApply.addEventListener('click', function() {
            const selectedType = tourTypeFilter.value;
            const selectedMonth = monthFilter.value;
            const maxPrice = parseInt(priceFilter.value);
            
            let visibleCount = 0;
            
            tourCards.forEach(card => {
                const cardType = card.dataset.type;
                const cardDate = card.dataset.date;
                const cardMonth = cardDate.split('-')[1];
                const cardPrice = parseInt(card.dataset.price);
                
                let showCard = true;
                
                // Filter by type
                if (selectedType !== 'all' && cardType !== selectedType) {
                    showCard = false;
                }
                
                // Filter by month
                if (selectedMonth !== 'all' && cardMonth !== selectedMonth) {
                    showCard = false;
                }
                
                // Filter by price
                if (cardPrice > maxPrice) {
                    showCard = false;
                }
                
                card.style.display = showCard ? 'block' : 'none';
                
                if (showCard) {
                    visibleCount++;
                }
            });
            
            // Показываем или скрываем сообщение об отсутствии туров
            const noToursMessage = document.querySelector('.no-tours-message');
            if (noToursMessage) {
                noToursMessage.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        });
        
        // Reset filters
        filterReset.addEventListener('click', function() {
            tourTypeFilter.value = 'all';
            monthFilter.value = 'all';
            priceFilter.value = 100000;
            priceValue.textContent = '100 000 ₽';
            
            tourCards.forEach(card => {
                card.style.display = 'block';
            });
            
            // Скрываем сообщение об отсутствии туров при сбросе
            const noToursMessage = document.querySelector('.no-tours-message');
            if (noToursMessage) {
                noToursMessage.style.display = 'none';
            }
        });
    });
</script>
@endsection 