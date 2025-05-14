@extends('layouts.app') <!-- Убедитесь, что это имя вашего основного шаблона -->

@section('content')
<section>
    <head>
        <link rel="stylesheet" href="{{ asset('css/media.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <script src="{{ asset('js/tours.js') }}" defer></script>
    </head>
        <div class="max">
            <h2>Наши туры</h2>
            <div class="tabs tury" data-tabs>
                <div class="btns-row">
                    <ul class="tabs__pane" data-tabs-nav>
                        <li class="active" data-index="0">Новинки</li>
                        <li data-index="1">Ближайшие</li>
                        <li data-index="2">Популярные</li>
                        <li data-index="3">Летние</li>
                        <li data-index="4">Зимние</li>
                        <li data-index="5">Осенние</li>
                        <li data-index="6">Весенние</li>
                    </ul>
                    <a class="btn--white" href="{{ route('tours.index') }}">
                        <span>Все туры</span>
                    <img src="/img/arrow-btn.svg" alt="" srcset="">
                    </a>
                </div>
                <div class="tab__panels" data-tabs-list>

                <div class="tab__element active" data-index="0">  <!-- Все туры -->
    <div class="cont-tury">
        @if(isset($newTours) && !$newTours->isEmpty())
            @foreach($newTours as $tour)
                <div class="block show">
                    <a href="{{ route('tours.show', $tour->id) }}">
                        <img src="" alt="{{ $tour->name }}" srcset="">
                        <div class="info">
                            <h1>{{ $tour->name }}</h1>
                            <h3 class="name">{{ $tour->description }}</h3>
                            <p class="data">{{ $tour->data }}</p>
                            <p class="price">Цена: {{ $tour->price }}₽</p>
                        </div>
                    </a>
                </div>
            @endforeach
        @else
            <p>Нет доступных туров.</p>
        @endif
    </div>
</div>

    <div class="tab__element" data-index="1">  <!--  Добавлено data-index -->
            <div class="cont-tury">
                @if(isset($upcomingTours) && !$upcomingTours->isEmpty())
                    @foreach($upcomingTours as $tour)
                        <div class="block show">
                            <a href="{{ route('tours.show', $tour->id) }}">
                                <img src="" alt="{{ $tour->name }}" srcset="">
                                <div class="info">
                                    <h1>{{ $tour->name }}</h1>
                                    <h3 class="name">{{ $tour->description }}</h3>
                                    <p class="data">{{ $tour->data }}</p>
                                    <p class="price">Цена: {{ $tour->price }}₽</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <p>Нет ближайших туров.</p>
                @endif
            </div>
        </div>

    <div class="tab__element" data-index="2">
        <div class="cont-tury">
            @if(isset($popularTours) && !$popularTours->isEmpty())
                @foreach($popularTours as $tour)
                    <div class="block show">
                        <a href="{{ route('tours.show', $tour->id) }}">
                            <img src="" alt="{{ $tour->name }}" srcset="">
                            <div class="info">
                                <h1>{{ $tour->name }}</h1>
                                <h3 class="name">{{ $tour->description }}</h3>
                                <p class="data">{{ $tour->data }}</p>
                                <p class="price">Цена: {{ $tour->price }}₽</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <p>Нет популярных туров.</p>
            @endif
        </div>
    </div>

    <div class="tab__element" data-index="3">
        <div class="cont-tury">
            @if(isset($summerTours) && !$summerTours->isEmpty())
                @foreach($summerTours as $tour)
                    <div class="block show">
                        <a href="{{ route('tours.show', $tour->id) }}">
                            <img src="" alt="{{ $tour->name }}" srcset="">
                            <div class="info">
                                <h1>{{ $tour->name }}</h1>
                                <h3 class="name">{{ $tour->description }}</h3>
                                <p class="data">{{ $tour->data }}</p>
                                <p class="price">Цена: {{ $tour->price }}₽</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <p>Нет летних туров.</p>
            @endif
        </div>
    </div>

    <div class="tab__element" data-index="4">
        <div class="cont-tury">
            @if(isset($winterTours) && !$winterTours->isEmpty())
                @foreach($winterTours as $tour)
                    <div class="block show">
                        <a href="{{ route('tours.show', $tour->id) }}">
                            <img src="" alt="{{ $tour->name }}" srcset="">
                            <div class="info">
                                <h1>{{ $tour->name }}</h1>
                                <h3 class="name">{{ $tour->description }}</h3>
                                <p class="data">{{ $tour->data }}</p>
                                <p class="price">Цена: {{ $tour->price }}₽</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <p>Нет зимних туров.</p>
            @endif
        </div>
    </div>

    <div class="tab__element" data-index="5">
        <div class="cont-tury">
            @if(isset($autumnTours) && !$autumnTours->isEmpty())
                @foreach($autumnTours as $tour)
                    <div class="block show">
                        <a href="{{ route('tours.show', $tour->id) }}">
                            <img src="" alt="{{ $tour->name }}" srcset="">
                            <div class="info">
                                <h1>{{ $tour->name }}</h1>
                                <h3 class="name">{{ $tour->description }}</h3>
                                <p class="data">{{ $tour->data }}</p>
                                <p class="price">Цена: {{ $tour->price }}₽</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <p>Нет осенних туров.</p>
            @endif
        </div>
    </div>

    <div class="tab__element" data-index="6">
        <div class="cont-tury">
            @if(isset($springTours) && !$springTours->isEmpty())
                @foreach($springTours as $tour)
                    <div class="block show">
                        <a href="{{ route('tours.show', $tour->id) }}">
                            <img src="" alt="{{ $tour->name }}" srcset="">
                            <div class="info">
                                <h1>{{ $tour->name }}</h1>
                                <h3 class="name">{{ $tour->description }}</h3>
                                <p class="data">{{ $tour->data }}</p>
                                <p class="price">Цена: {{ $tour->price }}₽</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <p>Нет весенних туров.</p>
            @endif
        </div>
    </div>
