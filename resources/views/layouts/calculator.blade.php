<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/media.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Калькулятор туров | Rodina-tur')</title>
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
                            <img src="img/Vector.svg" alt="" srcset="">
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
                                <img src="/img/login.svg" alt="" srcset="">
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
                            <li class="menu-item"><a href="" class="menu-link">Расписание</a></li>
                            <li class="menu-item"><a href="" class="menu-link">Хит сезона</a></li>
                            <li class="menu-item"><a href="" class="menu-link">Контакты</a></li>
                            <li class="menu-item"><a href="" class="menu-link">Экскурсии</a></li>
                            <li class="menu-item"><a href="" class="menu-link">Туристам</a></li>
                            <li class="menu-item"><a href="" class="menu-link">Горящие туры</a></li>
                            <li class="menu-item"><a href="{{ route('calculate') }}" class="menu-link">Калькулятор туров</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <main class="main">
        <!-- Баннер с "Путешествуй по великой России" -->
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
        
        <!-- Содержимое страницы (калькулятор) -->
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
                                    <img src="img/Vector.svg" alt="" srcset="">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bot"></div>
        <div class="soc nmob"></div>
    </footer>

    <!-- Модальное окно для заказа звонка -->
    <div class="modal" data-modal="1">
        <div class="modal__cross js-modal-close"></div>
        <div class="img-form">
            <img src="img/p-f.png" alt="" srcset="">
            <div class="cont">
                <h3>Заказать звонок</h3>
                <p class="txt">Оставьте заявку и наш менеджер проведет для вас консультацию.</p>
                <form action="index.html"  onsubmit="ym('98198773','reachGoal','order-call-modal'); return true;">
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
    <script src="/js/calculate.js" defer></script>
    @yield('scripts')
</body>
</html> 