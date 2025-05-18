@extends('layouts.admin')

@section('title', 'Настройки')

@section('header-title', 'Настройки сайта')

@section('content')
<div class="admin-settings">
    <div class="admin-content-header">
        <h2>Настройки сайта</h2>
    </div>

    <div class="settings-container">
        <div class="settings-section">
            <h3>Основные настройки</h3>
            <p class="settings-description">Настройте основные параметры работы сайта.</p>
            
            <div class="settings-form-container">
                <form action="{{ route('admin.settings.update') }}" method="POST" class="admin-form">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="site_name">Название сайта</label>
                        <input type="text" id="site_name" name="site_name" value="Rodina-tur" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_email">Контактный Email</label>
                        <input type="email" id="contact_email" name="contact_email" value="info@rodina-tur.ru" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_phone">Контактный телефон</label>
                        <input type="text" id="contact_phone" name="contact_phone" value="8-800-200-31-52" class="form-control">
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="admin-btn" disabled>
                            <i class="fas fa-save"></i> Сохранить настройки
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="settings-section">
            <h3>Резервное копирование</h3>
            <p class="settings-description">Управление резервными копиями данных.</p>
            
            <div class="backup-actions">
                <form action="{{ route('admin.settings.backup') }}" method="POST" style="display: inline-block;">
                    @csrf
                    <button type="submit" class="admin-btn" disabled>
                        <i class="fas fa-download"></i> Создать резервную копию
                    </button>
                </form>
                
                <div class="backup-status">
                    <p>Последнее резервное копирование: <strong>не выполнялось</strong></p>
                </div>
            </div>
        </div>
        
        <div class="settings-section">
            <h3>Настройки SEO</h3>
            <p class="settings-description">Настройте SEO параметры для улучшения видимости сайта в поисковых системах.</p>
            
            <div class="settings-form-container">
                <form action="{{ route('admin.settings.update-seo') }}" method="POST" class="admin-form">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="meta_title">Meta Title</label>
                        <input type="text" id="meta_title" name="meta_title" value="Rodina-tur - Путешествия по России" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <textarea id="meta_description" name="meta_description" class="form-control">Туристическая компания Rodina-tur предлагает лучшие туры по России. Отдых на море, горнолыжные курорты, экскурсионные туры и многое другое.</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="meta_keywords">Meta Keywords</label>
                        <input type="text" id="meta_keywords" name="meta_keywords" value="туры, отдых, путешествия, Россия, курорты, экскурсии" class="form-control">
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="admin-btn" disabled>
                            <i class="fas fa-save"></i> Сохранить SEO настройки
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="admin-note">
        <p><i class="fas fa-info-circle"></i> Примечание: Функционал настроек находится в разработке и будет доступен в следующих обновлениях.</p>
    </div>
</div>

<style>
    .settings-section {
        background-color: #fff;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .settings-section h3 {
        color: var(--admin-text);
        border-bottom: 1px solid var(--admin-border);
        padding-bottom: 10px;
        margin-top: 0;
    }
    
    .settings-description {
        color: #777;
        margin-bottom: 20px;
    }
    
    .backup-actions {
        margin-top: 20px;
    }
    
    .backup-status {
        margin-top: 15px;
        color: #777;
    }
    
    .admin-note {
        background-color: rgba(255, 203, 34, 0.1);
        border-left: 4px solid var(--admin-primary);
        padding: 15px;
        margin-top: 20px;
        color: var(--admin-text);
    }
</style>
@endsection 