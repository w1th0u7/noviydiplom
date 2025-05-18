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

  // Обработчик для кнопки расчета стоимости
  if (calculateButton) {
    calculateButton.addEventListener("click", function (e) {
      e.preventDefault(); // Предотвращаем стандартную отправку формы

      // Проверка заполнения формы
      if (!validateForm()) {
        showError("Пожалуйста, заполните все обязательные поля формы");
        return;
      }

      // Показываем индикатор загрузки
      const loader = document.getElementById("loader");
      if (loader) loader.style.display = "block";

      // Собираем данные формы
      const formData = {
        tourType: document.getElementById("tourType").value,
        country: countrySelect.value,
        resort: resortSelect.value,
        departureCity: document.getElementById("departureCity").value,
        departureDate: departureDateInput.value,
        nights: nightsSlider.value,
        tourists: parseInt(document.getElementById("tourists").value) || 2,
        hotelClass: document.getElementById("hotelClass").value,
        meal: document.getElementById("meal").value,
        insurance: document.getElementById("insurance").checked,
        transfer: document.getElementById("transfer").checked,
        excursions: document.getElementById("excursions").checked,
        seaProximity: document.getElementById("seaProximity").value,
      };

      // Получаем CSRF-токен
      const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");

      // Отправка данных на сервер для расчета
      fetch("/calculate/price", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify(formData),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Ошибка при расчете стоимости: " + response.status);
          }
          return response.json();
        })
        .then((data) => {
          // Скрываем индикатор загрузки
          if (loader) loader.style.display = "none";

          // Отображаем результат
          displayResult(data, formData);

          // Сохраняем данные в localStorage
          saveDataToLocalStorage(formData, data);
        })
        .catch((error) => {
          console.error("Ошибка при расчете стоимости:", error);

          // Скрываем индикатор загрузки
          if (loader) loader.style.display = "none";

          showError(
            "Ошибка при расчете стоимости. Пожалуйста, попробуйте еще раз."
          );

          // В случае ошибки используем имитацию данных
          const result = {
            basePrice: calculateMockPrice(formData),
            accommodationPrice: Math.round(calculateMockPrice(formData) * 0.7),
            extrasPrice: Math.round(calculateMockPrice(formData) * 0.3),
            totalPrice: calculateMockPrice(formData),
          };

          // Отображаем результат
          displayResult(result, formData);
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

  // Генерация карточек отелей
  function generateHotelCards() {
    const hotelCards = document.getElementById("hotelCards");
    if (!hotelCards) return;

    // Очищаем предыдущие результаты
    hotelCards.innerHTML = "";

    // Получаем выбранные параметры
    const country = countrySelect.value;
    const resort = resortSelect.value;
    const hotelClass = document.getElementById("hotelClass").value;

    // Примеры отелей (в реальном приложении они должны загружаться с сервера)
    const hotels = [
      {
        name: "Grand Resort & Spa",
        location: resort + ", " + country,
        image: "/img/image 5.jpg",
        stars: 5,
        reviews: 320,
        price: 65000,
        tags: ["beach", "pool", "center"],
      },
      {
        name: "Морской бриз",
        location: resort + ", " + country,
        image: "/img/image 6.jpg",
        stars: 4,
        reviews: 184,
        price: 42000,
        tags: ["beach", "family"],
      },
      {
        name: "Sunshine Hotel",
        location: resort + ", " + country,
        image: "/img/image 7.jpg",
        stars: 3,
        reviews: 95,
        price: 35000,
        tags: ["center", "pool"],
      },
      {
        name: "Azure Bay Resort",
        location: resort + ", " + country,
        image: "/img/image 8.jpg",
        stars: 5,
        reviews: 210,
        price: 78000,
        tags: ["beach", "family", "pool"],
      },
    ];

    // Создаем карточки отелей
    hotels.forEach((hotel) => {
      const hotelCard = document.createElement("div");
      hotelCard.className = "hotel-card";
      hotel.tags.forEach((tag) => (hotelCard.dataset[tag] = "true"));

      hotelCard.innerHTML = `
        <div class="hotel-card-image">
          <img src="${hotel.image}" alt="${hotel.name}">
        </div>
        <div class="hotel-card-content">
          <h3 class="hotel-card-name">${hotel.name}</h3>
          <div class="hotel-card-location">
            <i class="fas fa-map-marker-alt"></i>
            <span>${hotel.location}</span>
          </div>
          <div class="hotel-card-rating">
            <div class="hotel-card-stars">
              ${Array(hotel.stars).fill('<i class="fas fa-star"></i>').join("")}
            </div>
            <div class="hotel-card-reviews">${hotel.reviews} отзывов</div>
          </div>
          <div class="hotel-card-price">
            <div class="price-label">За весь тур:</div>
            <div class="price-value">${hotel.price.toLocaleString()} ₽</div>
          </div>
        </div>
      `;

      hotelCards.appendChild(hotelCard);
    });

    // Добавляем обработчики для фильтров отелей
    const filterChips = document.querySelectorAll(".filter-chip");
    if (filterChips.length > 0) {
      filterChips.forEach((chip) => {
        chip.addEventListener("click", function () {
          // Удаляем активный класс у всех чипов
          filterChips.forEach((c) => c.classList.remove("active"));

          // Добавляем активный класс к нажатому чипу
          this.classList.add("active");

          // Фильтруем отели
          const filter = this.dataset.filter;
          const cards = document.querySelectorAll(".hotel-card");

          cards.forEach((card) => {
            if (filter === "all" || card.dataset[filter]) {
              card.style.display = "flex";
            } else {
              card.style.display = "none";
            }
          });
        });
      });
    }
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

  // Функция для открытия модального окна с информацией о туре
  window.showTourDetails = function (tourData) {
    if (!tourModal) return;

    // Заполняем информацию о туре
    document.getElementById("tour-title").textContent =
      tourData.name || "Название тура";
    document.getElementById("tour-location").textContent =
      tourData.location || "Местоположение";
    document.getElementById("tour-rating").textContent =
      tourData.rating || "4.5";
    document.getElementById("tour-reviews").textContent = `(${
      tourData.reviews || 0
    } отзывов)`;
    document.getElementById("tour-description-text").textContent =
      tourData.description || "Описание тура";
    document.getElementById("tour-sea-distance").textContent =
      getSeaProximityText(tourData.seaProximity);
    document.getElementById("tour-price-value").textContent = formatPrice(
      tourData.price || 0
    );

    // Заполняем звезды рейтинга
    const starsContainer = document.getElementById("tour-stars");
    if (starsContainer) {
      starsContainer.innerHTML = generateStarsHtml(tourData.rating || 4.5);
    }

    // Устанавливаем изображения
    if (tourData.images && tourData.images.length > 0) {
      mainImage.src = tourData.images[0];
      mainImage.alt = tourData.name;

      // Заполняем миниатюры
      thumbnails.forEach((thumb, index) => {
        if (index < tourData.images.length) {
          thumb.src = tourData.images[index];
          thumb.alt = `${tourData.name} - фото ${index + 1}`;
          thumb.style.display = "block";
        } else {
          thumb.style.display = "none";
        }
      });
    }

    // Отображаем особенности тура
    const featuresList = document.getElementById("tour-features-list");
    if (featuresList && tourData.features) {
      featuresList.innerHTML = "";
      tourData.features.forEach((feature) => {
        featuresList.innerHTML += `<li><i class="fas fa-check"></i> ${feature}</li>`;
      });
    }

    // Отображаем модальное окно
    tourModal.style.display = "block";
  };

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

  // Добавляем обработчики клика по карточкам отелей для открытия модального окна
  function attachTourCardClickHandlers() {
    const hotelCards = document.querySelectorAll(".hotel-card");

    hotelCards.forEach((card) => {
      card.addEventListener("click", function (event) {
        // Предотвращаем обработку клика по кнопкам внутри карточки
        if (event.target.closest(".hotel-card-actions")) {
          return;
        }

        // Получаем данные о туре из атрибута data-tour
        let tourData;
        try {
          tourData = JSON.parse(this.dataset.tour || "{}");
        } catch (e) {
          console.error("Ошибка при парсинге данных тура:", e);
          tourData = {};
        }

        // Открываем модальное окно
        window.showTourDetails(tourData);
      });
    });
  }

  // Вызываем функцию добавления обработчиков при генерации карточек отелей
  document.addEventListener("hotelCardsGenerated", attachTourCardClickHandlers);
});
