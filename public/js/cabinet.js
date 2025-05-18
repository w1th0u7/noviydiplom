document.addEventListener("DOMContentLoaded", function () {
  // Обработка формы настроек
  const settingsForm = document.querySelector(".settings-form form");
  if (settingsForm) {
    settingsForm.addEventListener("submit", function (e) {
      const password = document.getElementById("password");
      const passwordConfirm = document.getElementById("password_confirmation");

      // Если пользователь заполнил поле пароля, проверяем совпадение
      if (password.value && password.value !== passwordConfirm.value) {
        e.preventDefault();
        alert("Пароли не совпадают");
        return false;
      }
    });
  }

  // Добавляем анимацию для карточек на дашборде
  const dashboardCards = document.querySelectorAll(".dashboard-card");
  if (dashboardCards.length) {
    dashboardCards.forEach((card) => {
      card.addEventListener("mouseenter", function () {
        this.style.transform = "translateY(-5px)";
        this.style.boxShadow = "0 5px 15px rgba(0,0,0,0.08)";
      });

      card.addEventListener("mouseleave", function () {
        this.style.transform = "translateY(0)";
        this.style.boxShadow = "none";
      });
    });
  }
});
