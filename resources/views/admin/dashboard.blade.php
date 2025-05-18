@extends('layouts.admin')

@section('title', 'Статистика')

@section('header-title', 'Статистика сайта')

@section('content')
<div class="admin-dashboard">
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-card-icon">
                <i class="fas fa-umbrella-beach"></i>
            </div>
            <div class="stat-card-content">
                <h3>Туры</h3>
                <p class="stat-number">{{ $tourCount }}</p>
                <p class="stat-label">Всего направлений</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-card-content">
                <h3>Пользователи</h3>
                <p class="stat-number">{{ $userCount }}</p>
                <p class="stat-label">Зарегистрировано</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-card-content">
                <h3>Администраторы</h3>
                <p class="stat-number">{{ $adminCount }}</p>
                <p class="stat-label">С правами управления</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-card-content">
                <h3>Заказы</h3>
                <p class="stat-number">0</p>
                <p class="stat-label">Ожидается разработка</p>
            </div>
        </div>
    </div>
    
    <div class="dashboard-actions">
        <div class="action-card">
            <h3>Быстрые действия</h3>
            <div class="action-links">
                <a href="{{ route('admin.tours.create') }}" class="admin-btn">
                    <i class="fas fa-plus"></i> Добавить тур
                </a>
                <a href="{{ route('admin.tours') }}" class="admin-btn">
                    <i class="fas fa-list"></i> Управление турами
                </a>
                <a href="{{ route('admin.users') }}" class="admin-btn">
                    <i class="fas fa-user-cog"></i> Управление пользователями
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 