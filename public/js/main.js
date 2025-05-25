"use strict";

// Вспомогательные функции для работы с классами
function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
}

function _createClass(Constructor, protoProps, staticProps) {
  if (protoProps) _defineProperties(Constructor.prototype, protoProps);
  if (staticProps) _defineProperties(Constructor, staticProps);
  return Constructor;
}

function _defineProperties(target, props) {
  for (var i = 0; i < props.length; i++) {
    var descriptor = props[i];
    descriptor.enumerable = descriptor.enumerable || false;
    descriptor.configurable = true;
    if ("value" in descriptor) descriptor.writable = true;
    Object.defineProperty(target, descriptor.key, descriptor);
  }
}

// Определение класса Tabs
var Tabs = /*#__PURE__*/ (function () {
  function Tabs(e) {
    _classCallCheck(this, Tabs);
    this.container = e;
    var t = e.querySelector("[data-tabs-nav]"),
      s = e.querySelector("[data-tabs-list]");

    // Проверяем наличие необходимых элементов
    if (!t || !s) {
      console.error("Tabs: Missing required elements");
      return;
    }

    (this.navItems = t.querySelectorAll(":scope > *")),
      (this.listItems = s.querySelectorAll(":scope > *"));
  }
  _createClass(Tabs, [
    {
      key: "init",
      value: function init() {
        var _this = this;

        // Проверка наличия элементов навигации
        if (!this.navItems || !this.listItems || this.navItems.length === 0) {
          console.error("Tabs: No navigation items found");
          return;
        }

        for (var e = 0; e < this.navItems.length; e++) {
          var t = this.navItems[e];
          if (this.active && t.classList.contains("active")) {
            this.isActive = e;
          }
          t.classList.remove("active");
          t.dataset.index = e;
        }

        this.listItems.forEach(function (e, index) {
          e.classList.remove("active");
          e.dataset.index = index; // Убеждаемся, что у каждого элемента есть атрибут data-index
        });

        if (!this.active) {
          this.isActive = 0;
        }

        this.toggle(this.isActive);

        this.navItems.forEach(function (e) {
          e.addEventListener("click", function () {
            var index = parseInt(e.dataset.index);
            if (!isNaN(index)) {
              _this.toggle(index);
            }
          });
        });
      },
    },
    {
      key: "toggle",
      value: function toggle(e) {
        // Проверка, что индекс в числовом формате
        var index = parseInt(e);
        if (isNaN(index)) {
          console.error("Tabs: Invalid index");
          return;
        }

        // Проверка, что индекс находится в диапазоне
        if (
          index < 0 ||
          index >= this.navItems.length ||
          index >= this.listItems.length
        ) {
          console.error("Tabs: Index out of range");
          return;
        }

        // Удаляем активный класс с текущих активных элементов
        if (typeof this.isActive !== "undefined" && this.isActive >= 0) {
          this.navItems[this.isActive].classList.remove("active");
          this.listItems[this.isActive].classList.remove("active");
        }

        // Устанавливаем новый активный индекс
        this.isActive = index;

        // Добавляем активный класс новым активным элементам
        this.navItems[this.isActive].classList.add("active");
        this.listItems[this.isActive].classList.add("active");

        // Генерируем пользовательское событие о смене таба
        this.container.dispatchEvent(
          new CustomEvent("tab-change", {
            detail: { index: this.isActive },
          })
        );
      },
    },
  ]);
  return Tabs;
})();

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

