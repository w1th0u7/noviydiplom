<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/media.css">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="/css/calculate.css">
    <title>Калькулятор туров</title>
  </head>
  <body>
    <header class="home">
        <div class="max">
            <div class="header-top">
                <a href="index.html" class="logo"><img src="/img/logo__rodina-tur__top 2.svg" alt="" srcset=""></a>
                <div class="soc">
                    <a href="http:// " class="tg" target="_blank">
                    <svg>
                        <g id="#tg">
                            <img src="img/Vector.svg" alt="" srcset="">
                        </g>
                        <use xlink:href = "#tg"></use>
                    </svg>  
                    </a>
                    <a href="http://" class="wp" target="_blank">
                    <svg>
                        <g id="#wp">
                            <img src="/img/wtsp.svg" alt="" srcset="">
                        </g>
                        <use xlink:href = "#wp"></use>
                    </svg>
                    </a>
                    <a href="http://" class="vk" target="_blank">
                    <svg>
                        <g id="#vk">
                            <img src="/img/vk.svg" alt="" srcset="">
                        </g>
                        <use xlink:href = "#vk"></use>
                    </svg>
                    </a>
                    <a href="http://" class="ytb" target="_blank">
                    <svg>
                        <g id="#ytb">
                            <img src="/img/ytb.svg" alt="" srcset="">
                        </g>
                        <use xlink:href = "#ytb"></use>
                    </svg>
                    </a>
                </div>
                <div class="header-info">
                    <div class="phone">
                        <a href="tel:88002003152">8-800-200-31-52</a>
                        <span>по России Бесплатный</span>
                    </div>
                    <div class="js-open-modal zakaz-zvonka">
                        <img src="/img/Phone.svg" class="img-phone">
                        <p>+7 (920) 904-13-83</p>
                        <p>Заказать звонок</p>
                    </div>
                    <a href="login.html">
                        <div class="login">
                            <svg>
                                <img src="/img/login.svg" alt="" srcset="">
                            </svg>
                            <button id="loginBtn" type="submit">ВОЙТИ</button>
                        </div>
                    </a>
                </div>
            </div>
            <div class="header-mid">
                <div class="max">
                    <nav>
                        <ul class="menu">
                            <li class="menu-item"><a href="" class="menu-link">Расписание</a></li>
                            <li class="menu-item"><a href="" class="menu-link">Хит сезона</a></li>
                            <li class="menu-item"><a href="" class="menu-link">Контакты</a></li>
                            <li class="menu-item"><a href="" class="menu-link">Экскурсии</a></li>
                            <li class="menu-item"><a href="" class="menu-link">Туристам</a></li>
                            <li class="menu-item"><a href="" class="menu-link">Горящие туры</a></li>
                            <li class="menu-item"><a href="calculate.html" class="menu-link">Калькулятор туров</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <section class="banner-home">
        <div class="max">
            <div class="swiperloc">
                <div class="swiper spiwer-initialized swiper-horisontal swiper-backface-hidden">
                    <div class="swiper-wrapper" id="swiper-wrapper-7106f2bb2da1645dd" aria-live="polite">
                            <div class="swiper-slide swiper-slide-active swiper-slide-next" role="group" aria-label="1 / 1" data-swiper-slide-index="0" style="width: 765px; margin-right: 20px;">
                                <div class="registr">
                                        <div class="registr-wrapper">
                                            <div class="flex-container">
                                                <form id="tourForm">
                                                    <h1 class="h1" style="font-size: 36px; text-align: center;" >Калькулятор туров</h1>
                                                    <div class="form-group">
                                                        <label for="country" style="color: #fff;">Страна:</label>
                                                        <select id="country" required>
                                                        <option value="">Выберите страну</option>
                                                        <option value="Россия">Россия</option>
                                                        <option value="Турция">Турция</option>
                                                        <option value="Египет">Египет</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="resort" style="color: #fff;">Курорт:</label>
                                                        <select id="resort" required>
                                                            <option value="">Выберите курорт</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="hotel" style="color: #fff;">Отель:</label>
                                                        <select id="hotel" required>
                                                            <option value="">Выберите отель</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="hotelClass" style="color: #fff;">Класс отеля:</label>
                                                        <select id="hotelClass" required>
                                                            <option value="эконом">Эконом</option>
                                                            <option value="стандарт">Стандарт</option>
                                                            <option value="люкс">Люкс</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="nights" style="color: #fff;">Количество ночей: </label>
                                                        <select name="nights" id="nights">
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3 </option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                        </select>
                                                    </div>
                                                    <label for="departureDate" style="color: #fff;">Дата вылета:</label>
                                                    <input type="date" id="departureDate" min="2025-01-01" max="2026-12-31" required>

                                                    <label for="nights" style="color: #fff;">Ночей:</label>
                                                    <input type="number" id="nights" min="1" max="8" required />

                                                    <label for="tourists" style="color: #fff;">Количество туристов:</label>
                                                    <input type="number" id="tourists" min="1" required />
                                                    
                                                    <div class="form-group">
                                                        <label for="meal" style="color: #fff;">Питание:</label>
                                                        <select id="meal" required>
                                                        <option value="без питания">Без питания</option>
                                                        <option value="завтрак">Завтрак</option>
                                                        <option value="полупансион">Полупансион</option>
                                                        <option value="все включено">Все включено</option>
                                                        </select>
                                                    </div>

                                                    <label for="insurance-label" class="insurance-label" style="color: #fff;">
                                                        <input name="insurance" type="checkbox" id="insurance" required> Страховка(1000 рублей)
                                                    </label>

                                                    <button type="submit" class="btn">Рассчитать</button>
                                                </form>
                                                <div id="result" class="result-container">
                                                    <h2 class="result-title">Итого: </h2>
                                                    <div id="resultText" class="result"></div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                            </div>
                    <div class="swiper-pagination swiper-pagination-bullets swiper-pagination-horisontal swiper-pagination-block">
                        <span class="swiper-pagination-bullet swiper-pagination-bullet-active" aria-current="true"></span>
                    </div>
                    <span class="swiper-notification" aria-current="assertive" aria-atomic="true"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="/js/calculate.js"></script>
  </body>
</html>
