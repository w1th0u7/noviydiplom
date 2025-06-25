@extends('layouts.admin')

@section('title', 'Управление экскурсиями')

@section('header-title', 'Управление экскурсиями')

@section('content')
<div class="admin-excursions">
    <div class="admin-content-header">
        <h2>Список экскурсий</h2>
        <a href="{{ route('admin.excursions.create') }}" class="admin-btn">
            <i class="fas fa-plus"></i> Добавить экскурсию
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Изображение</th>
                    <th>Название</th>
                    <th>Локация</th>
                    <th>Аудитория</th>
                    <th>Продолжительность</th>
                    <th>Мест</th>
                    <th>Цена</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($excursions as $excursion)
                <tr>
                    <td>{{ $excursion->id }}</td>
                    <td>
                        @if($excursion->image)
                            <img src="{{ \App\Helpers\ImageHelper::getImageUrl($excursion->image) }}" alt="{{ $excursion->name }}" class="excursion-thumbnail">
                        @else
                            <span class="no-image">Нет изображения</span>
                        @endif
                    </td>
                    <td>{{ $excursion->name }}</td>
                    <td>{{ $excursion->location }}</td>
                    <td>
                        @switch($excursion->audience_type)
                            @case('preschool')
                                <span class="badge preschool">Дошкольники</span>
                                @break
                            @case('school')
                                <span class="badge school">Школьники</span>
                                @break
                            @case('adult')
                                <span class="badge adult">Взрослые</span>
                                @break
                            @case('all')
                                <span class="badge all">Для всех</span>
                                @break
                            @default
                                <span class="badge">{{ $excursion->audience_type }}</span>
                        @endswitch
                    </td>
                    <td>{{ $excursion->duration }} {{ trans_choice('час|часа|часов', $excursion->duration) }}</td>
                    <td>{{ $excursion->available_seats }}</td>
                    <td>{{ number_format($excursion->price, 0, ',', ' ') }} ₽</td>
                    <td class="actions">
                        <a href="{{ route('admin.excursions.edit', $excursion) }}" class="edit-btn" title="Редактировать">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.excursions.destroy', $excursion) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn" title="Удалить" onclick="return confirm('Вы уверены, что хотите удалить эту экскурсию?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="empty-table">Экскурсии не найдены. <a href="{{ route('admin.excursions.create') }}">Добавить первую экскурсию</a></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container">
        {{ $excursions->links('vendor.pagination.admin') }}
    </div>
</div>
@endsection 