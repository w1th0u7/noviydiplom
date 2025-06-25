@extends('layouts.admin')

@section('title', 'Редактирование экскурсии')

@section('header-title', 'Редактирование экскурсии')

@section('content')
<div class="admin-edit-excursion">
    <div class="admin-content-header">
        <h2>Редактирование экскурсии "{{ $excursion->name }}"</h2>
        <a href="{{ route('admin.excursions.index') }}" class="admin-btn secondary-btn">
            <i class="fas fa-arrow-left"></i> Вернуться к списку
        </a>
    </div>

    <div class="admin-form-container">
        <form action="{{ route('admin.excursions.update', $excursion) }}" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Название экскурсии <span class="required">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $excursion->name) }}" required class="form-control">
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-row">
                <div class="form-group half">
                    <label for="location">Локация <span class="required">*</span></label>
                    <input type="text" id="location" name="location" value="{{ old('location', $excursion->location) }}" required class="form-control">
                    @error('location')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group half">
                    <label for="region">Регион <span class="required">*</span></label>
                    <select id="region" name="region" required class="form-control">
                        <option value="">Выберите регион</option>
                        <option value="Центральный" {{ old('region', $excursion->region) == 'Центральный' ? 'selected' : '' }}>Центральный</option>
                        <option value="Северо-Западный" {{ old('region', $excursion->region) == 'Северо-Западный' ? 'selected' : '' }}>Северо-Западный</option>
                        <option value="Южный" {{ old('region', $excursion->region) == 'Южный' ? 'selected' : '' }}>Южный</option>
                        <option value="Северо-Кавказский" {{ old('region', $excursion->region) == 'Северо-Кавказский' ? 'selected' : '' }}>Северо-Кавказский</option>
                        <option value="Приволжский" {{ old('region', $excursion->region) == 'Приволжский' ? 'selected' : '' }}>Приволжский</option>
                        <option value="Уральский" {{ old('region', $excursion->region) == 'Уральский' ? 'selected' : '' }}>Уральский</option>
                        <option value="Сибирский" {{ old('region', $excursion->region) == 'Сибирский' ? 'selected' : '' }}>Сибирский</option>
                        <option value="Дальневосточный" {{ old('region', $excursion->region) == 'Дальневосточный' ? 'selected' : '' }}>Дальневосточный</option>
                    </select>
                    @error('region')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="description">Описание <span class="required">*</span></label>
                <textarea id="description" name="description" class="form-control" rows="5" required>{{ old('description', $excursion->description) }}</textarea>
                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-row">
                <div class="form-group half">
                    <label for="audience_type">Тип аудитории <span class="required">*</span></label>
                    <select id="audience_type" name="audience_type" required class="form-control">
                        <option value="">Выберите тип аудитории</option>
                        <option value="preschool" {{ old('audience_type', $excursion->audience_type) == 'preschool' ? 'selected' : '' }}>Дошкольники</option>
                        <option value="school" {{ old('audience_type', $excursion->audience_type) == 'school' ? 'selected' : '' }}>Школьники</option>
                        <option value="adult" {{ old('audience_type', $excursion->audience_type) == 'adult' ? 'selected' : '' }}>Взрослые</option>
                        <option value="all" {{ old('audience_type', $excursion->audience_type) == 'all' ? 'selected' : '' }}>Для всех возрастов</option>
                    </select>
                    @error('audience_type')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group half">
                    <label for="duration">Продолжительность (часов) <span class="required">*</span></label>
                    <input type="number" id="duration" name="duration" value="{{ old('duration', $excursion->duration) }}" min="1" required class="form-control">
                    @error('duration')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group half">
                    <label for="min_age">Минимальный возраст</label>
                    <input type="number" id="min_age" name="min_age" value="{{ old('min_age', $excursion->min_age) }}" min="0" class="form-control">
                    @error('min_age')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group half">
                    <label for="max_age">Максимальный возраст</label>
                    <input type="number" id="max_age" name="max_age" value="{{ old('max_age', $excursion->max_age) }}" min="0" class="form-control">
                    @error('max_age')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group half">
                    <label for="price">Цена (₽) <span class="required">*</span></label>
                    <input type="number" id="price" name="price" value="{{ old('price', $excursion->price) }}" min="0" step="1" required class="form-control">
                    @error('price')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group half">
                    <label for="available_seats">Доступных мест</label>
                    <input type="number" id="available_seats" name="available_seats" value="{{ old('available_seats', $excursion->available_seats) }}" min="0" class="form-control">
                    @error('available_seats')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="features">Особенности экскурсии (каждая с новой строки)</label>
                <textarea id="features" name="features" class="form-control" rows="5">{{ old('features', is_array($excursion->features) ? implode("\n", $excursion->features) : '') }}</textarea>
                <small>Укажите особенности/включенные услуги экскурсии, каждую с новой строки</small>
                @error('features')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="image">Изображение</label>
                @if($excursion->image)
                <div class="current-image">
                    <p>Текущее изображение:</p>
                    <img src="{{ asset($excursion->image) }}" alt="{{ $excursion->name }}" class="excursion-image-preview">
                </div>
                @endif
                <div class="file-upload-wrapper">
                    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg" class="form-control">
                    <div class="file-upload-info">Поддерживаемые форматы: JPG, JPEG, PNG. Максимальный размер: 2MB. Оставьте пустым, чтобы сохранить текущее изображение.</div>
                </div>
                <!-- Контейнер для превью нового изображения -->
                <div class="image-preview-container" id="imagePreviewContainer">
                    <p>Превью нового изображения:</p>
                    <img id="imagePreview" src="" alt="Превью изображения">
                </div>
                @error('image')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-actions">
                <button type="submit" class="admin-btn">
                    <i class="fas fa-save"></i> Сохранить изменения
                </button>
                <a href="{{ route('admin.excursions.index') }}" class="admin-btn cancel-btn">Отмена</a>
            </div>
        </form>
    </div>
</div>
@endsection 