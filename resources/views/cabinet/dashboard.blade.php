@extends('layouts.cabinet')

@section('title', 'Главная')

@section('page-title', 'Главная')

@section('content')
<div class="dashboard-welcome">
    <div class="welcome-header">
        <h2>Добро пожаловать, {{ Auth::user()->name }}!</h2>
        <div class="welcome-decoration"></div>
    </div>
    <p class="welcome-text">Добро пожаловать в личный кабинет. Здесь вы можете управлять своими поездками и настройками аккаунта.</p>
    
    <div class="dashboard-quick-links">
        <div class="dashboard-card">
            <div class="dashboard-card-icon trips-icon"></div>
            <div class="dashboard-card-content">
                <h3>Мои поездки</h3>
                <p>Просматривайте информацию о своих поездках</p>
                <a href="{{ route('trips') }}" class="dashboard-card-link">Перейти →</a>
            </div>
        </div>
        
        <div class="dashboard-card">
            <div class="dashboard-card-icon settings-icon"></div>
            <div class="dashboard-card-content">
                <h3>Настройки</h3>
                <p>Управляйте настройками вашего аккаунта</p>
                <a href="{{ route('settings') }}" class="dashboard-card-link">Перейти →</a>
            </div>
        </div>
    </div>
</div>
@endsection 