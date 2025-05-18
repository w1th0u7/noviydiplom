@extends('layouts.cabinet')

@section('title', 'Настройки')

@section('page-title', 'Настройки')

@section('content')
<div class="settings-content">
    <div class="settings-form">
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
        
        @if(Auth::user()->role === 'admin')
        <div class="admin-action-panel">
            <h3>Административные функции</h3>
            <p>У вас есть права администратора. Используйте эту кнопку для перехода в панель управления.</p>
            <a href="{{ route('admin.dashboard') }}" class="admin-panel-button">
                <i class="cabinet-icon admin-icon"></i> Войти в админ-панель
            </a>
        </div>
        @endif
        
        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->name }}" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ Auth::user()->email }}" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Телефон</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ Auth::user()->phone ?? '' }}">
            </div>
            
            <h3>Изменить пароль</h3>
            <p class="hint">Оставьте поля пустыми, если не хотите менять пароль</p>
            
            <div class="form-group">
                <label for="current_password">Текущий пароль</label>
                <input type="password" name="current_password" id="current_password" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="password">Новый пароль</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="password_confirmation">Подтвердите новый пароль</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            </div>
        </form>
    </div>
</div>
@endsection 