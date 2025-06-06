<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=YOUR_API_KEY&lang=ru_RU" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/media.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/fixes.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rodina-tur</title>
    <script src="{{ asset('/js/fixes.js') }}" defer></script>
</head>
<body class>
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
                                    <path d="M25.501 10.5C25.501 16.0012 20.8219 20.5 15.0005 20.5C9.17903 20.5 4.5 16.0012 4.5 10.5C4.5 4.99884 9.17903 0.5 15.0005 0.5C20.8219 0.5 25.501 4.99884 25.501 10.5Z"  shape-rendering="crispEdges"/>
                                    </g>
                                    <path d="M17.9886 7.58333C17.9886 9.60247 16.4922 11.1667 14.7323 11.1667C12.9724 11.1667 11.4761 9.60247 11.4761 7.58333C11.4761 5.56419 12.9724 4 14.7323 4C16.4922 4 17.9886 5.56419 17.9886 7.58333Z"/>
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
                    <nav class>
                        <div class="close-menu">
                            <img src="/icons/close.svg">
                        </div>
                        <div class="soc mob">
                            <a href="http:// " class="tg" target="_blank">
                                <svg style="display: none;">
                                    <!-- Telegram -->
                                    <symbol id="telegram-icon" viewBox="0 0 26 23">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M26 11.5C26 17.8513 20.1797 23 13 23C5.8203 23 0 17.8513 0 11.5C0 5.14873 5.8203 0 13 0C20.1797 0 26 5.14873 26 11.5ZM13.4659 8.48981C12.2014 8.95505 9.67431 9.91798 5.88455 11.3786C5.26915 11.5951 4.94678 11.8069 4.91743 12.014C4.86783 12.3639 5.36327 12.5017 6.03792 12.6894C6.1297 12.7149 6.22478 12.7414 6.32227 12.7694C6.98602 12.9603 7.87889 13.1836 8.34306 13.1924C8.7641 13.2005 9.23404 13.0469 9.75286 12.7318C13.2938 10.6174 15.1216 9.54865 15.2363 9.52561C15.3173 9.50936 15.4295 9.48892 15.5055 9.54869C15.5815 9.60845 15.574 9.72164 15.566 9.752C15.5169 9.93709 13.5721 11.5365 12.5657 12.3642C12.252 12.6222 12.0294 12.8053 11.9839 12.8471C11.882 12.9407 11.7781 13.0293 11.6783 13.1144C11.0617 13.6403 10.5992 14.0346 11.7039 14.6786C12.2348 14.9881 12.6596 15.244 13.0834 15.4993C13.5462 15.7781 14.0078 16.0562 14.6051 16.4025C14.7572 16.4908 14.9026 16.5824 15.0441 16.6717C15.5827 17.0114 16.0666 17.3165 16.6645 17.2679C17.0118 17.2396 17.3707 16.9506 17.5529 16.0888C17.9836 14.0522 18.8301 9.63935 19.0257 7.82093C19.0429 7.66162 19.0213 7.45772 19.004 7.36822C18.9867 7.27871 18.9505 7.15119 18.819 7.05678C18.6632 6.94498 18.4228 6.9214 18.3152 6.92308C17.8263 6.9307 17.0761 7.16145 13.4659 8.48981Z" />
                                    </symbol>
                                </svg>
                                <svg width="26" height="23" fill="">
                                    <use href="#telegram-icon"></use>
                                </svg>
                            </a>
                            <a href="http:/image.png/" class="wp" target="_blank">
                                <svg style="display: none;">
                                    <!-- WhatsApp -->
                                    <symbol id="whatsapp-icon" viewBox="0 0 28 23">
                                        <path d="M0 23L1.96816 17.0938C0.753665 15.365 0.1155 13.4052 0.116666 11.3955C0.120166 5.11271 6.34432 0 13.9918 0C17.703 0.000958333 21.1866 1.18833 23.8069 3.34267C26.4261 5.497 27.8681 8.3605 27.8669 11.4061C27.8634 17.6899 21.6393 22.8026 13.9918 22.8026C11.6701 22.8016 9.38231 22.3234 7.35582 21.4149L0 23ZM7.69648 19.3516C9.65181 20.3052 11.5185 20.8763 13.9871 20.8773C20.3431 20.8773 25.5208 16.628 25.5243 11.4042C25.5266 6.16975 20.3735 1.92625 13.9965 1.92433C7.63582 1.92433 2.46166 6.17358 2.45933 11.3965C2.45816 13.5288 3.21883 15.1254 4.49632 16.7957L3.33083 20.2917L7.69648 19.3516ZM20.9813 14.1153C20.895 13.9965 20.664 13.9255 20.3163 13.7828C19.9698 13.64 18.2653 12.9509 17.9468 12.856C17.6295 12.7612 17.3985 12.7133 17.1663 12.9988C16.9353 13.2835 16.2703 13.9255 16.0685 14.1153C15.8666 14.305 15.6636 14.329 15.3171 14.1862C14.9706 14.0434 13.853 13.7435 12.5288 12.7727C11.4986 12.0175 10.8021 11.085 10.6003 10.7995C10.3985 10.5148 10.5793 10.3605 10.752 10.2187C10.9083 10.0912 11.0985 9.88617 11.2723 9.71942C11.4485 9.55458 11.5056 9.43575 11.6223 9.24504C11.7378 9.05529 11.6806 8.88854 11.5931 8.74575C11.5056 8.60392 10.8126 7.20187 10.5245 6.63167C10.2421 6.07679 9.95631 6.15154 9.74398 6.14292L9.07898 6.13333C8.84798 6.13333 8.47231 6.20425 8.15498 6.48983C7.83765 6.77542 6.94165 7.4635 6.94165 8.86554C6.94165 10.2676 8.18415 11.6217 8.35681 11.8115C8.53065 12.0012 10.801 14.8781 14.2788 16.1115C15.106 16.4048 15.7523 16.5801 16.2551 16.7114C17.0858 16.928 17.8418 16.8973 18.4391 16.8245C19.1053 16.743 20.4901 16.1355 20.7795 15.4704C21.0688 14.8043 21.0688 14.2341 20.9813 14.1153Z" />
                                    </symbol>
                                </svg>
                                <svg width="28" height="23" fill="#FFDA56">
                                    <use href="#whatsapp-icon"></use>
                                </svg>
                            </a>
                            <a href="http://" class="vk" target="_blank">
                                <svg style="display: none;">
                                    <!-- VK -->
                                    <symbol id="vk-icon" viewBox="0 0 27 23">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.89795 1.61677C0 3.23354 0 5.83568 0 11.04V11.96C0 17.1643 0 19.7664 1.89795 21.3832C3.7959 23 6.85058 23 12.96 23H14.04C20.1494 23 23.2041 23 25.1021 21.3832C27 19.7664 27 17.1643 27 11.96V11.04C27 5.83568 27 3.23354 25.1021 1.61677C23.2041 0 20.1494 0 14.04 0H12.96C6.85058 0 3.7959 0 1.89795 1.61677ZM4.55632 6.99588C4.70257 12.9759 8.21256 16.5696 14.3663 16.5696H14.7151V13.1484C16.9764 13.34 18.6862 14.7488 19.3725 16.5696H22.5676C21.6901 13.848 19.3837 12.3434 17.9437 11.7684C19.3837 11.0592 21.4087 9.33421 21.8924 6.99588H18.9899C18.3599 8.89338 16.4926 10.6184 14.7151 10.7813V6.99588H11.8125V13.6275C10.0125 13.2442 7.74006 11.385 7.63881 6.99588H4.55632Z"/>
                                    </symbol>
                                </svg>
                                <svg width="27" height="23" fill="#FFDA56">
                                    <use href="#vk-icon"></use>
                                </svg>
                            </a>
                        </div>
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
        <section class="banner-home">
            <div class="max">
                <div class="swiper swiper-initialized swiper-horizontal swiper-backface-hidden">
                    <div class="swiper-wrapper" aria-live="polite">
                        <div class="swiper-slide swiper-slide-active swiper-slide-next" role="group" aria-label="1/1" data-swiper-slide-index="0" style="width: 100% !important;">
                            <h1 class="h1">Путешествуй по великой России с нами</h1>
                            <p>Широкий выбор туров любой направленности. Организация групповых и индивидуальных программ.</p>
                            <div class="btns">
                                <a href="{{ route('schedule') }}">Выбрать свой тур</a>
                                <a href="{{ route('login') }}">Личный кабинет</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>

        <section>
        <div class="max">
            <div class="zag-btn">
                <h2>Виды туров</h2>
                <a href="/" class="btn--white mob">Все туры</a>
            </div>
        </div>
    <div class="slider vidy-turov">
        <div class="swiper swiper-initialized swiper-horizontal swiper-backface-hidden">
            <div class="swiper-wrapper max" id="swiper-wrapper-76c2ad871031f5bf8" aria-live="polite" style="padding-bottom: 50px;">
                <div class="swiper-slide swiper-slide-active" role="group" aria-label="1 / 9" style="margin-right: 40px;">
                    <img src="/img/sayMGFc-uGI 2.png" alt="" srcset="">
                    <p>Круизы</p>
                    <a href="{{ route('calculate') }}"></a>
                </div>
                <div class="swiper-slide swiper-slide-next" role="group" aria-label="2 / 9" style="margin-right: 40px;">
                    <img src="/img/YiVpT7_kdsw 1.png" alt="" srcset="">
                    <p>Зарубежные туры</p>
                    <a href="{{ route('schedule') }}"></a>
                </div>
                <div class="swiper-slide swiper-slide" role="group" aria-label="3 / 9" style="margin-right: 40px;">
                    <img src="/img/7nlvLmnwPIo.png" alt="" srcset="">
                    <p>Многодневные туры</p>
                    <a href="{{ route('schedule') }}"></a>
                </div>
                <div class="swiper-slide swiper-slide" role="group" aria-label="4 / 9" style="margin-right: 40px;">
                    <img src="/img/9752bded3270d6662c72431b59b74fca 1.png" alt="" srcset="">
                    <p>Водные туры</p>
                    <a href="{{ route('schedule') }}"></a>
                </div>
                <div class="swiper-slide swiper-slide" role="group" aria-label="5 / 9" style="margin-right: 40px;">
                    <img src="/img/tours/kazan.jpg" alt="" srcset="">
                    <p>Процедуры</p>
                    <a href="{{ route('calculate') }}"></a>
                </div>
                <div class="swiper-slide swiper-slide" role="group" aria-label="6 / 9" style="margin-right: 40px;">
                    <img src="/img/tours/kazan.jpg" alt="" srcset="">
                    <p>Увлекательные</p>
                    <a href="{{ route('calculate') }}"></a>
                </div>
                <div class="swiper-slide swiper-slide" role="group" aria-label="7 / 9" style="margin-right: 40px;">
                    <img src="/img/tours/kazan.jpg" alt="" srcset="">
                    <p>Горные туры</p>
                    <a href="{{ route('schedule') }}"></a>
                </div>
                <div class="swiper-slide swiper-slide" role="group" aria-label="8 / 9" style="margin-right: 40px;">
                    <img src="/img/tours/kazan.jpg" alt="" srcset="">
                    <p>Детям</p>
                    <a href="{{ route('excursions') }}"></a>
                </div>
                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
            </div>
            <div class="max">
                <div class="btns-block">
                    <a class="btn--white" href="http://">
                        <span>Все туры</span>
                        <svg>
                            <img src="/img/arrow-btn.svg" alt="" srcset="">
                        </svg>
                    </a>
                    <div class="navigate">
                        <div class="swiper-button-prev swiper-button-disabled" tabindex="-1" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-76c2ad871031f5bf8" aria-disabled="true">
                            <img src="/img/arrow-btn.svg" style="width: 24px; height:24px; transform: rotate(-180deg);" >
                        </div>
                        <div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-76c2ad871031f5bf8" aria-disabled="false">
                            <img src="/img/arrow-btn.svg" style="width: 24px; height:24px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 
        
        <!-- Основной контент страницы -->
        @yield('content')
        @yield('form')

        <section>
    <div class="max">
        <div class="zag-btn">
            <h2>Отзывы</h2>
        </div>
    </div>
    <div class="slider otz">
        <div class="swiper swiper-initialized swiper-horizontal swiper-backface-hidden">
            <div class="swiper-wrapper max" id="swiper-wrapper-c6adae34b699761e" aria-live="polite" style="transform: translate3(0px, 0px, 0px);">
                <div class="swiper-slide swiper-slide-active" role="group" aria-label="1 / 9" style="margin-right: 40px;">
                    <div class="info">
                        <div class="cont">
                            <p class="name">Игорь</p>
                            <div class="star">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi praesentium repellat molestias. Quo, sit harum distinctio, reiciendis explicabo fuga blanditiis molestias et corrupti commodi dolor voluptatibus! Ipsa eaque tempora ratione?</p>
                    <div class="btns">
                        <button>
                            <span>Раскрыть отзыв</span>
                            <img src="/img/arrow-btn.svg" alt="">
                        </button>
                        <p class="data">13.08.2024</p>
                    </div>
                </div>
                <div class="swiper-slide swiper-slide-active" role="group" aria-label="2 / 9" style="margin-right: 40px;">
                    <div class="info">
                        <div class="cont">
                            <p class="name">Мария</p>
                            <div class="star">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi praesentium repellat molestias. Quo, sit harum distinctio, reiciendis explicabo fuga blanditiis molestias et corrupti commodi dolor voluptatibus! Ipsa eaque tempora ratione?</p>
                    <div class="btns">
                        <button>
                            <span>Раскрыть отзыв</span>
                            <img src="/img/arrow-btn.svg" alt="">
                        </button>
                        <p class="data">13.08.2024</p>
                    </div>
                </div>
                <div class="swiper-slide swiper-slide-active" role="group" aria-label="4 / 9" style="margin-right: 40px;">
                    <div class="info">
                        <div class="cont">
                            <p class="name">Надежда</p>
                            <div class="star">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi praesentium repellat molestias. Quo, sit harum distinctio, reiciendis explicabo fuga blanditiis molestias et corrupti commodi dolor voluptatibus! Ipsa eaque tempora ratione?</p>
                    <div class="btns">
                        <button>
                            <span>Раскрыть отзыв</span>
                            <img src="/img/arrow-btn.svg" alt="">
                        </button>
                        <p class="data">13.08.2024</p>
                    </div>
                </div>
                <div class="swiper-slide swiper-slide-active" role="group" aria-label="5 / 9" style="margin-right: 40px;">
                    <div class="info">
                        <div class="cont">
                            <p class="name">Надежда</p>
                            <div class="star">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi praesentium repellat molestias. Quo, sit harum distinctio, reiciendis explicabo fuga blanditiis molestias et corrupti commodi dolor voluptatibus! Ipsa eaque tempora ratione?</p>
                    <div class="btns">
                        <button>
                            <span>Раскрыть отзыв</span>
                            <img src="/img/arrow-btn.svg" alt="">
                        </button>
                        <p class="data">13.08.2024</p>
                    </div>
                </div>
                <div class="swiper-slide swiper-slide-active" role="group" aria-label="6 / 9" style="margin-right: 40px;">
                    <div class="info">
                        <div class="cont">
                            <p class="name">Надежда</p>
                            <div class="star">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi praesentium repellat molestias. Quo, sit harum distinctio, reiciendis explicabo fuga blanditiis molestias et corrupti commodi dolor voluptatibus! Ipsa eaque tempora ratione?</p>
                    <div class="btns">
                        <button>
                            <span>Раскрыть отзыв</span>
                            <img src="/img/arrow-btn.svg" alt="">
                        </button>
                        <p class="data">13.08.2024</p>
                    </div>
                </div>
                <div class="swiper-slide swiper-slide-active" role="group" aria-label="8 / 9" style="margin-right: 40px;">
                    <div class="info">
                        <div class="cont">
                            <p class="name">Надежда</p>
                            <div class="star">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi praesentium repellat molestias. Quo, sit harum distinctio, reiciendis explicabo fuga blanditiis molestias et corrupti commodi dolor voluptatibus! Ipsa eaque tempora ratione?</p>
                    <div class="btns">
                        <button>
                            <span>Раскрыть отзыв</span>
                            <img src="/img/arrow-btn.svg" alt="">
                        </button>
                        <p class="data">13.08.2024</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 
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
                                    <svg style="display: none;">
                                        <!-- Telegram -->
                                        <symbol id="telegram-icon" viewBox="0 0 26 23">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M26 11.5C26 17.8513 20.1797 23 13 23C5.8203 23 0 17.8513 0 11.5C0 5.14873 5.8203 0 13 0C20.1797 0 26 5.14873 26 11.5ZM13.4659 8.48981C12.2014 8.95505 9.67431 9.91798 5.88455 11.3786C5.26915 11.5951 4.94678 11.8069 4.91743 12.014C4.86783 12.3639 5.36327 12.5017 6.03792 12.6894C6.1297 12.7149 6.22478 12.7414 6.32227 12.7694C6.98602 12.9603 7.87889 13.1836 8.34306 13.1924C8.7641 13.2005 9.23404 13.0469 9.75286 12.7318C13.2938 10.6174 15.1216 9.54865 15.2363 9.52561C15.3173 9.50936 15.4295 9.48892 15.5055 9.54869C15.5815 9.60845 15.574 9.72164 15.566 9.752C15.5169 9.93709 13.5721 11.5365 12.5657 12.3642C12.252 12.6222 12.0294 12.8053 11.9839 12.8471C11.882 12.9407 11.7781 13.0293 11.6783 13.1144C11.0617 13.6403 10.5992 14.0346 11.7039 14.6786C12.2348 14.9881 12.6596 15.244 13.0834 15.4993C13.5462 15.7781 14.0078 16.0562 14.6051 16.4025C14.7572 16.4908 14.9026 16.5824 15.0441 16.6717C15.5827 17.0114 16.0666 17.3165 16.6645 17.2679C17.0118 17.2396 17.3707 16.9506 17.5529 16.0888C17.9836 14.0522 18.8301 9.63935 19.0257 7.82093C19.0429 7.66162 19.0213 7.45772 19.004 7.36822C18.9867 7.27871 18.9505 7.15119 18.819 7.05678C18.6632 6.94498 18.4228 6.9214 18.3152 6.92308C17.8263 6.9307 17.0761 7.16145 13.4659 8.48981Z" />
                                        </symbol>
                                    </svg>
                                    <svg width="26" height="23" fill="">
                                        <use href="#telegram-icon"></use>
                                    </svg>
                                </a>
                                <a href="http://" class="wp" target="_blank">
                                    <svg style="display: none;">
                                        <!-- WhatsApp -->
                                        <symbol id="whatsapp-icon" viewBox="0 0 28 23">
                                            <path d="M0 23L1.96816 17.0938C0.753665 15.365 0.1155 13.4052 0.116666 11.3955C0.120166 5.11271 6.34432 0 13.9918 0C17.703 0.000958333 21.1866 1.18833 23.8069 3.34267C26.4261 5.497 27.8681 8.3605 27.8669 11.4061C27.8634 17.6899 21.6393 22.8026 13.9918 22.8026C11.6701 22.8016 9.38231 22.3234 7.35582 21.4149L0 23ZM7.69648 19.3516C9.65181 20.3052 11.5185 20.8763 13.9871 20.8773C20.3431 20.8773 25.5208 16.628 25.5243 11.4042C25.5266 6.16975 20.3735 1.92625 13.9965 1.92433C7.63582 1.92433 2.46166 6.17358 2.45933 11.3965C2.45816 13.5288 3.21883 15.1254 4.49632 16.7957L3.33083 20.2917L7.69648 19.3516ZM20.9813 14.1153C20.895 13.9965 20.664 13.9255 20.3163 13.7828C19.9698 13.64 18.2653 12.9509 17.9468 12.856C17.6295 12.7612 17.3985 12.7133 17.1663 12.9988C16.9353 13.2835 16.2703 13.9255 16.0685 14.1153C15.8666 14.305 15.6636 14.329 15.3171 14.1862C14.9706 14.0434 13.853 13.7435 12.5288 12.7727C11.4986 12.0175 10.8021 11.085 10.6003 10.7995C10.3985 10.5148 10.5793 10.3605 10.752 10.2187C10.9083 10.0912 11.0985 9.88617 11.2723 9.71942C11.4485 9.55458 11.5056 9.43575 11.6223 9.24504C11.7378 9.05529 11.6806 8.88854 11.5931 8.74575C11.5056 8.60392 10.8126 7.20187 10.5245 6.63167C10.2421 6.07679 9.95631 6.15154 9.74398 6.14292L9.07898 6.13333C8.84798 6.13333 8.47231 6.20425 8.15498 6.48983C7.83765 6.77542 6.94165 7.4635 6.94165 8.86554C6.94165 10.2676 8.18415 11.6217 8.35681 11.8115C8.53065 12.0012 10.801 14.8781 14.2788 16.1115C15.106 16.4048 15.7523 16.5801 16.2551 16.7114C17.0858 16.928 17.8418 16.8973 18.4391 16.8245C19.1053 16.743 20.4901 16.1355 20.7795 15.4704C21.0688 14.8043 21.0688 14.2341 20.9813 14.1153Z" />
                                        </symbol>
                                    </svg>
                                    <svg width="28" height="23" fill="#FFDA56">
                                        <use href="#whatsapp-icon"></use>
                                    </svg>
                                </a>
                                <a href="http://" class="vk" target="_blank">
                                    <svg style="display: none;">
                                        <!-- VK -->
                                        <symbol id="vk-icon" viewBox="0 0 27 23">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M1.89795 1.61677C0 3.23354 0 5.83568 0 11.04V11.96C0 17.1643 0 19.7664 1.89795 21.3832C3.7959 23 6.85058 23 12.96 23H14.04C20.1494 23 23.2041 23 25.1021 21.3832C27 19.7664 27 17.1643 27 11.96V11.04C27 5.83568 27 3.23354 25.1021 1.61677C23.2041 0 20.1494 0 14.04 0H12.96C6.85058 0 3.7959 0 1.89795 1.61677ZM4.55632 6.99588C4.70257 12.9759 8.21256 16.5696 14.3663 16.5696H14.7151V13.1484C16.9764 13.34 18.6862 14.7488 19.3725 16.5696H22.5676C21.6901 13.848 19.3837 12.3434 17.9437 11.7684C19.3837 11.0592 21.4087 9.33421 21.8924 6.99588H18.9899C18.3599 8.89338 16.4926 10.6184 14.7151 10.7813V6.99588H11.8125V13.6275C10.0125 13.2442 7.74006 11.385 7.63881 6.99588H4.55632Z"/>
                                        </symbol>
                                    </svg>
                                    <svg width="27" height="23" fill="#FFDA56">
                                        <use href="#vk-icon"></use>
                                    </svg>
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
                <div class="soc mob">
                    <a href="http:// " class="tg" target="_blank">
                        <svg style="display: none;">
                            <!-- Telegram -->
                            <symbol id="telegram-icon" viewBox="0 0 26 23">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M26 11.5C26 17.8513 20.1797 23 13 23C5.8203 23 0 17.8513 0 11.5C0 5.14873 5.8203 0 13 0C20.1797 0 26 5.14873 26 11.5ZM13.4659 8.48981C12.2014 8.95505 9.67431 9.91798 5.88455 11.3786C5.26915 11.5951 4.94678 11.8069 4.91743 12.014C4.86783 12.3639 5.36327 12.5017 6.03792 12.6894C6.1297 12.7149 6.22478 12.7414 6.32227 12.7694C6.98602 12.9603 7.87889 13.1836 8.34306 13.1924C8.7641 13.2005 9.23404 13.0469 9.75286 12.7318C13.2938 10.6174 15.1216 9.54865 15.2363 9.52561C15.3173 9.50936 15.4295 9.48892 15.5055 9.54869C15.5815 9.60845 15.574 9.72164 15.566 9.752C15.5169 9.93709 13.5721 11.5365 12.5657 12.3642C12.252 12.6222 12.0294 12.8053 11.9839 12.8471C11.882 12.9407 11.7781 13.0293 11.6783 13.1144C11.0617 13.6403 10.5992 14.0346 11.7039 14.6786C12.2348 14.9881 12.6596 15.244 13.0834 15.4993C13.5462 15.7781 14.0078 16.0562 14.6051 16.4025C14.7572 16.4908 14.9026 16.5824 15.0441 16.6717C15.5827 17.0114 16.0666 17.3165 16.6645 17.2679C17.0118 17.2396 17.3707 16.9506 17.5529 16.0888C17.9836 14.0522 18.8301 9.63935 19.0257 7.82093C19.0429 7.66162 19.0213 7.45772 19.004 7.36822C18.9867 7.27871 18.9505 7.15119 18.819 7.05678C18.6632 6.94498 18.4228 6.9214 18.3152 6.92308C17.8263 6.9307 17.0761 7.16145 13.4659 8.48981Z" />
                            </symbol>
                        </svg>
                        <svg width="26" height="23" fill="">
                            <use href="#telegram-icon"></use>
                        </svg>
                    </a>
                    <a href="http://" class="wp" target="_blank">
                        <svg style="display: none;">
                            <!-- WhatsApp -->
                            <symbol id="whatsapp-icon" viewBox="0 0 28 23">
                                <path d="M0 23L1.96816 17.0938C0.753665 15.365 0.1155 13.4052 0.116666 11.3955C0.120166 5.11271 6.34432 0 13.9918 0C17.703 0.000958333 21.1866 1.18833 23.8069 3.34267C26.4261 5.497 27.8681 8.3605 27.8669 11.4061C27.8634 17.6899 21.6393 22.8026 13.9918 22.8026C11.6701 22.8016 9.38231 22.3234 7.35582 21.4149L0 23ZM7.69648 19.3516C9.65181 20.3052 11.5185 20.8763 13.9871 20.8773C20.3431 20.8773 25.5208 16.628 25.5243 11.4042C25.5266 6.16975 20.3735 1.92625 13.9965 1.92433C7.63582 1.92433 2.46166 6.17358 2.45933 11.3965C2.45816 13.5288 3.21883 15.1254 4.49632 16.7957L3.33083 20.2917L7.69648 19.3516ZM20.9813 14.1153C20.895 13.9965 20.664 13.9255 20.3163 13.7828C19.9698 13.64 18.2653 12.9509 17.9468 12.856C17.6295 12.7612 17.3985 12.7133 17.1663 12.9988C16.9353 13.2835 16.2703 13.9255 16.0685 14.1153C15.8666 14.305 15.6636 14.329 15.3171 14.1862C14.9706 14.0434 13.853 13.7435 12.5288 12.7727C11.4986 12.0175 10.8021 11.085 10.6003 10.7995C10.3985 10.5148 10.5793 10.3605 10.752 10.2187C10.9083 10.0912 11.0985 9.88617 11.2723 9.71942C11.4485 9.55458 11.5056 9.43575 11.6223 9.24504C11.7378 9.05529 11.6806 8.88854 11.5931 8.74575C11.5056 8.60392 10.8126 7.20187 10.5245 6.63167C10.2421 6.07679 9.95631 6.15154 9.74398 6.14292L9.07898 6.13333C8.84798 6.13333 8.47231 6.20425 8.15498 6.48983C7.83765 6.77542 6.94165 7.4635 6.94165 8.86554C6.94165 10.2676 8.18415 11.6217 8.35681 11.8115C8.53065 12.0012 10.801 14.8781 14.2788 16.1115C15.106 16.4048 15.7523 16.5801 16.2551 16.7114C17.0858 16.928 17.8418 16.8973 18.4391 16.8245C19.1053 16.743 20.4901 16.1355 20.7795 15.4704C21.0688 14.8043 21.0688 14.2341 20.9813 14.1153Z" />
                            </symbol>
                        </svg>
                        <svg width="28" height="23" fill="#FFDA56">
                            <use href="#whatsapp-icon"></use>
                        </svg>
                    </a>
                    <a href="http://" class="vk" target="_blank">
                        <svg style="display: none;">
                            <!-- VK -->
                            <symbol id="vk-icon" viewBox="0 0 27 23">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.89795 1.61677C0 3.23354 0 5.83568 0 11.04V11.96C0 17.1643 0 19.7664 1.89795 21.3832C3.7959 23 6.85058 23 12.96 23H14.04C20.1494 23 23.2041 23 25.1021 21.3832C27 19.7664 27 17.1643 27 11.96V11.04C27 5.83568 27 3.23354 25.1021 1.61677C23.2041 0 20.1494 0 14.04 0H12.96C6.85058 0 3.7959 0 1.89795 1.61677ZM4.55632 6.99588C4.70257 12.9759 8.21256 16.5696 14.3663 16.5696H14.7151V13.1484C16.9764 13.34 18.6862 14.7488 19.3725 16.5696H22.5676C21.6901 13.848 19.3837 12.3434 17.9437 11.7684C19.3837 11.0592 21.4087 9.33421 21.8924 6.99588H18.9899C18.3599 8.89338 16.4926 10.6184 14.7151 10.7813V6.99588H11.8125V13.6275C10.0125 13.2442 7.74006 11.385 7.63881 6.99588H4.55632Z"/>
                            </symbol>
                        </svg>
                        <svg width="27" height="23" fill="#FFDA56">
                            <use href="#vk-icon"></use>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>
    
    <div class="modal" data-modal="1">
        <div class="modal__cross js-modal-close"></div>
        <div class="img-form">
            <img src="img/p-f.png" alt="" srcset="">
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
