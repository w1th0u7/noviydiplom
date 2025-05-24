<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/media.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Регистрация - Rodina-tur</title>
</head>
<body>
    <header class="home">
        <div class="max">
            <div class="header-top">
                <a href="{{ route('home') }}" class="logo"><img src="/img/logo__rodina-tur__top 2.svg" alt="Rodina-tur"></a>
                <div class="soc">
                    <a href="http:// " class="tg" target="_blank">
                        <img src="/img/Vector.svg" alt="Telegram">
                    </a>
                    <a href="http://" class="wp" target="_blank">
                        <img src="/img/wtsp.svg" alt="WhatsApp">
                    </a>
                    <a href="http://" class="vk" target="_blank">
                        <img src="/img/vk.svg" alt="VK">
                    </a>
                    <a href="http://" class="ytb" target="_blank">
                        <img src="/img/ytb.svg" alt="YouTube">
                    </a>
                </div>
                <div class="header-info">
                    <div class="phone">
                        <a href="tel:88002003152">8-800-200-31-52</a>
                        <span>по России Бесплатный</span>
                    </div>
                    <div class="js-open-modal zakaz-zvonka" data-modal="1">
                        <img src="/img/Phone.svg" class="img-phone">
                        <p>+7 (920) 904-13-83</p>
                        <p>Заказать звонок</p>
                    </div>
                    <a href="{{ route('login') }}">
                        <div class="login">
                            <svg width="30" height="29" viewBox="0 0 30 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g filter="url(#filter0_d_login)">
                                <path d="M25.501 10.5C25.501 16.0012 20.8219 20.5 15.0005 20.5C9.17903 20.5 4.5 16.0012 4.5 10.5C4.5 4.99884 9.17903 0.5 15.0005 0.5C20.8219 0.5 25.501 4.99884 25.501 10.5Z" stroke="#EEBB07" shape-rendering="crispEdges"/>
                                </g>
                                <path d="M17.9886 7.58333C17.9886 9.60247 16.4922 11.1667 14.7323 11.1667C12.9724 11.1667 11.4761 9.60247 11.4761 7.58333C11.4761 5.56419 12.9724 4 14.7323 4C16.4922 4 17.9886 5.56419 17.9886 7.58333Z" stroke="#EEBB07"/>
                                <path d="M21.7082 18.6667H8.29297C8.29297 15.9167 10.5764 12.25 14.8579 12.25C18.9744 12.25 21.7082 15.4583 21.7082 18.6667Z" stroke="#EEBB07"/>
                                <defs>
                                <filter id="filter0_d_login" x="0" y="0" width="30.001" height="29" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                <feOffset dy="4"/>
                                <feGaussianBlur stdDeviation="2"/>
                                <feComposite in2="hardAlpha" operator="out"/>
                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_login"/>
                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_login" result="shape"/>
                                </filter>
                                </defs>
                            </svg>
                            <p>ВОЙТИ</p>
                        </div>
                    </a>
                    <div class="menu-btn">
                        <img src="/img/menu-btn.svg" alt="Меню">
                    </div>
                </div>
            </div>
            <div class="header-mid">
                <div class="max">
                    <nav>
                        <div class="close-menu">
                            <img src="/img/close-menu.svg" alt="Закрыть">
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

    <section class="banner-home">
        <div class="max">
            <div class="swiperloc">
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
                            
                            <form id="registerForm" method="POST" action="{{ route('register') }}">
                                @csrf
                                <h1 class="h1">Регистрация</h1>
                                <div class="form-group">
                                    <label for="name">Имя пользователя:</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Введите ваше имя" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Введите ваш email" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="password">Пароль:</label>
                                    <input type="password" id="password" name="password" placeholder="Введите пароль (минимум 6 символов)" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="password_confirmation">Подтверждение пароля:</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Повторите пароль" required>
                                </div>
                                
                                <div class="remember">
                                    <label for="rememberMe">
                                        <input type="checkbox" id="rememberMe" name="rememberMe">
                                        Запомнить меня
                                    </label>
                                    <a href="#">Правила регистрации</a>
                                </div>
                                
                                <button type="submit" class="btn">Зарегистрироваться</button>
                                
                                <div class="register-link">
                                    <p>Уже зарегистрированы? <a href="{{ route('login') }}">Войти</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="/js/main.js" defer></script>
    <script src="/js/modal.js" defer></script>
    <script src="{{ asset('js/login.js') }}" defer></script>
</body>
</html>