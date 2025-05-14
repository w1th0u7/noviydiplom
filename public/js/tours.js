document.addEventListener("DOMContentLoaded", function () {
  const tabsNav = document.querySelector("[data-tabs-nav]");
  const tabsList = document.querySelector("[data-tabs-list]");
  const tabButtons = tabsNav.querySelectorAll("li");
  const tabPanels = tabsList.querySelectorAll(".tab__element");
  const showMoreButton = document.querySelector(".btn-add"); // Кнопка "Показать еще"
  let currentTabIndex = 0; // Индекс текущей активной вкладки
  let toursLoaded = 3; // Сколько туров загружено (можно начать с 3 или другого числа)

  function activateTab(tabIndex) {
    // Удаляем класс 'active' у всех вкладок и панелей
    tabButtons.forEach((button) => button.classList.remove("active"));
    tabPanels.forEach((panel) => panel.classList.remove("active"));

    // Добавляем класс 'active' к выбранной вкладке и панели
    tabButtons[tabIndex].classList.add("active");
    tabPanels[tabIndex].classList.add("active");
    currentTabIndex = tabIndex; // Обновляем индекс текущей вкладки

    // Обновляем отображение туров для текущей вкладки
    updateTours(tabIndex);
  }

  // Функция для обновления отображения туров
  function updateTours(tabIndex) {
    // Определите, какую переменную с турами использовать в зависимости от вкладки
    let tourVariable;

    switch (tabIndex) {
      case 0:
        tourVariable = "newTours";
        break;
      case 1:
        tourVariable = "upcomingTours";
        break;
      case 2:
        tourVariable = "popularTours";
        break;
      case 3:
        tourVariable = "summerTours";
        break;
      case 4:
        tourVariable = "winterTours";
        break;
      case 5:
        tourVariable = "autumnTours";
        break;
      case 6:
        tourVariable = "springTours";
        break;
      default:
        tourVariable = "tours"; // Общий список туров
        break;
    }

    // Отправьте AJAX-запрос на сервер, чтобы получить больше туров
    fetch(`/load-more-tours?tab=${tourVariable}&offset=${toursLoaded}`)
      .then((response) => response.json())
      .then((data) => {
        // Обработайте полученные данные и добавьте их на страницу
        const tabPanel = tabPanels[tabIndex].querySelector(".cont-tury"); // Найдите контейнер туров
        data.forEach((tour) => {
          // Создайте HTML для нового тура
          const tourHTML = `
                      <div class="block show">
                          <a href="/tours/${tour.id}">
                              <img src="" alt="${tour.name}" srcset="">
                              <div class="info">
                                  <h1>${tour.name}</h1>
                                  <h3 class="name">${tour.description}</h3>
                                  <p class="data">${tour.data}</p>
                                  <p class="price">Цена: ${tour.price}₽</p>
                              </div>
                          </a>
                      </div>
                  `;

          // Добавьте новый тур в контейнер
          tabPanel.insertAdjacentHTML("beforeend", tourHTML);
        });

        toursLoaded += data.length; // Обновите количество загруженных туров
        if (data.length < 6) {
          //Скрываем кнопку
          showMoreButton.style.display = "none";
        }
      })
      .catch((error) => {
        console.error("Error loading more tours:", error);
      });
  }

  // Назначаем обработчик клика для каждой вкладки
  tabButtons.forEach((button, index) => {
    button.addEventListener("click", function (event) {
      event.preventDefault(); // Предотвращаем переход по ссылке (если это необходимо)
      activateTab(index);
    });
  });

  // Обработчик клика на кнопке "Показать еще"
  showMoreButton.addEventListener("click", function (event) {
    event.preventDefault();
    updateTours(currentTabIndex);
  });

  // Активируем первую вкладку по умолчанию (если нужно)
  activateTab(0);

  function getCsrfToken() {
    return document
      .querySelector('meta[name="csrf-token"]')
      .getAttribute("content");
  }

  fetch("/load-more-tours?tab=${tourVariable}&offset=${toursLoaded}", {
    method: "GET",
    headers: {
      "X-CSRF-TOKEN": getCsrfToken(),
    },
  });
});
