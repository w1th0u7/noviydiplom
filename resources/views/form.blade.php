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
                        
                        @if(session('success'))
                        <div class="alert alert-success mt-3">
                            {{ session('success') }}
                        </div>
                        @endif
                        
                        @if(session('error'))
                        <div class="alert alert-danger mt-3">
                            {{ session('error') }}
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        
                        <form id="order-call-form" action="{{ route('inquiries.store') }}" method="post">
                            @csrf
                            <input type="name" id="name" name="name" placeholder="Имя *" aria-required="true" required value="{{ old('name') }}">
                            <input type="tel" id="phone" name="phone" placeholder="Телефон *" aria-required="true" required value="{{ old('phone') }}">
                            <div class="chekbox">
                                <input id="politika" type="checkbox" aria-required="true" checked required>
                                <label for="politika"></label>
                                <p>Нажимая на кнопку, вы даете согласие на <a href="#">обработку ваших персональных данных</a></p>
                            </div>
                            <button type="submit">Перезвоните мне</button>
                        </form>
                    </div>
                    <div class="block">
                        <img src="/img/rodion.jpg" alt="">
                        <img src="/img/rodion-mob.jpg" alt="" class="mob">
                        <div class="info">
                            <p class="name">Анюта Родионовна</p>
                            <p class="prof">Заместитель ген.директора</p>
                        </div>
                        <div class="soc">
                            <a href="http:// " class="tg" target="_blank">
                                <svg style="display: none;">
                                    <!-- Telegram -->
                                    <symbol id="telegram-icon" viewBox="0 0 26 23">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M26 11.5C26 17.8513 20.1797 23 13 23C5.8203 23 0 17.8513 0 11.5C0 5.14873 5.8203 0 13 0C20.1797 0 26 5.14873 26 11.5ZM13.4659 8.48981C12.2014 8.95505 9.67431 9.91798 5.88455 11.3786C5.26915 11.5951 4.94678 11.8069 4.91743 12.014C4.86783 12.3639 5.36327 12.5017 6.03792 12.6894C6.1297 12.7149 6.22478 12.7414 6.32227 12.7694C6.98602 12.9603 7.87889 13.1836 8.34306 13.1924C8.7641 13.2005 9.23404 13.0469 9.75286 12.7318C13.2938 10.6174 15.1216 9.54865 15.2363 9.52561C15.3173 9.50936 15.4295 9.48892 15.5055 9.54869C15.5815 9.60845 15.574 9.72164 15.566 9.752C15.5169 9.93709 13.5721 11.5365 12.5657 12.3642C12.252 12.6222 12.0294 12.8053 11.9839 12.8471C11.882 12.9407 11.7781 13.0293 11.6783 13.1144C11.0617 13.6403 10.5992 14.0346 11.7039 14.6786C12.2348 14.9881 12.6596 15.244 13.0834 15.4993C13.5462 15.7781 14.0078 16.0562 14.6051 16.4025C14.7572 16.4908 14.9026 16.5824 15.0441 16.6717C15.5827 17.0114 16.0666 17.3165 16.6645 17.2679C17.0118 17.2396 17.3707 16.9506 17.5529 16.0888C17.9836 14.0522 18.8301 9.63935 19.0257 7.82093C19.0429 7.66162 19.0213 7.45772 19.004 7.36822C18.9867 7.27871 18.9505 7.15119 18.819 7.05678C18.6632 6.94498 18.4228 6.9214 18.3152 6.92308C17.8263 6.9307 17.0761 7.16145 13.4659 8.48981Z" />
                                    </symbol>
                                </svg>
                                <svg width="26" height="23" fill="">
                                    <use href="#telegram-icon"></use>
                                </svg>
                            </a>
                            <a href="http://" class="wp" target="_blank">
                                <svg style="display: none;">
                                    <!-- WhatsApp -->
                                    <symbol id="whatsapp-icon" viewBox="0 0 28 23">
                                        <path d="M0 23L1.96816 17.0938C0.753665 15.365 0.1155 13.4052 0.116666 11.3955C0.120166 5.11271 6.34432 0 13.9918 0C17.703 0.000958333 21.1866 1.18833 23.8069 3.34267C26.4261 5.497 27.8681 8.3605 27.8669 11.4061C27.8634 17.6899 21.6393 22.8026 13.9918 22.8026C11.6701 22.8016 9.38231 22.3234 7.35582 21.4149L0 23ZM7.69648 19.3516C9.65181 20.3052 11.5185 20.8763 13.9871 20.8773C20.3431 20.8773 25.5208 16.628 25.5243 11.4042C25.5266 6.16975 20.3735 1.92625 13.9965 1.92433C7.63582 1.92433 2.46166 6.17358 2.45933 11.3965C2.45816 13.5288 3.21883 15.1254 4.49632 16.7957L3.33083 20.2917L7.69648 19.3516ZM20.9813 14.1153C20.895 13.9965 20.664 13.9255 20.3163 13.7828C19.9698 13.64 18.2653 12.9509 17.9468 12.856C17.6295 12.7612 17.3985 12.7133 17.1663 12.9988C16.9353 13.2835 16.2703 13.9255 16.0685 14.1153C15.8666 14.305 15.6636 14.329 15.3171 14.1862C14.9706 14.0434 13.853 13.7435 12.5288 12.7727C11.4986 12.0175 10.8021 11.085 10.6003 10.7995C10.3985 10.5148 10.5793 10.3605 10.752 10.2187C10.9083 10.0912 11.0985 9.88617 11.2723 9.71942C11.4485 9.55458 11.5056 9.43575 11.6223 9.24504C11.7378 9.05529 11.6806 8.88854 11.5931 8.74575C11.5056 8.60392 10.8126 7.20187 10.5245 6.63167C10.2421 6.07679 9.95631 6.15154 9.74398 6.14292L9.07898 6.13333C8.84798 6.13333 8.47231 6.20425 8.15498 6.48983C7.83765 6.77542 6.94165 7.4635 6.94165 8.86554C6.94165 10.2676 8.18415 11.6217 8.35681 11.8115C8.53065 12.0012 10.801 14.8781 14.2788 16.1115C15.106 16.4048 15.7523 16.5801 16.2551 16.7114C17.0858 16.928 17.8418 16.8973 18.4391 16.8245C19.1053 16.743 20.4901 16.1355 20.7795 15.4704C21.0688 14.8043 21.0688 14.2341 20.9813 14.1153Z" />
                                    </symbol>
                                </svg>
                                <svg width="28" height="23" fill="#FFDA56">
                                    <use href="#whatsapp-icon"></use>
                                </svg>
                            </a>
                            <a href="http://" class="vk" target="_blank">
                                <svg style="display: none;">
                                    <!-- VK -->
                                    <symbol id="vk-icon" viewBox="0 0 27 23">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.89795 1.61677C0 3.23354 0 5.83568 0 11.04V11.96C0 17.1643 0 19.7664 1.89795 21.3832C3.7959 23 6.85058 23 12.96 23H14.04C20.1494 23 23.2041 23 25.1021 21.3832C27 19.7664 27 17.1643 27 11.96V11.04C27 5.83568 27 3.23354 25.1021 1.61677C23.2041 0 20.1494 0 14.04 0H12.96C6.85058 0 3.7959 0 1.89795 1.61677ZM4.55632 6.99588C4.70257 12.9759 8.21256 16.5696 14.3663 16.5696H14.7151V13.1484C16.9764 13.34 18.6862 14.7488 19.3725 16.5696H22.5676C21.6901 13.848 19.3837 12.3434 17.9437 11.7684C19.3837 11.0592 21.4087 9.33421 21.8924 6.99588H18.9899C18.3599 8.89338 16.4926 10.6184 14.7151 10.7813V6.99588H11.8125V13.6275C10.0125 13.2442 7.74006 11.385 7.63881 6.99588H4.55632Z"/>
                                    </symbol>
                                </svg>
                                <svg width="27" height="23" fill="#FFDA56">
                                    <use href="#vk-icon"></use>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
        </section>
        
@endsection

@section('scripts')
    <script src="/js/form.js"></script>
@endsection