// Инициализация Swiper
var swiper = new Swiper(".banner-home .swiper", {
    spaceBetween: 20,
    slidesPerView: 1,
    direction: "horizontal",
    loop: !0,
    pagination: {
      el: ".swiper-pagination",
    },
  }),
  swiper1 = new Swiper(".vidy-turov .swiper", {
    loop: !1,
    spaceBetween: 20,
    slidesPerView: "auto",
    direction: "horizontal",
    navigation: {
      nextEl: ".vidy-turov .swiper-button-next",
      prevEl: ".vidy-turov .swiper-button-prev",
    },
    breakpoints: {
      300: {
        slidesPerView: "auto",
        spaceBetween: 20,
      },
      767: {
        slidesPerView: "auto",
        spaceBetween: 30,
      },
      1200: {
        slidesPerView: "auto",
        spaceBetween: 40,
      },
    },
  }),
  swiper2 = new Swiper(".otz .swiper", {
    loop: !1,
    spaceBetween: 40,
    slidesPerView: "auto",
    direction: "horizontal",
    navigation: {
      nextEl: ".otz .swiper-button-next",
      prevEl: ".otz .swiper-button-prev",
    },
    breakpoints: {
      300: {
        slidesPerView: "auto",
        spaceBetween: 20,
      },
      767: {
        slidesPerView: "auto",
        spaceBetween: 30,
      },
      1200: {
        slidesPerView: "auto",
        spaceBetween: 40,
      },
    },
  });

// Обработчики событий
!(function (e) {
  "function" != typeof e.matches &&
    (e.matches =
      e.msMatchesSelector ||
      e.mozMatchesSelector ||
      e.webkitMatchesSelector ||
      function (e) {
        for (
          var t = this,
            s = (t.document || t.ownerDocument).querySelectorAll(e),
            o = 0;
          s[o] && s[o] !== t;

        )
          ++o;
        return Boolean(s[o]);
      }),
    "function" != typeof e.closest &&
      (e.closest = function (e) {
        for (var t = this; t && 1 === t.nodeType; ) {
          if (t.matches(e)) return t;
          t = t.parentNode;
        }
        return null;
      });
})(window.Element.prototype);

