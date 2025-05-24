<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\TourController;
use App\Http\Controllers\TourCalculatorController;
use App\Http\Controllers\BookingController;
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


Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');


Route::post('/login', [UserController::class, 'login'])->name('login.post');


Route::get('/login2', function() {
    return view('login2');
})->name('login2');


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
    Route::get('/tours', [\App\Http\Controllers\Admin\ToursController::class, 'index'])->name('tours.index');
    Route::get('/', [\App\Http\Controllers\Admin\ToursController::class, 'index'])->name('tours');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/orders', [\App\Http\Controllers\AdminController::class, 'orders'])->name('orders');
    Route::get('/settings', [\App\Http\Controllers\AdminController::class, 'settings'])->name('settings');
    
    
    Route::resource('tours', \App\Http\Controllers\Admin\ToursController::class)->except(['show', 'index']);
    
    
    Route::get('/excursions', [\App\Http\Controllers\Admin\ExcursionsController::class, 'index'])->name('excursions.index');
    Route::get('/excursions/create', [\App\Http\Controllers\Admin\ExcursionsController::class, 'create'])->name('excursions.create');
    Route::post('/excursions', [\App\Http\Controllers\Admin\ExcursionsController::class, 'store'])->name('excursions.store');
    Route::get('/excursions/{excursion}/edit', [\App\Http\Controllers\Admin\ExcursionsController::class, 'edit'])->name('excursions.edit');
    Route::put('/excursions/{excursion}', [\App\Http\Controllers\Admin\ExcursionsController::class, 'update'])->name('excursions.update');
    Route::delete('/excursions/{excursion}', [\App\Http\Controllers\Admin\ExcursionsController::class, 'destroy'])->name('excursions.destroy');
    
    // Маршрут для переключения роли пользователя
    Route::patch('/users/{user}/toggle-role', [\App\Http\Controllers\AdminController::class, 'toggleUserRole'])->name('users.toggle-role');
    
    // Маршруты для настроек (заглушки)
    Route::put('/settings', [\App\Http\Controllers\AdminController::class, 'updateSettings'])->name('settings.update');
    Route::post('/settings/backup', [\App\Http\Controllers\AdminController::class, 'createBackup'])->name('settings.backup');
    Route::put('/settings/seo', [\App\Http\Controllers\AdminController::class, 'updateSeoSettings'])->name('settings.update-seo');
    
    // Маршруты для управления бронированиями
    Route::get('/bookings', [\App\Http\Controllers\Admin\BookingsController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [\App\Http\Controllers\Admin\BookingsController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{id}/confirm', [\App\Http\Controllers\Admin\BookingsController::class, 'confirm'])->name('bookings.confirm');
    Route::post('/bookings/{id}/cancel', [\App\Http\Controllers\Admin\BookingsController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/bookings/{id}/complete', [\App\Http\Controllers\Admin\BookingsController::class, 'complete'])->name('bookings.complete');
    Route::delete('/bookings/{id}', [\App\Http\Controllers\Admin\BookingsController::class, 'destroy'])->name('bookings.destroy');
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
    Route::get('/cabinet/trips', [BookingController::class, 'myBookings'])->name('trips');
    Route::get('/cabinet/settings', [App\Http\Controllers\CabinetController::class, 'settings'])->name('settings');
    Route::put('/cabinet/settings', [App\Http\Controllers\CabinetController::class, 'updateSettings'])->name('settings.update');
});

// Маршрут для расписания туров
Route::get('/schedule', [App\Http\Controllers\ScheduleController::class, 'index'])->name('schedule');

// Маршрут для хит сезона
Route::get('/hits', function () {
    return view('index'); 
})->name('hits');

// Маршрут для контактов
Route::get('/contacts', [App\Http\Controllers\ContactsController::class, 'index'])->name('contacts');

// Маршрут для экскурсий
Route::get('/excursions', [App\Http\Controllers\ExcursionsController::class, 'index'])->name('excursions');
Route::get('/excursions/preschool', [App\Http\Controllers\ExcursionsController::class, 'preschool'])->name('excursions.preschool');
Route::get('/excursions/school', [App\Http\Controllers\ExcursionsController::class, 'school'])->name('excursions.school');
Route::get('/excursions/adult', [App\Http\Controllers\ExcursionsController::class, 'adult'])->name('excursions.adult');
Route::get('/excursions/{id}', [App\Http\Controllers\ExcursionsController::class, 'show'])->name('excursions.show');

// Маршрут для туристов
Route::get('/tourists', [App\Http\Controllers\TouristInfoController::class, 'index'])->name('tourists');

// Маршрут для горящих туров
Route::get('/lastminute', function () {
    return view('index'); // Замените на ваш обработчик
})->name('lastminute');

// Маршруты для калькулятора туров
Route::get('/calculate', [TourCalculatorController::class, 'index'])->name('calculate');
Route::post('/calculate/get-resorts', [TourCalculatorController::class, 'getResorts'])->name('calculate.getResorts');
Route::post('/calculate/get-hotels', [TourCalculatorController::class, 'getHotels'])->name('calculate.getHotels');
Route::post('/calculate/price', [TourCalculatorController::class, 'calculate'])->name('calculate.price');

// Маршруты для бронирования
Route::middleware(['auth'])->group(function () {
    // Маршруты требующие авторизации
    Route::post('/tours/{id}/book', [BookingController::class, 'bookTour'])->name('tours.book');
    Route::post('/excursions/{id}/book', [BookingController::class, 'bookExcursion'])->name('excursions.book');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my');
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

// Маршруты для бронирования (общедоступные)
Route::get('/bookings/confirmation/{id}', [BookingController::class, 'confirmation'])->name('bookings.confirmation');

// Добавляем маршрут для тестовой страницы
Route::get('/test-css', function () {
    return view('test');
});



