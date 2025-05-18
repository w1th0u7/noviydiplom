<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\TourController;
use App\Http\Controllers\TourCalculatorController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Auth;

Route::post('register', [RegisterController::class, 'register']);
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLink']);
Route::post('password/reset', [ResetPasswordController::class, 'reset']);

// Маршрут для отображения формы регистрации
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

Route::get('/', [TourController::class, 'index'])->name('home');

// Маршрут для калькулятора теперь определен ниже

//  Группа маршрутов для авторизации (можно выделить в AuthController)
// Отображение формы входа
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');

// Обработка отправки формы входа
Route::post('/login', [UserController::class, 'login'])->name('login.post');

// Дополнительный маршрут для отображения альтернативной формы входа
Route::get('/login2', function() {
    return view('login2');
})->name('login2');

// Выход пользователя - POST маршрут
Route::post('/logout', function() {
    // Сбрасываем API токен
    $user = Auth::user();
    if ($user) {
        $user->api_token = null;
        $user->save();
    }
    
    Auth::logout();
    
    return redirect()->route('home');
})->name('logout');

// Дополнительные маршруты для восстановления пароля (если необходимо)
Route::get('/password/reset', [UserController::class, 'showResetForm'])->name('password.request');
Route::post('/password/email', [UserController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [UserController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [UserController::class, 'reset'])->name('password.update');

//  Группа маршрутов для административной панели (требует аутентификации и прав администратора)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Главная страница админ-панели (добавлено)
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('index');
    
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/tours', [\App\Http\Controllers\AdminController::class, 'tours'])->name('tours');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/orders', [\App\Http\Controllers\AdminController::class, 'orders'])->name('orders');
    Route::get('/settings', [\App\Http\Controllers\AdminController::class, 'settings'])->name('settings');
    
    // Маршруты для CRUD операций с турами
    Route::get('/tours/create', [\App\Http\Controllers\AdminController::class, 'createTour'])->name('tours.create');
    Route::post('/tours', [\App\Http\Controllers\AdminController::class, 'storeTour'])->name('tours.store');
    Route::get('/tours/{tour}/edit', [\App\Http\Controllers\AdminController::class, 'editTour'])->name('tours.edit');
    Route::put('/tours/{tour}', [\App\Http\Controllers\AdminController::class, 'updateTour'])->name('tours.update');
    Route::delete('/tours/{tour}', [\App\Http\Controllers\AdminController::class, 'destroyTour'])->name('tours.destroy');
    
    // Маршрут для переключения роли пользователя
    Route::patch('/users/{user}/toggle-role', [\App\Http\Controllers\AdminController::class, 'toggleUserRole'])->name('users.toggle-role');
    
    // Маршруты для настроек (заглушки)
    Route::put('/settings', [\App\Http\Controllers\AdminController::class, 'updateSettings'])->name('settings.update');
    Route::post('/settings/backup', [\App\Http\Controllers\AdminController::class, 'createBackup'])->name('settings.backup');
    Route::put('/settings/seo', [\App\Http\Controllers\AdminController::class, 'updateSeoSettings'])->name('settings.update-seo');
});

Route::group(['middleware' => ['web']], function () {
    Route::get('/tours/all', [TourController::class, 'showAll'])->name('tours.all');
    Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
    Route::get('/tours/{tour}', [TourController::class, 'show'])->name('tours.show');
    Route::get('/load-more-tours', [TourController::class, 'loadMoreTours'])->name('load.more.tours');
});

// Маршруты для личного кабинета
Route::middleware(['auth'])->group(function () {
    Route::get('/cabinet', [App\Http\Controllers\CabinetController::class, 'index'])->name('cabinet');
    Route::get('/cabinet/trips', [App\Http\Controllers\CabinetController::class, 'trips'])->name('trips');
    Route::get('/cabinet/settings', [App\Http\Controllers\CabinetController::class, 'settings'])->name('settings');
    Route::put('/cabinet/settings', [App\Http\Controllers\CabinetController::class, 'updateSettings'])->name('settings.update');
});

// Маршрут для расписания
Route::get('/schedule', function () {
    return view('index'); 
})->name('schedule');


// Маршрут для хит сезона
Route::get('/hits', function () {
    return view('index'); 
})->name('hits');

// Маршрут для контактов
Route::get('/contacts', function () {
    return view('index'); 
})->name('contacts');

// Маршрут для экскурсий
Route::get('/excursions', function () {
    return view('index'); 
})->name('excursions');

// Маршрут для туристов
Route::get('/tourists', function () {
    return view('index'); // Замените на ваш обработчик
})->name('tourists');

// Маршрут для горящих туров
Route::get('/lastminute', function () {
    return view('index'); // Замените на ваш обработчик
})->name('lastminute');

// Маршруты для калькулятора туров
Route::get('/calculate', [TourCalculatorController::class, 'index'])->name('calculate');
Route::post('/calculate/get-resorts', [TourCalculatorController::class, 'getResorts'])->name('calculate.getResorts');
Route::post('/calculate/get-hotels', [TourCalculatorController::class, 'getHotels'])->name('calculate.getHotels');
Route::post('/calculate/price', [TourCalculatorController::class, 'calculate'])->name('calculate.price');



