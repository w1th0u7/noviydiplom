<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Tour;
use App\Models\Excursion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class BookingController extends Controller
{
    /**
     * Создание бронирования для тура
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bookTour(Request $request, $id)
    {

        
        // Проверка аутентификации
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Для бронирования тура необходимо авторизоваться');
        }
        try {
            // Используем блокировку транзакции для предотвращения конкурентных обращений
            return DB::transaction(function() use ($request, $id) {
                $tour = Tour::findOrFail($id);

                // Валидация данных
                $validator = Validator::make($request->all(), [
                    'booking_date' => 'required|date|after_or_equal:today',
                    'persons' => 'required|integer|min:1|max:' . $tour->available_seats,
                    'guest_name' => 'required|string|max:255',
                    'guest_email' => 'required|email|max:255',
                    'guest_phone' => 'required|string|max:20',
                    'notes' => 'nullable|string',
                ]);
                if ($validator->fails()) {

                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }
                

                // Проверяем доступность тура на выбранную дату
                if (!$tour->isAvailableOn($request->booking_date)) {
                    $message = 'К сожалению, тур недоступен на выбранную дату.';
                    
                    // Проверяем, что дата входит в период проведения тура
                    if ($tour->start_date && $tour->end_date) {
                        $tourStart = new \DateTime($tour->start_date);
                        $tourEnd = new \DateTime($tour->end_date);
                        $bookingDate = new \DateTime($request->booking_date);
                        
                        if ($bookingDate < $tourStart || $bookingDate > $tourEnd) {
                            $message = 'Выбранная дата находится вне периода проведения тура. Доступный период: ' 
                                . $tour->start_date->format('d.m.Y') . ' - ' . $tour->end_date->format('d.m.Y');
                        }
                    }
                    
                    return redirect()->back()
                        ->with('error', $message)
                        ->withInput();
                }
                
                // Рассчитываем общую стоимость
                $totalPrice = $tour->price * $request->persons;
                
                // Получаем данные пользователя
                $user = Auth::user();
                
                // Создаем объект бронирования
                $booking = new Booking();
                $booking->user_id = $user->id;
                $booking->guest_name = $request->guest_name;
                $booking->guest_email = $request->guest_email;
                $booking->guest_phone = $request->guest_phone;
                $booking->booking_date = $request->booking_date;
                $booking->persons = $request->persons;
                $booking->total_price = $totalPrice;
                $booking->status = 'pending';
                $booking->notes = $request->notes;
                
                // Устанавливаем полиморфные связи
                $booking->bookable_type = 'App\\Models\\Tour';
                $booking->bookable_id = $tour->id;
                
                // Сохраняем бронирование
                $booking->save();
                \Log::info("Бронирование создано: #{$booking->id}");
                
                // Создаём данные для уведомления
                $notification = [
                    'title' => 'Заявка успешно создана!',
                    'message' => 'В ближайшее время с Вами свяжется менеджер для уточнения деталей бронирования.'
                ];
                
                // Устанавливаем флеш-сообщения
                session()->flash('booking_notification', $notification);
                session()->flash('global_alert', 'Бронирование успешно создано! Скоро с вами свяжется менеджер.');
                
                // Редирект на страницу подтверждения
                return redirect()
                    ->route('bookings.confirmation', $booking->id)
                    ->with('success', 'Ваше бронирование успешно создано и ожидает подтверждения.');
            }, 5);
                
        } catch (\Exception $e) {
            \Log::error('Ошибка при создании бронирования: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Произошла ошибка при создании бронирования. Пожалуйста, попробуйте еще раз.')
                ->withInput();
        }
    }
    
    /**
     * Создание бронирования для экскурсии
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bookExcursion(Request $request, $id)
    {
        \Log::info("Начало процесса бронирования экскурсии с ID: {$id}");
        \Log::info("Данные запроса: " . json_encode($request->all()));
        
        try {
            $excursion = Excursion::findOrFail($id);
            \Log::info("Экскурсия найдена: {$excursion->name}");
            
            $validator = Validator::make($request->all(), [
                'booking_date' => 'required|date|after_or_equal:today',
                'persons' => 'required|integer|min:1|max:' . $excursion->available_seats,
                'guest_name' => 'required_without:user_id|string|max:255',
                'guest_email' => 'required|email|max:255',
                'guest_phone' => 'required|string|max:20',
                'notes' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                \Log::warning("Ошибка валидации при бронировании экскурсии: " . json_encode($validator->errors()->toArray()));
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            
            // Проверяем доступность экскурсии на выбранную дату
            if (!$excursion->isAvailableOn($request->booking_date)) {
                \Log::warning("Экскурсия недоступна на выбранную дату: {$request->booking_date}");
                
                // Проверяем причину недоступности
                $message = 'К сожалению, на выбранную дату нет свободных мест.';
                
                // Проверяем, что дата входит в период проведения экскурсии
                if ($excursion->start_date && $excursion->end_date) {
                    $excursionStart = new \DateTime($excursion->start_date);
                    $excursionEnd = new \DateTime($excursion->end_date);
                    $bookingDate = new \DateTime($request->booking_date);
                    
                    if ($bookingDate < $excursionStart || $bookingDate > $excursionEnd) {
                        $message = 'Выбранная дата находится вне периода проведения экскурсии. Доступный период: ' 
                            . $excursion->start_date->format('d.m.Y') . ' - ' . $excursion->end_date->format('d.m.Y');
                    }
                } else {
                    // Если даты экскурсии не установлены, сообщаем администратору
                    \Log::error("Экскурсия #{$excursion->id} '{$excursion->name}' не имеет установленных дат начала и окончания");
                    $message = 'Для этой экскурсии не установлен период проведения. Пожалуйста, обратитесь к администратору.';
                }
                
                return redirect()->back()
                    ->with('error', $message)
                    ->withInput();
            }
            
            \Log::info("Начало транзакции для бронирования экскурсии");
            DB::beginTransaction();
            
            // Рассчитываем общую стоимость
            $totalPrice = $excursion->price * $request->persons;
            
            // Получаем данные пользователя
            $user = Auth::user();
            \Log::info("Пользователь: {$user->name} (ID: {$user->id})");
            
            // Создаем объект бронирования вручную
            $booking = new Booking();
            $booking->user_id = $user->id;
            $booking->guest_name = $request->guest_name ?? $user->name;
            $booking->guest_email = $request->guest_email ?? $user->email;
            $booking->guest_phone = $request->guest_phone;
            $booking->booking_date = $request->booking_date;
            $booking->persons = $request->persons;
            $booking->total_price = $totalPrice;
            $booking->status = 'pending';
            $booking->notes = $request->notes;
            
            // Устанавливаем полиморфные связи напрямую
            $booking->bookable_type = 'App\\Models\\Excursion';
            $booking->bookable_id = $excursion->id;
            
            \Log::info("Попытка сохранения бронирования экскурсии");
            $booking->save();
            
            // Проверяем, что бронирование сохранено и доступно через связь
            $freshBooking = Booking::with('bookable')->find($booking->id);
            if ($freshBooking && $freshBooking->bookable) {
                \Log::info("Проверка полиморфной связи успешна для бронирования #{$booking->id}");
            } else {
                \Log::warning("Проблема с полиморфной связью для бронирования #{$booking->id}");
                if ($freshBooking) {
                    \Log::warning("bookable_type: {$freshBooking->bookable_type}, bookable_id: {$freshBooking->bookable_id}");
                }
            }
            
            DB::commit();
            \Log::info("Бронирование экскурсии успешно сохранено с ID: {$booking->id}");
            
            // Создаём данные для уведомления
            $notification = [
                'title' => 'Заявка успешно создана!',
                'message' => 'В ближайшее время с Вами свяжется менеджер для уточнения деталей бронирования и подтверждения паспортных данных.'
            ];
            
            // Используем flash() для глобального доступа к уведомлению
            session()->flash('booking_notification', $notification);
            session()->flash('global_alert', 'Бронирование успешно создано! Скоро с вами свяжется менеджер.');
            
            // Логируем для отладки
            \Log::info("Перенаправление на страницу подтверждения, ID бронирования: {$booking->id}");
            
            // Возвращаем редирект с данными уведомления
            return redirect()
                ->route('bookings.confirmation', $booking->id)
                ->with('booking_notification', $notification)
                ->with('success', 'Ваше бронирование успешно создано и ожидает подтверждения.');
                
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Ошибка при создании бронирования экскурсии: ' . $e->getMessage());
            \Log::error('Стек вызовов: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Произошла ошибка при создании бронирования. Пожалуйста, попробуйте еще раз.')
                ->withInput();
        }
    }
    
    /**
     * Показать страницу подтверждения бронирования
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirmation($id)
    {
        try {
            $booking = Booking::with('bookable')->findOrFail($id);
            
            // Проверяем, что бронирование существует и у него есть связанный объект
            if (!$booking || !$booking->bookable) {
                return redirect()->route('home')
                    ->with('error', 'Бронирование не найдено или было удалено.');
            }
            
            // Жёстко устанавливаем уведомление, если оно не пришло через сессию
            if (!session()->has('booking_notification')) {
                session()->flash('booking_notification', [
                    'title' => 'Заявка успешно создана!',
                    'message' => 'В ближайшее время с Вами свяжется менеджер для уточнения деталей бронирования и подтверждения паспортных данных.'
                ]);
            }
            
            return view('bookings.confirmation', compact('booking'));
            
        } catch (\Exception $e) {
            \Log::error('Ошибка при отображении бронирования: ' . $e->getMessage());
            return redirect()->route('home')
                ->with('error', 'Произошла ошибка при загрузке информации о бронировании.');
        }
    }
    
    /**
     * Показать список бронирований пользователя
     *
     * @return \Illuminate\Http\Response
     */
    public function myBookings()
    {
        try {
            // Получаем ID текущего пользователя
            $userId = Auth::id();
            
            // Логируем для отладки с подробной информацией
            \Log::info("Загрузка бронирований для пользователя с ID: {$userId}");
            
            // Проверяем наличие бронирований в базе данных для этого пользователя
            $count = DB::table('bookings')->where('user_id', $userId)->count();
            \Log::info("Количество бронирований в базе данных: {$count}");
            
            // Получаем все бронирования пользователя с помощью Query Builder
            $rawBookings = DB::table('bookings')
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();
                
            \Log::info("Полученные бронирования через Query Builder: " . json_encode($rawBookings));
            
            // Улучшенный запрос для получения бронирований через Eloquent без предзагрузки полиморфных связей
            $bookings = Booking::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            
            // Проверка наличия бронирований
            \Log::info("Количество бронирований через Eloquent: " . $bookings->count());
            
            // Логируем объекты бронирований для отладки
            foreach ($bookings as $index => $booking) {
                \Log::info("Бронирование #{$index}: ID={$booking->id}, user_id={$booking->user_id}, bookable_type={$booking->bookable_type}, bookable_id={$booking->bookable_id}");
                // Проверяем связанный объект только для валидных типов
                if ($booking->bookable_type && class_exists($booking->bookable_type)) {
                    \Log::info("Имеется ли связанный объект: " . ($booking->bookable ? 'Да' : 'Нет'));
                } else {
                    \Log::info("Бронирование из калькулятора или недопустимый тип");
                }
            }
            
            // Возвращаем представление с данными о бронированиях
            return view('cabinet.trips', compact('bookings'));
        } catch (\Exception $e) {
            \Log::error('Ошибка при загрузке бронирований: ' . $e->getMessage());
            \Log::error('Стек вызовов: ' . $e->getTraceAsString());
            
            return view('cabinet.trips', ['bookings' => collect([])])
                ->with('error', 'Произошла ошибка при загрузке ваших бронирований. Пожалуйста, попробуйте позже.');
        }
    }
    
    /**
     * Отменить бронирование
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        
        // Проверяем, принадлежит ли бронирование текущему пользователю
        if ($booking->user_id != Auth::id()) {
            return redirect()->back()
                ->with('error', 'У вас нет прав для отмены этого бронирования.');
        }
        
        // Проверяем, можно ли отменить бронирование
        if ($booking->status == 'cancelled' || $booking->status == 'completed') {
            return redirect()->back()
                ->with('error', 'Это бронирование нельзя отменить.');
        }
        
        $booking->cancel();
        
        // Редирект на страницу личных бронирований с сообщением об успехе
        return redirect()->route('trips')
            ->with('success', 'Бронирование успешно отменено.');
    }

    /**
     * Тестовое бронирование через GET-запрос для отладки
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function testBookTour(Request $request)
    {
        \Log::info("Тестовое бронирование через GET", $request->all());
        
        try {
            // Находим тур по ID
            $tourId = $request->input('tour_id');
            $tour = Tour::findOrFail($tourId);
            
            // Создаем объект бронирования
            $booking = new Booking();
            $booking->user_id = Auth::id();
            $booking->guest_name = $request->input('guest_name', Auth::user()->name);
            $booking->guest_email = $request->input('guest_email', Auth::user()->email);
            $booking->guest_phone = $request->input('guest_phone', '79001234567');
            $booking->booking_date = $request->input('booking_date', now()->format('Y-m-d'));
            $booking->persons = $request->input('persons', 1);
            $booking->total_price = $tour->price * $booking->persons;
            $booking->status = 'pending';
            $booking->notes = $request->input('notes', 'Тестовое бронирование через GET');
            
            // Устанавливаем полиморфные связи
            $booking->bookable_type = 'App\\Models\\Tour';
            $booking->bookable_id = $tour->id;
            
            // Сохраняем бронирование
            $booking->save();
            \Log::info("Тестовое бронирование создано: #{$booking->id}");
            
            // Устанавливаем флеш-сообщения
            session()->flash('global_alert', 'Тестовое бронирование успешно создано! (ID: ' . $booking->id . ')');
            
            // Редирект на страницу подтверждения
            return redirect()
                ->route('bookings.confirmation', $booking->id)
                ->with('success', 'Тестовое бронирование успешно создано.');
                
        } catch (\Exception $e) {
            \Log::error('Ошибка при тестовом бронировании: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Произошла ошибка при тестовом бронировании: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Создание бронирования через калькулятор туров
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bookFromCalculator(Request $request)
    {
        // Простое логирование для отладки
        file_put_contents(storage_path('logs/calculator_debug.log'), 
            date('Y-m-d H:i:s') . " - Метод bookFromCalculator вызван\n", FILE_APPEND);
        file_put_contents(storage_path('logs/calculator_debug.log'), 
            date('Y-m-d H:i:s') . " - Данные: " . json_encode($request->all()) . "\n", FILE_APPEND);
        
        \Log::info("Начало процесса бронирования через калькулятор");
        \Log::info("Данные запроса: " . json_encode($request->all()));
        
        try {
            file_put_contents(storage_path('logs/calculator_debug.log'), 
                date('Y-m-d H:i:s') . " - Начало валидации\n", FILE_APPEND);
                
            // Валидация данных
            $validator = Validator::make($request->all(), [
                'booking_date' => 'required|date|after_or_equal:today',
                'persons' => 'required|integer|min:1|max:10',
                'guest_name' => 'required|string|max:255',
                'guest_email' => 'required|email|max:255',
                'guest_phone' => 'required|string|max:20',
                'total_price' => 'required|numeric|min:0',
                'special_requests' => 'nullable|string|max:1000',
                'calculator_data' => 'nullable|string',
                'calculator_country' => 'nullable|string|max:255',
                'calculator_resort' => 'nullable|string|max:255',
                'calculator_tour_type' => 'nullable|string|max:255',
                'calculator_hotel_class' => 'nullable|string|max:255',
                'calculator_meal' => 'nullable|string|max:255',
                'calculator_nights' => 'nullable|integer|min:1|max:30',
            ]);

            if ($validator->fails()) {
                file_put_contents(storage_path('logs/calculator_debug.log'), 
                    date('Y-m-d H:i:s') . " - ОШИБКА валидации: " . json_encode($validator->errors()->toArray()) . "\n", FILE_APPEND);
                \Log::warning("Ошибка валидации при бронировании через калькулятор: " . json_encode($validator->errors()->toArray()));
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            
            file_put_contents(storage_path('logs/calculator_debug.log'), 
                date('Y-m-d H:i:s') . " - Валидация прошла успешно\n", FILE_APPEND);
            
            DB::beginTransaction();
            file_put_contents(storage_path('logs/calculator_debug.log'), 
                date('Y-m-d H:i:s') . " - Начата транзакция\n", FILE_APPEND);
            
            // Получаем данные пользователя
            $user = Auth::user();
            file_put_contents(storage_path('logs/calculator_debug.log'), 
                date('Y-m-d H:i:s') . " - Пользователь: " . ($user ? $user->name . " (ID: {$user->id})" : 'НЕ АВТОРИЗОВАН') . "\n", FILE_APPEND);
            
            // Создаем объект бронирования
            $booking = new Booking();
            
            // Устанавливаем user_id в зависимости от наличия пользователя
            $booking->user_id = $user ? $user->id : null;
            $booking->guest_name = $request->guest_name;
            $booking->guest_email = $request->guest_email;
            $booking->guest_phone = $request->guest_phone;
            $booking->booking_date = $request->booking_date;
            $booking->persons = $request->persons;
            $booking->total_price = $request->total_price;
            $booking->status = 'pending';
            $booking->notes = $request->special_requests;
            
            // Для бронирований через калькулятор используем null для полиморфных связей
            $booking->bookable_type = null;
            $booking->bookable_id = null;
            
            // Сохраняем данные калькулятора
            $booking->calculator_data = $request->calculator_data;
            $booking->calculator_country = $request->calculator_country;
            $booking->calculator_resort = $request->calculator_resort;
            $booking->calculator_tour_type = $request->calculator_tour_type;
            $booking->calculator_hotel_class = $request->calculator_hotel_class;
            $booking->calculator_meal = $request->calculator_meal;
            $booking->calculator_nights = $request->calculator_nights;
            
            file_put_contents(storage_path('logs/calculator_debug.log'), 
                date('Y-m-d H:i:s') . " - Модель бронирования создана, пытаемся сохранить\n", FILE_APPEND);
            
            // Сохраняем бронирование
            $booking->save();
            file_put_contents(storage_path('logs/calculator_debug.log'), 
                date('Y-m-d H:i:s') . " - Бронирование сохранено с ID: {$booking->id}\n", FILE_APPEND);
            \Log::info("Бронирование через калькулятор создано: #{$booking->id}");
            
            DB::commit();
            file_put_contents(storage_path('logs/calculator_debug.log'), 
                date('Y-m-d H:i:s') . " - Транзакция подтверждена\n", FILE_APPEND);
            
            // Создаём данные для уведомления
            $notification = [
                'title' => 'Заявка успешно создана!',
                'message' => 'Ваш расчет сохранен. В ближайшее время с Вами свяжется менеджер для уточнения деталей поездки.'
            ];
            
            // Устанавливаем флеш-сообщения
            session()->flash('booking_notification', $notification);
            session()->flash('global_alert', 'Заявка успешно отправлена! Скоро с вами свяжется менеджер.');
            
            file_put_contents(storage_path('logs/calculator_debug.log'), 
                date('Y-m-d H:i:s') . " - Сессии установлены, готовимся к редиректу\n", FILE_APPEND);
            
            // Редирект обратно на калькулятор с сообщением об успехе
            return redirect()
                ->route('calculate')
                ->with('success', 'Ваша заявка успешно создана и ожидает обработки менеджером.')
                ->with('booking_notification', $notification);
                
        } catch (\Exception $e) {
            DB::rollback();
            file_put_contents(storage_path('logs/calculator_debug.log'), 
                date('Y-m-d H:i:s') . " - ИСКЛЮЧЕНИЕ: " . $e->getMessage() . "\n", FILE_APPEND);
            file_put_contents(storage_path('logs/calculator_debug.log'), 
                date('Y-m-d H:i:s') . " - Стек: " . $e->getTraceAsString() . "\n", FILE_APPEND);
            \Log::error('Ошибка при создании бронирования через калькулятор: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Произошла ошибка при создании заявки. Пожалуйста, попробуйте еще раз.')
                ->withInput();
        }
    }
}
