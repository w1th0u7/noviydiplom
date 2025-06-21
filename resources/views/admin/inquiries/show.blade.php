@extends('layouts.admin')

@section('title', 'Детали заявки')

@section('header-title', 'Просмотр заявки #' . $inquiry->id)

@section('content')
<div class="admin-inquiry-show">
    <div class="admin-content-header">
        <h2>Заявка #{{ $inquiry->id }}</h2>
        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-primary">Назад к списку</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <span>Информация о заявке</span>
                <span class="badge badge-{{ $inquiry->status === 'new' ? 'danger' : ($inquiry->status === 'assigned' ? 'warning' : 'success') }}">
                    {{ $inquiry->getStatusText() }}
                </span>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th>Имя клиента:</th>
                                <td>{{ $inquiry->name }}</td>
                            </tr>
                            <tr>
                                <th>Телефон:</th>
                                <td>{{ $inquiry->phone }}</td>
                            </tr>
                            <tr>
                                <th>Сообщение:</th>
                                <td>{{ $inquiry->message ?? 'Не указано' }}</td>
                            </tr>
                            <tr>
                                <th>Статус:</th>
                                <td>{{ $inquiry->getStatusText() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th>Дата создания:</th>
                                <td>{{ $inquiry->created_at->format('d.m.Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Назначенный менеджер:</th>
                                <td>{{ $inquiry->assignedManager ? $inquiry->assignedManager->name : 'Не назначен' }}</td>
                            </tr>
                            <tr>
                                <th>Дата обработки:</th>
                                <td>{{ $inquiry->processed_at ? $inquiry->processed_at->format('d.m.Y H:i') : 'Не обработана' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <div>
                    @if($inquiry->isNew())
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#assignModal">
                        <i class="fas fa-user-tag"></i> Назначить менеджера
                    </button>
                    @endif
                    
                    @if($inquiry->isAssigned())
                    <form action="{{ route('admin.inquiries.mark-processed', $inquiry) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success" onclick="return confirm('Отметить заявку как обработанную?')">
                            <i class="fas fa-check"></i> Отметить как обработанную
                        </button>
                    </form>
                    @endif
                </div>
                
                <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить эту заявку?')">
                        <i class="fas fa-trash"></i> Удалить заявку
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Модальное окно для назначения менеджера -->
    <div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignModalLabel">Назначить заявку #{{ $inquiry->id }}</h5>
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
                                @foreach(App\Models\User::where('role', 'manager')->orWhere('role', 'admin')->get() as $manager)
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
</div>
@endsection 