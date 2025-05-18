@extends('layouts.admin')

@section('title', 'Редактирование тура')

@section('header-title', 'Редактирование тура')

@section('content')
<div class="admin-edit-tour">
    <div class="admin-content-header">
        <h2>Редактирование тура "{{ $tour->name }}"</h2>
        <a href="{{ route('admin.tours') }}" class="admin-btn secondary-btn">
            <i class="fas fa-arrow-left"></i> Вернуться к списку
        </a>
    </div>

    <div class="admin-form-container">
        <form action="{{ route('admin.tours.update', $tour) }}" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Название тура <span class="required">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $tour->name) }}" required class="form-control">
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="description">Описание</label>
                <textarea id="description" name="description" class="form-control">{{ old('description', $tour->description) }}</textarea>
                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-row">
                <div class="form-group half">
                    <label for="season">Сезон <span class="required">*</span></label>
                    <select id="season" name="season" required class="form-control">
                        <option value="">Выберите сезон</option>
                        <option value="Лето" {{ old('season', $tour->season) == 'Лето' ? 'selected' : '' }}>Лето</option>
                        <option value="Осень" {{ old('season', $tour->season) == 'Осень' ? 'selected' : '' }}>Осень</option>
                        <option value="Зима" {{ old('season', $tour->season) == 'Зима' ? 'selected' : '' }}>Зима</option>
                        <option value="Весна" {{ old('season', $tour->season) == 'Весна' ? 'selected' : '' }}>Весна</option>
                        <option value="Круглый год" {{ old('season', $tour->season) == 'Круглый год' ? 'selected' : '' }}>Круглый год</option>
                    </select>
                    @error('season')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group half">
                    <label for="data">Дата <span class="required">*</span></label>
                    <input type="date" id="data" name="data" value="{{ old('data', $tour->data) }}" required class="form-control">
                    @error('data')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="price">Цена (₽) <span class="required">*</span></label>
                <input type="number" id="price" name="price" value="{{ old('price', $tour->price) }}" min="0" step="1" required class="form-control">
                @error('price')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="image">Изображение</label>
                @if($tour->image)
                <div class="current-image">
                    <p>Текущее изображение:</p>
                    <img src="{{ asset('storage/' . $tour->image) }}" alt="{{ $tour->name }}" class="tour-image-preview">
                </div>
                @endif
                <div class="file-upload-wrapper">
                    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg" class="form-control">
                    <div class="file-upload-info">Поддерживаемые форматы: JPG, JPEG, PNG. Максимальный размер: 2MB. Оставьте пустым, чтобы сохранить текущее изображение.</div>
                </div>
                @error('image')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-actions">
                <button type="submit" class="admin-btn">
                    <i class="fas fa-save"></i> Сохранить изменения
                </button>
                <a href="{{ route('admin.tours') }}" class="admin-btn cancel-btn">Отмена</a>
            </div>
        </form>
    </div>
</div>
@endsection 