/**
 * JavaScript для работы с модальным окном туров
 */
document.addEventListener("DOMContentLoaded", function () {
  const tourModal = document.getElementById("tour-modal");
  const closeModalButton = document.querySelector(".close-modal");

  // Пример данных о турах (в реальном приложении будут загружаться с сервера)
  const mockTourData = {
    Турция: {
      name: "Отдых в Турции - All Inclusive",
      location: "Анталия, Турция",
      rating: 4.7,
      reviews: 58,
      price: 84800,
      description:
        'Насладитесь незабываемым отдыхом на лазурном побережье Турецкой Ривьеры. Вас ждут первоклассные отели с системой "всё включено", чистейшие пляжи с бирюзовой водой и богатое культурное наследие.',
      features: [
        "Проживание в отеле 5* (7 ночей)",
        'Питание "всё включено"',
        "Авиаперелет туда-обратно",
        "Групповой трансфер из/в аэропорт",
        "Медицинская страховка",
      ],
      images: [
        "https://example.com/images/turkey1.jpg",
        "https://example.com/images/turkey2.jpg",
        "https://example.com/images/turkey3.jpg",
        "https://example.com/images/turkey4.jpg",
      ],
    },
    Египет: {
      name: "Курорты Красного моря",
      location: "Хургада, Египет",
      rating: 4.5,
      reviews: 42,
      price: 79500,
      description:
        "Откройте для себя удивительный подводный мир Красного моря и древние тайны Египта. Прекрасные отели с отличным сервисом, теплое море круглый год и увлекательные экскурсии сделают ваш отдых по-настоящему незабываемым.",
      features: [
        "Проживание в отеле 4* (7 ночей)",
        'Питание "всё включено"',
        "Авиаперелет туда-обратно",
        "Трансфер из/в аэропорт",
        "Медицинская страховка",
        "Возможность заказа экскурсий",
      ],
      images: [
        "https://example.com/images/egypt1.jpg",
        "https://example.com/images/egypt2.jpg",
        "https://example.com/images/egypt3.jpg",
        "https://example.com/images/egypt4.jpg",
      ],
    },
    ОАЭ: {
      name: "Роскошный отдых в ОАЭ",
      location: "Дубай, ОАЭ",
      rating: 4.8,
      reviews: 64,
      price: 105300,
      description:
        "Погрузитесь в атмосферу роскоши и неповторимого арабского гостеприимства. Ультрасовременные отели, белоснежные пляжи, впечатляющие небоскребы и крупнейшие торговые центры мира – всё это ждет вас в ОАЭ.",
      features: [
        "Проживание в отеле 5* (7 ночей)",
        "Питание завтрак+ужин",
        "Авиаперелет туда-обратно",
        "Индивидуальный трансфер из/в аэропорт",
        "Расширенная медицинская страховка",
        "Приветственный ужин",
      ],
      images: [
        "https://example.com/images/uae1.jpg",
        "https://example.com/images/uae2.jpg",
        "https://example.com/images/uae3.jpg",
        "https://example.com/images/uae4.jpg",
      ],
    },
  };

  // Функция для показа модального окна с информацией о туре
  window.showTourModal = function (searchParams) {
    if (!tourModal) return;

    // Выбираем тур на основе параметров поиска
    const selectedTour =
      mockTourData[searchParams.direction] || mockTourData["Турция"];

    // Заполняем данными модальное окно
    document.getElementById("tour-modal-title").textContent = selectedTour.name;
    document.querySelector(".rating-value").textContent = selectedTour.rating;
    document.querySelector(
      ".reviews-count"
    ).textContent = `(${selectedTour.reviews} отзывов)`;

    // Заполняем звезды рейтинга
    const starsContainer = document.querySelector(".stars");
    if (starsContainer) {
      starsContainer.innerHTML = "";
      const fullStars = Math.floor(selectedTour.rating);
      const hasHalfStar = selectedTour.rating % 1 >= 0.5;

      for (let i = 0; i < fullStars; i++) {
        starsContainer.innerHTML += '<i class="fas fa-star"></i>';
      }

      if (hasHalfStar) {
        starsContainer.innerHTML += '<i class="fas fa-star-half-alt"></i>';
      }

      const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
      for (let i = 0; i < emptyStars; i++) {
        starsContainer.innerHTML += '<i class="far fa-star"></i>';
      }
    }

    // Заполняем детали тура
    document.getElementById("tour-location").textContent =
      selectedTour.location;

    // Форматируем даты
    const dateText = searchParams.dates || "Гибкие даты";
    document.getElementById("tour-date").textContent = dateText;

    // Количество ночей
    const nights = searchParams.nights || 7;
    document.getElementById("tour-duration").textContent = `${nights} ночей`;

    // Размер группы (количество туристов)
    const tourists = searchParams.tourists || 2;
    document.getElementById("tour-group-size").textContent = `${tourists} чел.`;

    // Описание тура
    document.getElementById("tour-description-text").textContent =
      selectedTour.description;

    // Включенные услуги
    const featuresContainer = document.getElementById("tour-features-list");
    if (featuresContainer) {
      featuresContainer.innerHTML = "";
      selectedTour.features.forEach((feature) => {
        featuresContainer.innerHTML += `<li><i class="fas fa-check"></i> ${feature}</li>`;
      });
    }

    // Цена
    const priceElement = document.getElementById("tour-price-value");
    if (priceElement) {
      // Адаптируем цену под выбранные параметры
      let adjustedPrice = selectedTour.price;

      // Учитываем количество ночей
      const baseNights = 7;
      adjustedPrice = adjustedPrice * (nights / baseNights);

      // Учитываем количество туристов
      adjustedPrice = adjustedPrice * tourists;

      // Форматируем цену
      priceElement.textContent =
        new Intl.NumberFormat("ru-RU").format(Math.round(adjustedPrice)) + " ₽";
    }

    // Устанавливаем изображение тура
    const mainImage = document.getElementById("tour-main-image");
    if (mainImage && selectedTour.images && selectedTour.images.length > 0) {
      mainImage.src = selectedTour.images[0];
      mainImage.alt = selectedTour.name;

      // Заполняем миниатюры
      const thumbnails = document.querySelectorAll(".thumbnail");
      thumbnails.forEach((thumbnail, index) => {
        if (index < selectedTour.images.length) {
          thumbnail.src = selectedTour.images[index];
          thumbnail.alt = `${selectedTour.name} - фото ${index + 1}`;
        }
      });

      // Добавляем обработчики кликов на миниатюры
      thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener("click", function () {
          // Удаляем активный класс у всех миниатюр
          thumbnails.forEach((t) => t.classList.remove("active"));

          // Добавляем активный класс текущей миниатюре
          this.classList.add("active");

          // Меняем основное изображение
          if (index < selectedTour.images.length) {
            mainImage.src = selectedTour.images[index];
          }
        });
      });
    }

    // Показываем модальное окно
    tourModal.style.display = "block";
  };

  // Закрытие модального окна при клике на крестик
  if (closeModalButton) {
    closeModalButton.addEventListener("click", function () {
      tourModal.style.display = "none";
    });
  }

  // Закрытие модального окна при клике вне его области
  window.addEventListener("click", function (event) {
    if (event.target === tourModal) {
      tourModal.style.display = "none";
    }
  });

  // Обработчик для кнопки бронирования
  const bookTourButton = document.querySelector(".btn-book-tour");
  if (bookTourButton) {
    bookTourButton.addEventListener("click", function () {
      // Проверяем авторизацию пользователя
      const isLoggedIn =
        document
          .querySelector('meta[name="user-authenticated"]')
          ?.getAttribute("content") === "true";

      if (!isLoggedIn) {
        // Если пользователь не авторизован, перенаправляем на страницу входа
        const currentUrl = encodeURIComponent(window.location.href);
        window.location.href = `/login?redirect=${currentUrl}`;
        return;
      }

      // Если пользователь авторизован, показываем форму бронирования
      showBookingModal();
    });
  }

  // Функция показа модального окна бронирования
  function showBookingModal() {
    // Закрываем модальное окно тура
    if (tourModal) {
      tourModal.style.display = "none";
    }

    // Показываем модальное окно бронирования
    const bookingModal = document.getElementById("booking-modal");
    if (bookingModal) {
      bookingModal.style.display = "block";

      // Заполняем данные из калькулятора
      fillBookingFormFromCalculator();
    } else {
      // Если модальное окно бронирования не найдено, создаем его
      createBookingModal();
    }
  }

  // Функция заполнения формы бронирования данными из калькулятора
  function fillBookingFormFromCalculator() {
    try {
      // Получаем данные из localStorage (сохраненные после расчета)
      const calculatorData = JSON.parse(
        localStorage.getItem("calculatorData") || "{}"
      );
      const resultData = JSON.parse(
        localStorage.getItem("calculatorResult") || "{}"
      );

      // Заполняем поля формы
      const form = document.getElementById("booking-form");
      if (form && calculatorData && resultData) {
        // Дата поездки
        const dateField = form.querySelector('input[name="booking_date"]');
        if (dateField && calculatorData.departureDate) {
          dateField.value = calculatorData.departureDate;
        }

        // Количество человек
        const personsField = form.querySelector('input[name="persons"]');
        if (personsField && calculatorData.tourists) {
          personsField.value = calculatorData.tourists;
        }

        // Общая стоимость
        const priceField = form.querySelector('input[name="total_price"]');
        if (priceField && resultData.totalPrice) {
          priceField.value = resultData.totalPrice;
        }

        // Отображаем информацию о туре
        const tourInfo = form.querySelector(".booking-tour-info");
        if (tourInfo) {
          tourInfo.innerHTML = `
            <h4>${calculatorData.country}, ${calculatorData.resort}</h4>
            <p>${calculatorData.nights} ночей, ${
            calculatorData.tourists
          } человек</p>
            <p>Класс отеля: ${calculatorData.hotelClass}</p>
            <p>Питание: ${calculatorData.meal}</p>
            <p><strong>Стоимость: ${
              resultData.totalPrice?.toLocaleString() || 0
            } ₽</strong></p>
          `;
        }
      }
    } catch (error) {
      console.error("Ошибка при заполнении формы бронирования:", error);
    }
  }

  // Функция создания модального окна бронирования (если его нет)
  function createBookingModal() {
    const modalHtml = `
      <div id="booking-modal" class="modal">
        <div class="modal-content">
          <span class="close-modal" onclick="closeBookingModal()">&times;</span>
          <h2>Бронирование тура</h2>
          
          <div class="booking-tour-info"></div>
          
          <form id="booking-form" action="/calculator/book" method="POST" class="main-booking-form">
            <input type="hidden" name="_token" value="${
              document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content") || ""
            }">
            <input type="hidden" name="tour_type" value="calculator">
            <input type="hidden" name="total_price" value="">
            
            <div class="form-group">
              <label for="guest_name">Ваше имя *</label>
              <input type="text" id="guest_name" name="guest_name" required class="form-control">
            </div>
            
            <div class="form-group">
              <label for="guest_email">Email *</label>
              <input type="email" id="guest_email" name="guest_email" required class="form-control">
            </div>
            
            <div class="form-group">
              <label for="guest_phone">Телефон *</label>
              <input type="tel" id="guest_phone" name="guest_phone" required class="form-control">
            </div>
            
            <div class="form-group">
              <label for="booking_date">Дата поездки *</label>
              <input type="date" id="booking_date" name="booking_date" required class="form-control">
            </div>
            
            <div class="form-group">
              <label for="persons">Количество человек *</label>
              <input type="number" id="persons" name="persons" min="1" max="10" required class="form-control">
            </div>
            
            <div class="form-group">
              <label for="special_requests">Особые пожелания</label>
              <textarea id="special_requests" name="special_requests" class="form-control" rows="3"></textarea>
            </div>
            
            <div class="form-actions">
              <button type="submit" class="btn btn-primary">Отправить заявку</button>
              <button type="button" class="btn btn-secondary" onclick="closeBookingModal()">Отмена</button>
            </div>
          </form>
        </div>
      </div>
    `;

    document.body.insertAdjacentHTML("beforeend", modalHtml);

    // Показываем созданное модальное окно
    const bookingModal = document.getElementById("booking-modal");
    if (bookingModal) {
      bookingModal.style.display = "block";
      fillBookingFormFromCalculator();
    }
  }

  // Функция закрытия модального окна бронирования
  window.closeBookingModal = function () {
    const bookingModal = document.getElementById("booking-modal");
    if (bookingModal) {
      bookingModal.style.display = "none";
    }
  };

  // Обработчик для кнопки "В избранное"
  const addFavoriteButton = document.querySelector(".btn-add-favorite");
  if (addFavoriteButton) {
    addFavoriteButton.addEventListener("click", function () {
      // Изменяем иконку
      const heartIcon = this.querySelector("i");
      if (heartIcon.classList.contains("far")) {
        heartIcon.classList.remove("far");
        heartIcon.classList.add("fas");
        alert("Тур добавлен в избранное!");
      } else {
        heartIcon.classList.remove("fas");
        heartIcon.classList.add("far");
        alert("Тур удален из избранного");
      }
    });
  }
});
