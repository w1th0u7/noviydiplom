@extends('layouts.admin')

@section('title', 'Заявки')

@section('header-title', 'Управление заявками')

@section('content')
<div class="admin-inquiries">
    <div class="admin-content-header">
        <h2>Заявки клиентов</h2>
        <p>Здесь вы можете просматривать и управлять заявками, поступающими от пользователей.</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="inquiry-filters mb-4">
        <form action="{{ route('admin.inquiries.index') }}" method="get" class="form-inline">
            <div class="row">
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">Все статусы</option>
                        <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>Новые</option>
                        <option value="assigned" {{ request('status') === 'assigned' ? 'selected' : '' }}>Назначенные</option>
                        <option value="processed" {{ request('status') === 'processed' ? 'selected' : '' }}>Обработанные</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Фильтр</button>
                    <a href="{{ route('admin.inquiries.index') }}" class="btn btn-secondary ml-2">Сбросить</a>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Телефон</th>
                            <th>Сообщение</th>
                            <th>Статус</th>
                            <th>Менеджер</th>
                            <th>Дата создания</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inquiries as $inquiry)
                        <tr>
                            <td>{{ $inquiry->id }}</td>
                            <td>{{ $inquiry->name }}</td>
                            <td>{{ $inquiry->phone }}</td>
                            <td>{{ Str::limit($inquiry->message, 30) }}</td>
                            <td>
                                <span class="badge badge-{{ $inquiry->status === 'new' ? 'danger' : ($inquiry->status === 'assigned' ? 'warning' : 'success') }}">
                                    {{ $inquiry->getStatusText() }}
                                </span>
                            </td>
                            <td>{{ $inquiry->assignedManager ? $inquiry->assignedManager->name : 'Не назначен' }}</td>
                            <td>{{ $inquiry->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($inquiry->isNew())
                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#assignModal{{ $inquiry->id }}">
                                        <i class="fas fa-user-tag"></i>
                                    </button>
                                    @endif
                                    
                                    @if($inquiry->isAssigned())
                                    <form action="{{ route('admin.inquiries.mark-processed', $inquiry) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Отметить как обработанную?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены, что хотите удалить эту заявку?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- Модальное окно для назначения менеджера -->
                                <div class="modal fade" id="assignModal{{ $inquiry->id }}" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel{{ $inquiry->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="assignModalLabel{{ $inquiry->id }}">Назначить заявку #{{ $inquiry->id }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('admin.inquiries.assign', $inquiry) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="manager_id">Выберите менеджера</label>
                                                        <select name="manager_id" id="manager_id" class="form-control" required>
                                                            <option value="">-- Выберите менеджера --</option>
                                                            @foreach($managers as $manager)
                                                            <option value="{{ $manager->id }}">{{ $manager->name }} ({{ $manager->email }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                                    <button type="submit" class="btn btn-primary">Назначить</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Заявок не найдено</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="pagination-wrapper">
                {{ $inquiries->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 