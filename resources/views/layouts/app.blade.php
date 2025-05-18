<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/media.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rodina-tur</title>
</head>
<body class>
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
                    @auth
                        <a href="{{ route('cabinet') }}">
                            <div class="login">
                                <img src="/img/login.svg" alt="" srcset="">
                                <p>КАБИНЕТ</p>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('login') }}">
                            <div class="login">
                                <img src="/img/login.svg" alt="" srcset="">
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

        <section>
    <div class="max">
        <div class="zag-btn">
            <h2>Виды туров</h2>
        </div>
    </div>
    <div class="slider vidy-turov">
        <div class="swiper swiper-initialized swiper-horizontal swiper-backface-hidden">
            <div class="swiper-wrapper max" id="swiper-wrapper-76c2ad871031f5bf8" aria-live="polite" style="padding-bottom: 50px;">
                <div class="swiper-slide swiper-slide-active" role="group" aria-label="1 / 9" style="margin-right: 40px;">
                    <img src="/img/sayMGFc-uGI 2.png" alt="" srcset="">
                    <p>Круизы</p>
                    <a href="#"></a>
                </div>
                <div class="swiper-slide swiper-slide-next" role="group" aria-label="2 / 9" style="margin-right: 40px;">
                    <img src="/img/YiVpT7_kdsw 1.png" alt="" srcset="">
                    <p>Зарубежные туры</p>
                    <a href="#"></a>
                </div>
                <div class="swiper-slide swiper-slide" role="group" aria-label="3 / 9" style="margin-right: 40px;">
                    <img src="/img/7nlvLmnwPIo.png" alt="" srcset="">
                    <p>Многодневные туры</p>
                    <a href="#"></a>
                </div>
                <div class="swiper-slide swiper-slide" role="group" aria-label="4 / 9" style="margin-right: 40px;">
                    <img src="/img/9752bded3270d6662c72431b59b74fca 1.png" alt="" srcset="">
                    <p>Водные туры</p>
                    <a href="#"></a>
                </div>
                <div class="swiper-slide swiper-slide" role="group" aria-label="5 / 9" style="margin-right: 40px;">
                    <img src="/img/59.jpg" alt="" srcset="">
                    <p>Процедуры</p>
                    <a href="#"></a>
                </div>
                <div class="swiper-slide swiper-slide" role="group" aria-label="6 / 9" style="margin-right: 40px;">
                    <img src="/img/59.jpg" alt="" srcset="">
                    <p>Увлекательные</p>
                    <a href="#"></a>
                </div>
                <div class="swiper-slide swiper-slide" role="group" aria-label="7 / 9" style="margin-right: 40px;">
                    <img src="/img/59.jpg" alt="" srcset="">
                    <p>Горные туры</p>
                    <a href="#"></a>
                </div>
                <div class="swiper-slide swiper-slide" role="group" aria-label="8 / 9" style="margin-right: 40px;">
                    <img src="/img/59.jpg" alt="" srcset="">
                    <p>Детям</p>
                    <a href="#"></a>
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
    <script src="js/swiper.js" defer></script>
    <script src="js/main.js" defer></script>
    <script src="js/modal.js" defer></script>
</body>
</html>
