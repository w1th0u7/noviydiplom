# Настройка хостинга для сайта rodinaa-tur.ru

## Необходимые настройки для корректного отображения изображений

1. **Символические ссылки на хостинге**

   Убедитесь, что на хостинге включена поддержка символических ссылок. Выполните команду:
   ```
   php artisan storage:link
   ```

2. **Права доступа к директориям**

   Установите необходимые права для директорий:
   ```
   chmod -R 755 public/
   chmod -R 755 storage/
   chmod -R 777 storage/app/public/
   chmod -R 777 storage/framework/
   chmod -R 777 storage/logs/
   ```

3. **Проверьте настройки .htaccess в директориях**

   Убедитесь, что файлы .htaccess настроены правильно в следующих директориях:
   - public/
   - public/storage/
   - public/storage/tours/

4. **Структура директорий для изображений**

   Создайте все необходимые директории для изображений:
   ```
   mkdir -p storage/app/public/tours
   mkdir -p storage/app/public/excursions
   ```

5. **Проверка отображения изображений**

   После загрузки изображений на хостинг убедитесь, что у них корректный URL, например:
   - `https://rodinaa-tur.ru/storage/tours/имя_файла.jpg`
   - `https://rodinaa-tur.ru/storage/excursions/имя_файла.jpg`

6. **Если изображения по-прежнему не отображаются**

   - Проверьте журналы ошибок хостинга
   - Убедитесь, что путь к изображениям в базе данных соответствует реальному расположению файлов
   - Проверьте, что файлы физически существуют на сервере

7. **Настройка APP_URL в .env**

   Убедитесь, что в файле .env указан правильный домен:
   ```
   APP_URL=https://rodinaa-tur.ru
   ```

## Полезные команды Laravel для отладки на хостинге

```
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:cache
``` 