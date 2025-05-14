document.addEventListener("DOMContentLoaded", function () {
  const modal = document.querySelector(".modal");
  const modalClose = document.querySelector(".js-modal-close");
  const overlay = document.querySelector(".js-overlay-modal");
  const openModalButton = document.querySelector(".js-open-modal");
  const form = document.querySelector("form");

  if (modal && modalClose && overlay && openModalButton && form) {
    modal.classList.remove("active");
    overlay.classList.remove("active");

    openModalButton.addEventListener("click", function () {
      modal.classList.add("active");
      overlay.classList.add("active");
    });

    modalClose.addEventListener("click", function () {
      modal.classList.remove("active");
      overlay.classList.remove("active");
      window.location.href = "/";
    });

    overlay.addEventListener("click", function (e) {
      if (e.target === overlay) {
        modal.classList.remove("active");
        overlay.classList.remove("active");
        window.location.href = "/";
      }
    });

    form.addEventListener("submit", function (e) {
      e.preventDefault();

      const formData = new FormData(this);
      const data = {};

      for (const [key, value] of formData) {
        data[key] = value;
      }

      localStorage.setItem("orderCalls", JSON.stringify(data));

      // Обновлям форму после отправки
      this.reset();

      // Выведите сообщение об успехе
      document.querySelector(".uspeh").style.display = "block";
      setTimeout(function () {
        document.querySelector(".uspeh").style.display = "none";
      }, 3000);

      window.location.href = "/";
    });
  }
});
