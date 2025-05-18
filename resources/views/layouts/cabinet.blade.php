<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cabinet.css') }}">
</head>
<body>
    <div class="cabinet-wrapper">
        <!-- Боковая панель -->
        <div class="cabinet-sidebar">
            <div class="cabinet-user">
                <h2>Личный кабинет</h2>
                <div class="cabinet-user-info">
                    <p class="cabinet-username">{{ Auth::user()->name }}</p>
                    <p class="cabinet-email">{{ Auth::user()->email }}</p>
                </div>
            </div>
            
            <nav class="cabinet-nav">
                <ul>
                    <li>
                        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                            <i class="cabinet-icon home-icon"></i> Главная
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('trips') }}" class="{{ request()->routeIs('trips') ? 'active' : '' }}">
                            <i class="cabinet-icon trips-icon"></i> Мои поездки
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('settings') }}" class="{{ request()->routeIs('settings') ? 'active' : '' }}">
                            <i class="cabinet-icon settings-icon"></i> Настройки
                        </a>
                    </li>
                    @if(Auth::user()->role === 'admin')
                    <li class="admin-menu-item">
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">
                            <i class="cabinet-icon admin-icon"></i> Админ-панель
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>

        <!-- Основной контент -->
        <div class="cabinet-content">
            <header class="cabinet-header">
                <div class="cabinet-header-container">
                    <div class="cabinet-logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('img/logo__rodina-tur__top 2.svg') }}" alt="Rodina-tur">
                        </a>
                    </div>
                    <div class="cabinet-user-controls">
                        <form action="{{ url('/logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="logout-btn">Выйти</button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="cabinet-main">
                <h1>@yield('page-title')</h1>
                
                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ asset('js/cabinet.js') }}"></script>
</body>
</html> 