// Скрипты для админ-панели

document.addEventListener("DOMContentLoaded", function () {
  // Автоматически скрывать уведомления через 5 секунд
  const alerts = document.querySelectorAll(".alert");
  if (alerts.length) {
    setTimeout(function () {
      alerts.forEach((alert) => {
        alert.style.opacity = "0";
        setTimeout(() => {
          alert.style.display = "none";
        }, 500);
      });
    }, 5000);
  }

  // Подтверждение удаления
  const deleteForms = document.querySelectorAll(".delete-form");
  deleteForms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      if (
        !confirm(
          "Вы уверены, что хотите удалить этот элемент? Это действие нельзя отменить."
        )
      ) {
        e.preventDefault();
      }
    });
  });

  // Улучшение элементов выбора файлов
  const fileInputs = document.querySelectorAll('input[type="file"]');
  fileInputs.forEach((input) => {
    input.addEventListener("change", function (e) {
      const fileName = this.files[0]?.name;
      const fileInfo = this.parentElement.querySelector(".file-upload-info");

      if (fileName && fileInfo) {
        fileInfo.textContent = `Выбран файл: ${fileName}`;
      }
    });
  });

  // Сохранение активной вкладки при перезагрузке страницы
  const currentPath = window.location.pathname;
  const navLinks = document.querySelectorAll(".admin-nav a");

  navLinks.forEach((link) => {
    const linkPath = link.getAttribute("href");
    if (currentPath.includes(linkPath)) {
      link.classList.add("active");
    }
  });

  // Обработка превью изображений
  handleImagePreview();

  // Добавляем обработчики для форм удаления
  deleteForms.forEach(function (form) {
    form.addEventListener("submit", function (e) {
      const confirmMessage =
        form.dataset.confirm || "Вы уверены, что хотите удалить этот элемент?";
      if (!confirmDelete(confirmMessage)) {
        e.preventDefault();
      }
    });
  });

  // Улучшенная валидация форм
  const forms = document.querySelectorAll(".admin-form");
  forms.forEach(function (form) {
    form.addEventListener("submit", function (e) {
      // Проверяем обязательные поля
      const requiredFields = form.querySelectorAll("[required]");
      let hasErrors = false;

      requiredFields.forEach(function (field) {
        if (!field.value.trim()) {
          field.style.borderColor = "#dc3545";
          hasErrors = true;
        } else {
          field.style.borderColor = "";
        }
      });

      if (hasErrors) {
        e.preventDefault();
        alert("Пожалуйста, заполните все обязательные поля.");
      }
    });
  });

  // Автоматическая очистка сообщений об ошибках при фокусе на поле
  const inputFields = document.querySelectorAll(".form-control");
  inputFields.forEach(function (field) {
    field.addEventListener("focus", function () {
      this.style.borderColor = "";
      const errorMessage = this.parentNode.querySelector(".error-message");
      if (errorMessage) {
        errorMessage.style.display = "none";
      }
    });
  });
});

// Функция для отображения превью изображения
function handleImagePreview() {
  const imageInput = document.getElementById("image");
  const previewContainer = document.getElementById("imagePreviewContainer");
  const previewImage = document.getElementById("imagePreview");

  if (imageInput && previewContainer && previewImage) {
    imageInput.addEventListener("change", function (event) {
      const file = event.target.files[0];

      if (file) {
        // Проверяем, что файл является изображением
        if (file.type.startsWith("image/")) {
          const reader = new FileReader();

          reader.onload = function (e) {
            previewImage.src = e.target.result;
            previewContainer.classList.add("show");
          };

          reader.readAsDataURL(file);
        } else {
          // Если файл не является изображением, скрываем превью
          previewContainer.classList.remove("show");
          alert("Пожалуйста, выберите файл изображения (JPG, JPEG, PNG).");
        }
      } else {
        // Если файл не выбран, скрываем превью
        previewContainer.classList.remove("show");
      }
    });
  }
}

// Функция для подтверждения удаления
function confirmDelete(message) {
  return confirm(message || "Вы уверены, что хотите удалить этот элемент?");
}

// Функция для отображения уведомлений
function showNotification(message, type = "success") {
  const notification = document.createElement("div");
  notification.className = `alert alert-${type}`;
  notification.textContent = message;
  notification.style.position = "fixed";
  notification.style.top = "20px";
  notification.style.right = "20px";
  notification.style.zIndex = "9999";
  notification.style.minWidth = "300px";

  document.body.appendChild(notification);

  // Автоматически удаляем уведомление через 5 секунд
  setTimeout(function () {
    if (notification.parentNode) {
      notification.parentNode.removeChild(notification);
    }
  }, 5000);
}

// Функция для копирования текста в буфер обмена
function copyToClipboard(text) {
  if (navigator.clipboard) {
    navigator.clipboard.writeText(text).then(function () {
      showNotification("Текст скопирован в буфер обмена");
    });
  } else {
    // Fallback для старых браузеров
    const textArea = document.createElement("textarea");
    textArea.value = text;
    document.body.appendChild(textArea);
    textArea.select();
    document.execCommand("copy");
    document.body.removeChild(textArea);
    showNotification("Текст скопирован в буфер обмена");
  }
}
