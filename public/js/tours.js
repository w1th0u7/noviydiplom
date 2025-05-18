document.addEventListener("DOMContentLoaded", function () {
  const tabsNav = document.querySelector("[data-tabs-nav]");
  const tabsList = document.querySelector("[data-tabs-list]");
  const tabButtons = tabsNav.querySelectorAll("li");
  const tabPanels = tabsList.querySelectorAll(".tab__element");
  const showMoreButton = document.querySelector(".btn-add"); // Кнопка "Показать еще"

  function activateTab(tabIndex) {
    // Удаляем класс 'active' у всех вкладок и панелей
    tabButtons.forEach((button) => button.classList.remove("active"));
    tabPanels.forEach((panel) => panel.classList.remove("active"));

    // Добавляем класс 'active' к выбранной вкладке и панели
    tabButtons[tabIndex].classList.add("active");
    tabPanels[tabIndex].classList.add("active");

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

      // Показываем все скрытые туры
      hiddenTours.forEach((tour) => {
        tour.classList.add("show");
      });

      // Скрываем кнопку, если все туры уже показаны
      if (hiddenTours.length === 0) {
        this.style.display = "none";
      }
    });
  }

  // Активируем первую вкладку по умолчанию и проверяем статус кнопки
  activateTab(0);
  updateShowMoreButtonVisibility();

  function getCsrfToken() {
    return document
      .querySelector('meta[name="csrf-token"]')
      .getAttribute("content");
  }
});
