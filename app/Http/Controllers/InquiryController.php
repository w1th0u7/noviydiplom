<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InquiryController extends Controller
{
    /**
     * Обработчик создания новой заявки от пользователя.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Отладочная информация
        Log::info('Inquiry form submitted', [
            'data' => $request->all(),
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip()
        ]);

        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
            ]);

            // Создаем новую заявку (message не нужно, так как поле убрано из формы)
            $inquiry = Inquiry::create([
                'name' => $validatedData['name'],
                'phone' => $validatedData['phone'],
                'message' => null, // Всегда null, так как поле убрано
                'status' => 'new',
            ]);

            // Логирование успешного создания
            Log::info('New inquiry created successfully', [
                'inquiry_id' => $inquiry->id,
                'name' => $inquiry->name,
                'phone' => $inquiry->phone
            ]);

            // Проверяем тип запроса
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Спасибо за вашу заявку! Наш менеджер свяжется с вами в ближайшее время.'
                ]);
            }

            // Редирект с сообщением об успехе для обычных запросов
            return redirect()->back()->with('success', 'Спасибо за вашу заявку! Наш менеджер свяжется с вами в ближайшее время.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in inquiry form', [
                'errors' => $e->errors(),
                'data' => $request->all()
            ]);
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Пожалуйста, заполните все обязательные поля',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return redirect()->back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            Log::error('Error creating inquiry', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'data' => $request->all()
            ]);
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Произошла ошибка при отправке заявки. Пожалуйста, попробуйте еще раз.'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Произошла ошибка при отправке заявки. Пожалуйста, попробуйте еще раз.')->withInput();
        }
    }
}
