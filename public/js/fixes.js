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

// Функция для полноценной замены и инициализации слайдера видов туров
function fixTourTypesSlider() {
  // Проверяем наличие Swiper
  if (typeof Swiper === "undefined") {
    console.error("Swiper не найден. Невозможно инициализировать слайдер.");
    return;
  }

  // Уничтожаем все существующие инстансы слайдера видов туров
  if (window.swiper1) {
    try {
      window.swiper1.destroy(true, true);
    } catch (e) {
      console.log("Ошибка при уничтожении существующего слайдера", e);
    }
  }

  // Настраиваем параметры в зависимости от размера экрана
  const isMobile = window.innerWidth < 768;
  const slidesPerView = isMobile ? 1.2 : "auto";
  const spaceBetween = isMobile ? 10 : 20;
  const loop = true; // Зацикливаем слайдер для лучшего UX на мобильных

  // Создаем новый инстанс слайдера
  try {
    window.swiper1 = new Swiper(".vidy-turov .swiper", {
      loop: loop,
      spaceBetween: spaceBetween,
      slidesPerView: slidesPerView,
      centeredSlides: isMobile, // На мобильных центрируем слайды
      grabCursor: true, // Показываем руку-курсор для перетаскивания
      slideToClickedSlide: true, // Переход к слайду по клику
      autoHeight: true, // Автоматическая высота для слайдера
      watchOverflow: true, // Отключение навигации если слайдов меньше чем нужно
      touchRatio: 1, // Повышенная чувствительность свайпов
      speed: 400, // Более плавный переход между слайдами
      navigation: {
        nextEl: ".vidy-turov .swiper-button-next",
        prevEl: ".vidy-turov .swiper-button-prev",
      },
      breakpoints: {
        320: {
          slidesPerView: 1.2,
          spaceBetween: 10,
          centeredSlides: true,
        },
        480: {
          slidesPerView: 1.5,
          spaceBetween: 15,
          centeredSlides: false,
        },
        767: {
          slidesPerView: 2.2,
          spaceBetween: 20,
          centeredSlides: false,
        },
        1200: {
          slidesPerView: "auto",
          spaceBetween: 30,
          centeredSlides: false,
        },
      },
      on: {
        init: function () {
          console.log("Слайдер видов туров успешно инициализирован");
        },
        resize: function () {
          // Обновляем слайдер при изменении размера окна
          this.update();
        },
      },
    });
  } catch (error) {
    console.error("Ошибка инициализации слайдера:", error);
  }

  // Дополнительные улучшения для слайдов
  const slides = document.querySelectorAll(".vidy-turov .swiper-slide");
  slides.forEach(function (slide) {
    // Убеждаемся, что все слайды видны и имеют корректный размер
    slide.style.opacity = "1";
    slide.style.visibility = "visible";

    // Добавляем обработчик клика для улучшения UX
    slide.addEventListener("click", function (e) {
      // Если клик был не по ссылке, а просто по слайду
      if (e.target.tagName !== "A") {
        // Находим ссылку внутри слайда и переходим по ней
        const link = this.querySelector("a");
        if (link && link.href) {
          window.location.href = link.href;
        }
      }
    });
  });
}

// Добавляем новую функцию к исполнению после загрузки DOM
document.addEventListener("DOMContentLoaded", function () {
  // Фиксируем отображение логин-иконки на всех страницах
  fixLoginIconOnAllPages();

  // Фиксируем отображение слайдера видов туров
  // Небольшая задержка для гарантированной загрузки Swiper
  setTimeout(fixTourTypesSlider, 100);

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
