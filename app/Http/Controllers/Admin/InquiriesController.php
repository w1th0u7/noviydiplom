<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiriesController extends Controller
{
    /**
     * Отображает список всех заявок
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Inquiry::query();

        // Фильтрация по статусу
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Получаем заявки с пагинацией
        $inquiries = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.inquiries.index', compact('inquiries'));
    }



    /**
     * Отмечает заявку как обработанную.
     *
     * @param  \App\Models\Inquiry  $inquiry
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markProcessed(Inquiry $inquiry)
    {
        $inquiry->update([
            'status' => 'processed',
            'processed_at' => now()
        ]);

        return redirect()->route('admin.inquiries.index')
            ->with('success', "Заявка №{$inquiry->id} отмечена как обработанная");
    }

    /**
     * Отображает детали заявки.
     *
     * @param  \App\Models\Inquiry  $inquiry
     * @return \Illuminate\View\View
     */
    public function show(Inquiry $inquiry)
    {
        return view('admin.inquiries.show', compact('inquiry'));
    }

    /**
     * Удаляет заявку.
     *
     * @param  \App\Models\Inquiry  $inquiry
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')
            ->with('success', "Заявка №{$inquiry->id} удалена");
    }
}
