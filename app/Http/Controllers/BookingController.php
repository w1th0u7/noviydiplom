<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Tour;
use App\Models\Excursion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
        $tour = Tour::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'booking_date' => 'required|date|after_or_equal:today',
            'persons' => 'required|integer|min:1|max:' . $tour->available_seats,
            'guest_name' => 'required_without:user_id|string|max:255',
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
            return redirect()->back()
                ->with('error', 'К сожалению, на выбранную дату нет свободных мест.')
                ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            // Рассчитываем общую стоимость
            $totalPrice = $tour->price * $request->persons;
            
            // Получаем данные пользователя
            $user = Auth::user();
            
            // Создаем бронирование
            $booking = new Booking([
                'user_id' => $user->id, // Явно указываем ID пользователя
                'guest_name' => $request->guest_name ?? $user->name,
                'guest_email' => $request->guest_email ?? $user->email,
                'guest_phone' => $request->guest_phone,
                'booking_date' => $request->booking_date,
                'persons' => $request->persons,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'notes' => $request->notes,
            ]);
            
            // Сохраняем сначала бронирование
            $booking->save();
            
            // Затем привязываем к туру через полиморфную связь
            $booking->bookable()->associate($tour);
            $booking->save();
            
            DB::commit();
            
            // Создаём данные для уведомления
            $notification = [
                'title' => 'Заявка успешно создана!',
                'message' => 'В ближайшее время с Вами свяжется менеджер для уточнения деталей бронирования и подтверждения паспортных данных.'
            ];
            
            // Используем flash() для глобального доступа к уведомлению
            session()->flash('booking_notification', $notification);
            session()->flash('global_alert', 'Бронирование успешно создано! Скоро с вами свяжется менеджер.');
            
            // Возвращаем редирект с данными уведомления (дублируем для надежности)
            return redirect()
                ->route('bookings.confirmation', $booking->id)
                ->with('booking_notification', $notification)
                ->with('success', 'Ваше бронирование успешно создано и ожидает подтверждения.');
                
        } catch (\Exception $e) {
            DB::rollback();
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
        $excursion = Excursion::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'booking_date' => 'required|date|after_or_equal:today',
            'persons' => 'required|integer|min:1|max:' . $excursion->available_seats,
            'guest_name' => 'required_without:user_id|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:20',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Проверяем доступность экскурсии на выбранную дату
        if (!$excursion->isAvailableOn($request->booking_date)) {
            return redirect()->back()
                ->with('error', 'К сожалению, на выбранную дату нет свободных мест.')
                ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            // Рассчитываем общую стоимость
            $totalPrice = $excursion->price * $request->persons;
            
            // Получаем данные пользователя
            $user = Auth::user();
            
            // Создаем бронирование
            $booking = new Booking([
                'user_id' => $user->id, // Явно указываем ID пользователя
                'guest_name' => $request->guest_name ?? $user->name,
                'guest_email' => $request->guest_email ?? $user->email,
                'guest_phone' => $request->guest_phone,
                'booking_date' => $request->booking_date,
                'persons' => $request->persons,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'notes' => $request->notes,
            ]);
            
            // Сохраняем сначала бронирование
            $booking->save();
            
            // Затем привязываем к экскурсии через полиморфную связь
            $booking->bookable()->associate($excursion);
            $booking->save();
            
            DB::commit();
            
            // Создаём данные для уведомления
            $notification = [
                'title' => 'Заявка успешно создана!',
                'message' => 'В ближайшее время с Вами свяжется менеджер для уточнения деталей бронирования и подтверждения паспортных данных.'
            ];
            
            // Используем flash() для глобального доступа к уведомлению
            session()->flash('booking_notification', $notification);
            session()->flash('global_alert', 'Бронирование успешно создано! Скоро с вами свяжется менеджер.');
            
            // Возвращаем редирект с данными уведомления (дублируем для надежности)
            return redirect()
                ->route('bookings.confirmation', $booking->id)
                ->with('booking_notification', $notification)
                ->with('success', 'Ваше бронирование успешно создано и ожидает подтверждения.');
                
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Ошибка при создании бронирования: ' . $e->getMessage());
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
            
            // Логируем для отладки
            \Log::info("Загрузка бронирований для пользователя с ID: {$userId}");
            
            // Проверка наличия бронирований для пользователя
            $hasBookings = DB::table('bookings')->where('user_id', $userId)->exists();
            \Log::info("Наличие бронирований: " . ($hasBookings ? 'Да' : 'Нет'));
            
            if (!$hasBookings) {
                // Если бронирований нет, возвращаем пустую коллекцию
                return view('cabinet.trips', ['bookings' => collect([])]);
            }
            
            // Получаем все бронирования пользователя с присоединением связанных моделей
            $bookings = Booking::where('user_id', $userId)
                ->with('bookable')  // Подгружаем связанные сущности
                ->orderBy('booking_date', 'desc')  // Сначала показываем ближайшие бронирования
                ->orderBy('created_at', 'desc')
                ->paginate(10);
                
            // Логируем для отладки количество найденных бронирований
            \Log::info("Найдено бронирований: " . $bookings->count());
            
            // Возвращаем шаблон trips из папки cabinet
            return view('cabinet.trips', compact('bookings'));
            
        } catch (\Exception $e) {
            \Log::error('Ошибка при загрузке бронирований: ' . $e->getMessage());
            return view('cabinet.trips', ['bookings' => collect([])]);
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
}
