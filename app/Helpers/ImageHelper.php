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
        
        // Если путь начинается с http, это внешняя ссылка
        if (str_starts_with($imagePath, 'http')) {
            return $imagePath;
        }
        
        // Для всех остальных случаев используем asset
        return asset($imagePath);
    }
} 