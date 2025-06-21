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
                <span class="badge badge-{{ $inquiry->status === 'new' ? 'danger' : 'success' }} inquiry-status">
                    {{ $inquiry->status === 'new' ? 'Новая' : 'Обработана' }}
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
                                <td><a href="tel:{{ $inquiry->phone }}" class="phone-link">{{ $inquiry->phone }}</a></td>
                            </tr>
                            <tr>
                                <th>Статус:</th>
                                <td>{{ $inquiry->status === 'new' ? 'Новая' : 'Обработана' }}</td>
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
                    @if($inquiry->status === 'new')
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

</div>
@endsection 