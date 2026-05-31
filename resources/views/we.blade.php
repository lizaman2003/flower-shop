@extends('tampletes.header')
@section('body')
    <!-- Hero Section -->
    <div class="bg-primary bg-opacity-10 py-5 mb-5">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <div class="pe-lg-4">
                        <div class="d-flex align-items-center mb-4">
                            
                            <div>
                                <h1 class="mb-2 fw-bold">Мир Цветов</h1>
                                <p class="lead text-primary mb-0">Цветы - нечто прекрасное</p>
                            </div>
                        </div>
                        <p class="fs-5 text-muted mb-0">
                            Мы компания, которая занимается доставкой цветов и других аксессуаров. 
                            Делаем ваши праздники ярче, а моменты — особенными!
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('img/cvetok-babochka.jpg') }}" 
                         class="img-fluid rounded-3 shadow-lg" 
                         style="max-height: 400px; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4 hover-shadow">
                    <div class="card-body">
                        <div class="icon-box bg-primary bg-opacity-10 rounded-circle p-4 mb-3 d-inline-block">
                            <i class="bi bi-truck text-primary fs-2"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-3">Быстрая доставка</h5>
                        <p class="card-text text-muted mb-0">Доставляем цветы в кратчайшие сроки по всему городу</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4 hover-shadow">
                    <div class="card-body">
                        <div class="icon-box bg-success bg-opacity-10 rounded-circle p-4 mb-3 d-inline-block">
                            <i class="bi bi-heart text-success fs-2"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-3">Свежие цветы</h5>
                        <p class="card-text text-muted mb-0">Только свежие и качественные цветы от лучших поставщиков</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4 hover-shadow">
                    <div class="card-body">
                        <div class="icon-box bg-danger bg-opacity-10 rounded-circle p-4 mb-3 d-inline-block">
                            <i class="bi bi-gift text-danger fs-2"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-3">Подарки</h5>
                        <p class="card-text text-muted mb-0">Широкий выбор аксессуаров и подарков к любому празднику</p>
                    </div>
                </div>
            </div>
        </div>

       
        @if($items->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <div class="bg-primary text-white rounded-3 p-5 shadow">
                    <div class="row text-center g-4">
                        <div class="col-md-3">
                            <h2 class="display-4 fw-bold mb-2">500+</h2>
                            <p class="mb-0 opacity-75">Довольных клиентов</p>
                        </div>
                        <div class="col-md-3">
                            <h2 class="display-4 fw-bold mb-2">1000+</h2>
                            <p class="mb-0 opacity-75">Доставленных заказов</p>
                        </div>
                        <div class="col-md-3">
                            <h2 class="display-4 fw-bold mb-2">{{ $items->count() }}+</h2>
                            <p class="mb-0 opacity-75">Видов цветов</p>
                        </div>
                        <div class="col-md-3">
                            <h2 class="display-4 fw-bold mb-2">24/7</h2>
                            <p class="mb-0 opacity-75">Поддержка клиентов</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Последние товары -->
        @if($items->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="text-center mb-4 fw-bold">Наши популярные товары</h2>
                
                @if($items->count() >= 3)
                    <!-- Карусель если товаров 3 или больше -->
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner rounded-3 shadow">
                            @php
                                $chunks = $items->chunk(3);
                            @endphp
                            
                            @foreach($chunks as $index => $chunk)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <div class="row g-4 p-4">
                                        @foreach($chunk as $i)
                                            <div class="col-md-4">
                                                <div class="card h-100 border-0 shadow-sm hover-shadow">
                                                    <div style="height: 250px; overflow: hidden; background: #f8f9fa;">
                                                        <img src="{{ asset($i->img) }}" 
                                                             class="card-img-top" 
                                                             alt="{{ $i->name }}"
                                                             style="width: 100%; height: 100%; object-fit: contain;">
                                                    </div>
                                                    <div class="card-body d-flex flex-column">
                                                        <h5 class="card-title fw-bold mb-2">{{ $i->name }}</h5>
                                                        <div class="mt-auto">
                                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                                <span class="fs-5 fw-bold text-primary">{{ $i->price }} ₽</span>
                                                            </div>
                                                            <a href="{{ route('item', ['id' => $i->id]) }}" 
                                                               class="btn btn-outline-primary w-100">
                                                                <i class="bi bi-eye me-1"></i>Подробнее
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        
                                        {{-- Заполняем пустые места если нужно --}}
                                        @for($j = $chunk->count(); $j < 3; $j++)
                                            <div class="col-md-4 d-none d-md-block">
                                                <div class="card h-100 border-0 shadow-sm" style="visibility: hidden;"></div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($chunks->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                                <span class="visually-hidden">Предыдущий</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                                <span class="visually-hidden">Следующий</span>
                            </button>
                        @endif
                    </div>
                @else
                    <!-- Просто сетка если товаров меньше 3 -->
                    <div class="row g-4">
                        @foreach($items as $i)
                            <div class="col-md-4">
                                <div class="card h-100 border-0 shadow-sm hover-shadow">
                                    <div style="height: 250px; overflow: hidden; background: #f8f9fa;">
                                        <img src="{{ asset($i->img) }}" 
                                             class="card-img-top" 
                                             alt="{{ $i->name }}"
                                             style="width: 100%; height: 100%; object-fit: contain;">
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title fw-bold mb-2">{{ $i->name }}</h5>
                                        <div class="mt-auto">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="fs-5 fw-bold text-primary">{{ $i->price }} ₽</span>
                                            </div>
                                            <a href="{{ route('item', ['id' => $i->id]) }}" 
                                               class="btn btn-outline-primary w-100">
                                                <i class="bi bi-eye me-1"></i>Подробнее
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="bg-light rounded-3 p-5 text-center shadow-sm">
                    <h2 class="mb-3 fw-bold">Готовы сделать заказ?</h2>
                    <p class="lead text-muted mb-4">Перейдите в наш каталог и выберите лучшие цветы для ваших близких</p>
                    <a href="/" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-cart-plus me-2"></i>
                        Перейти в каталог
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection