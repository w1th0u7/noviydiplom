document.addEventListener("DOMContentLoaded", function () {
  // Инициализация элементов формы
  const tourForm = document.getElementById("tourForm");
  const countrySelect = document.getElementById("country");
  const resortSelect = document.getElementById("resort");
  const hotelSelect = document.getElementById("hotel");
  const departureDateInput = document.getElementById("departureDate");
  const adultsInput = document.getElementById("adults");
  const childrenInput = document.getElementById("children");
  const nightsSlider = document.getElementById("nightsSlider");
  const nightsDisplay = document.getElementById("nightsDisplay");
  const resultContainer = document.getElementById("resultContainer");
  const priceContainer = document.getElementById("priceContainer");
  const tourSummary = document.getElementById("tourSummary");
  const loadingIndicator = document.getElementById("loadingIndicator");
  const calculateButton = document.getElementById("calculateButton");
  const resetButton = document.getElementById("resetCalculatorButton");
  const showHotelsButton = document.getElementById("showHotelsButton");
  const calculationResult = document.getElementById("calculationResult");
  const errorMessage = document.getElementById("errorMessage");
  const resortMapSection = document.getElementById("resortMapSection");
  const hotelsResultSection = document.getElementById("hotelsResultSection");
  const loader = document.getElementById("loader");

  // Получаем CSRF-токен
  const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    ?.getAttribute("content");

  // Инициализация datepicker для даты вылета
  if (departureDateInput) {
    // Устанавливаем минимальную дату (завтра)
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    departureDateInput.min = formatDate(tomorrow);

    // Устанавливаем максимальную дату (1 год вперед)
    const nextYear = new Date();
    nextYear.setFullYear(nextYear.getFullYear() + 1);
    departureDateInput.max = formatDate(nextYear);

    // Устанавливаем значение по умолчанию (через 2 недели)
    const twoWeeksLater = new Date();
    twoWeeksLater.setDate(twoWeeksLater.getDate() + 14);
    departureDateInput.value = formatDate(twoWeeksLater);
  }

  // Инициализация слайдера для выбора ночей
  if (nightsSlider && nightsDisplay) {
    nightsSlider.addEventListener("input", function () {
      nightsDisplay.textContent = this.value;
    });

    // Устанавливаем значение по умолчанию
    nightsDisplay.textContent = nightsSlider.value;
  }

  // Инициализация обработчика отправки формы
  if (tourForm) {
    tourForm.addEventListener("submit", function (e) {
      e.preventDefault(); // Предотвращаем стандартную отправку формы
      console.log("Form submitted via event listener!");

      // Проверяем валидность формы
      if (!validateForm()) {
        return;
      }

      // Показываем индикатор загрузки
      if (loader) {
        loader.style.display = "block";
      }

      // Собираем данные формы
      const formData = new FormData(tourForm);
      const formObject = {};

      // Преобразуем FormData в обычный объект
      for (let [key, value] of formData.entries()) {
        formObject[key] = value;
      }

      // Отправляем запрос на сервер для расчета стоимости
      fetch("/calculate/price", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify(formObject),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Ошибка при расчете стоимости: " + response.status);
          }
          return response.json();
        })
        .then((data) => {
          // Скрываем индикатор загрузки
          if (loader) {
            loader.style.display = "none";
          }

          // Отображаем результаты расчета
          displayResult(data, formObject);

          // Показываем блок с результатами
          if (calculationResult) {
            calculationResult.style.display = "block";
          }

          // Сохраняем данные в localStorage
          saveDataToLocalStorage(formObject, data);

          // Генерируем карточки отелей
          generateHotelCards(data);
        })
        .catch((error) => {
          console.error("Ошибка при расчете стоимости:", error);

          // Скрываем индикатор загрузки
          if (loader) {
            loader.style.display = "none";
          }

          showError(
            "Ошибка при расчете стоимости. Пожалуйста, попробуйте еще раз."
          );
        });
    });
  }

  // Обработчик изменения страны
  if (countrySelect) {
    countrySelect.addEventListener("change", function () {
      const country = this.value;

      // Очищаем предыдущие значения
      resortSelect.innerHTML = '<option value="">Выберите курорт</option>';

      if (document.querySelector("#hotel")) {
        document.querySelector("#hotel").innerHTML =
          '<option value="">Сначала выберите курорт</option>';
      }

      if (country) {
        // Показываем индикатор загрузки
        toggleLoading(true);

        // Запрашиваем курорты для выбранной страны
        fetch("/calculate/get-resorts", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
          },
          body: JSON.stringify({ country: country }),
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error(
                "Ошибка при получении курортов: " + response.status
              );
            }
            return response.json();
          })
          .then((data) => {
            // Добавляем полученные курорты в выпадающий список
            if (Array.isArray(data)) {
              data.forEach((resort) => {
                const option = document.createElement("option");
                option.value = resort;
                option.textContent = resort;
                resortSelect.appendChild(option);
              });
            } else {
              console.error("Получены некорректные данные: ", data);
            }

            // Скрываем индикатор загрузки
            toggleLoading(false);
          })
          .catch((error) => {
            console.error("Ошибка при получении курортов:", error);
            toggleLoading(false);
            showError(
              "Ошибка при загрузке курортов. Пожалуйста, попробуйте еще раз."
            );
          });
      }
    });
  }

  // Обработчик изменения курорта
  if (resortSelect) {
    resortSelect.addEventListener("change", function () {
      const resort = this.value;
      const country = countrySelect.value;
      const hotelClass = document.getElementById("hotelClass").value;
      const tourType = document.getElementById("tourType").value;

      // Очищаем предыдущие отели
      if (document.querySelector("#hotel")) {
        document.querySelector("#hotel").innerHTML =
          '<option value="">Выберите отель</option>';
      }

      if (resort) {
        // Показываем индикатор загрузки
        toggleLoading(true);

        // Запрашиваем отели для выбранного курорта
        fetch("/calculate/get-hotels", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
          },
          body: JSON.stringify({
            resort: resort,
            country: country,
            hotelClass: hotelClass,
            tourType: tourType,
          }),
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error(
                "Ошибка при получении отелей: " + response.status
              );
            }
            return response.json();
          })
          .then((data) => {
            // Добавляем полученные отели в выпадающий список
            if (document.querySelector("#hotel")) {
              if (Array.isArray(data)) {
                data.forEach((hotel) => {
                  const option = document.createElement("option");
                  option.value = hotel.name || hotel;
                  option.textContent = hotel.name || hotel;
                  document.querySelector("#hotel").appendChild(option);
                });
              } else {
                console.error("Получены некорректные данные: ", data);
              }
            }

            // Скрываем индикатор загрузки
            toggleLoading(false);
          })
          .catch((error) => {
            console.error("Ошибка при получении отелей:", error);
            toggleLoading(false);
            showError(
              "Ошибка при загрузке отелей. Пожалуйста, попробуйте еще раз."
            );
          });
      }
    });
  }

  // Инициализация выбора типа тура
  initSelector(".tour-type", "tourType");

  // Инициализация выбора класса отеля
  initSelector(".hotel-category", "hotelClass");

  // Инициализация выбора питания
  initSelector(".meal-type", "meal");

  // Инициализация выбора близости к морю
  initSelector(".sea-proximity-type", "seaProximity");

  // Функция для инициализации селекторов с радио-кнопками
  function initSelector(selector, inputId) {
    const elements = document.querySelectorAll(selector);
    const hiddenInput = document.getElementById(inputId);

    if (!elements || !hiddenInput) return;

    elements.forEach((element) => {
      element.addEventListener("click", function () {
        // Удаляем класс active у всех элементов
        elements.forEach((el) => el.classList.remove("active"));

        // Добавляем класс active к выбранному элементу
        this.classList.add("active");

        // Устанавливаем значение в скрытое поле
        hiddenInput.value = this.dataset.value;
      });
    });
  }

  // Функция для имитации расчета цены (в реальном приложении будет API)
  function calculateMockPrice(formData) {
    // Базовая стоимость в зависимости от выбранной страны
    let basePrice = 0;
    switch (formData.country) {
      case "Россия":
        basePrice = 20000;
        break;
      case "Турция":
        basePrice = 45000;
        break;
      case "Египет":
        basePrice = 50000;
        break;
      case "ОАЭ":
        basePrice = 65000;
        break;
      case "Таиланд":
        basePrice = 75000;
        break;
      default:
        basePrice = 30000;
    }

    // Коэффициенты для расчета
    const nightsCoeff = formData.nights * 0.1 + 0.7; // Чем больше ночей, тем дешевле одна ночь
    const touristsCoeff = formData.tourists;

    // Коэффициенты класса отеля
    let hotelClassCoeff = 1;
    switch (formData.hotelClass) {
      case "эконом":
        hotelClassCoeff = 0.8;
        break;
      case "стандарт":
        hotelClassCoeff = 1;
        break;
      case "комфорт":
        hotelClassCoeff = 1.3;
        break;
      case "люкс":
        hotelClassCoeff = 1.8;
        break;
    }

    // Коэффициенты питания
    let mealCoeff = 1;
    switch (formData.meal) {
      case "без питания":
        mealCoeff = 0.85;
        break;
      case "завтрак":
        mealCoeff = 1;
        break;
      case "полупансион":
        mealCoeff = 1.15;
        break;
      case "полный пансион":
        mealCoeff = 1.25;
        break;
      case "все включено":
        mealCoeff = 1.4;
        break;
      case "ультра всё включено":
        mealCoeff = 1.6;
        break;
    }

    // Дополнительные услуги
    let extrasCoeff = 1;
    if (formData.insurance) extrasCoeff += 0.05;
    if (formData.transfer) extrasCoeff += 0.03;
    if (formData.excursions) extrasCoeff += 0.07;
    if (formData.vip) extrasCoeff += 0.15;

    // Сезонный фактор
    const seasonCoeff = getSeasonCoefficientForDate(formData.departureDate);

    // Скидка за раннее бронирование
    const earlyBookingDiscount = isEarlyBooking(formData.departureDate)
      ? 0.95
      : 1;

    // Итоговая цена
    let totalPrice =
      basePrice *
      nightsCoeff *
      touristsCoeff *
      hotelClassCoeff *
      mealCoeff *
      extrasCoeff *
      seasonCoeff *
      earlyBookingDiscount;

    // Округляем до целых
    return Math.round(totalPrice);
  }

  // Функция определения сезонного коэффициента
  function getSeasonCoefficientForDate(dateString) {
    const date = new Date(dateString);
    const month = date.getMonth() + 1; // Месяцы в JS начинаются с 0

    // Высокий сезон: июнь-август, декабрь-январь
    if ((month >= 6 && month <= 8) || month == 12 || month == 1) {
      return 1.3;
    }
    // Средний сезон: май, сентябрь, февраль
    else if (month == 5 || month == 9 || month == 2) {
      return 1.1;
    }
    // Низкий сезон: остальные месяцы
    else {
      return 0.9;
    }
  }

  // Функция определения сезонного фактора для отображения
  function getSeasonFactor(dateString) {
    const date = new Date(dateString);
    const month = date.getMonth() + 1;

    if ((month >= 6 && month <= 8) || month == 12 || month == 1) {
      return "Высокий сезон";
    } else if (month == 5 || month == 9 || month == 2) {
      return "Средний сезон";
    } else {
      return "Низкий сезон";
    }
  }

  // Функция проверки раннего бронирования (за 60+ дней)
  function isEarlyBooking(dateString) {
    const today = new Date();
    const tripDate = new Date(dateString);
    const diffTime = tripDate.getTime() - today.getTime();
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    return diffDays >= 60;
  }

  // Проверка заполнения формы
  function validateForm() {
    const requiredFields = [
      { element: countrySelect, name: "страна" },
      { element: resortSelect, name: "курорт" },
      {
        element: document.getElementById("departureCity"),
        name: "город вылета",
      },
      { element: departureDateInput, name: "дата вылета" },
    ];

    for (const field of requiredFields) {
      if (!field.element || !field.element.value) {
        showError(`Пожалуйста, выберите ${field.name}`);
        return false;
      }
    }

    // Проверка количества туристов
    const tourists = parseInt(document.getElementById("tourists")?.value || 0);
    if (isNaN(tourists) || tourists < 1) {
      showError("Укажите корректное количество туристов");
      return false;
    }

    return true;
  }

  // Отображение результата расчета
  function displayResult(data, formData) {
    if (!calculationResult) {
      console.error("Не найдены контейнеры для отображения результатов");
      return;
    }

    // Отображаем контейнер с результатами
    calculationResult.style.display = "block";

    // Формируем описание тура
    const tourDescription = `
      ${formData.country}, ${formData.resort}, ${
      formData.nights
    } ${getNightsWord(formData.nights)}, 
      ${formData.tourists} ${getPersonsWord(formData.tourists)}, 
      ${getMealDescription(formData.meal)}, вылет ${formatDateForDisplay(
      formData.departureDate
    )}
    `;

    // Обновляем описание тура
    if (tourSummary) {
      tourSummary.textContent = tourDescription;
    }

    // Отображаем общую стоимость
    const totalPriceValue = document.getElementById("totalPriceValue");
    if (totalPriceValue) {
      totalPriceValue.textContent =
        (data.totalPrice || 0).toLocaleString() + " ₽";
    }

    // Отображаем разбивку по ценам
    const accommodationPrice = document.getElementById("accommodationPrice");
    const flightPrice = document.getElementById("flightPrice");
    const mealPrice = document.getElementById("mealPrice");
    const additionalServices = document.getElementById("additionalServices");

    if (accommodationPrice) {
      accommodationPrice.textContent =
        (data.accommodationPrice || 0).toLocaleString() + " ₽";
    }

    if (flightPrice) {
      flightPrice.textContent =
        Math.round((data.totalPrice || 0) * 0.3).toLocaleString() + " ₽";
    }

    if (mealPrice) {
      mealPrice.textContent =
        Math.round((data.totalPrice || 0) * 0.2).toLocaleString() + " ₽";
    }

    // Добавляем дополнительные услуги
    if (additionalServices) {
      additionalServices.innerHTML = "";

      if (formData.insurance) {
        const insuranceItem = document.createElement("div");
        insuranceItem.className = "price-item";
        insuranceItem.innerHTML = `
          <div class="price-label">Страховка</div>
          <div class="price-value">${(
            1500 * formData.tourists
          ).toLocaleString()} ₽</div>
        `;
        additionalServices.appendChild(insuranceItem);
      }

      if (formData.transfer) {
        const transferItem = document.createElement("div");
        transferItem.className = "price-item";
        transferItem.innerHTML = `
          <div class="price-label">Трансфер</div>
          <div class="price-value">${(2000).toLocaleString()} ₽</div>
        `;
        additionalServices.appendChild(transferItem);
      }

      if (formData.excursions) {
        const excursionsItem = document.createElement("div");
        excursionsItem.className = "price-item";
        excursionsItem.innerHTML = `
          <div class="price-label">Экскурсии</div>
          <div class="price-value">${(
            3500 * formData.tourists
          ).toLocaleString()} ₽</div>
        `;
        additionalServices.appendChild(excursionsItem);
      }
    }

    // Плавная прокрутка к результатам
    calculationResult.scrollIntoView({ behavior: "smooth" });
  }

  // Показ/скрытие индикатора загрузки
  function toggleLoading(show) {
    if (loadingIndicator) {
      loadingIndicator.style.display = show ? "block" : "none";
    }
  }

  // Отображение сообщения об ошибке
  function showError(message) {
    const errorElement = document.getElementById("errorMessage");
    if (errorElement) {
      errorElement.textContent = message;
      errorElement.style.display = "block";

      // Скрываем сообщение через 5 секунд
      setTimeout(() => {
        errorElement.style.display = "none";
      }, 5000);
    } else {
      // Fallback к стандартному alert, если нет элемента для ошибок
      alert(message);
    }
  }

  // Сохранение данных в localStorage
  function saveDataToLocalStorage(formData, resultData) {
    try {
      localStorage.setItem(
        "tourCalculatorData",
        JSON.stringify({
          formData: formData,
          result: resultData,
          timestamp: new Date().toISOString(),
        })
      );
    } catch (error) {
      console.error("Ошибка при сохранении данных в localStorage:", error);
    }
  }

  // Загрузка сохраненных данных
  function loadFromLocalStorage() {
    try {
      const savedData = JSON.parse(localStorage.getItem("tourCalculatorData"));
      if (savedData && savedData.formData) {
        const formData = savedData.formData;

        // Заполняем форму сохраненными данными
        if (countrySelect) countrySelect.value = formData.country;
        if (departureDateInput)
          departureDateInput.value = formData.departureDate;
        if (document.getElementById("meal"))
          document.getElementById("meal").value = formData.meal;
        if (document.getElementById("hotelClass"))
          document.getElementById("hotelClass").value = formData.hotelClass;
        if (document.getElementById("insurance"))
          document.getElementById("insurance").checked = formData.insurance;
        if (document.getElementById("transfer"))
          document.getElementById("transfer").checked = formData.transfer;

        // Устанавливаем количество туристов
        if (adultsInput) adultsInput.value = formData.tourists;
        if (childrenInput) childrenInput.value = formData.children || 0;
        if (document.getElementById("tourists"))
          document.getElementById("tourists").value = formData.tourists;

        // Устанавливаем количество ночей
        if (nightsSlider) {
          nightsSlider.value = formData.nights;
          nightsDisplay.textContent = formData.nights;
        }
        if (document.getElementById("nights"))
          document.getElementById("nights").value = formData.nights;

        // Загружаем курорты и отели, если выбрана страна
        if (formData.country) {
          countrySelect.dispatchEvent(new Event("change"));

          // Небольшая задержка перед выбором курорта (ждем загрузки курортов)
          setTimeout(() => {
            if (resortSelect && formData.resort) {
              resortSelect.value = formData.resort;
              resortSelect.dispatchEvent(new Event("change"));

              // Небольшая задержка перед выбором отеля (ждем загрузки отелей)
              setTimeout(() => {
                if (hotelSelect && formData.hotel) {
                  hotelSelect.value = formData.hotel;
                }
              }, 500);
            }
          }, 500);
        }
      }
    } catch (error) {
      console.error("Ошибка при загрузке данных из localStorage:", error);
    }
  }

  // Форматирование даты для input[type="date"]
  function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const day = String(date.getDate()).padStart(2, "0");
    return `${year}-${month}-${day}`;
  }

  // Форматирование даты для отображения
  function formatDateForDisplay(dateString) {
    const options = { day: "numeric", month: "long", year: "numeric" };
    return new Date(dateString).toLocaleDateString("ru-RU", options);
  }

  // Получение правильного склонения слова "ночь"
  function getNightsWord(nights) {
    nights = parseInt(nights);
    if (nights % 10 === 1 && nights % 100 !== 11) {
      return "ночь";
    } else if (
      [2, 3, 4].includes(nights % 10) &&
      ![12, 13, 14].includes(nights % 100)
    ) {
      return "ночи";
    } else {
      return "ночей";
    }
  }

  // Получение правильного склонения слова "человек"
  function getPersonsWord(persons) {
    persons = parseInt(persons);
    if (persons % 10 === 1 && persons % 100 !== 11) {
      return "взрослый";
    } else {
      return "взрослых";
    }
  }

  // Получение правильного склонения слова "ребенок"
  function getChildrenWord(children) {
    children = parseInt(children);
    if (children % 10 === 1 && children % 100 !== 11) {
      return "ребенок";
    } else if (
      [2, 3, 4].includes(children % 10) &&
      ![12, 13, 14].includes(children % 100)
    ) {
      return "ребенка";
    } else {
      return "детей";
    }
  }

  // Получение описания типа питания
  function getMealDescription(mealType) {
    const mealDescriptions = {
      "без питания": "Без питания (RO)",
      завтрак: "Завтрак (BB)",
      полупансион: "Завтрак и ужин (HB)",
      "все включено": "Всё включено (AI)",
    };

    return mealDescriptions[mealType] || mealType;
  }

  // Обработчик для кнопки показа отелей
  if (showHotelsButton) {
    showHotelsButton.addEventListener("click", function () {
      hotelsResultSection.style.display = "block";

      // Добавим плавную прокрутку к секции отелей
      hotelsResultSection.scrollIntoView({ behavior: "smooth" });

      // Тут можно было бы загрузить отели с сервера, но для демонстрации просто создадим несколько тестовых
      generateHotelCards();
    });
  }

  // Функция для создания карточки отеля или экскурсии
  function createHotelCard(hotel) {
    const cardDiv = document.createElement("div");
    cardDiv.className = `hotel-card ${hotel.filters
      .split(",")
      .map((f) => `filter-${f}`)
      .join(" ")} sea-${hotel.seaProximity}`;
    cardDiv.dataset.tour = JSON.stringify(hotel);

    const stars = generateStars(hotel.stars);

    // Разное содержимое карточки для тура или экскурсии
    if (hotel.isExcursion) {
      // Карточка для экскурсии
      cardDiv.innerHTML = `
        <div class="hotel-card-image">
          <img src="${
            hotel.image.startsWith("/img")
              ? hotel.image
              : hotel.isExcursion 
                ? "/img/excursions/" + hotel.image.replace('excursions/', '')
                : "/img/tours/" + hotel.image.replace('tours/', '')
          }" alt="${hotel.name}">
          <div class="hotel-duration">${hotel.excursionData.duration}</div>
        </div>
        <div class="hotel-card-content">
          <div class="hotel-info">
            <div class="hotel-name">${hotel.name}</div>
            <div class="hotel-location"><i class="fas fa-map-marker-alt"></i> ${
              hotel.location
            }</div>
            <div class="hotel-description">${hotel.description.substring(
              0,
              100
            )}${hotel.description.length > 100 ? "..." : ""}</div>
          </div>
          <div class="hotel-price">
            <div class="price-label">Стоимость:</div>
            <div class="price-value">${formatPrice(hotel.price)} ₽</div>
            <div class="price-details">на человека</div>
          </div>
        </div>
        <div class="hotel-card-actions">
          <button class="btn btn-primary">Подробнее</button>
        </div>
      `;
    } else {
      // Карточка для тура
      cardDiv.innerHTML = `
        <div class="hotel-card-image">
          <img src="${
            hotel.image.startsWith("/img")
              ? hotel.image
              : hotel.isExcursion 
                ? "/img/excursions/" + hotel.image.replace('excursions/', '')
                : "/img/tours/" + hotel.image.replace('tours/', '')
          }" alt="${hotel.name}">
          <div class="hotel-duration">${hotel.tourData.nights} ${getNightsWord(
        hotel.tourData.nights
      )}</div>
        </div>
        <div class="hotel-card-content">
          <div class="hotel-info">
            <div class="hotel-name">${hotel.name}</div>
            <div class="hotel-location"><i class="fas fa-map-marker-alt"></i> ${
              hotel.location
            }</div>
            <div class="hotel-stars">${stars}</div>
            <div class="hotel-description">${hotel.description.substring(
              0,
              100
            )}${hotel.description.length > 100 ? "..." : ""}</div>
          </div>
          <div class="hotel-price">
            <div class="price-label">Цена за тур:</div>
            <div class="price-value">${formatPrice(hotel.price)} ₽</div>
            <div class="price-details">${hotel.tourData.nights} ${getNightsWord(
        hotel.tourData.nights
      )}, ${hotel.tourData.tourists} ${getPersonsWord(
        hotel.tourData.tourists
      )}</div>
          </div>
        </div>
        <div class="hotel-card-actions">
          <button class="btn btn-primary">Подробнее</button>
        </div>
      `;
    }

    return cardDiv;
  }

  // Функция для генерации звезд
  function generateStars(count) {
    let stars = "";
    for (let i = 0; i < count; i++) {
      stars += '<i class="fas fa-star"></i>';
    }
    return stars;
  }

  // Генерация карточек отелей
  function generateHotelCards(data) {
    // Очищаем контейнер карточек отелей
    const hotelCards = document.getElementById("hotelCards");
    if (!hotelCards) return;

    hotelCards.innerHTML = "";

    // Проверяем, есть ли данные по турам
    if (!data.matchingTours || data.matchingTours.length === 0) {
      // Если туры не найдены, показываем сообщение
      const noResultsMessage = document.createElement("div");
      noResultsMessage.className = "no-results-message";
      noResultsMessage.innerHTML = `
        <i class="fas fa-exclamation-circle"></i>
        <p>По вашим параметрам не найдено подходящих туров</p>
        <p>Попробуйте изменить параметры поиска</p>
      `;
      hotelCards.appendChild(noResultsMessage);
      return;
    }

    // Получаем выбранные параметры из формы
    const country = document.getElementById("country").value;
    const resort = document.getElementById("resort").value;
    const nights = document.getElementById("nightsSlider").value;
    const tourists = document.getElementById("tourists").value;
    const departureDate = document.getElementById("departureDate").value;
    const meal = document.getElementById("meal").value;

    // Добавляем заголовок для туров
    const toursHeading = document.createElement("h3");
    toursHeading.className = "section-subheading";
    toursHeading.textContent = "Подходящие туры";
    hotelCards.appendChild(toursHeading);

    // Создаем карточки для каждого тура из базы данных
    data.matchingTours.forEach((tour) => {
      // Преобразуем данные тура в формат для карточки
      const hotelData = {
        name: tour.name,
        location: tour.location,
        image: tour.image_path || "/img/tours/tour-placeholder.jpg", // Используем путь к изображению или заглушку
        stars:
          tour.type === "Люкс"
            ? 5
            : tour.type === "Комфорт"
            ? 4
            : tour.type === "Стандарт"
            ? 3
            : 2,
        reviews: "0 отзывов", // В будущем здесь будут реальные отзывы
        price: tour.price,
        filters:
          "all," +
          (tour.type.toLowerCase() === "пляжный" ? "beach," : "") +
          (tour.location.toLowerCase().includes("центр") ? "center," : "") +
          (tour.features &&
          tour.features.some((f) => f.toLowerCase().includes("басс"))
            ? "pool,"
            : "") +
          (tour.features &&
          tour.features.some((f) => f.toLowerCase().includes("дет"))
            ? "family"
            : ""),
        seaProximity: "any", // По умолчанию
        rating: 4.0, // По умолчанию
        reviewsCount: 0,
        description: tour.description,
        images: [tour.image_path || "/img/tours/tour-placeholder.jpg"],
        features: tour.features || [],
        // Добавляем данные из параметров поиска
        tourData: {
          nights: tour.duration || nights,
          tourists: tourists,
          departureDate: formatDateForDisplay(tour.start_date) || departureDate,
          meal: getMealDescription(meal),
          id: tour.id, // Сохраняем ID тура для возможности бронирования
        },
      };

      // Создаем карточку тура
      const hotelCard = createHotelCard(hotelData);
      hotelCards.appendChild(hotelCard);
    });

    // Если есть экскурсии, добавляем их в отдельном блоке
    if (data.matchingExcursions && data.matchingExcursions.length > 0) {
      // Добавляем разделитель
      const divider = document.createElement("div");
      divider.className = "cards-divider";
      hotelCards.appendChild(divider);

      // Добавляем заголовок для экскурсий
      const excursionsHeading = document.createElement("h3");
      excursionsHeading.className = "section-subheading";
      excursionsHeading.textContent = "Рекомендуемые экскурсии";
      hotelCards.appendChild(excursionsHeading);

      // Создаем карточки для каждой экскурсии
      data.matchingExcursions.forEach((excursion) => {
        // Преобразуем данные экскурсии в формат для карточки
        const excursionData = {
          name: excursion.name,
          location: excursion.location + ", " + excursion.region,
          image: excursion.image_path || "/img/excursion-placeholder.jpg",
          stars: 4, // Условное значение для экскурсии
          reviews: "0 отзывов",
          price: excursion.price,
          filters: "all,excursion",
          seaProximity: "any",
          rating: 4.0,
          reviewsCount: 0,
          description: excursion.description,
          images: [excursion.image_path || "/img/excursion-placeholder.jpg"],
          features: excursion.features || [],
          isExcursion: true, // Помечаем, что это экскурсия
          // Данные специфичные для экскурсии
          excursionData: {
            duration:
              excursion.duration +
              " " +
              (excursion.duration == 1 ? "день" : "дня"),
            tourists: tourists,
            id: excursion.id,
          },
        };

        // Создаем карточку экскурсии
        const excursionCard = createHotelCard(excursionData);
        hotelCards.appendChild(excursionCard);
      });
    }

    // Добавляем обработчики для фильтров отелей
    const filterChips = document.querySelectorAll(".filter-chip[data-filter]");
    if (filterChips.length > 0) {
      filterChips.forEach((chip) => {
        chip.addEventListener("click", function () {
          // Удаляем активный класс у всех чипов этой группы
          filterChips.forEach((c) => c.classList.remove("active"));

          // Добавляем активный класс к нажатому чипу
          this.classList.add("active");

          // Фильтруем отели
          filterHotels();
        });
      });
    }

    // Добавляем обработчики для фильтров по близости к морю
    const seaFilterChips = document.querySelectorAll(
      ".filter-chip[data-sea-filter]"
    );
    if (seaFilterChips.length > 0) {
      seaFilterChips.forEach((chip) => {
        chip.addEventListener("click", function () {
          // Удаляем активный класс у всех чипов этой группы
          seaFilterChips.forEach((c) => c.classList.remove("active"));

          // Добавляем активный класс к нажатому чипу
          this.classList.add("active");

          // Фильтруем отели
          filterHotels();
        });
      });
    }

    // Автоматически отображаем секцию отелей
    const hotelsSection = document.getElementById("hotelsSection");
    if (hotelsSection) {
      hotelsSection.style.display = "block";

      // Плавно прокручиваем к секции с отелями
      setTimeout(() => {
        hotelsSection.scrollIntoView({ behavior: "smooth" });
      }, 300);
    }

    // Прикрепляем обработчики кликов к карточкам туров
    attachTourCardClickHandlers();
  }

  // Инициализация карты, если есть соответствующий раздел
  if (document.getElementById("resortMap")) {
    // Код для инициализации Яндекс.Карты будет здесь
    // В реальном приложении он должен загружать точки курортов
  }

  // Обработчик для кнопки сброса параметров
  if (resetButton) {
    resetButton.addEventListener("click", function () {
      // Сбрасываем значения формы
      if (tourForm) tourForm.reset();

      // Устанавливаем значения по умолчанию
      if (nightsSlider) {
        nightsSlider.value = 7;
        nightsDisplay.textContent = "7";
      }

      if (document.getElementById("tourists")) {
        document.getElementById("tourists").value = 2;
      }

      // Сбрасываем активные классы
      document.querySelectorAll(".hotel-category.active").forEach((el) => {
        el.classList.remove("active");
      });
      document
        .querySelector('.hotel-category[data-value="стандарт"]')
        ?.classList.add("active");

      document.querySelectorAll(".meal-type.active").forEach((el) => {
        el.classList.remove("active");
      });
      document
        .querySelector('.meal-type[data-value="завтрак"]')
        ?.classList.add("active");

      document.querySelectorAll(".tour-type.active").forEach((el) => {
        el.classList.remove("active");
      });
      document
        .querySelector('.tour-type[data-value="beach"]')
        ?.classList.add("active");

      // Сбрасываем скрытые поля
      if (document.getElementById("hotelClass"))
        document.getElementById("hotelClass").value = "стандарт";
      if (document.getElementById("meal"))
        document.getElementById("meal").value = "завтрак";
      if (document.getElementById("tourType"))
        document.getElementById("tourType").value = "beach";

      // Скрываем результаты и раздел отелей
      if (calculationResult) calculationResult.style.display = "none";
      if (hotelsResultSection) hotelsResultSection.style.display = "none";
      if (resortMapSection) resortMapSection.style.display = "none";

      // Очищаем локальное хранилище
      localStorage.removeItem("tourCalculatorData");
    });
  }

  // Обработчики для кнопок выбора питания
  const mealTypeButtons = document.querySelectorAll(".meal-type");
  const mealInput = document.getElementById("meal");

  if (mealTypeButtons.length > 0 && mealInput) {
    mealTypeButtons.forEach((button) => {
      button.addEventListener("click", function () {
        // Удаляем активный класс у всех кнопок
        mealTypeButtons.forEach((btn) => btn.classList.remove("active"));

        // Добавляем активный класс к нажатой кнопке
        this.classList.add("active");

        // Устанавливаем значение в скрытом поле
        mealInput.value = this.dataset.value;
      });
    });
  }

  // Обработчики для кнопок +/- туристов
  const decreaseTouristsBtn = document.getElementById("decreaseTourists");
  const increaseTouristsBtn = document.getElementById("increaseTourists");
  const touristsInput = document.getElementById("tourists");

  if (decreaseTouristsBtn && increaseTouristsBtn && touristsInput) {
    decreaseTouristsBtn.addEventListener("click", function () {
      let currentValue = parseInt(touristsInput.value);
      if (currentValue > 1) {
        touristsInput.value = currentValue - 1;
      }
    });

    increaseTouristsBtn.addEventListener("click", function () {
      let currentValue = parseInt(touristsInput.value);
      if (currentValue < 10) {
        touristsInput.value = currentValue + 1;
      }
    });
  }

  // Загружаем сохраненные данные при загрузке страницы
  loadFromLocalStorage();

  // Инициализация обработчика кнопки расчета
  if (calculateButton) {
    calculateButton.addEventListener("click", function (e) {
      console.log("Calculate button clicked!");

      // Проверяем валидность формы
      if (!validateForm()) {
        return;
      }

      // Показываем индикатор загрузки
      if (loader) {
        loader.style.display = "block";
      }

      // Собираем данные формы
      const formData = new FormData(tourForm);
      const formObject = {};

      // Преобразуем FormData в обычный объект
      for (let [key, value] of formData.entries()) {
        formObject[key] = value;
      }

      // Отправляем запрос на сервер для расчета стоимости
      fetch("/calculate/price", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify(formObject),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Ошибка при расчете стоимости: " + response.status);
          }
          return response.json();
        })
        .then((data) => {
          // Скрываем индикатор загрузки
          if (loader) {
            loader.style.display = "none";
          }

          // Отображаем результаты расчета
          displayResult(data, formObject);

          // Показываем блок с результатами
          if (calculationResult) {
            calculationResult.style.display = "block";
          }

          // Сохраняем данные в localStorage
          saveDataToLocalStorage(formObject, data);

          // Генерируем карточки отелей
          generateHotelCards(data);
        })
        .catch((error) => {
          console.error("Ошибка при расчете стоимости:", error);

          // Скрываем индикатор загрузки
          if (loader) {
            loader.style.display = "none";
          }

          showError(
            "Ошибка при расчете стоимости. Пожалуйста, попробуйте еще раз."
          );
        });
    });
  }

  // Функционал модального окна с подробностями тура
  const tourModal = document.getElementById("tour-detail-modal");
  const closeButton = document.querySelector(".tour-modal-close");

  if (tourModal && closeButton) {
    // Закрытие модального окна при клике на крестик
    closeButton.addEventListener("click", function () {
      tourModal.style.display = "none";
    });

    // Закрытие модального окна при клике вне его области
    window.addEventListener("click", function (event) {
      if (event.target === tourModal) {
        tourModal.style.display = "none";
      }
    });

    // Обработка переключения миниатюр в галерее
    const thumbnails = document.querySelectorAll(".thumbnail");
    const mainImage = document.getElementById("tour-main-image");

    thumbnails.forEach((thumbnail) => {
      thumbnail.addEventListener("click", function () {
        // Убираем класс active у всех миниатюр
        thumbnails.forEach((thumb) => thumb.classList.remove("active"));

        // Добавляем класс active текущей миниатюре
        this.classList.add("active");

        // Устанавливаем основное изображение
        mainImage.src = this.src;
      });
    });
  }

  // Прикрепляем обработчики к карточкам туров/экскурсий
  function attachTourCardClickHandlers() {
    const tourCards = document.querySelectorAll(".hotel-card");
    const tourModal = document.getElementById("tour-detail-modal");

    if (!tourCards.length || !tourModal) return;

    tourCards.forEach((card) => {
      card.addEventListener("click", function () {
        const tourData = JSON.parse(this.dataset.tour || "{}");

        // Заполняем данные о туре или экскурсии в модальном окне
        if (tourData.isExcursion) {
          // Для экскурсий
          document.getElementById("tour-title").textContent =
            tourData.name || "Название экскурсии";
          document.getElementById("tour-location").textContent =
            tourData.location || "Местоположение";
          document.getElementById("tour-date").textContent =
            "Доступно для бронирования";
          document.getElementById("tour-duration").textContent =
            tourData.excursionData?.duration || "1 день";
          document.getElementById("tour-group-size").textContent = `до ${
            tourData.excursionData?.maxGroupSize || 20
          } человек`;
          document.getElementById("tour-sea-distance").textContent = "Н/Д";
          document.getElementById("tour-description-text").textContent =
            tourData.description || "Описание экскурсии";
          document.getElementById("tour-price-value").textContent =
            formatPrice(tourData.price || 0) + " ₽ на человека";

          // Обновляем список особенностей
          updateFeaturesList(
            tourData.features || [
              "Профессиональный гид",
              "Трансфер от/до отеля",
              "Входные билеты",
              "Фотосъемка",
            ]
          );
        } else {
          // Для туров
          document.getElementById("tour-title").textContent =
            tourData.name || "Название тура";
          document.getElementById("tour-location").textContent =
            tourData.location || "Местоположение";

          // Формируем дату на основе информации о туре
          const dateText = tourData.tourData?.departureDate || "По запросу";
          document.getElementById("tour-date").textContent = dateText;

          // Длительность
          document.getElementById("tour-duration").textContent = `${
            tourData.tourData?.nights || "7"
          } ночей`;

          // Количество туристов
          document.getElementById("tour-group-size").textContent = `${
            tourData.tourData?.tourists || "2"
          } человека`;

          // Расстояние до моря
          document.getElementById("tour-sea-distance").textContent =
            getSeaProximityText(tourData.seaProximity || "any");

          // Описание
          document.getElementById("tour-description-text").textContent =
            tourData.description || "Описание тура";

          // Цена
          document.getElementById("tour-price-value").textContent = formatPrice(
            tourData.price || 0
          );

          // Обновляем список особенностей
          updateFeaturesList(
            tourData.features || [
              "Проживание в отеле",
              "Питание по выбранной программе",
              "Авиаперелет туда-обратно",
              "Трансфер из/в аэропорт",
              "Медицинская страховка",
            ]
          );
        }

        // Заполняем звезды рейтинга
        const starsContainer = document.getElementById("tour-stars");
        if (starsContainer) {
          starsContainer.innerHTML = generateStarsHtml(tourData.rating || 4.0);
        }

        // Установка рейтинга
        document.getElementById("tour-rating").textContent =
          tourData.rating || "4.0";
        document.getElementById("tour-reviews").textContent = `(${
          tourData.reviewsCount || 0
        } отзывов)`;

        // Устанавливаем основное изображение
        const mainImage = document.getElementById("tour-main-image");
        if (mainImage) {
          mainImage.src = tourData.image || "/img/tours/tour-placeholder.jpg";
          mainImage.alt = tourData.name;
        }

        // Заполняем миниатюры, если они есть
        const thumbnails = document.querySelectorAll(
          ".tour-thumbnails .thumbnail"
        );
        if (thumbnails.length > 0 && tourData.images) {
          thumbnails.forEach((thumb, index) => {
            if (index < tourData.images.length) {
              thumb.src = tourData.images[index];
              thumb.alt = `${tourData.name} - фото ${index + 1}`;
              thumb.style.display = "block";

              // Добавляем обработчик клика на миниатюру
              thumb.onclick = function () {
                // Удаляем активный класс со всех миниатюр
                thumbnails.forEach((t) => t.classList.remove("active"));
                // Добавляем активный класс к текущей миниатюре
                this.classList.add("active");
                // Обновляем основное изображение
                mainImage.src = this.src;
              };
            } else {
              thumb.style.display = "none";
            }
          });

          // Делаем первую миниатюру активной
          if (thumbnails.length > 0) {
            thumbnails[0].classList.add("active");
          }
        }

        // Отображаем модальное окно
        tourModal.style.display = "block";
      });
    });

    // Закрытие модального окна
    const closeBtn = document.querySelector(".tour-modal-close");
    if (closeBtn) {
      closeBtn.addEventListener("click", function () {
        tourModal.style.display = "none";
      });
    }

    // Закрытие модального окна при клике вне его
    window.addEventListener("click", function (event) {
      if (event.target === tourModal) {
        tourModal.style.display = "none";
      }
    });
  }

  // Функция для обновления списка особенностей тура
  function updateFeaturesList(features) {
    const featuresList = document.getElementById("tour-features-list");
    if (!featuresList) return;

    featuresList.innerHTML = "";

    features.forEach((feature) => {
      const li = document.createElement("li");
      li.innerHTML = `<i class="fas fa-check"></i> ${feature}`;
      featuresList.appendChild(li);
    });
  }

  // Функция для отображения звезд рейтинга
  function generateStarsHtml(rating) {
    let html = "";
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 >= 0.5;

    for (let i = 0; i < fullStars; i++) {
      html += '<i class="fas fa-star"></i>';
    }

    if (hasHalfStar) {
      html += '<i class="fas fa-star-half-alt"></i>';
    }

    const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
    for (let i = 0; i < emptyStars; i++) {
      html += '<i class="far fa-star"></i>';
    }

    return html;
  }

  // Форматирование цены
  function formatPrice(price) {
    return new Intl.NumberFormat("ru-RU").format(price) + " ₽";
  }

  // Функция для получения текстового описания близости к морю
  function getSeaProximityText(proximity) {
    const descriptions = {
      "first-line": "1-я линия",
      "up-to-500": "До 500 метров",
      "over-500": "Более 500 метров",
      any: "Не указано",
    };

    return descriptions[proximity] || "Не указано";
  }
});
