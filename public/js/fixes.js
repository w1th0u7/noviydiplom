/**
 * Файл с функциями для исправления различных проблем в интерфейсе сайта
 *
 * Содержит функции для:
 * - Стандартизации размера иконки login на всех страницах
 * - Улучшения работы мобильного меню
 * - Исправления отображения в разных браузерах
 * - Исправления работы слайдера видов туров
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

// Функция для исправления отображения слайдера видов туров
function fixTourTypesSlider() {
  // Находим все слайдеры видов туров
  const tourTypesSliders = document.querySelectorAll(".vidy-turov .swiper");

  if (tourTypesSliders.length === 0) {
    console.log("Слайдер видов туров не найден");
    return;
  }

  // Перебираем найденные слайдеры
  tourTypesSliders.forEach(function (slider) {
    // Находим все слайды
    const slides = slider.querySelectorAll(".swiper-slide");

    // Проверяем наличие слайдов
    if (slides.length === 0) {
      console.log("Слайды не найдены в слайдере видов туров");
      return;
    }

    // Проверяем видимость слайдов
    slides.forEach(function (slide, index) {
      // Убеждаемся, что слайды видны
      slide.style.display = "block";
      slide.style.opacity = "1";
      slide.style.visibility = "visible";

      // Задаем правильные размеры и отступы
      if (window.innerWidth > 767) {
        slide.style.width = "370px";
        slide.style.marginRight = "30px";
      } else {
        slide.style.width = "280px";
        slide.style.marginRight = "20px";
      }
    });

    // Проверяем работу навигации
    const nextButton = slider.parentElement.querySelector(
      ".swiper-button-next"
    );
    const prevButton = slider.parentElement.querySelector(
      ".swiper-button-prev"
    );

    if (nextButton) {
      nextButton.style.opacity = "1";
      nextButton.style.visibility = "visible";
      // Обновляем обработчик событий для кнопки "Следующий"
      nextButton.addEventListener("click", function () {
        // Получаем текущее смещение
        const wrapper = slider.querySelector(".swiper-wrapper");
        if (!wrapper) return;

        const currentTransform =
          wrapper.style.transform || "translate3d(0px, 0px, 0px)";
        const currentX = parseInt(
          currentTransform.match(/translate3d\((-?\d+)px/)?.[1] || 0
        );

        // Вычисляем новое смещение (смещаем на ширину слайда + отступ)
        const slideWidth = window.innerWidth > 767 ? 370 : 280;
        const slideMargin = window.innerWidth > 767 ? 30 : 20;
        const newX = currentX - (slideWidth + slideMargin);

        // Вычисляем максимальное смещение (чтобы не уходило дальше последнего слайда)
        const maxOffset = -(slideWidth + slideMargin) * (slides.length - 1);

        // Применяем новое смещение, но не больше максимального
        const finalX = Math.max(newX, maxOffset);
        wrapper.style.transform = `translate3d(${finalX}px, 0px, 0px)`;

        // Обновляем состояние кнопок
        prevButton.classList.remove("swiper-button-disabled");
        if (finalX <= maxOffset) {
          nextButton.classList.add("swiper-button-disabled");
        }
      });
    }

    if (prevButton) {
      // Изначально кнопка "Предыдущий" должна быть отключена, если мы на первом слайде
      prevButton.classList.add("swiper-button-disabled");

      // Обновляем обработчик событий для кнопки "Предыдущий"
      prevButton.addEventListener("click", function () {
        // Получаем текущее смещение
        const wrapper = slider.querySelector(".swiper-wrapper");
        if (!wrapper) return;

        const currentTransform =
          wrapper.style.transform || "translate3d(0px, 0px, 0px)";
        const currentX = parseInt(
          currentTransform.match(/translate3d\((-?\d+)px/)?.[1] || 0
        );

        // Вычисляем новое смещение (смещаем на ширину слайда + отступ в обратную сторону)
        const slideWidth = window.innerWidth > 767 ? 370 : 280;
        const slideMargin = window.innerWidth > 767 ? 30 : 20;
        const newX = currentX + (slideWidth + slideMargin);

        // Применяем новое смещение, но не больше 0 (начальная позиция)
        const finalX = Math.min(newX, 0);
        wrapper.style.transform = `translate3d(${finalX}px, 0px, 0px)`;

        // Обновляем состояние кнопок
        nextButton.classList.remove("swiper-button-disabled");
        if (finalX >= 0) {
          prevButton.classList.add("swiper-button-disabled");
        }
      });
    }
  });
}

// Добавляем новую функцию к исполнению после загрузки DOM
document.addEventListener("DOMContentLoaded", function () {
  // Фиксируем отображение логин-иконки на всех страницах
  fixLoginIconOnAllPages();

  // Фиксируем отображение слайдера видов туров
  fixTourTypesSlider();

  // Добавляем обработчики для гарантии правильного отображения
  window.addEventListener("resize", function () {
    fixLoginIconOnAllPages();
    fixTourTypesSlider();
  });

  window.addEventListener("load", function () {
    fixLoginIconOnAllPages();
    fixTourTypesSlider();
  });

  // Дополнительный запуск через небольшую задержку, на случай если что-то
  // не успело загрузиться к моменту DOMContentLoaded
  setTimeout(function () {
    fixLoginIconOnAllPages();
    fixTourTypesSlider();
  }, 500);
});

// Экспортируем функции для использования в других скриптах
if (typeof module !== "undefined" && typeof module.exports !== "undefined") {
  module.exports = {
    fixLoginIconOnAllPages,
  };
}
