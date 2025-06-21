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
        if (!$imagePath) {
            return asset($defaultImage);
        }
        
        if (str_starts_with($imagePath, 'img/')) {
            return asset($imagePath);
        }
        
        if (str_starts_with($imagePath, 'http')) {
            return $imagePath;
        }
        
        // Перенаправляем пути из storage в img
        if (str_starts_with($imagePath, 'tours/') || str_starts_with($imagePath, 'excursions/')) {
            return asset('img/' . $imagePath);
        }
        
        return asset('img/' . $imagePath);
    }
} 