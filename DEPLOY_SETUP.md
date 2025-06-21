# 🚀 Настройка автоматического развертывания с deploy.sh

## 📋 Что это дает:

- Автоматическое обновление сайта при каждом push в GitHub
- Автоматическая очистка и пересоздание всех кешей Laravel
- Запуск миграций
- Обновление зависимостей Composer
- Логирование всех операций

## ⚙️ Настройка:

### 1️⃣ Файлы уже готовы

У вас есть:

- `deploy.sh` - основной скрипт развертывания (улучшен)
- `public/webhook.php` - веб-интерфейс для запуска deploy.sh

### 2️⃣ Измените секретный токен

В файле `public/webhook.php` измените строку:

```php
$secret = 'your_secret_token_here';
```

На свой уникальный токен (например: `my_super_secret_2025_token`)

### 3️⃣ Сделайте deploy.sh исполняемым

Через SSH или панель хостинга выполните:

```bash
chmod +x deploy.sh
```

### 4️⃣ Настройте webhook в GitHub

1. Перейдите в репозиторий: https://github.com/w1th0u7/noviydiplom
2. **Settings** → **Webhooks** → **Add webhook**
3. Заполните:
   - **Payload URL:** `https://rodinaa-tur.ru/webhook.php?token=ВАШ_ТОКЕН`
   - **Content type:** `application/json`
   - **Events:** "Just the push event"
   - **Active:** ✅

### 5️⃣ Проверьте работу

1. Запустите вручную: `https://rodinaa-tur.ru/webhook.php?token=ВАШ_ТОКЕН`
2. Должно появиться: "✅ OK - Deploy successful"

## 🔧 Что происходит при развертывании:

1. **🔄 Git операции:**

   - `git reset --hard` - сброс локальных изменений
   - `git checkout main` - переключение на main
   - `git pull origin main` - загрузка изменений

2. **📦 Зависимости:**

   - `composer install --no-dev --optimize-autoloader`

3. **🗄️ База данных:**

   - `php artisan migrate --force`

4. **🧹 Очистка кеша:**

   - `cache:clear`, `config:clear`, `view:clear`
   - `route:clear`, `event:clear`

5. **⚡ Создание продакшн кеша:**
   - `config:cache`, `view:cache`
   - `route:cache`, `event:cache`

## 📝 Логи

Логи сохраняются в `deploy.log` в корне проекта

## 🎯 Преимущества этого подхода:

- ✅ Использует существующий `deploy.sh`
- ✅ Полная очистка кеша решает проблемы обновления
- ✅ Автоматический запуск миграций
- ✅ Оптимизация для продакшена
- ✅ Подробное логирование

После настройки все ваши изменения будут автоматически применяться на сайте! 🎉
