<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/media.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/adminpanel.css">
    <script src="js/login.js" defer></script>
    <title>Rodina-tur</title>
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
                                        <div class="registr-wrapper" style="color: #ffbc22;">
                                        <div class="flex-container">
    <h1>Управление турами</h1>

    <!-- Форма для добавления тура -->
    <div id="add-tour-form">
        <form id="add-tour-form-data" action="{{ url('/admin/tours') }}" method="POST">
            @csrf
            <h2 style="color: #ffbc22;">Добавить тур</h2>
            <div class="form-group">
                <label for="add-tour-name">Название:</label>
                <input type="text" name="name" id="add-tour-name" required>
            </div>
            <div class="form-group">
                <label for="add-tour-description">Описание:</label>
                <input type="text" name="description" id="add-tour-description" required>
            </div>
            <div class="form-group">
                <label for="add-tour-price">Цена:</label>
                <input type="number" name="price" id="add-tour-price" required>
            </div>
            <button type="submit">Добавить тур</button>
        </form>
    </div>

    <!-- Форма для изменения тура -->
    <div id="rename-tour-form" style="display: none;">
        <form id="rename-tour-form-data" action="{{ url('/admin/tours') }}" method="POST">
            @csrf
            @method('PUT')
            <h2>Изменить тур</h2>
            <input type="hidden" name="id" id="edit-tour-id"> <!-- Скрытое поле для идентификатора тура -->
            <div class="form-group">
                <label for="edit-tour-name">Название:</label>
                <input type="text" name="name" id="edit-tour-name" required>
            </div>
            <div class="form-group">
                <label for="edit-tour-description">Описание:</label>
                <input type="text" name="description" id="edit-tour-description" required>
            </div>
            <div class="form-group">
                <label for="edit-tour-price">Цена:</label>
                <input type="number" name="price" id="edit-tour-price" required>
            </div>
            <button type="submit">Сохранить изменения</button>
        </form>
    </div>

    <!-- Форма для удаления тура -->
    <div id="delete-tour-form" style="display: none;">
        <form id="delete-tour-form-data" action="{{ url('/admin/tours') }}" method="POST">
            @csrf
            @method('DELETE')
            <h2>Удалить тур</h2>
            <div class="form-group">
                <label for="delete-tour-id">Идентификатор тура:</label>
                <input type="number" name="id" id="delete-tour-id" required>
            </div>
            <button type="submit">Удалить</button>
        </form>
    </div>

    <!-- Таблица для отображения туров -->
    <table>
        <thead>
            <tr>
                <th>Название</th>
                <th>Описание</th>
                <th>Цена</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody id="tours-body">
            @foreach($tours as $tour)
                <tr>
                    <td>{{ $tour->name }}</td>
                    <td>{{ $tour->description }}</td>
                    <td>{{ $tour->price }}₽</td>
                    <td>
                        <button onclick="editTour({{ $tour->id }}, '{{ $tour->name }}', '{{ $tour->description }}', {{ $tour->price }})">Изменить</button>
                        <form action="{{ url('/admin/tours/' . $tour->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Вы уверены, что хотите удалить этот тур?');">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button onclick="toggleAddTourForm()">Добавить тур</button>
    <button onclick="toggleDeleteTourForm()">Удалить тур</button>
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
    <script src="js/login.js" defer></script>
    <script src="js/adminpanelfunc.js" defer></script>
  </body>
</html>