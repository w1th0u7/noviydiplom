@extends('layouts.basic')

@section('title', 'Экскурсии | Родина-тур')

@section('styles')
<link rel="stylesheet" href="{{ asset('/css/media.css') }}">
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('/css/pages/excursions.css') }}">
<link rel="stylesheet" href="{{ asset('/css/pages/responsive.css') }}">
@endsection

@section('content')
<section class="excursions-page">
    <div class="max">
        <div class="zag-btn">
            <h2>Экскурсии</h2>
            <p>Познавательные программы по всей России</p>
        </div>
        
        <!-- Навигация по типам аудитории -->
        <div class="nav-tabs">
            <div class="nav-tab active" data-target="all">
                <img src="{{ asset('img/icons/excursion-icon.png') }}" alt="Все экскурсии">
                <h3>Все экскурсии</h3>
            </div>
            <div class="nav-tab" data-target="preschool">
                <img src="{{ asset('img/icons/children.png') }}" alt="Для дошкольников">
                <h3>Для дошкольников</h3>
            </div>
            <div class="nav-tab" data-target="school">
                <img src="{{ asset('img/icons/schoolboy.png') }}" alt="Для школьников">
                <h3>Для школьников</h3>
            </div>
            <div class="nav-tab" data-target="adult">
                <img src="{{ asset('img/icons/vzroslie.png') }}" alt="Для взрослых">
                <h3>Для взрослых</h3>
            </div>
        </div>
        
        <div class="excursion-filter excursions-list">
            <div class="filter-group">
                <label for="region">Регион:</label>
                <select id="region" class="filter-select">
                    <option value="all">Все регионы</option>
                    <option value="Центральный">Центральный</option>
                    <option value="Северо-Западный">Северо-Западный</option>
                    <option value="Южный">Южный</option>
                    <option value="Северо-Кавказский">Северо-Кавказский</option>
                    <option value="Приволжский">Приволжский</option>
                    <option value="Уральский">Уральский</option>
                    <option value="Сибирский">Сибирский</option>
                    <option value="Дальневосточный">Дальневосточный</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="duration">Продолжительность:</label>
                <select id="duration" class="filter-select">
                    <option value="all">Любая</option>
                    <option value="1">1 день</option>
                    <option value="2-3">2-3 дня</option>
                    <option value="4-7">4-7 дней</option>
                    <option value="8+">8+ дней</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="price-range">Цена до:</label>
                <input type="range" id="price-range" min="1000" max="50000" step="1000" value="50000">
                <div id="price-value">до 50 000 ₽</div>
            </div>
            
            <div class="filter-group">
                <button id="filter-button" class="filter-button">Применить</button>
                <button id="filter-reset" class="filter-button filter-reset">Сбросить</button>
            </div>
        </div>

        <!-- Контент для всех экскурсий (показывается по умолчанию) -->
        <div class="tab-pane active" id="tab-all">
            <div class="excursion-grid">
                @foreach($preschoolExcursions as $excursion)
                <div class="excursion-card" data-region="{{ $excursion['region'] ?? $excursion->region }}" data-duration="{{ $excursion['duration'] ?? $excursion->duration }}" data-price="{{ $excursion['price'] ?? $excursion->price }}" data-type="preschool">
                    <div class="excursion-image">
                        <img src="{{ asset('img/' . (isset($excursion['image']) ? $excursion['image'] : ($excursion->image_path ?? 'excursions/placeholder.jpg'))) }}" alt="{{ $excursion['name'] ?? $excursion->name }}">
                        <div class="excursion-duration">{{ $excursion['duration'] ?? $excursion->duration }} {{ ($excursion['duration'] ?? $excursion->duration) == 1 ? 'день' : 'дня' }}</div>
                    </div>
                    <div class="excursion-info">
                        <h3>{{ $excursion['name'] ?? $excursion->name }}</h3>
                        <div class="excursion-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $excursion['location'] ?? $excursion->location }}</span>
                        </div>
                        <div class="excursion-description">
                            {{ Str::limit($excursion['description'] ?? $excursion->description, 100) }}
                        </div>
                        <div class="excursion-price">
                            <strong>{{ number_format($excursion['price'] ?? $excursion->price, 0, '.', ' ') }} ₽</strong>
                            <span>на человека</span>
                        </div>
                    </div>
                    <a href="{{ isset($excursion['id']) ? route('excursions.show', $excursion['id']) : route('excursions.show', $excursion->id) }}" class="excursion-button">Подробнее</a>
                </div>
                @endforeach

                @foreach($schoolExcursions as $excursion)
                @if(!$preschoolExcursions->contains('id', $excursion['id'] ?? $excursion->id))
                <div class="excursion-card" data-region="{{ $excursion['region'] ?? $excursion->region }}" data-duration="{{ $excursion['duration'] ?? $excursion->duration }}" data-price="{{ $excursion['price'] ?? $excursion->price }}" data-type="school">
                    <div class="excursion-image">
                        <img src="{{ asset('img/' . (isset($excursion['image']) ? $excursion['image'] : ($excursion->image_path ?? 'excursions/placeholder.jpg'))) }}" alt="{{ $excursion['name'] ?? $excursion->name }}">
                        <div class="excursion-duration">{{ $excursion['duration'] ?? $excursion->duration }} {{ ($excursion['duration'] ?? $excursion->duration) == 1 ? 'день' : 'дня' }}</div>
                    </div>
                    <div class="excursion-info">
                        <h3>{{ $excursion['name'] ?? $excursion->name }}</h3>
                        <div class="excursion-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $excursion['location'] ?? $excursion->location }}</span>
                        </div>
                        <div class="excursion-description">
                            {{ Str::limit($excursion['description'] ?? $excursion->description, 100) }}
                        </div>
                        <div class="excursion-price">
                            <strong>{{ number_format($excursion['price'] ?? $excursion->price, 0, '.', ' ') }} ₽</strong>
                            <span>на человека</span>
                        </div>
                    </div>
                    <a href="{{ isset($excursion['id']) ? route('excursions.show', $excursion['id']) : route('excursions.show', $excursion->id) }}" class="excursion-button">Подробнее</a>
                </div>
                @endif
                @endforeach

                @foreach($adultExcursions as $excursion)
                @if(!$preschoolExcursions->contains('id', $excursion['id'] ?? $excursion->id) && 
                    !$schoolExcursions->contains('id', $excursion['id'] ?? $excursion->id))
                <div class="excursion-card" data-region="{{ $excursion['region'] ?? $excursion->region }}" data-duration="{{ $excursion['duration'] ?? $excursion->duration }}" data-price="{{ $excursion['price'] ?? $excursion->price }}" data-type="adult">
                    <div class="excursion-image">
                        <img src="{{ asset('img/' . (isset($excursion['image']) ? $excursion['image'] : ($excursion->image_path ?? 'excursions/placeholder.jpg'))) }}" alt="{{ $excursion['name'] ?? $excursion->name }}">
                        <div class="excursion-duration">{{ $excursion['duration'] ?? $excursion->duration }} {{ ($excursion['duration'] ?? $excursion->duration) == 1 ? 'день' : 'дня' }}</div>
                    </div>
                    <div class="excursion-info">
                        <h3>{{ $excursion['name'] ?? $excursion->name }}</h3>
                        <div class="excursion-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $excursion['location'] ?? $excursion->location }}</span>
                        </div>
                        <div class="excursion-description">
                            {{ Str::limit($excursion['description'] ?? $excursion->description, 100) }}
                        </div>
                        <div class="excursion-price">
                            <strong>{{ number_format($excursion['price'] ?? $excursion->price, 0, '.', ' ') }} ₽</strong>
                            <span>на человека</span>
                        </div>
                    </div>
                    <a href="{{ isset($excursion['id']) ? route('excursions.show', $excursion['id']) : route('excursions.show', $excursion->id) }}" class="excursion-button">Подробнее</a>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        
        <!-- Контент для дошкольников -->
        <div class="tab-pane" id="tab-preschool">
            <div class="excursion-grid">
                @foreach($preschoolExcursions as $excursion)
                <div class="excursion-card" data-region="{{ $excursion['region'] ?? $excursion->region }}" data-duration="{{ $excursion['duration'] ?? $excursion->duration }}" data-price="{{ $excursion['price'] ?? $excursion->price }}">
                    <div class="excursion-image">
                        <img src="{{ asset('img/' . (isset($excursion['image']) ? $excursion['image'] : ($excursion->image_path ?? 'excursions/placeholder.jpg'))) }}" alt="{{ $excursion['name'] ?? $excursion->name }}">
                        <div class="excursion-duration">{{ $excursion['duration'] ?? $excursion->duration }} {{ ($excursion['duration'] ?? $excursion->duration) == 1 ? 'день' : 'дня' }}</div>
                    </div>
                    <div class="excursion-info">
                        <h3>{{ $excursion['name'] ?? $excursion->name }}</h3>
                        <div class="excursion-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $excursion['location'] ?? $excursion->location }}</span>
                        </div>
                        <div class="excursion-description">
                            {{ Str::limit($excursion['description'] ?? $excursion->description, 100) }}
                        </div>
                        <div class="excursion-price">
                            <strong>{{ number_format($excursion['price'] ?? $excursion->price, 0, '.', ' ') }} ₽</strong>
                            <span>на человека</span>
                        </div>
                    </div>
                    <a href="{{ isset($excursion['id']) ? route('excursions.show', $excursion['id']) : route('excursions.show', $excursion->id) }}" class="excursion-button">Подробнее</a>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Контент для школьников -->
        <div class="tab-pane" id="tab-school">
            <div class="excursion-grid">
                @foreach($schoolExcursions as $excursion)
                <div class="excursion-card" data-region="{{ $excursion['region'] ?? $excursion->region }}" data-duration="{{ $excursion['duration'] ?? $excursion->duration }}" data-price="{{ $excursion['price'] ?? $excursion->price }}">
                    <div class="excursion-image">
                        <img src="{{ asset('img/' . (isset($excursion['image']) ? $excursion['image'] : ($excursion->image_path ?? 'excursions/placeholder.jpg'))) }}" alt="{{ $excursion['name'] ?? $excursion->name }}">
                        <div class="excursion-duration">{{ $excursion['duration'] ?? $excursion->duration }} {{ ($excursion['duration'] ?? $excursion->duration) == 1 ? 'день' : 'дня' }}</div>
                    </div>
                    <div class="excursion-info">
                        <h3>{{ $excursion['name'] ?? $excursion->name }}</h3>
                        <div class="excursion-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $excursion['location'] ?? $excursion->location }}</span>
                        </div>
                        <div class="excursion-description">
                            {{ Str::limit($excursion['description'] ?? $excursion->description, 100) }}
                        </div>
                        <div class="excursion-price">
                            <strong>{{ number_format($excursion['price'] ?? $excursion->price, 0, '.', ' ') }} ₽</strong>
                            <span>на человека</span>
                        </div>
                    </div>
                    <a href="{{ isset($excursion['id']) ? route('excursions.show', $excursion['id']) : route('excursions.show', $excursion->id) }}" class="excursion-button">Подробнее</a>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Контент для взрослых -->
        <div class="tab-pane" id="tab-adult">
            <div class="excursion-grid">
                @foreach($adultExcursions as $excursion)
                <div class="excursion-card" data-region="{{ $excursion['region'] ?? $excursion->region }}" data-duration="{{ $excursion['duration'] ?? $excursion->duration }}" data-price="{{ $excursion['price'] ?? $excursion->price }}">
                    <div class="excursion-image">
                        <img src="{{ asset('img/' . (isset($excursion['image']) ? $excursion['image'] : ($excursion->image_path ?? 'excursions/placeholder.jpg'))) }}" alt="{{ $excursion['name'] ?? $excursion->name }}">
                        <div class="excursion-duration">{{ $excursion['duration'] ?? $excursion->duration }} {{ ($excursion['duration'] ?? $excursion->duration) == 1 ? 'день' : 'дня' }}</div>
                    </div>
                    <div class="excursion-info">
                        <h3>{{ $excursion['name'] ?? $excursion->name }}</h3>
                        <div class="excursion-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $excursion['location'] ?? $excursion->location }}</span>
                        </div>
                        <div class="excursion-description">
                            {{ Str::limit($excursion['description'] ?? $excursion->description, 100) }}
                        </div>
                        <div class="excursion-price">
                            <strong>{{ number_format($excursion['price'] ?? $excursion->price, 0, '.', ' ') }} ₽</strong>
                            <span>на человека</span>
                        </div>
                    </div>
                    <a href="{{ isset($excursion['id']) ? route('excursions.show', $excursion['id']) : route('excursions.show', $excursion->id) }}" class="excursion-button">Подробнее</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Переключение между вкладками
        const tabs = document.querySelectorAll('.nav-tab');
        const tabContents = document.querySelectorAll('.tab-pane');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const target = this.getAttribute('data-target');
                
                // Активация текущей вкладки
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                // Отображение соответствующего контента
                tabContents.forEach(content => content.classList.remove('active'));
                document.getElementById(`tab-${target}`).classList.add('active');
                
                // Если выбрана определенная категория, фильтруем только карточки этой категории
                if (target !== 'all') {
                    document.querySelectorAll(`#tab-${target} .excursion-card`).forEach(card => {
                        applyFilters(card);
                    });
                } else {
                    document.querySelectorAll(`#tab-all .excursion-card`).forEach(card => {
                        applyFilters(card);
                    });
                }
            });
        });
        
        // Обновление отображаемой цены на слайдере
        const priceRange = document.getElementById('price-range');
        const priceValue = document.getElementById('price-value');
        
        priceRange.addEventListener('input', function() {
            priceValue.textContent = `до ${parseInt(this.value).toLocaleString('ru-RU')} ₽`;
        });
        
        // Фильтрация экскурсий
        const filterButton = document.getElementById('filter-button');
        const filterReset = document.getElementById('filter-reset');
        
        filterButton.addEventListener('click', function() {
            const activeTabContent = document.querySelector('.tab-pane.active');
            const cards = activeTabContent.querySelectorAll('.excursion-card');
            
            cards.forEach(card => {
                applyFilters(card);
            });
        });
        
        filterReset.addEventListener('click', function() {
            // Сброс значений фильтров
            document.getElementById('region').value = 'all';
            document.getElementById('duration').value = 'all';
            document.getElementById('price-range').value = 50000;
            priceValue.textContent = 'до 50 000 ₽';
            
            // Отображение всех карточек
            const activeTabContent = document.querySelector('.tab-pane.active');
            const cards = activeTabContent.querySelectorAll('.excursion-card');
            
            cards.forEach(card => {
                card.style.display = 'flex';
            });
        });
        
        function applyFilters(card) {
            const selectedRegion = document.getElementById('region').value;
            const selectedDuration = document.getElementById('duration').value;
            const maxPrice = parseInt(document.getElementById('price-range').value);
            
            const cardRegion = card.getAttribute('data-region');
            const cardDuration = parseInt(card.getAttribute('data-duration'));
            const cardPrice = parseInt(card.getAttribute('data-price'));
            
            let showCard = true;
            
            // Фильтр по региону
            if (selectedRegion !== 'all' && cardRegion !== selectedRegion) {
                showCard = false;
            }
            
            // Фильтр по продолжительности
            if (selectedDuration !== 'all') {
                if (selectedDuration === '1' && cardDuration !== 1) {
                    showCard = false;
                } else if (selectedDuration === '2-3' && (cardDuration < 2 || cardDuration > 3)) {
                    showCard = false;
                } else if (selectedDuration === '4-7' && (cardDuration < 4 || cardDuration > 7)) {
                    showCard = false;
                } else if (selectedDuration === '8+' && cardDuration < 8) {
                    showCard = false;
                }
            }
            
            // Фильтр по цене
            if (cardPrice > maxPrice) {
                showCard = false;
            }
            
            card.style.display = showCard ? 'flex' : 'none';
        }
    });
</script>
@endsection

