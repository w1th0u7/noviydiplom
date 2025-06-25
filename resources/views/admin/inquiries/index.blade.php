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
                            <th>Статус</th>
                            <th>Дата создания</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inquiries as $inquiry)
                        <tr>
                            <td>{{ $inquiry->id }}</td>
                            <td><strong>{{ $inquiry->name }}</strong></td>
                            <td><a href="tel:{{ $inquiry->phone }}" class="text-primary">{{ $inquiry->phone }}</a></td>
                            <td>
                                <span class="badge badge-{{ $inquiry->status === 'new' ? 'danger' : 'success' }} inquiry-status">
                                    {{ $inquiry->status === 'new' ? 'Новая' : 'Обработана' }}
                                </span>
                            </td>
                            <td>{{ $inquiry->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <div class="btn-group inquiry-actions">
                                    <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="btn btn-sm btn-info" title="Просмотреть">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($inquiry->status === 'new')
                                    <form action="{{ route('admin.inquiries.mark-processed', $inquiry) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Отметить как обработанную?')" title="Отметить как обработанную">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены, что хотите удалить эту заявку?')" title="Удалить">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Заявок не найдено</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="pagination-wrapper">
                {{ $inquiries->appends(request()->query())->links('vendor.pagination.admin') }}
            </div>
        </div>
    </div>
</div>
@endsection 