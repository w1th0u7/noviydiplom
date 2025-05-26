<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('/css/media.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/cabinet.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                        <a href="{{ route('cabinet') }}" class="{{ request()->routeIs('cabinet') ? 'active' : '' }}">
                            <i class="fas fa-home"></i> Главная
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('trips') }}" class="{{ request()->routeIs('trips') ? 'active' : '' }}">
                            <i class="fas fa-suitcase"></i> Мои бронирования
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('settings') }}" class="{{ request()->routeIs('settings') ? 'active' : '' }}">
                            <i class="fas fa-cog"></i> Настройки
                        </a>
                    </li>
                    @if(Auth::user()->role === 'admin')
                    <li class="admin-menu-item">
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">
                            <i class="fas fa-tools"></i> Админ-панель
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
                            <img src="/img/logo__rodina-tur__top 2.svg" alt="Rodina-tur">
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

    <script src="/js/cabinet.js"></script>
</body>
</html> 