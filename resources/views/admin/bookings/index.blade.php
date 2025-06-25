@extends('layouts.admin')

@section('title', 'Управление бронированиями')

@section('header-title', 'Управление бронированиями')

@section('content')
<div class="admin-bookings">
    <div class="admin-content-header">
        <h2>Список бронирований</h2>
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
                    <th>Тип</th>
                    <th>Название</th>
                    <th>Клиент</th>
                    <th>Дата бронирования</th>
                    <th>Человек</th>
                    <th>Сумма</th>
                    <th>Статус</th>
                    <th>Создано</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>
                        @if($booking->bookable_type == 'App\Models\Tour')
                            <span class="badge tour">Тур</span>
                        @elseif($booking->bookable_type == 'App\Models\Excursion')
                            <span class="badge excursion">Экскурсия</span>
                        @endif
                    </td>
                    <td>
                        @if($booking->bookable)
                            {{ $booking->bookable->name }}
                        @else
                            <span class="no-data">Удалено</span>
                        @endif
                    </td>
                    <td>
                        <div>{{ $booking->guest_name }}</div>
                        <div class="small-text">{{ $booking->guest_email }}</div>
                        <div class="small-text">{{ $booking->guest_phone }}</div>
                        @if($booking->user)
                            <div class="user-badge">
                                <i class="fas fa-user"></i> ID: {{ $booking->user->id }}
                            </div>
                        @endif
                    </td>
                    <td>{{ $booking->booking_date->format('d.m.Y') }}</td>
                    <td>{{ $booking->persons }}</td>
                    <td>{{ number_format($booking->total_price, 0, ',', ' ') }} ₽</td>
                    <td>
                        @switch($booking->status)
                            @case('pending')
                                <span class="badge pending">Ожидает</span>
                                @break
                            @case('confirmed')
                                <span class="badge confirmed">Подтверждено</span>
                                @break
                            @case('cancelled')
                                <span class="badge cancelled">Отменено</span>
                                @break
                            @case('completed')
                                <span class="badge completed">Завершено</span>
                                @break
                            @default
                                <span class="badge">{{ $booking->status }}</span>
                        @endswitch
                    </td>
                    <td>{{ $booking->created_at->format('d.m.Y H:i') }}</td>
                    <td class="actions">
                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="view-btn" title="Просмотреть">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        @if($booking->status == 'pending')
                            <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST" class="action-form">
                                @csrf
                                <button type="submit" class="confirm-btn" title="Подтвердить">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                        @endif
                        
                        @if($booking->status == 'pending' || $booking->status == 'confirmed')
                            <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" class="action-form">
                                @csrf
                                <button type="submit" class="cancel-btn" title="Отменить" onclick="return confirm('Вы уверены, что хотите отменить бронирование?')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        @endif
                        
                        @if($booking->status == 'confirmed')
                            <form action="{{ route('admin.bookings.complete', $booking->id) }}" method="POST" class="action-form">
                                @csrf
                                <button type="submit" class="complete-btn" title="Завершить" onclick="return confirm('Отметить бронирование как завершенное?')">
                                    <i class="fas fa-check-double"></i>
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="action-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn" title="Удалить" onclick="return confirm('Вы уверены, что хотите удалить это бронирование?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="empty-table">Бронирования не найдены.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container">
        {{ $bookings->links('vendor.pagination.admin') }}
    </div>
</div>

<style>
    .badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        text-align: center;
        color: white;
    }
    
    .badge.tour {
        background-color: #007bff;
    }
    
    .badge.excursion {
        background-color: #6f42c1;
    }
    
    .badge.pending {
        background-color: #ffc107;
        color: #212529;
    }
    
    .badge.confirmed {
        background-color: #28a745;
    }
    
    .badge.cancelled {
        background-color: #dc3545;
    }
    
    .badge.completed {
        background-color: #6c757d;
    }
    
    .small-text {
        font-size: 12px;
        color: #6c757d;
    }
    
    .no-data {
        color: #dc3545;
        font-style: italic;
    }
    
    .action-form {
        display: inline-block;
        margin: 0 2px;
    }
    
    .confirm-btn, .cancel-btn, .complete-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
    }
    
    .confirm-btn i {
        color: #28a745;
    }
    
    .cancel-btn i {
        color: #dc3545;
    }
    
    .complete-btn i {
        color: #6f42c1;
    }
    
    .user-badge {
        display: inline-block;
        margin-top: 5px;
        padding: 2px 6px;
        background-color: #17a2b8;
        color: white;
        border-radius: 3px;
        font-size: 11px;
        font-weight: bold;
    }
</style>
@endsection 