<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Подключение шрифтов через Google Fonts -->
    <link rel="stylesheet" href="{{ asset('/css/web-fonts.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/media.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/pages/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/calculate.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Калькулятор туров | Rodina-tur')</title>
    <script src="{{ asset('/js/fixes.js') }}" defer></script>
    @yield('styles')
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
                    <a href="http:// " class="tg" target="_blank">
                            <img src="/img/Vector.svg" alt="" srcset="">
                    </a>
                    <a href="http://" class="wp" target="_blank">
                            <img src="/img/wtsp.svg" alt="" srcset="">
                    </a>
                    <a href="http://" class="vk" target="_blank">
                            <img src="/img/vk.svg" alt="" srcset="">
                    </a>
                    <a href="http://" class="ytb" target="_blank">
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
                    <a href="{{ route('login') }}">
                        <div class="login">
                                <svg width="30" height="29" viewBox="0 0 30 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_974_66_calculator)">
                                    <path d="M25.501 10.5C25.501 16.0012 20.8219 20.5 15.0005 20.5C9.17903 20.5 4.5 16.0012 4.5 10.5C4.5 4.99884 9.17903 0.5 15.0005 0.5C20.8219 0.5 25.501 4.99884 25.501 10.5Z" stroke="#EEBB07" shape-rendering="crispEdges"/>
                                    </g>
                                    <path d="M17.9886 7.58333C17.9886 9.60247 16.4922 11.1667 14.7323 11.1667C12.9724 11.1667 11.4761 9.60247 11.4761 7.58333C11.4761 5.56419 12.9724 4 14.7323 4C16.4922 4 17.9886 5.56419 17.9886 7.58333Z" stroke="#EEBB07"/>
                                    <path d="M21.7082 18.6667H8.29297C8.29297 15.9167 10.5764 12.25 14.8579 12.25C18.9744 12.25 21.7082 15.4583 21.7082 18.6667Z" stroke="#EEBB07"/>
                                    <defs>
                                    <filter id="filter0_d_974_66_calculator" x="0" y="0" width="30.001" height="29" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
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
        <section class="banner-home">
            <div class="max">
                <div class="swiper swiper-initialized swiper-horizontal swiper-backface-hidden">
                    <div class="swiper-wrapper" aria-live="polite">
                        <div class="swiper-slide swiper-slide-active swiper-slide-next" role="group" aria-label="1/1" data-swiper-slide-index="0">
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
                </div>
                <div class="block">
                    <div class="info">
                        <div class="bl">
                            <div class="info-icon adres">
                                <p>Наш адрес</p>
                                <p>Владимирская область, г. Александров, ул.Ленина</p>
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
                                    <svg width="26" height="23" fill="#FFDA56">
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
        </div>
        <div class="footer-bot"></div>
        <div class="soc mob"></div>
    </footer>

    <!-- Модальное окно для заказа звонка -->
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
                
                <div class="social-icons">
                    <a href="#" class="telegram"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 0C5.37097 0 0 5.37097 0 12C0 18.629 5.37097 24 12 24C18.629 24 24 18.629 24 12C24 5.37097 18.629 0 12 0ZM17.8935 8.22097L15.9387 17.5016C15.8032 18.0484 15.4532 18.1935 15 17.9435L11.9758 15.7016L10.5242 17.0919C10.3742 17.2419 10.2484 17.3677 9.95806 17.3677L10.1564 14.2823L15.7887 9.15484C16.0145 8.95484 15.7403 8.84032 15.4403 9.04032L8.49919 13.4113L5.50403 12.4532C4.9621 12.2758 4.95403 11.8839 5.63226 11.6339L17.1048 7.1621C17.5565 6.99677 17.9532 7.29193 17.8935 8.22097Z" fill="#FFFFFF"/></svg></a>
                    <a href="#" class="whatsapp"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 0.375C5.57775 0.375 0.375 5.57775 0.375 12C0.375 14.0167 0.88425 15.9215 1.79175 17.5912L0.375 23.625L6.57225 22.2307C8.19675 23.073 10.0373 23.625 12 23.625C18.4223 23.625 23.625 18.4223 23.625 12C23.625 5.57775 18.4223 0.375 12 0.375ZM12 21.5625C10.254 21.5625 8.56125 21.06 7.10475 20.157L6.807 19.9778L3.26625 20.778L4.08075 17.3318L3.88125 17.0205C2.889 15.5205 2.4375 13.7992 2.4375 12C2.4375 6.7455 6.7455 2.4375 12 2.4375C17.2545 2.4375 21.5625 6.7455 21.5625 12C21.5625 17.2545 17.2545 21.5625 12 21.5625ZM17.0048 14.4173C16.7527 14.2943 15.4875 13.1722 15.2595 13.1123C15.0337 13.0477 14.8687 13.0523 14.6182 13.3043C14.3678 13.5562 13.482 14.6077 13.3403 14.7705C13.1985 14.9355 13.0522 14.9625 12.8023 14.8372C12.5502 14.7142 11.7112 14.454 10.7055 13.5562C9.9225 12.8505 9.4005 11.9842 9.25875 11.7322C9.1125 11.4825 9.2565 11.3385 9.37575 11.2162C9.50475 11.0782 9.64875 10.86 9.7905 10.7182C9.93225 10.5765 9.9675 10.467 10.032 10.302C10.0965 10.1347 10.0612 9.99075 10.0125 9.8655C9.9675 9.744 9.46575 8.47875 9.2655 7.97925C9.06525 7.473 8.8695 7.551 8.718 7.54425C8.57625 7.5375 8.4135 7.5375 8.2485 7.5375C8.0835 7.5375 7.8217 7.5825 7.59825 7.83225C7.37025 8.0865 6.20175 9.20625 6.20175 10.4738C6.20175 11.7412 7.11375 12.9645 7.24725 13.1295C7.38075 13.2967 9.39 16.3943 12.4763 17.5058C13.26 17.8395 13.8735 18.0397 14.3475 18.1875C15.1395 18.4335 15.861 18.396 16.4317 18.345C17.0722 18.288 18.0915 17.283 18.2918 16.6898C18.492 16.0965 18.492 15.597 18.4425 15.513C18.393 15.429 18.2235 15.3757 17.9715 15.2527C17.7218 15.1252 16.4498 14.0077 16.1977 13.8847C15.9457 13.7595 15.7807 13.6973 15.5302 13.947C15.2797 14.2012 14.4557 14.7322 14.2365 14.9775C14.0933 15.1178 13.8667 15.138 13.6957 15.0555C13.3957 14.9325 12.5442 14.661 11.5252 13.7595C10.7333 13.053 10.1895 12.195 10.0455 11.943C9.9015 11.691 10.0275 11.5493 10.1467 11.4187C10.2547 11.3025 10.3875 11.1187 10.5112 10.9748C10.635 10.8308 10.698 10.7295 10.7625 10.5645C10.8247 10.3972 10.7872 10.2532 10.7333 10.1302C10.6793 10.0073 10.1708 8.7382 9.93225 8.2298C9.6982 7.73605 9.46425 7.81455 9.31575 7.80555C9.1125 7.79205 8.95275 7.79205 8.79075 7.79205L8.783 7.78755C8.61425 7.79205 8.355 7.836 8.12475 8.091C7.9035 8.346 6.714 9.477 6.714 10.7663C6.714 12.0557 7.56225 13.2922 7.7175 13.5352C7.86825 13.7805 9.4005 16.2885 12.5707 17.5058C13.0785 17.7082 13.4895 17.8395 13.8037 17.9347C14.3565 18.0915 14.8665 18.072 15.2618 18.018C15.7012 17.9572 16.7663 16.9448 16.9665 16.335C17.1668 15.7275 17.1668 15.2122 17.1127 15.1252C17.0587 15.0405 16.9035 14.9955 16.6515 14.8702L17.0048 14.4173Z" fill="white"/></svg></a>
                    <a href="#" class="vkontakte"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 0C5.37097 0 0 5.37097 0 12C0 18.629 5.37097 24 12 24C18.629 24 24 18.629 24 12C24 5.37097 18.629 0 12 0ZM18.2332 16.2358C17.0684 16.2371 15.9097 15.9997 14.8426 15.5387C14.6677 15.4587 14.4729 15.4536 14.2942 15.5245C14.1155 15.5955 13.9677 15.7368 13.8813 15.9161L13.4032 16.871C12.0703 16.3581 10.8677 15.5355 9.89032 14.4774C8.83226 13.5 8.00968 12.2974 7.49677 10.9645L8.45162 10.4865C8.63093 10.4 8.77226 10.2523 8.84322 10.0735C8.91419 9.89484 8.90903 9.7 8.82903 9.52516C8.36774 8.45806 8.12903 7.29935 8.13032 6.13548C8.13032 5.85484 8.01935 5.58581 7.82129 5.38774C7.62323 5.18968 7.35419 5.07871 7.07355 5.07871H5.33226C5.05163 5.07871 4.78258 5.18968 4.58452 5.38774C4.38645 5.58581 4.27548 5.85484 4.27548 6.13548C4.27677 7.95161 4.7229 9.73548 5.57677 11.329C6.41032 12.9213 7.62452 14.2794 9.11613 15.329C10.6148 16.3774 12.3587 17.0826 14.1961 17.381C16.0335 17.6794 17.9165 17.561 19.6916 17.0368C19.8877 16.9755 20.0529 16.849 20.1606 16.6806C20.2684 16.5123 20.3123 16.3123 20.2839 16.1162C20.2839 16.1162 20.2839 16.1148 20.2839 16.1135V14.3723C20.2839 14.0916 20.1729 13.8226 19.9748 13.6245C19.7768 13.4264 19.5077 13.3155 19.2271 13.3155H18.2332V16.2358Z" fill="white"/></svg></a>
                </div>
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
    <script src="/js/calculate.js" defer></script>
    @yield('scripts')
</body>
</html> 