@extends('layouts.basic')

@section('title', 'Информация для туристов | Родина-тур')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/pages/tourist_info.css') }}">
<link rel="stylesheet" href="{{ asset('css/media.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/responsive.css') }}">
@endsection

@section('content')
<section class="tourist-info-page">
    <div class="max">
        <div class="zag-btn">
            <h2>Информация для туристов</h2>
            <p>Всё, что нужно знать перед поездкой</p>
        </div>
        
        <div class="info-cards">
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-passport"></i>
                </div>
                <div class="info-content">
                    <h3>Документы</h3>
                    <p>Для поездки вам потребуются следующие документы:</p>
                    <ul>
                        <li>Паспорт гражданина РФ</li>
                        <li>Полис ОМС</li>
                        <li>Для детей до 14 лет - свидетельство о рождении</li>
                        <li>При путешествии с ребенком без сопровождения родителей - нотариально заверенное согласие родителей</li>
                    </ul>
                </div>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-suitcase"></i>
                </div>
                <div class="info-content">
                    <h3>Что взять с собой</h3>
                    <p>Не забудьте взять с собой в поездку:</p>
                    <ul>
                        <li>Удобную одежду и обувь по сезону</li>
                        <li>Предметы личной гигиены</li>
                        <li>Медикаменты первой необходимости</li>
                        <li>Фотоаппарат или камеру</li>
                        <li>Зарядные устройства для техники</li>
                        <li>Небольшой рюкзак для экскурсий</li>
                    </ul>
                </div>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-medkit"></i>
                </div>
                <div class="info-content">
                    <h3>Здоровье и безопасность</h3>
                    <p>Рекомендации по здоровью и безопасности:</p>
                    <ul>
                        <li>Не забудьте взять личные медикаменты, если вы регулярно их принимаете</li>
                        <li>При наличии хронических заболеваний, проконсультируйтесь с врачом перед поездкой</li>
                        <li>Соблюдайте правила личной безопасности</li>
                        <li>Следуйте указаниям гида или экскурсовода</li>
                        <li>Берегите личные вещи и документы</li>
                    </ul>
                </div>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="info-content">
                    <h3>Оплата и валюта</h3>
                    <p>Информация об оплате и финансах:</p>
                    <ul>
                        <li>В большинстве городов и туристических мест работают банковские карты</li>
                        <li>Рекомендуем иметь при себе небольшую сумму наличных денег</li>
                        <li>В удаленных районах могут не принимать карты к оплате</li>
                        <li>Помните о дополнительных расходах на сувениры и личные покупки</li>
                    </ul>
                </div>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-camera"></i>
                </div>
                <div class="info-content">
                    <h3>Фото и видеосъемка</h3>
                    <p>Правила фото- и видеосъемки:</p>
                    <ul>
                        <li>В некоторых музеях и на отдельных объектах может быть запрещена фотосъемка</li>
                        <li>В некоторых местах фотосъемка может быть платной</li>
                        <li>Уточняйте правила фотосъемки у гида перед посещением объектов</li>
                    </ul>
                </div>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-wifi"></i>
                </div>
                <div class="info-content">
                    <h3>Связь и интернет</h3>
                    <p>Информация о связи:</p>
                    <ul>
                        <li>Мобильная связь доступна в большинстве населенных пунктов</li>
                        <li>Wi-Fi есть в большинстве отелей и общественных мест</li>
                        <li>В отдаленных районах связь может быть нестабильной</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="faq-section">
            <h3>Часто задаваемые вопросы</h3>
            
            <div class="accordion">
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h4>Как забронировать тур?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="accordion-content">
                        <p>Забронировать тур можно онлайн на нашем сайте, по телефону или в офисе компании. После оформления заявки с вами свяжется менеджер для подтверждения деталей и оплаты.</p>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h4>Можно ли отменить бронирование?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="accordion-content">
                        <p>Да, бронирование можно отменить. Условия отмены зависят от конкретного тура и времени, оставшегося до начала поездки. Подробную информацию вы можете получить у менеджера при бронировании.</p>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h4>Что делать, если я опоздал на экскурсию?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="accordion-content">
                        <p>В случае опоздания, немедленно свяжитесь с указанным в ваучере номером телефона. Мы постараемся найти решение в каждой конкретной ситуации.</p>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h4>Есть ли скидки для детей?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="accordion-content">
                        <p>Да, для детей предусмотрены скидки. Размер скидки зависит от возраста ребенка и конкретного тура.</p>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <div class="accordion-header">
                        <h4>Включено ли питание в программу тура?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="accordion-content">
                        <p>Информация о включенном питании указана в описании каждого тура. Обычно в программу включены завтраки, а обеды и ужины - опционально.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Accordion functionality
        const accordionItems = document.querySelectorAll('.accordion-item');
        
        accordionItems.forEach(item => {
            const header = item.querySelector('.accordion-header');
            const content = item.querySelector('.accordion-content');
            
            header.addEventListener('click', function() {
                // Toggle active class
                this.classList.toggle('active');
                
                // Toggle icon
                const icon = this.querySelector('i');
                icon.classList.toggle('fa-chevron-down');
                icon.classList.toggle('fa-chevron-up');
                
                // Toggle content visibility
                if (content.style.maxHeight) {
                    content.style.maxHeight = null;
                } else {
                    content.style.maxHeight = content.scrollHeight + "px";
                }
            });
        });
    });
</script>
@endsection
