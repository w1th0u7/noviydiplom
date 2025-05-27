/**
 * JavaScript для форм бронирования
 */
document.addEventListener("DOMContentLoaded", function () {
  console.log("Booking JS loaded");

  // Показ/скрытие формы бронирования
  const showFormButtons = document.querySelectorAll(".show-booking-form");
  console.log("Found " + showFormButtons.length + " booking buttons");

  showFormButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      console.log("Booking button clicked");
      e.preventDefault();

      // Более точный способ найти форму бронирования
      const bookingForm = document.querySelector(".booking-form");
      console.log("Form found:", bookingForm);

      if (bookingForm) {
        console.log("Showing booking form");
        bookingForm.style.display = "block";
        this.style.display = "none"; // Скрываем кнопку

        // Плавная прокрутка к форме
        bookingForm.scrollIntoView({ behavior: "smooth", block: "start" });
      } else {
        console.error("Booking form not found!");
      }
    });
  });

  // Расчет итоговой стоимости при изменении количества человек
  const personsInputs = document.querySelectorAll(
    '.booking-form input[name="persons"]'
  );
  console.log("Found " + personsInputs.length + " persons inputs");

  personsInputs.forEach((input) => {
    input.addEventListener("input", function () {
      const form = this.closest("form");
      const personsCount = form.querySelector("#persons-count") || document.getElementById("persons-count");
      const totalPrice = form.querySelector("#total-price") || document.getElementById("total-price");
      
      console.log("Updating price calculation");
      console.log("Persons count element:", personsCount);
      console.log("Total price element:", totalPrice);

      if (personsCount && totalPrice) {
        const persons = parseInt(this.value) || 1;
        const price = parseFloat(this.dataset.price) || 0;
        
        console.log("Persons:", persons, "Price:", price);

        personsCount.textContent = persons;
        totalPrice.textContent = new Intl.NumberFormat("ru-RU").format(
          price * persons
        );
      }
    });
  });

  // Закрытие формы бронирования
  const closeButtons = document.querySelectorAll(".close-booking-form");
  console.log("Found " + closeButtons.length + " close buttons");

  closeButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault();
      console.log("Close booking form clicked");

      // Находим форму по классу
      const bookingForm = document.querySelector(".booking-form");
      const showButton = document.querySelector(".show-booking-form");

      if (bookingForm && showButton) {
        console.log("Hiding booking form");
        bookingForm.style.display = "none";
        showButton.style.display = "block";
      } else {
        console.error("Could not find booking form or show button");
        console.log("Booking form:", bookingForm);
        console.log("Show button:", showButton);
      }
    });
  });

  // Обработчик отправки основной формы бронирования
  const mainBookingForm = document.querySelector(".main-booking-form");
  if (mainBookingForm) {
    console.log("Found main booking form, adding submit handler");
    
    mainBookingForm.addEventListener("submit", function(e) {
      // НЕ прерываем отправку формы, просто логируем для отладки
      console.log("Main booking form submitted");
      
      // Проверяем все ли поля заполнены
      const requiredFields = mainBookingForm.querySelectorAll("[required]");
      let allFieldsValid = true;
      
      requiredFields.forEach(field => {
        if (!field.value.trim()) {
          console.error(`Required field ${field.name} is empty`);
          allFieldsValid = false;
          field.classList.add("error");
        } else {
          field.classList.remove("error");
        }
      });
      
      // Если есть незаполненные поля, предотвращаем отправку
      if (!allFieldsValid) {
        console.error("Form has validation errors");
        e.preventDefault();
        return false;
      }
      
      console.log("Form validation passed, submitting to server...");
      
      // Блокируем кнопку отправки для предотвращения двойной отправки
      const submitButton = mainBookingForm.querySelector("button[type='submit']");
      if (submitButton) {
        submitButton.disabled = true;
        submitButton.textContent = "Отправка...";
      }
      
      // Логирование данных формы для отладки
      const formData = new FormData(mainBookingForm);
      console.log("Form data:");
      for (const [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
      }
      
      // Продолжаем стандартную отправку формы
      return true;
    });
  } else {
    console.warn("Main booking form not found on page");
  }

  // Проверка CSRF токена в формах
  const bookingForms = document.querySelectorAll("form");
  bookingForms.forEach(form => {
    // Добавлять только к формам, которые отправляются на сервер через POST
    if (form.method.toLowerCase() === 'post') {
      const hasToken = form.querySelector('input[name="_token"]');
      if (!hasToken) {
        console.warn("Form without CSRF token:", form);
        // Добавляем CSRF токен, если его нет
        const token = document.querySelector('meta[name="csrf-token"]');
        if (token) {
          const input = document.createElement('input');
          input.type = 'hidden';
          input.name = '_token';
          input.value = token.content;
          form.appendChild(input);
          console.log("Added CSRF token to form");
        }
      }
    }
  });
});
