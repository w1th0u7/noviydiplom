#!/bin/bash

set -e

echo "🚀 Начинаем развертывание..."

# Сброс всех локальных изменений
echo "📥 Сброс локальных изменений..."
git reset --hard

# Переключение на main ветку
echo "🔄 Переключение на main ветку..."
git checkout main

# Получение последних изменений
echo "⬇️ Загрузка изменений из GitHub..."
git pull origin main

# Установка зависимостей
echo "📦 Обновление зависимостей..."
php8.2 composer.phar install --no-dev --optimize-autoloader

# Запуск миграций
echo "🗄️ Выполнение миграций..."
php8.2 artisan migrate --force

# Создание таблиц кеша если их нет
echo "🗃️ Проверка таблиц кеша..."
php8.2 artisan cache:table --quiet || echo "Таблицы кеша уже существуют"

# Очистка всех кешей
echo "🧹 Очистка кеша..."
php8.2 artisan cache:clear
php8.2 artisan config:clear
php8.2 artisan view:clear
php8.2 artisan route:clear
php8.2 artisan event:clear

# Пересоздание кешей для продакшена
echo "⚡ Создание кеша для продакшена..."
php8.2 artisan config:cache
php8.2 artisan view:cache
php8.2 artisan route:cache
php8.2 artisan event:cache

echo "✅ Развертывание завершено успешно!"
echo "🎉 Сайт обновлен и готов к работе!"

