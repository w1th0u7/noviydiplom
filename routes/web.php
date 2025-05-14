<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController; // Убедитесь, что импортировали нужный контроллер
use App\Http\Controllers\UserController; // Убедитесь, что импортировали нужный контроллер
use App\Http\Controllers\CalculateController; // Убедитесь, что импортировали нужный контроллер
use App\Http\Controllers\TourController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLink']);
Route::post('password/reset', [ResetPasswordController::class, 'reset']);




// Главная страница с турами
Route::get('/', [TourController::class, 'index'])->name('home');

// Страница калькулятора
Route::get('/calculate', function () {
    return view('calculate');
})->name('calculate');

//  Группа маршрутов для авторизации (можно выделить в AuthController)
// Отображение формы входа
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');

// Обработка отправки формы входа
Route::post('/login', [UserController::class, 'login'])->name('login.post');

// Отображение формы регистрации
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');

// Обработка отправки формы регистрации
Route::post('/register', [UserController::class, 'register'])->name('register.post');

// Дополнительный маршрут для отображения альтернативной формы входа
Route::get('/login2', function() {
    return view('login2');
})->name('login2');

// Выход пользователя
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Дополнительные маршруты для восстановления пароля (если необходимо)
Route::get('/password/reset', [UserController::class, 'showResetForm'])->name('password.request');
Route::post('/password/email', [UserController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [UserController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [UserController::class, 'reset'])->name('password.update');
Route::post('/logout', [UserController::class, 'logout'])->name('logout'); // Маршрут для выхода

//  Группа маршрутов для административной панели (требует аутентификации и прав администратора)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/adminpanel', [AdminController::class, 'index'])->name('admin.adminpanel');
    //  Здесь добавьте другие маршруты для администрирования (создание, редактирование, удаление и т.д.)
    //  Пример:
    // Route::get('/admin/tours', [AdminController::class, 'tours'])->name('admin.tours');
    // Route::post('/admin/tours/create', [AdminController::class, 'createTour'])->name('admin.tours.create');
});


Route::group(['middleware' => ['web']], function () {
    Route::get('/tours/all', [TourController::class, 'showAll'])->name('tours.all');
    Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
    Route::get('/tours/{tour}', [TourController::class, 'show'])->name('tours.show');
    Route::get('/load-more-tours', [TourController::class, 'loadMoreTours'])->name('load.more.tours');
});
// Маршрут для расписания
Route::get('/schedule', function () {
    return view('index'); // Убедитесь, что имя представления указано правильно
})->name('schedule');


// Маршрут для хит сезона
Route::get('/hits', function () {
    return view('index'); // Замените на ваш обработчик
})->name('hits');

// Маршрут для контактов
Route::get('/contacts', function () {
    return view('index'); // Замените на ваш обработчик
})->name('contacts');

// Маршрут для экскурсий
Route::get('/excursions', function () {
    return view('index'); // Замените на ваш обработчик
})->name('excursions');

// Маршрут для туристов
Route::get('/tourists', function () {
    return view('index'); // Замените на ваш обработчик
})->name('tourists');

// Маршрут для горящих туров
Route::get('/lastminute', function () {
    return view('index'); // Замените на ваш обработчик
})->name('lastminute');
