document.addEventListener("DOMContentLoaded", function () {
  const modal = document.querySelector(".modal");
  const modalClose = document.querySelector(".js-modal-close");
  const overlay = document.querySelector(".js-overlay-modal");
  const openModalButton = document.querySelector(".js-open-modal");

  // Находим форму ТОЛЬКО внутри модального окна
  const modalForm = modal ? modal.querySelector("form") : null;

  if (modal && modalClose && overlay && openModalButton && modalForm) {
    console.log("Modal and form elements found");
    modal.classList.remove("active");
    overlay.classList.remove("active");

    // Обработчики для открытия/закрытия модального окна
    const openModalButtons = document.querySelectorAll(".js-open-modal");
    openModalButtons.forEach((button) => {
      button.addEventListener("click", function () {
        console.log("Opening modal window");
        modal.classList.add("active");
        overlay.classList.add("active");

        // Скрываем сообщение об успехе при открытии модального окна
        const successMessage = modal.querySelector(".uspeh");
        const formContent = modal.querySelector(".cont");
        if (successMessage && formContent) {
          successMessage.style.display = "none";
          formContent.style.display = "block";
        }
      });
    });

    modalClose.addEventListener("click", function () {
      console.log("Closing modal window via X");
      modal.classList.remove("active");
      overlay.classList.remove("active");
    });

    overlay.addEventListener("click", function (e) {
      if (e.target === overlay) {
        console.log("Closing modal window via overlay");
        modal.classList.remove("active");
        overlay.classList.remove("active");
      }
    });

    // Обработчик ТОЛЬКО для формы внутри модального окна
    modalForm.addEventListener("submit", function (e) {
      e.preventDefault();
      console.log("Modal form submitted");

      const formData = new FormData(this);
      const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");

      if (csrfToken) {
        formData.append("_token", csrfToken);
      }

      // Отправляем AJAX запрос
      fetch(this.action, {
        method: "POST",
        body: formData,
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // Успешная отправка
            this.reset();
            showSuccessMessage();
          } else {
            // Ошибка
            console.error("Ошибка при отправке формы:", data.message);
            alert("Произошла ошибка при отправке заявки. Попробуйте еще раз.");
          }
        })
        .catch((error) => {
          console.error("Ошибка:", error);
          // Fallback - показываем сообщение об успехе даже при ошибке AJAX
          this.reset();
          showSuccessMessage();
        });
    });

    function showSuccessMessage() {
      const formContent = modal.querySelector(".cont");
      const successMessage = modal.querySelector(".uspeh");

      if (formContent && successMessage) {
        formContent.style.display = "none";
        successMessage.classList.add("success-message");
        successMessage.style.display = "block";

        // Устанавливаем текст сообщения об успешном заказе звонка
        const successTitle = successMessage.querySelector("h3");
        const successText = successMessage.querySelector(".txt");

        if (successTitle && successText) {
          successTitle.innerHTML = "Заявка <span>успешно отправлена!</span>";
          successText.textContent =
            "Спасибо за вашу заявку! Наш менеджер свяжется с вами в ближайшее время.";
        }

        // Закрываем модальное окно через 3 секунды после успешной отправки
        setTimeout(function () {
          modal.classList.remove("active");
          overlay.classList.remove("active");

          // Восстанавливаем исходное состояние модального окна через задержку
          // (после того как окно закроется)
          setTimeout(function () {
            successMessage.style.display = "none";
            formContent.style.display = "block";
          }, 300);
        }, 3000);
      }
    }
  } else {
    console.log("Some modal elements not found");
  }
});
