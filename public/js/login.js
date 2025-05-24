document.addEventListener("DOMContentLoaded", function () {
  // Валидация формы при вводе данных
  const inputs = document.querySelectorAll(".form-group input");

  inputs.forEach((input) => {
    // Добавляем классы при фокусе/расфокусе для анимации
    input.addEventListener("focus", function () {
      this.classList.add("focused");
      this.parentElement.classList.add("input-focused");
    });

    input.addEventListener("blur", function () {
      if (this.value.trim() === "") {
        this.classList.remove("focused");
        this.parentElement.classList.remove("input-focused");
      }
    });

    // Простая валидация ввода
    input.addEventListener("input", function () {
      validateInput(this);
    });
  });

  // Валидация формы при отправке
  const loginForm = document.getElementById("loginForm");
  const registerForm = document.getElementById("registerForm");

  if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
      const email = document.getElementById("email");
      const password = document.getElementById("password");

      if (!validateInput(email) || !validateInput(password)) {
        e.preventDefault();
      }
    });
  }

  if (registerForm) {
    registerForm.addEventListener("submit", function (e) {
      const name = document.getElementById("name");
      const email = document.getElementById("email");
      const password = document.getElementById("password");
      const passwordConfirmation = document.getElementById(
        "password_confirmation"
      );

      if (
        !validateInput(name) ||
        !validateInput(email) ||
        !validateInput(password) ||
        !validateInput(passwordConfirmation)
      ) {
        e.preventDefault();
      }

      // Проверка совпадения паролей
      if (password.value !== passwordConfirmation.value) {
        showError(passwordConfirmation, "Пароли не совпадают");
        e.preventDefault();
      }
    });
  }

  // Функция валидации полей формы
  function validateInput(input) {
    const value = input.value.trim();

    // Очистка предыдущих ошибок
    clearError(input);

    // Проверка на пустое поле
    if (value === "") {
      showError(input, "Это поле обязательно для заполнения");
      return false;
    }

    // Валидация email
    if (input.type === "email") {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(value)) {
        showError(input, "Введите корректный email адрес");
        return false;
      }
    }

    // Валидация пароля
    if (input.id === "password" && value.length < 6) {
      showError(input, "Пароль должен содержать минимум 6 символов");
      return false;
    }

    return true;
  }

  // Функция для отображения ошибки
  function showError(input, message) {
    const formGroup = input.parentElement;

    // Создаем элемент с сообщением об ошибке, если его еще нет
    if (!formGroup.querySelector(".error-message")) {
      const errorElement = document.createElement("div");
      errorElement.className = "error-message";
      errorElement.textContent = message;
      formGroup.appendChild(errorElement);
    } else {
      formGroup.querySelector(".error-message").textContent = message;
    }

    input.classList.add("error");
  }

  // Функция для очистки ошибки
  function clearError(input) {
    const formGroup = input.parentElement;
    const errorElement = formGroup.querySelector(".error-message");

    if (errorElement) {
      errorElement.remove();
    }

    input.classList.remove("error");
  }

  // Автоматическая анимация успешных и ошибочных сообщений (flash messages)
  const alerts = document.querySelectorAll(".alert");

  if (alerts.length > 0) {
    alerts.forEach((alert) => {
      // Добавляем класс для анимации
      setTimeout(() => {
        alert.classList.add("alert-show");
      }, 100);

      // Автоматическое скрытие success-сообщений через 5 секунд
      if (alert.classList.contains("alert-success")) {
        setTimeout(() => {
          alert.classList.add("alert-hide");

          setTimeout(() => {
            alert.remove();
          }, 500); // После завершения анимации удаляем элемент
        }, 5000);
      }
    });
  }

  // Адаптация высоты формы под контент
  function adjustFormHeight() {
    const wrapper = document.querySelector(".registr-wrapper");
    if (wrapper) {
      const windowHeight = window.innerHeight;
      const wrapperHeight = wrapper.offsetHeight;

      if (wrapperHeight > windowHeight - 100) {
        document.querySelector(".banner-home").style.height = "auto";
        document.querySelector(".banner-home .swiper-slide").style.height =
          "auto";
      }
    }
  }

  // Вызываем функцию при загрузке и изменении размера окна
  adjustFormHeight();
  window.addEventListener("resize", adjustFormHeight);
});
