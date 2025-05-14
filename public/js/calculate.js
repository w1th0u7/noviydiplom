function saveData() {
  const country = document.getElementById("country").value;
  const resort = document.getElementById("resort").value;
  const hotel = document.getElementById("hotel").value;
  const hotelClass = document.getElementById("hotelClass").value;
  const departureDate = document.getElementById("departureDate").value;
  const nights = document.getElementById("nights").value;
  const tourists = document.getElementById("tourists").value;
  const meal = document.getElementById("meal").value;
  const insurance = document.getElementById("insurance").checked;

  const tourData = {
    country,
    resort,
    hotel,
    hotelClass,
    departureDate,
    nights,
    tourists,
    meal,
    insurance,
  };

  localStorage.setItem("tourData", JSON.stringify(tourData));
}

// Загрузка данных из localStorage
function loadData() {
  const tourData = JSON.parse(localStorage.getItem("tourData"));
  if (tourData) {
    document.getElementById("country").value = tourData.country;
    document.getElementById("resort").value = tourData.resort;
    document.getElementById("hotel").value = tourData.hotel;
    document.getElementById("hotelClass").value = tourData.hotelClass;
    document.getElementById("departureDate").value = tourData.departureDate;
    document.getElementById("nights").value = tourData.nights;
    document.getElementById("tourists").value = tourData.tourists;
    document.getElementById("meal").value = tourData.meal;
    document.getElementById("insurance").checked = tourData.insurance;
  }
}

document.getElementById("country").addEventListener("change", function () {
  const country = this.value;
  const resortSelect = document.getElementById("resort");
  const hotelSelect = document.getElementById("hotel");

  // Очищаем предыдущие курорты и отели
  resortSelect.innerHTML = '<option value="">Выберите курорт</option>';
  hotelSelect.innerHTML = '<option value="">Выберите отель</option>';

  // Добавляем курорты в зависимости от выбранной страны
  if (country === "Египет") {
    const egyptResorts = ["Шарм-эль-Шейх", "Хургада", "Дахаб", "Марса-Алам"];
    egyptResorts.forEach(function (resort) {
      const option = document.createElement("option");
      option.value = resort;
      option.textContent = resort;
      resortSelect.appendChild(option);
    });
  } else if (country === "Россия") {
    const russiaResorts = [
      "Сочи",
      "Крым",
      "Калининград",
      "Геленджик",
      "Анапа",
      "Санкт-Петербург",
    ];
    russiaResorts.forEach(function (resort) {
      const option = document.createElement("option");
      option.value = resort;
      option.textContent = resort;
      resortSelect.appendChild(option);
    });
  } else if (country === "Турция") {
    const turkeyResorts = ["Анталия", "Бодрум", "Стамбул", "Кемер"];
    turkeyResorts.forEach(function (resort) {
      const option = document.createElement("option");
      option.value = resort;
      option.textContent = resort;
      resortSelect.appendChild(option);
    });
  }

  // Сохраняем данные после изменения страны
  saveData();
});

document.getElementById("resort").addEventListener("change", function () {
  const resort = this.value;
  const hotelSelect = document.getElementById("hotel");

  // Очищаем предыдущие отели
  hotelSelect.innerHTML = '<option value="">Выберите отель</option>';

  // Добавляем отели в зависимости от выбранного курорта
  if (resort === "Шарм-эль-Шейх") {
    const hotels = ["Отель A", "Отель B", "Отель C"];
    hotels.forEach(function (hotel) {
      const option = document.createElement("option");
      option.value = hotel;
      option.textContent = hotel;
      hotelSelect.appendChild(option);
    });
  } else if (resort === "Хургада") {
    const hotels = ["Отель D", "Отель E", "Отель F"];
    hotels.forEach(function (hotel) {
      const option = document.createElement("option");
      option.value = hotel;
      option.textContent = hotel;
      hotelSelect.appendChild(option);
    });
  } else if (resort === "Дахаб") {
    const hotels = ["Отель G", "Отель H"];
    hotels.forEach(function (hotel) {
      const option = document.createElement("option");
      option.value = hotel;
      option.textContent = hotel;
      hotelSelect.appendChild(option);
    });
  } else if (resort === "Марса-Алам") {
    const hotels = ["Отель I", "Отель J"];
    hotels.forEach(function (hotel) {
      const option = document.createElement("option");
      option.value = hotel;
      option.textContent = hotel;
      hotelSelect.appendChild(option);
    });
  } else if (resort === "Сочи") {
    const hotels = ["Отель K", "Отель L"];
    hotels.forEach(function (hotel) {
      const option = document.createElement("option");
      option.value = hotel;
      option.textContent = hotel;
      hotelSelect.appendChild(option);
    });
  } // Добавьте отели для других курортов аналогично

  // Сохраняем данные после изменения курорта
  saveData();
});

