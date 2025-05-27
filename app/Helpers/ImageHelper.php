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
    public static function getImageUrl($imagePath, $defaultImage = 'tours/placeholder.jpg')
    {
        if (!$imagePath) {
            return asset('storage/' . $defaultImage);
        }
        
        if (str_starts_with($imagePath, 'img/')) {
            return asset($imagePath);
        }
        
        if (str_starts_with($imagePath, 'http')) {
            return $imagePath;
        }
        
        return asset('storage/' . $imagePath);
    }
} 