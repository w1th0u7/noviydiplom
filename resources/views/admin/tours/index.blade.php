@extends('layouts.admin')

@section('title', 'Управление турами')

@section('header-title', 'Управление турами')

@section('content')
<div class="admin-tours">
    <div class="admin-content-header">
        <h2>Список туров</h2>
        <a href="{{ route('admin.tours.create') }}" class="admin-btn">
            <i class="fas fa-plus"></i> Добавить тур
        </a>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Изображение</th>
                    <th>Название</th>
                    <th>Тип</th>
                    <th>Даты</th>
                    <th>Продолжительность</th>
                    <th>Мест</th>
                    <th>Цена</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tours as $tour)
                <tr>
                    <td>{{ $tour->id }}</td>
                    <td>
                        @if($tour->image)
                            <img src="{{ asset($tour->image) }}" alt="{{ $tour->name }}" class="tour-thumbnail">
                        @else
                            <span class="no-image">Нет изображения</span>
                        @endif
                    </td>
                    <td>{{ $tour->name }}</td>
                    <td>{{ $tour->type ?? 'Не указан' }}</td>
                    <td>
                        @if($tour->start_date && $tour->end_date)
                            {{ $tour->start_date->format('d.m.Y') }} - {{ $tour->end_date->format('d.m.Y') }}
                        @else
                            {{ $tour->data ? $tour->data->format('d.m.Y') : 'Не указана' }}
                        @endif
                    </td>
                    <td>{{ $tour->duration ? $tour->duration_text : 'Не указана' }}</td>
                    <td>{{ $tour->available_seats }}</td>
                    <td>{{ number_format($tour->price, 0, ',', ' ') }} ₽</td>
                    <td class="actions">
                        <a href="{{ route('admin.tours.edit', $tour) }}" class="edit-btn" title="Редактировать">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.tours.destroy', $tour) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn" title="Удалить" onclick="return confirm('Вы уверены, что хотите удалить этот тур?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="empty-table">Туры не найдены. <a href="{{ route('admin.tours.create') }}">Добавить первый тур</a></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container">
        {{ $tours->links() }}
    </div>
</div>
@endsection 