<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=YOUR_API_KEY&lang=ru_RU" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/media.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Родина-тур')</title>
</head>
<body class>
    <!-- Шапка -->
    <header class="home">
        <div class="max">
            <div class="header-top">
                <a href="{{ route('home') }}" class="logo">
                    <img src="/img/logo__rodina-tur__top 2.svg" alt="" srcset="">
                </a>
                <div class="soc">
                    <a href="https://t.me/rodinatur" class="tg" target="_blank">
                            <img src="/img/Vector.svg" alt="" srcset="">
                    </a>
                    <a href="https://wa.me/99190093660" class="wp" target="_blank">
                            <img src="/img/wtsp.svg" alt="" srcset="">
                    </a>
                    <a href="https://vk.com/rodinatur" class="vk" target="_blank">
                            <img src="/img/vk.svg" alt="" srcset="">
                    </a>
                    <a href="https://www.youtube.com/@rodinatur" class="ytb" target="_blank">
                            <img src="/img/ytb.svg" alt="" srcset="">
                    </a>
                </div>
                <div class="header-info">
                    <div class="phone">
                        <a href="tel:88002003152">8-800-200-31-52</a>
                        <span>по России Бесплатный</span>
                    </div>
                    <div class="js-open-modal zakaz-zvonka">
                        <img src="/img/Phone.svg" class="img-phone">
                        <p>+7 (920) 904-13-83</p>
                        <p>Заказать звонок</p>
                    </div>
                    @auth
                        <a href="{{ route('cabinet') }}">
                            <div class="login">
                                <svg width="30" height="29" viewBox="0 0 30 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_974_66_auth)">
                                    <path d="M25.501 10.5C25.501 16.0012 20.8219 20.5 15.0005 20.5C9.17903 20.5 4.5 16.0012 4.5 10.5C4.5 4.99884 9.17903 0.5 15.0005 0.5C20.8219 0.5 25.501 4.99884 25.501 10.5Z" stroke="#EEBB07" shape-rendering="crispEdges"/>
                                    </g>
                                    <path d="M17.9886 7.58333C17.9886 9.60247 16.4922 11.1667 14.7323 11.1667C12.9724 11.1667 11.4761 9.60247 11.4761 7.58333C11.4761 5.56419 12.9724 4 14.7323 4C16.4922 4 17.9886 5.56419 17.9886 7.58333Z" stroke="#EEBB07"/>
                                    <path d="M21.7082 18.6667H8.29297C8.29297 15.9167 10.5764 12.25 14.8579 12.25C18.9744 12.25 21.7082 15.4583 21.7082 18.6667Z" stroke="#EEBB07"/>
                                    <defs>
                                    <filter id="filter0_d_974_66_auth" x="0" y="0" width="30.001" height="29" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                    <feOffset dy="4"/>
                                    <feGaussianBlur stdDeviation="2"/>
                                    <feComposite in2="hardAlpha" operator="out"/>
                                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_974_66"/>
                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_974_66" result="shape"/>
                                    </filter>
                                    </defs>
                                </svg>
                                <p>КАБИНЕТ</p>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('login') }}">
                            <div class="login">
                                <svg width="30" height="29" viewBox="0 0 30 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_974_66_login)">
                                    <path d="M25.501 10.5C25.501 16.0012 20.8219 20.5 15.0005 20.5C9.17903 20.5 4.5 16.0012 4.5 10.5C4.5 4.99884 9.17903 0.5 15.0005 0.5C20.8219 0.5 25.501 4.99884 25.501 10.5Z" stroke="#EEBB07" shape-rendering="crispEdges"/>
                                    </g>
                                    <path d="M17.9886 7.58333C17.9886 9.60247 16.4922 11.1667 14.7323 11.1667C12.9724 11.1667 11.4761 9.60247 11.4761 7.58333C11.4761 5.56419 12.9724 4 14.7323 4C16.4922 4 17.9886 5.56419 17.9886 7.58333Z" stroke="#EEBB07"/>
                                    <path d="M21.7082 18.6667H8.29297C8.29297 15.9167 10.5764 12.25 14.8579 12.25C18.9744 12.25 21.7082 15.4583 21.7082 18.6667Z" stroke="#EEBB07"/>
                                    <defs>
                                    <filter id="filter0_d_974_66_login" x="0" y="0" width="30.001" height="29" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                    <feOffset dy="4"/>
                                    <feGaussianBlur stdDeviation="2"/>
                                    <feComposite in2="hardAlpha" operator="out"/>
                                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_974_66"/>
                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_974_66" result="shape"/>
                                    </filter>
                                    </defs>
                                </svg>
                                <p>ВОЙТИ</p>
                            </div>
                        </a>
                    @endauth
                    <div class="menu-btn">
                        <img src="/img/menu-btn.svg" alt="" >
                    </div>
                </div>
            </div>
            <div class="header-mid">
                <div class="max">
                    <nav>
                        <ul class="menu">
                            <li class="menu-item"><a href="{{ route('schedule') }}" class="menu-link">Расписание</a></li>
                            <li class="menu-item"><a href="{{ route('contacts') }}" class="menu-link">Контакты</a></li>
                            <li class="menu-item"><a href="{{ route('excursions') }}" class="menu-link">Экскурсии</a></li>
                            <li class="menu-item"><a href="{{ route('tourists') }}" class="menu-link">Туристам</a></li>
                            <li class="menu-item"><a href="{{ route('calculate') }}" class="menu-link">Калькулятор туров</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <main class="main">
        <!-- Баннер -->
        <section class="banner-home">
            <div class="max">
                <div class="swiper swiper-initialized swiper-horizontal swiper-backface-hidden">
                    <div class="swiper-wrapper" aria-live="polite">
                        <div class="swiper-slide swiper-slide-active" role="group" aria-label="1/1" data-swiper-slide-index="0">
                            <h1 class="h1">Путешествуй по великой России с нами</h1>
                            <p>Широкий выбор туров любой направленности. Организация групповых и индивидуальных программ.</p>
                            <div class="btns">
                                <a href="{{ route('tours.index') }}">Выбрать свой тур</a>
                                <a href="{{ route('login') }}">Личный кабинет</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </section>
        
        <!-- Глобальные уведомления -->
        @if(session('global_alert'))
        <div class="global-alert">
            <div class="max">
                <div class="alert-content">
                    <i class="fas fa-info-circle"></i>
                    <p>{{ session('global_alert') }}</p>
                    <button class="close-alert">&times;</button>
                </div>
            </div>
        </div>
        <style>
            .global-alert {
                background-color: #ffeb3b;
                color: #333;
                padding: 12px 0;
                margin-bottom: 20px;
                position: relative;
                box-shadow: 0 3px 10px rgba(0,0,0,0.1);
                animation: fadeIn 0.5s ease;
            }
            
            .alert-content {
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                padding: 0 40px;
            }
            
            .global-alert i {
                margin-right: 15px;
                font-size: 24px;
                color: #f57c00;
            }
            
            .global-alert p {
                font-size: 16px;
                margin: 0;
                font-weight: 500;
            }
            
            .close-alert {
                background: none;
                border: none;
                color: #333;
                font-size: 24px;
                cursor: pointer;
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
            }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const closeBtn = document.querySelector('.close-alert');
                if (closeBtn) {
                    closeBtn.addEventListener('click', function() {
                        const alert = document.querySelector('.global-alert');
                        alert.style.opacity = '0';
                        alert.style.height = '0';
                        alert.style.padding = '0';
                        alert.style.margin = '0';
                        alert.style.overflow = 'hidden';
                        alert.style.transition = 'all 0.3s ease';
                    });
                }
            });
        </script>
        @endif
        
        <!-- Основной контент страницы -->
        <div class="calculator-container-wrapper">
            @yield('content')
        </div>
    </main>

    <footer>
        <div class="max">
            <div class="footer-mid">
                <div class="block">
                    <div class="f-menu pk">
                        <div class="bl">
                            <a href="http://">Акции</a>
                            <a href="http://">Туры</a>
                            <a href="http://">Календарь</a>
                            <a href="http://">Экскурсии</a>
                            <a href="http://">Индивидуальные туры</a>
                            <a href="http://">Туристам</a>
                        </div>
                        <div class="bl">
                            <a href="http://">Турагенствам</a>
                            <a href="http://">Отзывы</a>
                            <a href="http://">О нас</a>
                            <a href="http://">Контакты</a>
                            <a href="http://">Реквизиты</a>
                        </div>
                        <div class="bl">
                            <a href="http://">Финансовая гарантия</a>
                            <a href="http://">Руководство</a>
                            <a href="http://">Доставка туристов</a>
                            <a href="http://">Снаряжение</a>
                            <a href="http://">Страхование</a>
                            <a href="http://">Размещение</a>
                        </div>
                    </div>
                    <div class="f-menu mob">
                        <a href="http://">Акции</a>
                        <a href="http://">Туры</a>
                        <a href="http://">Календарь</a>
                        <a href="http://">Экскурсии</a>
                        <a href="http://">Индивидуальные туры</a>
                        <a href="http://">Туристам</a>
                        <a href="http://">Турагенствам</a>
                        <a href="http://">Отзывы</a>
                        <a href="http://">О нас</a>
                        <a href="http://">Контакты</a>
                        <a href="http://">Реквизиты</a>
                        <a href="http://">Финансовая гарантия</a>
                        <a href="http://">Руководство</a>
                        <a href="http://">Доставка туристов</a>
                        <a href="http://">Снаряжение</a>
                        <a href="http://">Страхование</a>
                        <a href="http://">Размещение</a>
                    </div>
                </div>
                <div class="block">
                    <div class="info">
                        <div class="bl">
                            <div class="info-icon adres">
                                <p>Наш адрес</p>
                                <p>Владимирская область, г. Александров, ул. Ленина, д.16</p>
                            </div>
                            <div class="info-icon time">
                                <p>График работы</p>
                                <p>Пн - Сб: с 9:00 до 22:00</p>
                            </div>
                            <div class="info-icon mail">
                                <p>Наш адрес</p>
                                <a href="mailto:rodinatur@mail.ru">rodinatur@mail.ru</a>
                            </div>
                        </div>
                        <div class="bl">
                            <div class="js-open-modal zakaz-zvonka">
                                <img src="/img/Phone.svg" class="img-phone">
                                <p>+7 (920) 904-13-83</p>
                                <p>Заказать звонок</p>
                            </div>
                            <div class="phone">
                                <a href="tel:88002003152">8-800-200-31-52</a>
                                <span>по России Бесплатный</span>
                            </div>
                            <div class="soc">
                                <a href="http:// " class="tg" target="_blank">
                                    <img src="/img/Vector.svg" alt="" srcset="">
                                </a>
                                <a href="http://" class="wp" target="_blank">
                                    <img src="/img/wtsp.svg" alt="" srcset="">
                                </a>
                                <a href="http://" class="vk" target="_blank">
                                    <img src="/img/vk.svg" alt="" srcset="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bot">
                <p>© 2008 - 2025 ООО "Родина-тур"</p>
                <a href="http://">Политика конфиденциальности</a>
                <p>ИНН: 325401234567890</p>
                <p>ОГРН: 123456789012345</p>
            </div>
        </div>
    </footer>

    <!-- Модальное окно для заказа звонка -->
    <div class="modal" data-modal="1">
        <div class="modal__cross js-modal-close"></div>
        <div class="img-form">
            <img src="/img/p-f.png" alt="" srcset="">
            <div class="cont">
                <h3>Не нашли подходящий тур?</h3>
                <p class="txt">Оставьте заявку и мы перезвоним Вам. Предложим варианты и организуем отдых Вашей мечты.</p>
                <form action="index.html" onsubmit="ym('98198773','reachGoal','order-call-modal'); return true;">
                    <input type="name" id="ordercalls-name" name="OrderCalls[name]" placeholder="Имя *" aria-required="true" required="">
                    <input type="tel" id="ordercalls-phone" name="OrderCalls[phone]" placeholder="Телефон *" aria-required="true" required="">
                    <input type="hidden" id="ordercalls-type" name="OrderCalls[type]" aria-required="true" value="0" required="">
                    <div class="chekbox">
                        <input id="polit" type="checkbox" aria-required="true" checked="" required="">
                        <label for="polit"></label>
                        <p>Нажимая на кнопку, вы даете согласие на <a href="#">обработку ваших персональных данных</a></p>
                    </div>
                    <button type="submit">Перезвонить мне</button>
                </form>
            </div>
            <div class="uspeh">
                <h3>Заявка <span> успешно отправлена!</span></h3>
                <p class="txt">Наши специалисты свяжутся с Вами в течении 30 минут! Спасибо, что выбрали нас!</p>
            </div>
        </div>
    </div>

    <div class="overlay js-overlay-modal"></div>
    <script src="/js/swiper.js" defer></script>
    <script src="/js/main.js" defer></script>
    <script src="/js/modal.js" defer></script>
    @yield('scripts')
</body>
</html> 