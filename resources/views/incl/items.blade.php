@forelse ($items as $i)
    <div class="col">
        <div class="card h-100 border-0 shadow-sm hover-shadow">
            <div class="position-relative" style="height: 250px; overflow: hidden; background: #f8f9fa; border-radius: 0.5rem 0.5rem 0 0;">
                <img src="{{ asset($i->img) }}" 
                     class="card-img-top" 
                     alt="{{ $i->name }}"
                     style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 100%; max-height: 100%; object-fit: contain;">
                
                @if($i->count > 0)
                    <span class="position-absolute top-0 end-0 m-2 badge bg-success">
                        <i class="bi bi-check-circle me-1"></i>В наличии: {{ $i->count }}
                    </span>
                @else
                    <span class="position-absolute top-0 end-0 m-2 badge bg-danger">
                        <i class="bi bi-x-circle me-1"></i>Нет в наличии
                    </span>
                @endif
            </div>
            
            <div class="card-body d-flex flex-column">
                <h6 class="card-title fw-bold mb-2">{{ $i->name }}</h6>
                
                <div class="mt-auto">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fs-5 fw-bold text-primary">{{ $i->price }} ₽</span>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('item', ['id' => $i->id]) }}" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-eye me-1"></i>Подробнее
                        </a>
                        @auth
                            @if(Auth::user()->is_admin != 1)
                                <button type="button" 
                                        class="btn btn-primary btn-sm" 
                                        onclick="addBin({{ $i->id }})">
                                    <i class="bi bi-cart-plus me-1"></i>В корзину
                                </button>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <div class="text-center py-5">
            <i class="bi bi-box-seam display-1 text-muted mb-3"></i>
            <h4 class="text-muted">Товары не найдены</h4>
            <p class="text-muted">Попробуйте выбрать другую категорию</p>
            <a href="/" class="btn btn-primary">
                <i class="bi bi-arrow-left me-2"></i>Вернуться в каталог
            </a>
        </div>
    </div>
@endforelse