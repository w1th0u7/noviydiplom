document.addEventListener("DOMContentLoaded", function () {
  console.log("Login JS initialized");

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
    console.log("Login form found");
    loginForm.addEventListener("submit", function (e) {
      console.log("Login form submitted");
      const email = document.getElementById("email");
      const password = document.getElementById("password");

      if (!validateInput(email) || !validateInput(password)) {
        console.log("Login validation failed");
        e.preventDefault();
      } else {
        console.log("Login validation passed, submitting form normally");
      }
    });
  }

  if (registerForm) {
    console.log("Registration form found");
    registerForm.addEventListener("submit", function (e) {
      console.log("Registration form submitted");
      const name = document.getElementById("name");
      const email = document.getElementById("email");
      const password = document.getElementById("password");
      const passwordConfirmation = document.getElementById(
        "password_confirmation"
      );

      let isValid = true;

      if (!validateInput(name)) {
        console.log("Name validation failed");
        isValid = false;
      }

      if (!validateInput(email)) {
        console.log("Email validation failed");
        isValid = false;
      }

      if (!validateInput(password)) {
        console.log("Password validation failed");
        isValid = false;
      }

      if (!validateInput(passwordConfirmation)) {
        console.log("Password confirmation validation failed");
        isValid = false;
      }

      // Проверка совпадения паролей
      if (password.value !== passwordConfirmation.value) {
        console.log("Passwords do not match");
        showError(passwordConfirmation, "Пароли не совпадают");
        isValid = false;
      }

      if (!isValid) {
        console.log(
          "Registration validation failed, preventing form submission"
        );
        e.preventDefault();
      } else {
        console.log(
          "Registration validation passed, submitting form normally to: " +
            registerForm.action
        );
        // Убедимся, что форма отправляется как обычная HTML форма
        return true;
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
    const formGroup = input.closest(".form-group");

    // Создаем элемент с сообщением об ошибке, если его еще нет
    if (!formGroup.querySelector(".error-message")) {
      const errorElement = document.createElement("div");
      errorElement.className = "error-message";
      errorElement.textContent = message;

      // Находим текущую подсказку required-field, если есть
      const requiredField = formGroup.querySelector(".required-field");

      // Вставляем сообщение об ошибке после поля ввода или группы input-group
      const inputGroup = formGroup.querySelector(".input-group");
      if (inputGroup) {
        inputGroup.insertAdjacentElement("afterend", errorElement);
      } else {
        input.insertAdjacentElement("afterend", errorElement);
      }

      // Скрываем подсказку required-field если она есть
      if (requiredField) {
        requiredField.style.display = "none";
      }
    } else {
      formGroup.querySelector(".error-message").textContent = message;
    }

    input.classList.add("error");
  }

  // Функция для очистки ошибки
  function clearError(input) {
    const formGroup = input.closest(".form-group");
    const errorElement = formGroup.querySelector(".error-message");
    const requiredField = formGroup.querySelector(".required-field");

    if (errorElement) {
      errorElement.remove();

      // Показываем подсказку required-field снова, если она есть
      if (requiredField) {
        requiredField.style.display = "block";
      }
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
