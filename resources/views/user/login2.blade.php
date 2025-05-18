<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/media.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <script src="{{ asset('js/login.js') }}" defer></script>
    <script src="js/adminpanel.js" defer></script>
    <title>Вход - Rodina-tur</title>
</head>
<body>
    <header class="home">
        <div class="max">
            <div class="header-top">
                <a href="{{ route('home') }}" class="logo"><img src="/img/logo__rodina-tur__top 2.svg" alt="" srcset=""></a>
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
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="registr">
                                <div class="registr-wrapper">
                                    <div class="flex-container">
                                        @if(session('success'))
                                            <div class="alert alert-success">
                                                {{ session('success') }}
                                            </div>
                                        @endif

                                        @if($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        
                                        <form id="loginForm" method="POST" action="{{ route('login.post') }}">
                                            @csrf

                                            <h1 class="h1">Вход</h1>
                                            <div class="form-group">
                                                <label for="email">Email:</label>
                                                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="password">Пароль:</label>
                                                <input type="password" id="password" name="password" required>
                                            </div>
                                            
                                            <div class="remember">
                                                <label for="remember">
                                                    <input type="checkbox" id="remember" name="remember">Запомнить меня
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('js/login.js') }}"></script>
  </body>
</html>