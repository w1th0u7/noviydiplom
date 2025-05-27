@extends('layouts.basic')

@section('title', 'Контакты | Родина-тур')

@section('styles')
<link rel="stylesheet" href="{{ asset('/css/media.css') }}">
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('/css/pages/contacts.css') }}">
<link rel="stylesheet" href="{{ asset('/css/pages/responsive.css') }}">
@endsection

@section('content')
<section class="contacts-page">
    <div class="max">
        <div class="zag-btn">
            <h2>Контакты</h2>
            <p>Как с нами связаться?</p>
        </div>
        
        <div class="contacts-container contacts-main">
            <div class="contacts-info">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-details">
                        <h3>Адрес</h3>
                        <p>{{ $contacts['address'] }}</p>
                    </div>
                </div>
                
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="contact-details">
                        <h3>Телефон</h3>
                        <p><a href="tel:{{ str_replace([' ', '(', ')', '-'], '', $contacts['phone']) }}">{{ $contacts['phone'] }}</a></p>
                        <p class="text-muted">по России бесплатный</p>
                    </div>
                </div>
                
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-details">
                        <h3>Email</h3>
                        <p><a href="mailto:{{ $contacts['email'] }}">{{ $contacts['email'] }}</a></p>
                    </div>
                </div>
                
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="contact-details">
                        <h3>Режим работы</h3>
                        <p>{{ $contacts['working_hours'] }}</p>
                    </div>
                </div>
                
                <div class="social-links">
                    <h3>Мы в социальных сетях</h3>
                    <div class="social-icons">
                        <a href="#" class="social-icon" target="_blank">
                            <i class="fab fa-telegram"></i>
                        </a>
                        <a href="#" class="social-icon" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="social-icon" target="_blank">
                            <i class="fab fa-vk"></i>
                        </a>
                        <a href="#" class="social-icon" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="offices-section">
            <h3>Наш офис</h3>
            
            <div class="office-cards">
                @foreach($offices as $office)
                <div class="office-card">
                    <h4>{{ $office['name'] }}</h4>
                    <p><i class="fas fa-map-marker-alt"></i> {{ $office['address'] }}</p>
                    <p><i class="fas fa-phone-alt"></i> <a href="tel:{{ str_replace([' ', '(', ')', '-'], '', $office['phone']) }}">{{ $office['phone'] }}</a></p>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="map-container">
            <div id="map" style="width: 100%; height: 500px;"></div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Инициализация карты Яндекс
        ymaps.ready(init);
        
        function init() {
            const myMap = new ymaps.Map('map', {
                center: [55.753215, 37.622504],
                zoom: 10,
                controls: ['zoomControl', 'geolocationControl']
            });
            
            // Добавляем офисы на карту
            @foreach($offices as $office)
                const placemark{{ $loop->index }} = new ymaps.Placemark(
                    [{{ $office['coordinates'][0] }}, {{ $office['coordinates'][1] }}], 
                    {
                        balloonContentHeader: '{{ $office['name'] }}',
                        balloonContentBody: '{{ $office['address'] }}<br>{{ $office['phone'] }}',
                        hintContent: '{{ $office['name'] }}'
                    }, 
                    {
                        preset: 'islands#yellowDotIcon'
                    }
                );
                
                myMap.geoObjects.add(placemark{{ $loop->index }});
            @endforeach
            
            // Подгоняем карту под все метки
            if (myMap.geoObjects.getLength() > 0) {
                myMap.setBounds(myMap.geoObjects.getBounds(), {
                    checkZoomRange: true,
                    zoomMargin: 30
                });
            }
        }
    });
</script>
@endsection 