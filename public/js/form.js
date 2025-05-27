document.addEventListener("DOMContentLoaded", function() {
    // Находим форму с id "order-call-form" на странице
    const orderCallForm = document.getElementById("order-call-form");
    
    if (orderCallForm) {
        // Добавляем обработчик события отправки формы
        orderCallForm.addEventListener("submit", function(e) {
            e.preventDefault();
            console.log("Form submitted");

            // Собираем данные формы
            const formData = new FormData(this);
            const data = {};

            for (const [key, value] of formData) {
                data[key] = value;
            }

            // Сохраняем данные в localStorage (для демонстрации)
            localStorage.setItem("orderCallsPage", JSON.stringify(data));

            // Очищаем форму
            this.reset();

            // Создаем и добавляем сообщение об успешной отправке
            const formBlock = orderCallForm.closest(".block");
            
            // Проверяем, существует ли уже сообщение об успехе
            let successMessage = formBlock.querySelector(".success-message");
            
            // Если сообщение еще не существует, создаем его
            if (!successMessage) {
                successMessage = document.createElement("div");
                successMessage.className = "success-message";
                formBlock.appendChild(successMessage);
            }

            // Устанавливаем содержимое и стиль сообщения
            successMessage.innerHTML = "<p>Спасибо, что заказали звонок. Менеджер в ближайшее время позвонит Вам.</p>";
            successMessage.style.display = "block";
            successMessage.style.backgroundColor = "#e6f7e9";
            successMessage.style.color = "#2e7d32";
            successMessage.style.padding = "15px 20px";
            successMessage.style.borderRadius = "8px";
            successMessage.style.marginTop = "20px";
            successMessage.style.borderLeft = "4px solid #4caf50";
            
            // Скрываем форму
            const formInputs = orderCallForm.querySelectorAll("input, button");
            formInputs.forEach(input => {
                input.style.opacity = "0.5";
                input.disabled = true;
            });
            
            // Восстанавливаем форму через 3 секунды
            setTimeout(function() {
                // Скрываем сообщение
                successMessage.style.opacity = "0";
                successMessage.style.transition = "opacity 0.5s ease";
                
                // Возвращаем доступность поля формы
                setTimeout(function() {
                    successMessage.style.display = "none";
                    successMessage.style.opacity = "1";
                    formInputs.forEach(input => {
                        input.style.opacity = "1";
                        input.disabled = false;
                    });
                }, 500);
            }, 3000);
        });
    } else {
        console.log("Form element not found");
    }
}); 