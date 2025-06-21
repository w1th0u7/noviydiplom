# 🚀 Настройка автоматического развертывания на Beget

## 📋 Что это дает:

- Автоматическое обновление сайта при каждом push в GitHub
- Автоматическая очистка и пересоздание всех кешей Laravel
- Запуск миграций
- Обновление зависимостей Composer
- Логирование всех операций

## ⚙️ Настройка согласно рекомендациям техподдержки Beget:

### 1️⃣ Файлы готовы

- ✅ `deploy.php` - в корне сайта (добавлен в .gitignore)
- ✅ `deploy.sh` - основной скрипт развертывания
- ✅ Токен: `e8d71c9020c83aab24ed23b41a982f05`

### 2️⃣ SSH ключ (если требуется)

Если для доступа к репозиторию нужен ключ:

```bash
# Поместите SSH ключ в:
~/.ssh/id_rsa

# Установите права:
chmod 0700 ~/.ssh/
chmod 0700 ~/.ssh/id_rsa
```

### 3️⃣ Настройка webhook в GitHub

1. Репозиторий: https://github.com/w1th0u7/noviydiplom
2. **Settings** → **Webhooks** → **Add webhook**
3. **Payload URL:** `https://rodinaa-tur.ru/deploy.php?e8d71c9020c83aab24ed23b41a982f05`
4. **Content type:** `application/json`
5. **Events:** "Just the push event"
6. **Active:** ✅

### 4️⃣ Проверка работы

Откройте: `https://rodinaa-tur.ru/deploy.php?e8d71c9020c83aab24ed23b41a982f05`

Должно появиться: **"✅ OK - Deploy successful"**

## 🔧 Что происходит при развертывании:

1. **🔄 Git операции:**

   - `git reset --hard` - сброс локальных изменений
   - `git checkout main` - переключение на main
   - `git pull origin main` - загрузка изменений

2. **📦 Зависимости:**

   - `composer install --no-dev --optimize-autoloader`

3. **🗄️ База данных:**

   - `php artisan migrate --force`
   - `php artisan cache:table` - создание таблиц кеша

4. **🧹 Очистка кеша:**

   - `cache:clear`, `config:clear`, `view:clear`
   - `route:clear`, `event:clear`

5. **⚡ Создание продакшн кеша:**
   - `config:cache`, `view:cache`
   - `route:cache`, `event:cache`

## 📝 Логи

Логи сохраняются в `deploy.log` в корне проекта

## 🎯 Особенности для Beget:

- ✅ `deploy.php` в корне (не в public/)
- ✅ Поддержка GET и POST запросов
- ✅ Автоматическая установка прав на `deploy.sh`
- ✅ Подробное логирование
- ✅ Обработка ошибок

## 🔐 Безопасность:

- `deploy.php` добавлен в `.gitignore` (не попадет в репозиторий)
- Токен проверяется для GET и POST запросов
- Логирование IP адресов

После настройки все ваши изменения будут автоматически применяться на сайте! 🎉
