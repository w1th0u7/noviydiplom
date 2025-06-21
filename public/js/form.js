document.addEventListener("DOMContentLoaded", function () {
  // Находим форму с id "order-call-form" на странице
  const orderCallForm = document.getElementById("order-call-form");

  if (orderCallForm) {
    // Добавляем обработчик события отправки формы
    orderCallForm.addEventListener("submit", function (e) {
      e.preventDefault(); // Предотвращаем стандартную отправку
      console.log("Form submitted via AJAX");

      // Собираем данные формы
      const formData = new FormData(this);
      const submitButton = this.querySelector('button[type="submit"]');
      const originalButtonText = submitButton.textContent;

      // Показываем индикатор загрузки
      submitButton.disabled = true;
      submitButton.textContent = "Отправка...";

      // Отправляем AJAX запрос
      fetch(this.action, {
        method: "POST",
        body: formData,
        headers: {
          "X-Requested-With": "XMLHttpRequest",
          Accept: "application/json",
        },
      })
        .then((response) => {
          if (!response.ok) {
            return response.json().then((data) => Promise.reject(data));
          }
          return response.json();
        })
        .then((data) => {
          // Успешная отправка
          showSuccessMessage();
          this.reset(); // Очищаем форму
        })
        .catch((error) => {
          console.error("Error:", error);
          if (error.errors) {
            showErrorMessage("Пожалуйста, исправьте ошибки в форме");
          } else {
            showErrorMessage(
              "Произошла ошибка при отправке. Попробуйте еще раз."
            );
          }
        })
        .finally(() => {
          // Восстанавливаем кнопку
          submitButton.disabled = false;
          submitButton.textContent = originalButtonText;
        });
    });

    // Функция показа сообщения об успехе
    function showSuccessMessage() {
      const formBlock = orderCallForm.closest(".block");

      // Удаляем предыдущие сообщения
      const existingMessages = formBlock.querySelectorAll(".form-message");
      existingMessages.forEach((msg) => msg.remove());

      // Создаем сообщение об успехе
      const successMessage = document.createElement("div");
      successMessage.className = "form-message success-message";
      successMessage.innerHTML = `
                <div class="message-content">
                    <i class="message-icon">✓</i>
                    <div class="message-text">
                        <h4>Спасибо за вашу заявку!</h4>
                        <p>Наш менеджер свяжется с вами в ближайшее время.</p>
                    </div>
                </div>
            `;

      // Вставляем сообщение перед формой
      formBlock.insertBefore(successMessage, orderCallForm);

      // Добавляем анимацию появления
      setTimeout(() => {
        successMessage.classList.add("show");
      }, 100);

      // Скрываем сообщение через 5 секунд
      setTimeout(() => {
        successMessage.classList.remove("show");
        setTimeout(() => {
          if (successMessage.parentNode) {
            successMessage.remove();
          }
        }, 500);
      }, 5000);
    }

    // Функция показа сообщения об ошибке
    function showErrorMessage(message) {
      const formBlock = orderCallForm.closest(".block");

      // Удаляем предыдущие сообщения
      const existingMessages = formBlock.querySelectorAll(".form-message");
      existingMessages.forEach((msg) => msg.remove());

      // Создаем сообщение об ошибке
      const errorMessage = document.createElement("div");
      errorMessage.className = "form-message error-message";
      errorMessage.innerHTML = `
                <div class="message-content">
                    <i class="message-icon">⚠</i>
                    <div class="message-text">
                        <h4>Ошибка отправки</h4>
                        <p>${message}</p>
                    </div>
                </div>
            `;

      // Вставляем сообщение перед формой
      formBlock.insertBefore(errorMessage, orderCallForm);

      // Добавляем анимацию появления
      setTimeout(() => {
        errorMessage.classList.add("show");
      }, 100);

      // Скрываем сообщение через 4 секунды
      setTimeout(() => {
        errorMessage.classList.remove("show");
        setTimeout(() => {
          if (errorMessage.parentNode) {
            errorMessage.remove();
          }
        }, 500);
      }, 4000);
    }
  } else {
    console.log("Form element not found");
  }
});
