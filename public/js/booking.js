/**
 * JavaScript для форм бронирования
 */
document.addEventListener("DOMContentLoaded", function () {
  // Показ/скрытие формы бронирования
  const showFormButtons = document.querySelectorAll(".show-booking-form");

  showFormButtons.forEach((button) => {
    button.addEventListener("click", function () {
      // Получаем форму бронирования рядом с кнопкой
      const bookingForm = this.nextElementSibling;

      // Плавно показываем форму
      if (bookingForm) {
        bookingForm.style.display = "block";
        this.style.display = "none"; // Скрываем кнопку

        // Плавная прокрутка к форме
        bookingForm.scrollIntoView({ behavior: "smooth", block: "start" });
      }
    });
  });

  // Расчет итоговой стоимости при изменении количества человек
  const personsInputs = document.querySelectorAll(
    '.booking-form input[name="persons"]'
  );

  personsInputs.forEach((input) => {
    input.addEventListener("input", function () {
      const form = this.closest("form");
      const personsCount = form.querySelector("#persons-count");
      const totalPrice = form.querySelector("#total-price");

      if (personsCount && totalPrice) {
        const persons = parseInt(this.value) || 1;
        const price = parseFloat(this.dataset.price) || 0;

        personsCount.textContent = persons;
        totalPrice.textContent = new Intl.NumberFormat("ru-RU").format(
          price * persons
        );
      }
    });
  });

  // Закрытие формы бронирования
  const closeButtons = document.querySelectorAll(".close-booking-form");

  closeButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault();

      const bookingForm = this.closest(".booking-form");
      const showButton = bookingForm.previousElementSibling;

      if (bookingForm && showButton) {
        bookingForm.style.display = "none";
        showButton.style.display = "block";
      }
    });
  });
});
