@extends('tampletes.header')
@section('body')
    <div class="container mt-5 mb-5">
        <h2 class="text-center mb-4">Корзина</h2>

        <!-- Десктопная версия -->
        <div class="d-none d-lg-block">
            <div class="row mt-5 fw-bold border-bottom pb-2">
                <div class="col-1"></div>
                <div class="col-3">Наименование</div>
                <div class="col-3 text-center">Количество</div>
                <div class="col-2 text-end">Цена</div>
                <div class="col-2 text-end">Сумма</div>
                <div class="col-1"></div>
            </div>

            @forelse ($bins as $b)
                <div class="row mt-4 align-items-center border-bottom pb-3">
                    <div class="col-1">
                        <img src="{{ asset($b->img) }}" class="img-fluid rounded" alt="{{ $b->name }}"
                            style="max-width: 80px; max-height: 80px; object-fit: contain;">
                    </div>
                    <div class="col-3">
                        <strong>{{ $b->name }}</strong>
                    </div>
                    <div class="col-3 text-center">
                        <button type="button" class="btn btn-outline-primary"
                            onclick="changeCount({{ $b->id }}, 'remove')">-</button>
                        <span id="count{{ $b->id }}">{{ $b->count }}</span>
                        <button type="button" class="btn btn-outline-primary"
                            onclick="changeCount({{ $b->id }}, 'add')">+</button>
                    </div>
                    <div class="col-2 text-end">{{ $b->price }} ₽</div>
                    <div class="col-2 text-end">
                        <span id="sumPrice{{ $b->id }}">{{ $b->price * $b->count }}</span> ₽
                    </div>
                    <div class="col-1 text-end">
                        <button type="button" class="btn btn-danger btn-sm"
                            onclick="removeItem({{ $b->id }}, event)">
                            🗑️
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <h5 class="text-muted">Вы еще не добавили товары в корзину</h5>
                    <a href="/" class="btn btn-primary mt-3">Перейти к покупкам</a>
                </div>
            @endforelse
        </div>

        <!-- Мобильная версия  -->
        <div class="d-lg-none">
            @forelse ($bins as $b)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-4 text-center">
                                <img src="{{ asset($b->img) }}" class="img-fluid rounded" alt="{{ $b->name }}"
                                    style="max-height: 100px; object-fit: contain;">
                            </div>
                            <div class="col-8">
                                <h6 class="mb-2">{{ $b->name }}</h6>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Цена: <strong>{{ $b->price }} ₽</strong></small>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="removeItem({{ $b->id }}, event)">
                                        🗑️
                                    </button>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Сумма:</small>
                                    <strong><span id="sumPrice{{ $b->id }}">{{ $b->price * $b->count }}</span>
                                        ₽</strong>
                                </div>
                                <div class="text-center">
                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                        onclick="changeCount({{ $b->id }}, 'remove')">-</button>
                                    <span id="count{{ $b->id }}" class="mx-2">{{ $b->count }}</span>
                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                        onclick="changeCount({{ $b->id }}, 'add')">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <h5 class="text-muted">Вы еще не добавили товары в корзину</h5>
                    <a href="/" class="btn btn-primary mt-3">Перейти к покупкам</a>
                </div>
            @endforelse
        </div>
        @if (count($bins) > 0)
            <div class="modal fade" id="bin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('addOrder') }}" id="order" onsubmit="formAction(this,event)">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    <i class="bi bi-bag-check me-2"></i>Подтверждение заказа
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <div class="alert alert-info mb-3">
                                    <h6 class="fw-bold mb-2">
                                        <i class="bi bi-shop me-2"></i>Способ получения
                                    </h6>
                                    <p class="mb-1"><strong>Самовывоз из магазина</strong></p>
                                    <p class="mb-1 small">📍 г. Уфа, ул. Рубежного 47</p>
                                    <p class="mb-1 small">🕐 Режим работы: Пн-Вс 9:00 - 20:00</p>
                                    <p class="mb-0 small">📞 Телефон: +7 (856) 006-16-30</p>
                                </div>


                                <div class="alert alert-success mb-3">
                                    <h6 class="fw-bold mb-2">
                                        <i class="bi bi-cash-coin me-2"></i>Способ оплаты
                                    </h6>
                                    <p class="mb-0"><strong>💵 Наличными при получении</strong></p>
                                    <small class="text-muted">Оплата производится в магазине при получении товара</small>
                                </div>

                                <!-- Итого -->
                                <div class="card bg-light border-0 mb-3">
                                    <div class="card-body p-3 text-center">
                                        <p class="mb-0 text-muted">Сумма заказа:</p>
                                        <h4 class="mb-0 text-primary fw-bold">{{ $b->price * $b->count }} ₽</h4>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="passwordInput" class="form-label">
                                        <i class="bi bi-lock me-1"></i>Пароль для подтверждения *
                                    </label>
                                    <input type="password" class="form-control" name="password" id="passwordInput"
                                        placeholder="Введите ваш пароль" required>
                                    <div id="passwordError" class="invalid-feedback"></div>
                                    <div class="form-text">Для подтверждения заказа введите пароль от аккаунта</div>
                                </div>


                                <div class="alert alert-warning mb-0">
                                    <small>
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                        <strong>Важно!</strong> После оформления заказа с вами свяжется наш менеджер для
                                        подтверждения
                                    </small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="bi bi-x-lg me-1"></i>Отмена
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i>Подтвердить заказ
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <div class="d-flex justify-content-end align-items-center gap-4">
                        <h4 class="mb-0">Итого: <span id="sum">{{ $sum->sum }}</span> ₽</h4>
                        <button type="submit" class="btn btn-primary btn-lg" data-bs-toggle="modal"
                            data-bs-target="#bin">
                            <i class="bi bi-bag-check me-2"></i>Оформить заказ
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
