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
        // Улучшенное логирование для отладки
        \Log::info("=== НАЧАЛО ЗАПРОСА НА БРОНИРОВАНИЕ ТУРА #{$id} ===");
        \Log::info("Метод запроса: " . $request->method());
        \Log::info("URL запроса: " . $request->fullUrl());
        \Log::info("Все входящие данные: " . json_encode($request->all()));
        \Log::info("Заголовки запроса: " . json_encode($request->headers->all()));
        
        // Проверка аутентификации
        if (!Auth::check()) {
            \Log::warning("Пользователь не авторизован");
            return redirect()->route('login')
                ->with('error', 'Для бронирования тура необходимо авторизоваться');
        }
        
        \Log::info("Пользователь авторизован: " . Auth::id() . " (" . Auth::user()->email . ")");
        
        try {
            // Используем блокировку транзакции для предотвращения конкурентных обращений
            return DB::transaction(function() use ($request, $id) {
                $tour = Tour::findOrFail($id);
                \Log::info("Тур найден: #{$tour->id} - {$tour->name}");
                
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
                    \Log::warning("Ошибка валидации: " . json_encode($validator->errors()->toArray()));
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }
                
                \Log::info("Валидация пройдена успешно");
                
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
            
            // Улучшенный запрос для получения бронирований через Eloquent
            $bookings = Booking::where('user_id', $userId)
                ->with('bookable') // Загружаем связанные модели
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            
            // Проверка наличия бронирований
            \Log::info("Количество бронирований через Eloquent: " . $bookings->count());
            
            // Логируем объекты бронирований для отладки
            foreach ($bookings as $index => $booking) {
                \Log::info("Бронирование #{$index}: ID={$booking->id}, user_id={$booking->user_id}, bookable_type={$booking->bookable_type}, bookable_id={$booking->bookable_id}");
                \Log::info("Имеется ли связанный объект: " . ($booking->bookable ? 'Да' : 'Нет'));
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
}
