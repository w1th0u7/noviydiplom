document.addEventListener("DOMContentLoaded", function () {
  const tabsContainer = document.querySelector("[data-tabs]");

  // Проверяем наличие контейнера табов на странице
  if (!tabsContainer) return;

  const tabsNav = document.querySelector("[data-tabs-nav]");
  const tabsList = document.querySelector("[data-tabs-list]");

  // Проверяем наличие обязательных элементов
  if (!tabsNav || !tabsList) return;

  const tabButtons = tabsNav.querySelectorAll("li");
  const tabPanels = tabsList.querySelectorAll(".tab__element");
  const showMoreButton = document.querySelector(".btn-add"); // Кнопка "Показать еще"

  // Функция для показа/скрытия индикаторов прокрутки
  function updateScrollIndicators() {
    if (window.innerWidth <= 1024) {
      const btnsRow = document.querySelector(".tabs.tury .btns-row");
      if (btnsRow) {
        const canScrollLeft = btnsRow.scrollLeft > 0;
        const canScrollRight =
          btnsRow.scrollLeft < btnsRow.scrollWidth - btnsRow.clientWidth;

        // Показываем/скрываем левый индикатор
        if (canScrollLeft) {
          btnsRow.style.setProperty("--show-left-indicator", "1");
        } else {
          btnsRow.style.setProperty("--show-left-indicator", "0");
        }

        // Показываем/скрываем правый индикатор
        if (canScrollRight) {
          btnsRow.style.setProperty("--show-right-indicator", "1");
        } else {
          btnsRow.style.setProperty("--show-right-indicator", "0");
        }
      }
    }
  }

  // Функция для скролла к активной кнопке на мобильных устройствах
  function scrollToActiveTab(tabIndex) {
    if (window.innerWidth <= 1024) {
      const btnsRow = document.querySelector(".tabs.tury .btns-row");
      const activeButton = tabButtons[tabIndex];

      if (btnsRow && activeButton) {
        const buttonRect = activeButton.getBoundingClientRect();
        const containerRect = btnsRow.getBoundingClientRect();
        const scrollLeft = btnsRow.scrollLeft;

        // Вычисляем позицию для центрирования кнопки
        const targetScroll =
          scrollLeft +
          (buttonRect.left - containerRect.left) -
          containerRect.width / 2 +
          buttonRect.width / 2;

        btnsRow.scrollTo({
          left: targetScroll,
          behavior: "smooth",
        });

        // Обновляем индикаторы после скролла
        setTimeout(updateScrollIndicators, 300);
      }
    }
  }

  function activateTab(tabIndex) {
    // Удаляем класс 'active' у всех вкладок и панелей
    tabButtons.forEach((button) => button.classList.remove("active"));
    tabPanels.forEach((panel) => panel.classList.remove("active"));

    // Добавляем класс 'active' к выбранной вкладке и панели
    tabButtons[tabIndex].classList.add("active");
    tabPanels[tabIndex].classList.add("active");

    // Скролл к активной кнопке на мобильных
    scrollToActiveTab(tabIndex);

    // После переключения вкладки проверяем, есть ли скрытые туры
    updateShowMoreButtonVisibility();
  }

  // Обновление видимости кнопки "Показать еще"
  function updateShowMoreButtonVisibility() {
    if (!showMoreButton) return;

    const activeTabIndex = Array.from(tabButtons).findIndex((btn) =>
      btn.classList.contains("active")
    );
    const activePanel = tabPanels[activeTabIndex];
    const hiddenTours = activePanel.querySelectorAll(".block:not(.show)");

    // Показываем кнопку только если есть скрытые туры
    showMoreButton.style.display = hiddenTours.length > 0 ? "flex" : "none";
  }

  // Назначаем обработчик клика для каждой вкладки
  tabButtons.forEach((button, index) => {
    button.addEventListener("click", function (event) {
      event.preventDefault(); // Предотвращаем переход по ссылке (если это необходимо)
      activateTab(index);
    });
  });

  // Обработчик клика на кнопке "Показать еще туры"
  if (showMoreButton) {
    showMoreButton.addEventListener("click", function (event) {
      event.preventDefault();
      // Получаем активную вкладку
      const activeTabIndex = Array.from(tabButtons).findIndex((btn) =>
        btn.classList.contains("active")
      );
      const activePanel = tabPanels[activeTabIndex];

      // Получаем все скрытые блоки туров в активной вкладке
      const hiddenTours = activePanel.querySelectorAll(".block:not(.show)");

      // Показываем следующие 3 тура или все оставшиеся, если их меньше 3
      const toursToShow = Math.min(hiddenTours.length, 3);
      for (let i = 0; i < toursToShow; i++) {
        hiddenTours[i].classList.add("show");
      }

      // Скрываем кнопку, если все туры уже показаны
      if (hiddenTours.length <= toursToShow) {
        this.style.display = "none";
      }
    });
  }

  // Активируем первую вкладку по умолчанию и проверяем статус кнопки
  activateTab(0);
  updateShowMoreButtonVisibility();

  // Обработчик изменения размера окна для корректировки скролла
  window.addEventListener("resize", function () {
    const activeTabIndex = Array.from(tabButtons).findIndex((btn) =>
      btn.classList.contains("active")
    );
    if (activeTabIndex !== -1) {
      setTimeout(() => {
        scrollToActiveTab(activeTabIndex);
        updateScrollIndicators();
      }, 100);
    }
  });

  // Обработчик скролла для обновления индикаторов
  const btnsRow = document.querySelector(".tabs.tury .btns-row");
  if (btnsRow) {
    btnsRow.addEventListener("scroll", updateScrollIndicators);
    // Инициализация индикаторов
    setTimeout(updateScrollIndicators, 100);
  }
});

