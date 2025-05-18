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
});
