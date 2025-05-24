<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Админ-панель | @yield('title', 'Rodina-tur')</title>
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-wrapper">
        <!-- Боковая панель навигации -->
        <div class="admin-sidebar">
            <div class="admin-sidebar-header">
                <h2>Панель управления</h2>
                <div class="admin-logo">
                    <img src="/img/logo__rodina-tur__top 2.svg" alt="Rodina-tur">
                </div>
            </div>
            
            <nav class="admin-nav">
                <ul>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i> Статистика
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.tours') }}" class="{{ request()->routeIs('admin.tours') ? 'active' : '' }}">
                            <i class="fas fa-umbrella-beach"></i> Управление турами
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.excursions.index') }}" class="{{ request()->routeIs('admin.excursions.*') ? 'active' : '' }}">
                            <i class="fas fa-map-marked-alt"></i> Управление экскурсиями
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-check"></i> Управление бронированиями
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                            <i class="fas fa-users"></i> Пользователи
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders') }}" class="{{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart"></i> Заказы
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                            <i class="fas fa-cog"></i> Настройки
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}" target="_blank">
                            <i class="fas fa-globe"></i> Просмотр сайта
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Основной контент -->
        <div class="admin-content">
            <header class="admin-header">
                <div class="admin-header-container">
                    <div class="admin-header-title">
                        <h1>@yield('header-title')</h1>
                    </div>
                    <div class="admin-user-controls">
                        <div class="admin-user-info">
                            <span>{{ Auth::user()->name }}</span>
                            <small>Администратор</small>
                        </div>
                        <div class="admin-logout">
                            <form action="{{ url('/logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="logout-btn">
                                    <i class="fas fa-sign-out-alt"></i> Выйти
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="admin-main">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="http://127.0.0.1:8000/js/admin.js"></script>
    @yield('scripts')
</body>
</html> 