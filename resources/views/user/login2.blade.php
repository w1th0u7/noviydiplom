<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/media.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="js/login.js" defer></script>
    <script src="js/adminpanel.js" defer></script>
    <title>Rodina-tur</title>
</head>
<body>
    <header class="home">
        <div class="max">
            <div class="header-top">
                <a href="{{ route('home') }}" class="logo"><img src="/img/logo__rodina-tur__top 2.svg" alt="" srcset=""></a>
                <div class="soc">
                    <a href="http:// " class="tg" target="_blank">
                    <svg>
                        <g id="#tg">
                            <img src="img/Vector.svg" alt="" srcset="">
                        </g>
                        <use xlink:href = "#tg"></use>
                    </svg>
                    </a>
                    <a href="http://" class="wp" target="_blank">
                    <svg>
                        <g id="#wp">
                            <img src="/img/wtsp.svg" alt="" srcset="">
                        </g>
                        <use xlink:href = "#wp"></use>
                    </svg>
                    </a>
                    <a href="http://" class="vk" target="_blank">
                    <svg>
                        <g id="#vk">
                            <img src="/img/vk.svg" alt="" srcset="">
                        </g>
                        <use xlink:href = "#vk"></use>
                    </svg>
                    </a>
                    <a href="http://" class="ytb" target="_blank">
                    <svg>
                        <g id="#ytb">
                            <img src="/img/ytb.svg" alt="" srcset="">
                        </g>
                        <use xlink:href = "#ytb"></use>
                    </svg>
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
                    <a href="{{ route('home') }}">
                        <div class="login">
                            <svg>
                                <img src="/img/login.svg" alt="" srcset="">
                            </svg>
                            <button id="loginBtn" type="submit">ВОЙТИ</button>
                        </div>
                    </a>
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
                            <li class="menu-item"><a href="calculate.html" class="menu-link">Калькулятор туров</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <section class="banner-home">
        <div class="max">
            <div class="swiperloc">
                <div class="swiper spiwer-initialized swiper-horisontal swiper-backface-hidden">
                    <div class="swiper-wrapper" id="swiper-wrapper-7106f2bb2da1645dd" aria-live="polite">
                            <div class="swiper-slide swiper-slide-active swiper-slide-next" role="group" aria-label="1 / 1" data-swiper-slide-index="0" style="width: 765px; margin-right: 20px;">
                                <div class="registr">
                                        <div class="registr-wrapper">
                                            <div class="flex-container">
                                            <form id="registerForm" method="POST" action="{{ route('login') }}">
                                            @csrf

                                            <h1 class="h1" style="font-size: 36px; text-align: center;">Вход</h1>
                                            <div class="form-group">
                                                <label for="username" style="color: #fff;">Имя пользователя:</label>
                                                <input type="text" id="username" name="username" required>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="password" style="color: #fff;">Пароль:</label>
                                                <input type="password" id="password" name="password" required>
                                            </div>
                                            
                                            <div class="remember">
                                                <label for="rememberMe" style="color: #fff;">
                                                    <input type="checkbox" id="rememberMe" name="rememberMe">Запомнить меня
                                                </label>
                                                <a href='#'>Забыли пароль?</a>
                                            </div>
                                            
                                            <button type="submit" class="btn">Войти</button>
                                            
                                            <div class="register-link">
                                                <p>Еще не зарегистрированы? <a href="{{ route('register') }}">Зарегистрироваться</a></p>
                                            </div>
                                        </form>

                                        </div>
                                    </div>
                            </div>
                    <div class="swiper-pagination swiper-pagination-bullets swiper-pagination-horisontal swiper-pagination-block">
                        <span class="swiper-pagination-bullet swiper-pagination-bullet-active" aria-current="true"></span>
                    </div>
                    <span class="swiper-notification" aria-current="assertive" aria-atomic="true"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="js/login.js"></script>
    
  </body>
</html>