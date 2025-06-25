@extends('layouts.admin')

@section('title', 'Управление пользователями')

@section('header-title', 'Управление пользователями')

@section('content')
<div class="admin-users">
    <div class="admin-content-header">
        <h2>Список пользователей</h2>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Роль</th>
                    <th>Дата регистрации</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="role-badge {{ $user->role === 'admin' ? 'admin-badge' : 'user-badge' }}">
                            {{ $user->role === 'admin' ? 'Администратор' : 'Пользователь' }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                    <td class="actions">
                        <form action="{{ route('admin.users.toggle-role', $user) }}" method="POST" class="toggle-role-form" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            @if($user->role === 'admin')
                                <button type="submit" class="role-btn" title="Сделать пользователем">
                                    <i class="fas fa-user"></i>
                                </button>
                            @else
                                <button type="submit" class="role-btn" title="Сделать администратором">
                                    <i class="fas fa-user-shield"></i>
                                </button>
                            @endif
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="empty-table">Пользователи не найдены.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container">
        {{ $users->links('vendor.pagination.admin') }}
    </div>
</div>
@endsection 