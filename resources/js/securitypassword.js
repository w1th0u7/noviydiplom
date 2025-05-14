document.addEventListener("DOMContentLoaded", function () {
    // Функция для переключения видимости пароля
    const togglePassword = document.querySelector("#togglePassword");
    const passwordInput = document.querySelector("#password");

    if (togglePassword) {
        togglePassword.addEventListener("click", function () {
            // Переключение типа поля ввода
            const type =
                passwordInput.getAttribute("type") === "password"
                    ? "text"
                    : "password";
            passwordInput.setAttribute("type", type);
            // Изменение текста кнопки
            this.textContent =
                type === "password" ? "Show Password" : "Hide Password";
        });
    }

    // Простейшая валидация формы
    const form = document.querySelector("form");
    form.addEventListener("submit", function (event) {
        const email = document.querySelector("#email").value;
        const password = document.querySelector("#password").value;

        if (!email || !password) {
            event.preventDefault(); // Отменить отправку формы
            alert("Please fill in both fields.");
        }
    });
});
