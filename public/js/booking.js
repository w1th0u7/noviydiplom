/**
 * JavaScript для форм бронирования
 */
document.addEventListener("DOMContentLoaded", function () {
  console.log("Booking JS loaded");

  // Показ/скрытие формы бронирования
  const showFormButtons = document.querySelectorAll(".show-booking-form");
  console.log("Found " + showFormButtons.length + " booking buttons");

  showFormButtons.forEach((button) => {
    button.addEventListener("click", function () {
      console.log("Booking button clicked");

      // Получаем форму бронирования рядом с кнопкой
      const bookingForm = this.nextElementSibling;
      console.log("Form found:", bookingForm);

      // Плавно показываем форму
      if (bookingForm) {
        console.log("Showing booking form");
        bookingForm.style.display = "block";
        this.style.display = "none"; // Скрываем кнопку

        // Плавная прокрутка к форме
        bookingForm.scrollIntoView({ behavior: "smooth", block: "start" });
      } else {
        console.log("Booking form not found!");
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
      console.log("Close booking form clicked");

      const bookingForm = this.closest(".booking-form");
      const showButton = bookingForm.previousElementSibling;

      if (bookingForm && showButton) {
        bookingForm.style.display = "none";
        showButton.style.display = "block";
      }
    });
  });
});
