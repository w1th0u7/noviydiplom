<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    /**
     * Показать список всех бронирований
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = Booking::with(['bookable', 'user'])
            ->orderBy('booking_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Показать детали бронирования
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking = Booking::with('bookable', 'user')->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Подтвердить бронирование
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->confirm();
        
        return redirect()->back()
            ->with('success', 'Бронирование успешно подтверждено.');
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
        $booking->cancel();
        
        return redirect()->back()
            ->with('success', 'Бронирование успешно отменено.');
    }

    /**
     * Отметить бронирование как завершенное
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function complete($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->complete();
        
        return redirect()->back()
            ->with('success', 'Бронирование отмечено как завершенное.');
    }
    
    /**
     * Удалить бронирование
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Бронирование успешно удалено.');
    }
}
