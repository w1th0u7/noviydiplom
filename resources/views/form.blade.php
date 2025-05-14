@extends('layouts.app') <!-- Убедитесь, что это имя вашего основного шаблона -->

@section('form')
    <section class="form-block">
            <div class="max">
                <div class="form">
                    <div class="block">
                        <h2>Не нашли подходящий тур?</h2>
                        <p class="txt">Оставьте заявку и мы перезвоним Вам. Предложим варианты и организуем отдых Вашей
                            мечты.
                        </p>
                        <form id="order-call-form" method="post" onsubmit="ym(9209041383,'reachGoal','order-call'); return true;">
                            <input type="name" id="ordercalls-name" name="OrderCalls[name]" placeholder="Имя *" aria-required="true" required>
                            <input type="tel" id="ordercalls-phone" name="OrderCalls[phone]" placeholder="Телефон *" aria-required="true" required>
                            <div class="chekbox">
                                <input id="politika" type="checkbox" aria-required="true" checked required>
                                <label for="politika"></label>
                                <p>Нажимая на кнопку, вы даете согласие на <a href="#">обработку ваших персональных данных</a></p>
                            </div>
                            <button type="submit">Перезвоните мне</button>
                        </form>
                    </div>
                    <div class="block">
                        <img src="/img/rodion.jpg" class="rodion" alt="">
                        <div class="info">
                            <p class="name">Анюта Родионовна</p>
                            <p class="prof">Заместитель ген.директора</p>
                        </div>
                        <div class="soc">
                            <a href="http:// " class="tg" target="_blank">
                            <svg>
                                <g id="#tg">
                                    <img src="/img/Vector.svg" alt="" srcset="">
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
                        </div>
                    </div>
                </div>
        </section>
@endsection