</div>
                    <div class="btn-centr">
                        <button class="btn-add">
                                <img src="img/mngtch.svg" style="width: 24px; height:24px">
                            <span>Показать еще туры</span>
                        </button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @section('form')
        @include('form') 
    @endsection

    <section>
            <div class="max">
                <h2>Преимущества</h2>
                <div class="preim">
                    <div class="block">
                        <img src="img/p-1.svg" alt="" srcset="">
                        <p>Большой выбор туров по Великой России</p>
                        <p>Для опытных и начинающих туристов. Также экспедиции и экскурсии для детей.</p>
                    </div>
                    <div class="block">
                        <img src="img/p-2.svg" alt="" srcset="">
                        <p>Полная организация тура</p>
                        <p>Предоставление снаряжения, доставка до базы, организация питания и ночлега.</p>
                    </div>
                    <div class="block">
                        <img src="img/p-3.svg" alt="" srcset="">
                        <p>Нас выбирают, к нам возвращаются</p>
                        <p>Тысячи туристов, остаются довольными нашими турами каждый год.</p>
                    </div>
                    <div class="block">
                        <img src="img/p-4.svg" alt="" srcset="">
                        <p>"Мы самые активные"
                            <br>
                        по России
                        </p>
                        <p>Наша команда организует большое количества туров ежедневно.</p>
                    </div>
                    <div class="block">
                        <img src="img/p-5.svg" alt="" srcset="">
                        <p>Мы заботимся о Вашей безопасности</p>
                        <p>На время тура Вы защищены страховкой «Росгосстрах».</p>
                    </div>
                    <div class="block">
                        <img src="img/p-6.svg" alt="" srcset="">
                        <p>Одна команда - тысяча впечатлений</p>
                        <p>В нашей команде инструкторы с 6 летним стажем, мастера спорта и студенты.</p>
                    </div>
                </div>
            </div>
        </section>
@endsection

