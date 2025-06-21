<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Http\Request;

class InquiriesController extends Controller
{
    /**
     * Отображает список всех заявок
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Получаем заявки с менеджерами и пагинацией
        $inquiries = Inquiry::with('assignedManager')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Получаем список менеджеров для назначения
        $managers = User::where('role', 'manager')->orWhere('role', 'admin')->get();

        return view('admin.inquiries.index', compact('inquiries', 'managers'));
    }

    /**
     * Назначает заявку менеджеру
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inquiry  $inquiry
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assign(Request $request, Inquiry $inquiry)
    {
        $validatedData = $request->validate([
            'manager_id' => 'required|exists:users,id',
        ]);

        $manager = User::findOrFail($validatedData['manager_id']);
        $inquiry->assignTo($manager);

        return redirect()->route('admin.inquiries.index')
            ->with('success', "Заявка №{$inquiry->id} назначена менеджеру {$manager->name}");
    }

    /**
     * Отмечает заявку как обработанную.
     *
     * @param  \App\Models\Inquiry  $inquiry
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markProcessed(Inquiry $inquiry)
    {
        $inquiry->markAsProcessed();

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
