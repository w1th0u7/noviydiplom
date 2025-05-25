/**
 * Файл с функциями для исправления различных проблем в интерфейсе сайта
 *
 * Содержит функции для:
 * - Стандартизации размера иконки login на всех страницах
 * - Улучшения работы мобильного меню
 * - Исправления отображения в разных браузерах
 */

// Функция для исправления размеров иконки login на всех страницах
function fixLoginIconOnAllPages() {
  // Найти все SVG элементы внутри блоков с классом login
  const loginIcons = document.querySelectorAll(".login svg");

  // Применяем стили ко всем найденным элементам
  loginIcons.forEach(function (icon) {
    icon.style.width = "30px";
    icon.style.minWidth = "30px";
    icon.style.maxWidth = "30px";
    icon.style.height = "29px";
    icon.style.minHeight = "29px";
    icon.style.maxHeight = "29px";
    icon.style.display = "block";

    // Получаем родительский элемент (контейнер логина)
    const loginContainer = icon.closest(".login");
    if (loginContainer) {
      loginContainer.style.display = "flex";
      loginContainer.style.alignItems = "center";
      loginContainer.style.justifyContent = "center";

      // Находим текст внутри контейнера логина
      const loginText = loginContainer.querySelector("p");
      if (loginText) {
        loginText.style.fontSize = "12px";
        loginText.style.margin = "0";
        loginText.style.marginLeft = "4px";
      }
    }
  });
}

// Запускаем функции при загрузке DOM
document.addEventListener("DOMContentLoaded", function () {
  fixLoginIconOnAllPages();

  // Добавляем обработчики для гарантии правильного отображения
  window.addEventListener("resize", fixLoginIconOnAllPages);
  window.addEventListener("load", fixLoginIconOnAllPages);

  // Дополнительный запуск через небольшую задержку, на случай если что-то
  // не успело загрузиться к моменту DOMContentLoaded
  setTimeout(fixLoginIconOnAllPages, 500);
});

// Экспортируем функции для использования в других скриптах
if (typeof module !== "undefined" && typeof module.exports !== "undefined") {
  module.exports = {
    fixLoginIconOnAllPages,
  };
}
