@extends('layouts.admin')

@section('title', 'Заказы')

@section('header-title', 'Управление заказами')

@section('content')
<div class="admin-orders">
    <div class="admin-content-header">
        <h2>Заказы клиентов</h2>
    </div>

    <div class="admin-under-development">
        <div class="development-icon">
            <i class="fas fa-tools"></i>
        </div>
        <h3>Раздел в разработке</h3>
        <p>Функционал управления заказами находится в разработке и будет доступен в следующем обновлении.</p>
        <p>В этом разделе вы сможете отслеживать все заказы клиентов, изменять их статус и управлять бронированиями.</p>
    </div>
</div>

<style>
    .admin-under-development {
        text-align: center;
        padding: 50px 20px;
        background-color: #fff;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .development-icon {
        font-size: 4rem;
        color: var(--admin-primary);
        margin-bottom: 20px;
    }
    
    .admin-under-development h3 {
        color: var(--admin-text);
        margin-bottom: 15px;
    }
    
    .admin-under-development p {
        color: #777;
        max-width: 600px;
        margin: 10px auto;
    }
</style>
@endsection 