// Основная инициализация DOM
document.addEventListener("DOMContentLoaded", function () {
  // Фиксируем отображение логин-иконки на всех страницах
  fixLoginIconOnAllPages();

  // Инициализация бургер-меню
  var bntMenu = document.querySelector(".menu-btn"),
    menu = document.querySelector(".header-mid nav"),
    body = document.body;

  // Проверяем существует ли кнопка закрытия, если нет - создаем её
  let closeMenu = document.querySelector(".close-menu");
  if (!closeMenu && menu) {
    closeMenu = document.createElement("div");
    closeMenu.className = "close-menu";

    // Используем простой HTML-символ × вместо SVG для надежности
    const closeIcon = document.createElement("span");
    closeIcon.textContent = "×"; // HTML-символ крестика
    closeIcon.style.fontSize = "28px";
    closeIcon.style.fontWeight = "bold";
    closeIcon.style.color = "#FFDA56";
    closeIcon.style.lineHeight = "1";

    // Добавляем только крестик в кнопку закрытия (без текста "Закрыть")
    closeMenu.appendChild(closeIcon);

    // Стилизуем кнопку закрытия с более ярким стилем
    closeMenu.style.display = "flex";
    closeMenu.style.alignItems = "center";
    closeMenu.style.justifyContent = "center"; // Центрируем крестик
    closeMenu.style.padding = "10px";
    closeMenu.style.margin = "12px 0";
    closeMenu.style.width = "40px"; // Делаем кнопку квадратной
    closeMenu.style.height = "40px";
    closeMenu.style.borderRadius = "8px";
    closeMenu.style.border = "1px solid rgba(255, 218, 86, 0.6)";
    closeMenu.style.cursor = "pointer";
    closeMenu.style.background = "rgba(255, 218, 86, 0.1)";

    if (menu) {
      menu.insertBefore(closeMenu, menu.firstChild);
    }
  }

  // Функция для закрытия меню
  function closeMenuFunction() {
    if (menu) {
      // Мгновенно удаляем класс active для скрытия меню
      if (menu.hasAttribute("class")) {
        menu.className = menu.className.replace(/\bactive\b/, "").trim();
        if (menu.className === "") {
          menu.removeAttribute("class");
        }
      }

      // Мгновенно удаляем класс no_scroll с body
      body.classList.remove("no_scroll");

      // Сбрасываем стили пунктов меню
      const menuItems = menu.querySelectorAll(".menu-item");
      menuItems.forEach((item) => {
        item.style.transform = "";
        item.style.opacity = "";
        item.style.transition = "";
      });
    }

    // Удаляем оверлей
    const overlay = document.querySelector(".menu-overlay");
    if (overlay) {
      overlay.removeEventListener("click", closeMenuFunction);
      overlay.remove();
    }
  }

  // Улучшаем стиль меню
  function applyLightMenuStyle() {
    if (!menu) return;

    // Устанавливаем более светлый фон с большей яркостью
    menu.style.background =
      "linear-gradient(to bottom, rgba(30, 70, 105, 0.95), rgba(25, 50, 75, 0.97))";
    menu.style.boxShadow = "0 0 20px rgba(0, 0, 0, 0.5)";

    // Принудительно устанавливаем отображение и другие важные свойства
    menu.style.display = "block";
    menu.style.position = "fixed";
    menu.style.top = "0";
    menu.style.left = "0";
    menu.style.width = "100%";
    menu.style.height = "100%";
    menu.style.padding = "20px";
    menu.style.zIndex = "1000";
    menu.style.overflowY = "auto";

    // Стили для прокрутки
    menu.style.scrollbarWidth = "thin";
    menu.style.scrollbarColor = "#FFDA56 rgba(25, 50, 75, 0.8)";

    // Добавляем стили для пунктов меню
    const menuItems = menu.querySelectorAll(".menu-item");
    menuItems.forEach((item) => {
      item.style.marginBottom = "15px";
      item.style.borderBottom = "1px solid rgba(255, 218, 86, 0.3)";
      item.style.paddingBottom = "10px";
    });

    // Улучшаем стиль ссылок в меню
    const menuLinks = menu.querySelectorAll(".menu-link");
    menuLinks.forEach((link) => {
      link.style.color = "#ffffff";
      link.style.fontSize = "18px";
      link.style.fontWeight = "500";
      link.style.display = "block";
      link.style.padding = "10px 5px";
      link.style.textShadow = "0 1px 2px rgba(0, 0, 0, 0.5)";

      // Добавляем эффект при наведении
      link.addEventListener("mouseover", function () {
        this.style.color = "#FFDA56";
        this.style.background = "rgba(255, 218, 86, 0.1)";
        this.style.borderRadius = "5px";
        this.style.paddingLeft = "10px";
        this.style.transition = "all 0.2s ease";
      });

      link.addEventListener("mouseout", function () {
        this.style.color = "#ffffff";
        this.style.background = "transparent";
        this.style.paddingLeft = "5px";
      });
    });

    // Находим социальные иконки и перемещаем их на уровень кнопки закрытия
    const socMob = menu.querySelector(".soc.mob");
    if (socMob && closeMenu) {
      // Создаем контейнер для кнопки закрытия и социальных иконок
      const headerContainer = document.createElement("div");
      headerContainer.style.display = "flex";
      headerContainer.style.justifyContent = "space-between";
      headerContainer.style.alignItems = "center";
      headerContainer.style.width = "100%";
      headerContainer.style.marginBottom = "20px";

      // Проверяем, находятся ли элементы уже в контейнере
      if (
        socMob.parentNode !== headerContainer &&
        closeMenu.parentNode !== headerContainer
      ) {
        // Если socMob уже в DOM, удаляем его из текущего положения
        if (socMob.parentNode) {
          socMob.parentNode.removeChild(socMob);
        }

        // Добавляем стили для socMob
        socMob.style.display = "flex";
        socMob.style.gap = "10px";

        // Если closeMenu уже в DOM, удаляем его из текущего положения
        if (closeMenu.parentNode) {
          closeMenu.parentNode.removeChild(closeMenu);
        }

        // Добавляем оба элемента в новый контейнер
        headerContainer.appendChild(closeMenu);
        headerContainer.appendChild(socMob);

        // Вставляем контейнер в начало меню
        menu.insertBefore(headerContainer, menu.firstChild);
      }
    }
  }

  // Добавляем обработчики для открытия и закрытия меню
  if (bntMenu && menu) {
    bntMenu.addEventListener("click", function () {
      // Открываем меню
      menu.classList.add("active");
      body.classList.add("no_scroll");
      console.log("Меню открыто");

      // Применяем стили
      applyLightMenuStyle();

      // Анимируем появление пунктов меню
      const menuItems = menu.querySelectorAll(".menu-item");
      menuItems.forEach((item, index) => {
        // Сначала скрываем все пункты
        item.style.transform = "translateX(-20px)";
        item.style.opacity = "0";

        // Добавляем небольшую задержку для анимации
        const delay = index * 0.05;
        item.style.transition = `transform 0.3s ease ${delay}s, opacity 0.3s ease ${delay}s`;

        // Затем с задержкой показываем каждый пункт
        setTimeout(() => {
          item.style.transform = "translateX(0)";
          item.style.opacity = "1";
        }, 100 + index * 50);
      });

      // Создаем оверлей для закрытия меню при клике вне его
      if (!document.querySelector(".menu-overlay")) {
        const overlay = document.createElement("div");
        overlay.className = "menu-overlay";
        overlay.style.position = "fixed";
        overlay.style.top = "0";
        overlay.style.left = "0";
        overlay.style.width = "100%";
        overlay.style.height = "100%";
        overlay.style.background = "transparent";
        overlay.style.zIndex = "-2";
        document.body.appendChild(overlay);

        // Закрытие меню при клике на оверлей
        overlay.addEventListener("click", closeMenuFunction);
      }
    });
  }

  // Обработчик для кнопки закрытия меню
  if (closeMenu) {
    closeMenu.addEventListener("click", closeMenuFunction);
    console.log("Обработчик закрытия меню добавлен");
  }

  // Закрытие меню при нажатии Escape
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && menu && menu.classList.contains("active")) {
      closeMenuFunction();
    }
  });

  // Закрытие меню при клике на ссылки внутри меню
  if (menu) {
    const menuLinks = menu.querySelectorAll(".menu-link");
    menuLinks.forEach((link) => {
      // Добавляем обработчик с корректной логикой
      link.addEventListener("click", function (e) {
        // Закрываем меню, но не отменяем действие по умолчанию
        closeMenuFunction();
      });
    });
  }

  // Инициализация модальных окон
  var e = document.querySelectorAll(".js-open-modal"),
    t = document.querySelector(".js-overlay-modal"),
    s = document.querySelectorAll(".js-modal-close");

  // Проверяем, что все необходимые элементы найдены
  if (t) {
    e.forEach(function (e) {
      e.addEventListener("click", function (e) {
        e.preventDefault();
        var s = this.getAttribute("data-modal");
        var modal = document.querySelector('.modal[data-modal="' + s + '"]');
        if (modal) {
          modal.classList.add("active");
          t.classList.add("active");
        }
      });
    });

    s.forEach(function (e) {
      e.addEventListener("click", function (e) {
        var modal = this.closest(".modal");
        if (modal) {
          modal.classList.remove("active");
          t.classList.remove("active");
        }
      });
    });

    document.body.addEventListener(
      "keyup",
      function (e) {
        if (27 == e.keyCode) {
          var activeModal = document.querySelector(".modal.active");
          var overlay = document.querySelector(".overlay");
          if (activeModal) activeModal.classList.remove("active");
          if (overlay) overlay.classList.remove("active");
        }
      },
      !1
    );

    t.addEventListener("click", function () {
      var activeModal = document.querySelector(".modal.active");
      if (activeModal) activeModal.classList.remove("active");
      this.classList.remove("active");
    });
  }

  // Инициализация табов
  var tabItems = document.querySelectorAll("[data-tabs]");
  tabItems.forEach(function (e) {
    new Tabs(e).init();
  });

  // Обновленный код для работы с блоками туров
  var mansoryTabs = document.querySelectorAll(".tab__panels .tab__element");

  // Функция для определения количества блоков для отображения в зависимости от ширины экрана
  function getBlocksToShowCount() {
    var count = 6; // Desktop по умолчанию
    if (window.innerWidth < 1200) count = 4;
    if (window.innerWidth < 767) count = 3;
    return count;
  }

  function openMansoryBlocks(tabElement, count, button) {
    var hiddenBlocks = tabElement.querySelectorAll(".block:not(.show)");

    // Если блоки не найдены, прекращаем выполнение
    if (hiddenBlocks.length === 0) {
      if (button) button.style.display = "none";
      return;
    }

    // Показываем следующие блоки
    for (var i = 0; i < count; i++) {
      if (hiddenBlocks[i]) {
        hiddenBlocks[i].classList.add("show");
      }
    }

    // Проверяем, остались ли еще скрытые блоки
    var remainingHiddenBlocks =
      tabElement.querySelectorAll(".block:not(.show)");
    if (remainingHiddenBlocks.length === 0 && button) {
      button.style.display = "none";
    }
  }

  // Обработчик для адаптивной перестройки при изменении размера окна
  var resizeTimeout;
  window.addEventListener("resize", function () {
    // Используем debounce для оптимизации производительности
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(function () {
      var blocksToShow = getBlocksToShowCount();
      var activeTab = document.querySelector(".tab__element.active");
      var btnAdd = document.querySelector(".btn-centr .btn-add");

      if (activeTab && btnAdd) {
        // При изменении размера окна, показываем кнопку снова
        btnAdd.style.display = "flex";

        // Проверяем, остались ли еще скрытые блоки
        var remainingHiddenBlocks =
          activeTab.querySelectorAll(".block:not(.show)");
        if (remainingHiddenBlocks.length === 0) {
          btnAdd.style.display = "none";
        }
      }
    }, 250); // Задержка для debounce
  });

  // Настраиваем кнопки для всех вкладок
  mansoryTabs.forEach(function (tabElement) {
    // Находим кнопку "Показать еще туры" внутри родительского элемента
    var btnAdd = document.querySelector(".btn-centr .btn-add");

    // Если кнопка не найдена, прекращаем для этого таба
    if (!btnAdd) return;

    // Определяем количество блоков для показа в зависимости от ширины экрана
    var blocksToShow = getBlocksToShowCount();

    // Инициализируем отображение блоков при загрузке страницы для активной вкладки
    if (tabElement.classList.contains("active")) {
      openMansoryBlocks(tabElement, blocksToShow, btnAdd);
    }

    // Добавляем обработчик на кнопку
    btnAdd.addEventListener("click", function () {
      // Получаем текущую активную вкладку
      var activeTab = document.querySelector(".tab__element.active");
      if (activeTab) {
        openMansoryBlocks(activeTab, blocksToShow, btnAdd);
      }
    });
  });

  // Добавляем обработчик на клик по вкладкам для обновления отображения
  var tabNavItems = document.querySelectorAll(".tabs__pane li");
  tabNavItems.forEach(function (navItem) {
    navItem.addEventListener("click", function () {
      var btnAdd = document.querySelector(".btn-centr .btn-add");

      // Отображаем кнопку снова при переключении вкладки
      if (btnAdd) btnAdd.style.display = "flex";

      // Находим активную вкладку после клика
      setTimeout(function () {
        var newActiveTab = document.querySelector(".tab__element.active");
        if (newActiveTab) {
          // Сбрасываем состояние блоков для нового таба
          var allBlocks = newActiveTab.querySelectorAll(".block");
          allBlocks.forEach(function (block, index) {
            if (index < 3) {
              block.classList.add("show");
            } else {
              block.classList.remove("show");
            }
          });

          // Инициализируем отображение для нового активного таба
          openMansoryBlocks(newActiveTab, getBlocksToShowCount(), btnAdd);
        }
      }, 50);
    });
  });

  // ... остальной код ...
});

// Добавляем обработчик изменения размера экрана для пересчета размеров иконок
window.addEventListener("resize", fixLoginIconOnAllPages);

// Запускаем функцию еще раз после полной загрузки страницы для надежности
window.addEventListener("load", fixLoginIconOnAllPages);