document
  .getElementById("tourForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Отменяем стандартное поведение формы

    const country = document.getElementById("country").value;
    const resort = document.getElementById("resort").value;
    const hotel = document.getElementById("hotel").value;
    const hotelClass = document.getElementById("hotelClass").value;
    const departureDate = new Date(
      document.getElementById("departureDate").value
    );
    const nights = parseInt(document.getElementById("nights").value);
    const tourists = parseInt(document.getElementById("tourists").value);
    const meal = document.getElementById("meal").value;
    const insurance = document.getElementById("insurance").checked;

    // Пример расчета стоимости
    let basePrice = 0;

    // Устанавливаем базовую цену в зависимости от страны
    if (country === "Россия") {
      basePrice = 1000; // базовая цена для России
    } else if (country === "Турция") {
      basePrice = 30000; // базовая цена для Турции
    } else if (country === "Египет") {
      basePrice = 50000; // базовая цена для Египта
    }

    // Увеличение цены в зависимости от курорта
    if (country === "Египет") {
      if (resort === "Шарм-эль-Шейх") {
        basePrice += 3000; // прибавка за Шарм-эль-Шейх
      } else if (resort === "Хургада") {
        basePrice += 2500; // прибавка за Хургаду
      } else if (resort === "Дахаб") {
        basePrice += 2000; // прибавка за Дахаб
      } else if (resort === "Марса-Алам") {
        basePrice += 2200; // прибавка за Марса-Алам
      }
    } else if (country === "Россия") {
      if (resort === "Сочи") {
        basePrice += 2000; // прибавка за Сочи
      } else if (resort === "Крым") {
        basePrice += 1500; // прибавка за Крым
      } // Добавьте другие курорты аналогично
    } else if (country === "Турция") {
      if (resort === "Анталия") {
        basePrice += 3000; // прибавка за Анталию
      } else if (resort === "Бодрум") {
        basePrice += 2500; // прибавка за Бодрум
      } // Добавьте другие курорты аналогично
    }

    // Увеличение цены в зависимости от класса отеля
    if (hotelClass === "эконом") {
      basePrice += 2000; // прибавка за эконом класс
    } else if (hotelClass === "стандарт") {
      basePrice += 4000; // прибавка за стандарт класс
    } else if (hotelClass === "люкс") {
      basePrice += 6000; // прибавка за люкс класс
    }

    // Увеличение цены в зависимости от количества ночей и туристов
    let totalPrice = basePrice * nights * tourists;

    // Учитываем питание
    if (meal === "завтрак") {
      totalPrice += 1000 * nights * tourists;
    } else if (meal === "полупансион") {
      totalPrice += 2000 * nights * tourists;
    } else if (meal === "все включено") {
      totalPrice += 3000 * nights * tourists;
    }

    // Учитываем страховку
    if (insurance) {
      totalPrice += 1000; // прибавка за страховку
    }

    // Выводим результат
    document.getElementById(
      "resultText"
    ).innerText = `Стоимость тура: ${totalPrice.toFixed(2)} рублей`;

    // Сохраняем итоговую стоимость в localStorage
    localStorage.setItem("totalPrice", totalPrice.toFixed(2));
    saveData(); // Сохраняем все данные
  });

// Загружаем данные при загрузке страницы
window.onload = function () {
  loadData();
  const country = document.getElementById("country").value;
  if (country) {
    document.getElementById("country").dispatchEvent(new Event("change"));
  }
  const resort = document.getElementById("resort").value;
  if (resort) {
    document.getElementById("resort").dispatchEvent(new Event("change"));
  }
};
