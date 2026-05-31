<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @forelse ($orders as $o)
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h5 class="mb-1 fw-bold">
                                <i class="bi bi-receipt me-2"></i>Заказ №{{ $o->id }}
                            </h5>
                            <small class="text-muted">
                                <i class="bi bi-person me-1"></i>
                                {{ $o->surname }} {{ $o->name }} {{ $o->patronymic }}
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
                    <!-- Товары в заказе -->
                    <div class="mb-3">
                        <h6 class="fw-bold mb-2 small text-uppercase text-muted">
                            <i class="bi bi-basket me-1"></i>Товары
                        </h6>
                        
                        @if(isset($o->items) && $o->items->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($o->items as $item)
                                    <div class="list-group-item d-flex align-items-center py-2 px-0">
                                        @if(isset($item->item_img))
                                            <img src="{{ asset($item->item_img) }}" 
                                                 class="rounded me-3" 
                                                 style="width: 50px; height: 50px; object-fit: cover;" 
                                                 alt="{{ $item->item_name }}">
                                        @endif
                                        
                                        <div class="flex-grow-1">
                                            <p class="mb-0 fw-medium small">{{ $item->item_name }}</p>
                                            <small class="text-muted">{{ $item->count }} шт. × {{ $item->item_price }} ₽</small>
                                        </div>
                                        
                                        <div class="text-end">
                                            <p class="mb-0 fw-bold text-primary small">
                                                {{ $item->count * $item->item_price }} ₽
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Итого -->
                            <div class="mt-2 p-2 bg-light rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold small">Итого:</span>
                                    <span class="fw-bold text-primary">
                                        {{ $o->total }} ₽
                                    </span>
                                </div>
                            </div>
                        @else
                            <p class="text-muted small mb-0">Нет товаров</p>
                        @endif
                    </div>

                    <!-- Статус -->
                    <div class="mb-3">
                        <p class="mb-1 text-muted small">Статус:</p>
                        <p class="mb-0 fw-medium">{{ $o->status }}</p>
                    </div>

                    @if($o->status == 'Новый')
                        <div class="d-grid gap-2">
                            <form action="{{ route('selectStatus1') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $o->id }}">
                                <input type="hidden" name="status" value="Подтвержденный">
                                <button type="submit" class="btn btn-success btn-sm w-100">
                                    <i class="bi bi-check-lg me-1"></i>Подтвердить
                                </button>
                            </form>
                            
                            <button class="btn btn-outline-danger btn-sm w-100" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#cancelModal{{ $o->id }}">
                                <i class="bi bi-x-lg me-1"></i>Отменить
                            </button>
                        </div>
                        
                        <!-- Модальное окно отмены -->
                        <div class="modal fade" id="cancelModal{{ $o->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('selectStatus2') }}" method="POST">
                                        @csrf
                                        <div class="modal-header bg-warning bg-opacity-10 border-0">
                                            <h5 class="modal-title text-warning">
                                                <i class="bi bi-exclamation-triangle me-2"></i>
                                                Отмена заказа №{{ $o->id }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="{{ $o->id }}">
                                            <input type="hidden" name="status" value="Отмененный">
                                            
                                            <div class="mb-3">
                                                <label for="comment{{ $o->id }}" class="form-label">
                                                    Причина отмены:
                                                </label>
                                                <textarea class="form-control" 
                                                          id="comment{{ $o->id }}" 
                                                          name="comment" 
                                                          rows="3" 
                                                          placeholder="Укажите причину..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Отмена
                                            </button>
                                            <button type="submit" class="btn btn-warning">
                                                <i class="bi bi-check-lg me-1"></i>Отменить заказ
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @elseif($o->status == 'Подтвержденный')
                        <div class="text-center">
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>Подтвержден
                            </span>
                        </div>
                    @else
                        <div class="text-center">
                            <span class="badge bg-secondary">
                                <i class="bi bi-x-circle me-1"></i>Отменен
                            </span>
                            @if($o->comment)
                                <p class="mt-2 mb-0 text-muted small">{{ $o->comment }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="bi bi-cart-x display-1 text-muted mb-3"></i>
                <h5 class="text-muted">Заказы не найдены</h5>
            </div>
        </div>
    @endforelse
</div>