@extends('tampletes.header')
@section('body')
<div class="container mt-5 mb-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold mb-2">
                <i class="bi bi-bag-heart me-2 text-primary"></i>Мои заказы
            </h1>
            <p class="text-muted">История ваших покупок</p>
        </div>
    </div>

    <!-- Список заказов -->
    <div class="row g-4">
        @forelse ($orders as $o)
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm order-card">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="mb-1 fw-bold">
                                <i class="bi bi-receipt me-2"></i>Заказ №{{ $o->id }}
                            </h5>
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>
                                @if($o->created_at)
                                {{ $o->created_at->format('d.m.Y') }}
                                @else
                                <span class="text-muted">Дата не указана</span>
                                @endif
                            </small>
                        </div>

                        @if($o->status == 'Новый')
                        <span class="badge bg-primary">
                            <i class="bi bi-clock me-1"></i>Новый
                        </span>
                        @elseif($o->status == 'Подтвержденный')
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle me-1"></i>Подтвержден
                        </span>
                        @elseif($o->status == 'Отмененный')
                        <span class="badge bg-secondary">
                            <i class="bi bi-x-circle me-1"></i>Отменен
                        </span>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-3 p-3 rounded bg-light">
                        <div class="d-flex align-items-center">
                            @if($o->status == 'Новый')
                            <i class="bi bi-clock-history fs-3 text-primary me-3"></i>
                            @elseif($o->status == 'Подтвержденный')
                            <i class="bi bi-check-circle-fill fs-3 text-success me-3"></i>
                            @elseif($o->status == 'Отмененный')
                            <i class="bi bi-x-circle-fill fs-3 text-secondary me-3"></i>
                            @endif

                            <div>
                                <p class="mb-0 text-muted small">Текущий статус</p>
                                <p class="mb-0 fw-bold">
                                    @if($o->status == 'Новый')
                                    <span class="text-primary">Ожидает подтверждения</span>
                                    @elseif($o->status == 'Подтвержденный')
                                    <span class="text-success">Подтвержден магазином</span>
                                    @elseif($o->status == 'Отмененный')
                                    <span class="text-secondary">Отменен</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold mb-2">
                            <i class="bi bi-list-ul me-2"></i>Детали заказа
                        </h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Количество товаров:</span>
                                <span class="fw-bold">{{ $o->count }} шт.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold mb-2">
                            <i class="bi bi-basket me-2"></i>Товары в заказе
                        </h6>
                        @if(isset($o->items))
                            @foreach($o->items as $item)
                            <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
                                <img src="{{ asset($item->img) }}" 
                                     class="rounded me-2" 
                                     style="width: 50px; height: 50px; object-fit: cover;" 
                                     alt="{{ $item->name }}">
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-medium small">{{ $item->name }}</p>
                                    <small class="text-muted">{{ $item->count }} шт. × {{ $item->price }} ₽</small>
                                </div>
                                <div class="text-end">
                                    <p class="mb-0 fw-bold text-primary small">
                                        {{ $item->count * $item->price }} ₽
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        @endif

                        <div class="mt-2 p-2 bg-primary bg-opacity-10 rounded">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold small">Итого:</span>
                                <span class="fw-bold text-primary">
                                    @if(isset($o->items))
                                        {{ $o->items->sum(function($item) { return $item->count * $item->price; }) }} ₽
                                    @else
                                        0 ₽
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($o->comment)
                    <div class="alert alert-info mb-0 py-2">
                        <small>
                            <i class="bi bi-chat-left-text me-1"></i>
                            <strong>Комментарий:</strong> {{ $o->comment }}
                        </small>
                    </div>
                    @endif
                </div>

            
                <div class="card-footer bg-white border-0">
                    @if ($o->status == 'Новый')
                    <button class="btn btn-outline-danger w-100" data-bs-toggle="modal"
                        data-bs-target="#cancelModal{{ $o->id }}">
                        <i class="bi bi-trash me-2"></i>Отменить заказ
                    </button>
                    @elseif($o->status == 'Подтвержденный')
                    <div class="text-center">
                        <span class="text-success small">
                            <i class="bi bi-check-circle me-1"></i>
                            Ваш заказ подтвержден и обрабатывается
                        </span>
                    </div>
                    @else
                    <div class="text-center">
                        <span class="text-muted small">
                            <i class="bi bi-info-circle me-1"></i>
                            Заказ был отменен
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    <!-- Модальное окно для подтверждения отмены -->
    <div class="modal fade" id="cancelModal{{ $o->id }}" tabindex="-1" 
         aria-labelledby="cancelModalLabel{{ $o->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('deleteOrder', ['id' => $o->id]) }}" method="POST">
                    @csrf
                    <div class="modal-header bg-warning bg-opacity-10 border-0">
                        <h5 class="modal-title text-warning" id="cancelModalLabel{{ $o->id }}">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Подтверждение отмены
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <i class="bi bi-question-circle display-1 text-warning mb-3"></i>
                        <h5 class="mb-2">Отменить заказ №{{ $o->id }}?</h5>
                        <p class="text-muted mb-0">
                            Товары вернутся на склад
                        </p>
                    </div>
                    <div class="modal-footer border-0 justify-content-center">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                            Нет, оставить
                        </button>
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="bi bi-check-lg me-1"></i>Да, отменить
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="bi bi-bag-x display-1 text-muted mb-3"></i>
                <h4 class="text-muted">У вас пока нет заказов</h4>
                <p class="text-muted mb-4">Оформите свой первый заказ в каталоге</p>
                <a href="/" class="btn btn-primary btn-lg px-5">
                    <i class="bi bi-cart-plus me-2"></i>Перейти в каталог
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>

@endsection