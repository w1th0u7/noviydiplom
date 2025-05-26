<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - Rodina-tur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

<div class="auth-container">
    <div class="auth-image">
        <div class="logo-container">
            <a href="{{ route('home') }}">
                <img src="/img/logo__rodina-tur__top 2.svg" alt="Rodina-tur">
            </a>
        </div>
        <div class="tagline">
            <h2>Откройте для себя мир путешествий</h2>
            <p>Авторизуйтесь, чтобы получить доступ к персональным предложениям и удобному бронированию туров</p>
        </div>
    </div>

    <div class="auth-form">
        <a href="{{ route('home') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> На главную
        </a>
        
        <div class="form-wrapper">
            <div class="form-header">
                <h1>Добро пожаловать!</h1>
                <p>Войдите в свой аккаунт, чтобы продолжить</p>
            </div>

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
            
            <form id="loginForm" method="POST" action="{{ route('login.post') }}{{ request()->query('redirect') ? '?redirect=' . request()->query('redirect') : '' }}">
                @csrf
                
                @if(request()->query('redirect'))
                    <input type="hidden" name="redirect_url" value="{{ request()->query('redirect') }}">
                @endif

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            placeholder="Введите ваш email"
                            required
                        >
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <div class="input-group password-field">
                        <i class="fas fa-lock input-icon"></i>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Введите ваш пароль"
                            required
                        >
                        <span class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </span>
                    </div>
                </div>
                
                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Запомнить меня</label>
                    </div>
                    <a href="#" class="forgot-password">Забыли пароль?</a>
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Войти
                </button>
                
                <div class="register-link">
                    <p>Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a></p>
                </div>

                <div class="social-login">
                    <p>Или войдите через</p>
                    <div class="social-btn">
                        <a href="#" class="google"><i class="fab fa-google"></i></a>
                        <a href="#" class="vk"><i class="fab fa-vk"></i></a>
                        <a href="#" class="telegram"><i class="fab fa-telegram-plane"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordField = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }

    // Анимация появления формы
    document.addEventListener('DOMContentLoaded', function() {
        const formWrapper = document.querySelector('.form-wrapper');
        setTimeout(() => {
            formWrapper.style.opacity = '1';
            formWrapper.style.transform = 'translateY(0)';
        }, 100);
    });
</script>

</body>
</html>