// Обработчики для страницы экскурсий
document.addEventListener("DOMContentLoaded", function () {
  // Навигационные табы на странице экскурсий
  const navTabs = document.querySelectorAll(".nav-tab");

  if (navTabs.length > 0) {
    navTabs.forEach((tab) => {
      tab.addEventListener("click", function () {
        // Удаляем активный класс у всех табов
        navTabs.forEach((t) => t.classList.remove("active"));

        // Добавляем активный класс текущему табу
        this.classList.add("active");

        // Получаем целевую категорию
        const targetType = this.getAttribute("data-target");

        // Если выбраны все экскурсии, показываем все карточки
        if (targetType === "all") {
          document.querySelectorAll(".excursion-card").forEach((card) => {
            card.style.display = "block";
          });
        } else {
          // Иначе фильтруем карточки по типу
          document.querySelectorAll(".excursion-card").forEach((card) => {
            if (card.getAttribute("data-type") === targetType) {
              card.style.display = "block";
            } else {
              card.style.display = "none";
            }
          });
        }
      });
    });
  }

  // Обработчики для фильтров экскурсий
  const filterButton = document.getElementById("filter-button");
  const filterReset = document.getElementById("filter-reset");

  if (filterButton) {
    filterButton.addEventListener("click", function () {
      applyFilters();
    });
  }

  if (filterReset) {
    filterReset.addEventListener("click", function () {
      // Сброс фильтров
      document.getElementById("region").value = "all";
      document.getElementById("duration").value = "all";
      document.getElementById("price-range").value =
        document.getElementById("price-range").max;
      updatePriceLabel();

      // Показать все карточки активной вкладки
      const activeTab = document.querySelector(".nav-tab.active");
      const targetType = activeTab
        ? activeTab.getAttribute("data-target")
        : "all";

      document.querySelectorAll(".excursion-card").forEach((card) => {
        if (
          targetType === "all" ||
          card.getAttribute("data-type") === targetType
        ) {
          card.style.display = "block";
        } else {
          card.style.display = "none";
        }
      });
    });
  }

  // Ползунок цены
  const priceRange = document.getElementById("price-range");
  if (priceRange) {
    priceRange.addEventListener("input", updatePriceLabel);
    // Инициализация значения цены
    updatePriceLabel();
  }

  function updatePriceLabel() {
    const priceValue = document.getElementById("price-value");
    const priceRange = document.getElementById("price-range");
    if (priceValue && priceRange) {
      priceValue.textContent = `до ${new Intl.NumberFormat("ru-RU").format(
        priceRange.value
      )} ₽`;
    }
  }

  function applyFilters() {
    const region = document.getElementById("region").value;
    const duration = document.getElementById("duration").value;
    const maxPrice = document.getElementById("price-range").value;
    const activeTab = document.querySelector(".nav-tab.active");
    const targetType = activeTab
      ? activeTab.getAttribute("data-target")
      : "all";

    document.querySelectorAll(".excursion-card").forEach((card) => {
      // Проверяем, соответствует ли карточка активной вкладке
      const typeMatches =
        targetType === "all" || card.getAttribute("data-type") === targetType;

      // Проверяем соответствие региону
      const regionMatches =
        region === "all" || card.getAttribute("data-region") === region;

      // Проверяем соответствие продолжительности
      const cardDuration = parseInt(card.getAttribute("data-duration"));
      let durationMatches = duration === "all";
      if (duration === "1") {
        durationMatches = cardDuration === 1;
      } else if (duration === "2-3") {
        durationMatches = cardDuration >= 2 && cardDuration <= 3;
      } else if (duration === "4-7") {
        durationMatches = cardDuration >= 4 && cardDuration <= 7;
      } else if (duration === "8+") {
        durationMatches = cardDuration >= 8;
      }

      // Проверяем соответствие цене
      const cardPrice = parseInt(card.getAttribute("data-price"));
      const priceMatches = cardPrice <= maxPrice;

      // Показываем или скрываем карточку
      if (typeMatches && regionMatches && durationMatches && priceMatches) {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    });
  }
});
