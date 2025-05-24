@extends('layouts.admin')

@section('title', 'Создание тура')

@section('header-title', 'Добавление нового тура')

@section('content')
<div class="admin-create-tour">
    <div class="admin-content-header">
        <h2>Создание нового тура</h2>
        <a href="{{ route('admin.tours.index') }}" class="admin-btn secondary-btn">
            <i class="fas fa-arrow-left"></i> Вернуться к списку
        </a>
    </div>

    <div class="admin-form-container">
        <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf
            
            <div class="form-group">
                <label for="name">Название тура <span class="required">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="form-control">
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-row">
                <div class="form-group half">
                    <label for="type">Тип тура <span class="required">*</span></label>
                    <select id="type" name="type" required class="form-control">
                        <option value="">Выберите тип</option>
                        <option value="Пляжный" {{ old('type') == 'Пляжный' ? 'selected' : '' }}>Пляжный</option>
                        <option value="Экскурсионный" {{ old('type') == 'Экскурсионный' ? 'selected' : '' }}>Экскурсионный</option>
                        <option value="Горнолыжный" {{ old('type') == 'Горнолыжный' ? 'selected' : '' }}>Горнолыжный</option>
                        <option value="Оздоровительный" {{ old('type') == 'Оздоровительный' ? 'selected' : '' }}>Оздоровительный</option>
                        <option value="Круиз" {{ old('type') == 'Круиз' ? 'selected' : '' }}>Круиз</option>
                    </select>
                    @error('type')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group half">
                    <label for="season">Сезон <span class="required">*</span></label>
                    <select id="season" name="season" required class="form-control">
                        <option value="">Выберите сезон</option>
                        <option value="Лето 2023" {{ old('season') == 'Лето 2023' ? 'selected' : '' }}>Лето 2023</option>
                        <option value="Осень 2023" {{ old('season') == 'Осень 2023' ? 'selected' : '' }}>Осень 2023</option>
                        <option value="Зима 2023-2024" {{ old('season') == 'Зима 2023-2024' ? 'selected' : '' }}>Зима 2023-2024</option>
                        <option value="Весна 2024" {{ old('season') == 'Весна 2024' ? 'selected' : '' }}>Весна 2024</option>
                        <option value="Круглый год" {{ old('season') == 'Круглый год' ? 'selected' : '' }}>Круглый год</option>
                    </select>
                    @error('season')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="description">Описание <span class="required">*</span></label>
                <textarea id="description" name="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="location">Локация <span class="required">*</span></label>
                <input type="text" id="location" name="location" value="{{ old('location') }}" required class="form-control">
                @error('location')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-row">
                <div class="form-group half">
                    <label for="start_date">Дата начала <span class="required">*</span></label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" required class="form-control">
                    @error('start_date')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group half">
                    <label for="end_date">Дата окончания <span class="required">*</span></label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" required class="form-control">
                    @error('end_date')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group half">
                    <label for="duration">Продолжительность (дней) <span class="required">*</span></label>
                    <input type="number" id="duration" name="duration" value="{{ old('duration', 7) }}" min="1" required class="form-control">
                    @error('duration')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group half">
                    <label for="price">Цена (₽) <span class="required">*</span></label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" min="0" step="1" required class="form-control">
                    @error('price')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group half">
                    <label for="audience_type">Аудитория <span class="required">*</span></label>
                    <select id="audience_type" name="audience_type" required class="form-control">
                        <option value="all" {{ old('audience_type', 'all') == 'all' ? 'selected' : '' }}>Для всех</option>
                        <option value="adult" {{ old('audience_type') == 'adult' ? 'selected' : '' }}>Только для взрослых</option>
                        <option value="school" {{ old('audience_type') == 'school' ? 'selected' : '' }}>Для школьников</option>
                        <option value="preschool" {{ old('audience_type') == 'preschool' ? 'selected' : '' }}>Для дошкольников</option>
                    </select>
                    @error('audience_type')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group half">
                    <label for="available_seats">Доступных мест</label>
                    <input type="number" id="available_seats" name="available_seats" value="{{ old('available_seats', 20) }}" min="0" class="form-control">
                    @error('available_seats')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="features">Особенности тура (каждая с новой строки)</label>
                <textarea id="features" name="features" class="form-control" rows="5">{{ old('features') }}</textarea>
                <small>Укажите особенности/включенные услуги тура, каждую с новой строки</small>
                @error('features')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="image">Изображение <span class="required">*</span></label>
                <div class="file-upload-wrapper">
                    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg" required class="form-control">
                    <div class="file-upload-info">Поддерживаемые форматы: JPG, JPEG, PNG. Максимальный размер: 2MB.</div>
                </div>
                @error('image')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-actions">
                <button type="submit" class="admin-btn">
                    <i class="fas fa-plus"></i> Создать тур
                </button>
                <a href="{{ route('admin.tours.index') }}" class="admin-btn cancel-btn">Отмена</a>
            </div>
        </form>
    </div>
</div>
@endsection 