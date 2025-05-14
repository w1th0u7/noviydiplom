document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("registerForm");

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    if (username === "root" && password === "root") {
      // Перенаправление на adminpanel.html
      window.location.href = "adminpanel.html";
    } else {
      alert("Неверное имя пользователя или пароль.");
    }
  });
});
