<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - Rodina-tur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <!-- CSRF Token для предотвращения ошибок CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <h2>Путешествуйте вместе с нами</h2>
            <p>Регистрация позволит вам бронировать туры, получать персональные предложения и скидки</p>
        </div>
    </div>

    <div class="auth-form">
        <a href="{{ route('home') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> На главную
        </a>
        
        <div class="form-wrapper">
            <div class="form-header">
                <h1>Создайте аккаунт</h1>
                <p>Заполните форму для регистрации</p>
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
            
            <!-- Исправленная форма регистрации с явным отключением AJAX -->
            <form id="registerForm" method="POST" action="{{ url('/register') }}" data-ajax="false">
                @csrf

                <div class="form-group">
                    <label for="name">Имя</label>
                    <div class="input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}" 
                            placeholder="Введите ваше имя" 
                            required
                        >
                    </div>
                </div>
                
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
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <div class="input-group password-field">
                            <i class="fas fa-lock input-icon"></i>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Создайте пароль"
                                required
                            >
                            <span class="password-toggle" onclick="togglePassword('password', 'toggleIcon1')">
                                <i class="fas fa-eye" id="toggleIcon1"></i>
                            </span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation">Подтверждение пароля</label>
                        <div class="input-group password-field">
                            <i class="fas fa-lock input-icon"></i>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                placeholder="Подтвердите пароль"
                                required
                            >
                            <span class="password-toggle" onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                                <i class="fas fa-eye" id="toggleIcon2"></i>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="terms">
                    <label>
                        <input type="checkbox" id="terms" name="terms" required>
                        <span>Я согласен с <a href="#">Условиями использования</a> и <a href="#">Политикой конфиденциальности</a></span>
                    </label>
                </div>
                
                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus"></i> Зарегистрироваться
                </button>
                
                <div class="login-link">
                    <p>Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a></p>
                </div>

                <div class="social-login">
                    <p>Или зарегистрируйтесь через</p>
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
    function togglePassword(fieldId, iconId) {
        const passwordField = document.getElementById(fieldId);
        const toggleIcon = document.getElementById(iconId);
        
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

    // Валидация пароля при вводе
    document.getElementById('password').addEventListener('input', validatePassword);
    
    function validatePassword() {
        const password = document.getElementById('password').value;
        const confirmation = document.getElementById('password_confirmation').value;
        
        if (confirmation && password !== confirmation) {
            document.getElementById('password_confirmation').classList.add('error');
        } else if (confirmation) {
            document.getElementById('password_confirmation').classList.remove('error');
        }
    }
    
    document.getElementById('password_confirmation').addEventListener('input', validatePassword);
    
    // Отключение любых AJAX обработчиков для формы
    document.addEventListener('DOMContentLoaded', function() {
        const registerForm = document.getElementById('registerForm');
        
        // Переопределение стандартного поведения отправки формы
        registerForm.addEventListener('submit', function(e) {
            console.log('Form submitted, submitting as regular HTML form');
            // Не препятствуем стандартной отправке формы
            return true;
        });
        
        // Анимация появления формы
        const formWrapper = document.querySelector('.form-wrapper');
        setTimeout(() => {
            formWrapper.style.opacity = '1';
            formWrapper.style.transform = 'translateY(0)';
        }, 100);
    });
</script>

<!-- Подключаем наш JS файл для валидации -->
<script src="{{ asset('js/login.js') }}"></script>
</body>
</html>