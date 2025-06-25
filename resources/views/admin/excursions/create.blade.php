@extends('layouts.admin')

@section('title', 'Создание экскурсии')

@section('header-title', 'Добавление новой экскурсии')

@section('content')
<div class="admin-create-excursion">
    <div class="admin-content-header">
        <h2>Создание новой экскурсии</h2>
        <a href="{{ route('admin.excursions.index') }}" class="admin-btn secondary-btn">
            <i class="fas fa-arrow-left"></i> Вернуться к списку
        </a>
    </div>

    <div class="admin-form-container">
        <form action="{{ route('admin.excursions.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf
            
            <div class="form-group">
                <label for="name">Название экскурсии <span class="required">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="form-control">
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-row">
                <div class="form-group half">
                    <label for="location">Локация <span class="required">*</span></label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}" required class="form-control">
                    @error('location')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group half">
                    <label for="region">Регион <span class="required">*</span></label>
                    <select id="region" name="region" required class="form-control">
                        <option value="">Выберите регион</option>
                        <option value="Центральный" {{ old('region') == 'Центральный' ? 'selected' : '' }}>Центральный</option>
                        <option value="Северо-Западный" {{ old('region') == 'Северо-Западный' ? 'selected' : '' }}>Северо-Западный</option>
                        <option value="Южный" {{ old('region') == 'Южный' ? 'selected' : '' }}>Южный</option>
                        <option value="Северо-Кавказский" {{ old('region') == 'Северо-Кавказский' ? 'selected' : '' }}>Северо-Кавказский</option>
                        <option value="Приволжский" {{ old('region') == 'Приволжский' ? 'selected' : '' }}>Приволжский</option>
                        <option value="Уральский" {{ old('region') == 'Уральский' ? 'selected' : '' }}>Уральский</option>
                        <option value="Сибирский" {{ old('region') == 'Сибирский' ? 'selected' : '' }}>Сибирский</option>
                        <option value="Дальневосточный" {{ old('region') == 'Дальневосточный' ? 'selected' : '' }}>Дальневосточный</option>
                    </select>
                    @error('region')
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
            
            <div class="form-row">
                <div class="form-group half">
                    <label for="audience_type">Тип аудитории <span class="required">*</span></label>
                    <select id="audience_type" name="audience_type" required class="form-control">
                        <option value="">Выберите тип аудитории</option>
                        <option value="preschool" {{ old('audience_type') == 'preschool' ? 'selected' : '' }}>Дошкольники</option>
                        <option value="school" {{ old('audience_type') == 'school' ? 'selected' : '' }}>Школьники</option>
                        <option value="adult" {{ old('audience_type') == 'adult' ? 'selected' : '' }}>Взрослые</option>
                        <option value="all" {{ old('audience_type') == 'all' ? 'selected' : '' }}>Для всех возрастов</option>
                    </select>
                    @error('audience_type')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group half">
                    <label for="duration">Продолжительность (часов) <span class="required">*</span></label>
                    <input type="number" id="duration" name="duration" value="{{ old('duration', 2) }}" min="1" required class="form-control">
                    @error('duration')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group half">
                    <label for="min_age">Минимальный возраст</label>
                    <input type="number" id="min_age" name="min_age" value="{{ old('min_age') }}" min="0" class="form-control">
                    @error('min_age')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group half">
                    <label for="max_age">Максимальный возраст</label>
                    <input type="number" id="max_age" name="max_age" value="{{ old('max_age') }}" min="0" class="form-control">
                    @error('max_age')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group half">
                    <label for="price">Цена (₽) <span class="required">*</span></label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" min="0" step="1" required class="form-control">
                    @error('price')
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

            <div class="form-row">
                <div class="form-group half">
                    <label for="start_date">Дата начала проведения</label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" class="form-control">
                    @error('start_date')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group half">
                    <label for="end_date">Дата окончания проведения</label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" class="form-control">
                    @error('end_date')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="features">Особенности экскурсии (каждая с новой строки)</label>
                <textarea id="features" name="features" class="form-control" rows="5">{{ old('features') }}</textarea>
                <small>Укажите особенности/включенные услуги экскурсии, каждую с новой строки</small>
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
                <!-- Контейнер для превью изображения -->
                <div class="image-preview-container" id="imagePreviewContainer">
                    <p>Превью изображения:</p>
                    <img id="imagePreview" src="" alt="Превью изображения">
                </div>
                @error('image')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-actions">
                <button type="submit" class="admin-btn">
                    <i class="fas fa-plus"></i> Создать экскурсию
                </button>
                <a href="{{ route('admin.excursions.index') }}" class="admin-btn cancel-btn">Отмена</a>
            </div>
        </form>
    </div>
</div>
@endsection 