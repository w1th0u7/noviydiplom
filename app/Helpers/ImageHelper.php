<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Получает URL изображения в зависимости от типа пути
     * 
     * @param string|null $imagePath Путь к изображению
     * @param string $defaultImage Путь к изображению по умолчанию
     * @return string URL изображения
     */
    public static function getImageUrl($imagePath, $defaultImage = 'img/tours/placeholder.jpg')
    {
        // Если путь пустой, возвращаем изображение по умолчанию
        if (!$imagePath) {
            return asset($defaultImage);
        }
        
        // Если путь начинается с http, это внешняя ссылка
        if (str_starts_with($imagePath, 'http')) {
            return $imagePath;
        }
        
        // Если путь не содержит 'img/', но содержит 'excursions/', добавляем 'img/'
        if (!str_starts_with($imagePath, 'img/') && str_starts_with($imagePath, 'excursions/')) {
            return asset('img/' . $imagePath);
        }
        
        // Если путь не содержит 'img/excursions/', но это имя файла без пути
        if (!str_starts_with($imagePath, 'img/') && !str_contains($imagePath, '/')) {
            return asset('img/excursions/' . $imagePath);
        }
        
        // Для всех остальных случаев используем asset как есть
        return asset($imagePath);
    }
} 