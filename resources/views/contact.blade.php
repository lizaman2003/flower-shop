@extends('tampletes.header')
@section('body')
    <div class="container mt-5 mb-5">
        <h2 class="text-center mb-5">Где нас найти</h2>
        
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4 text-center">
                            <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                            Наши контакты
                        </h5>
                        
                        <div class="contact-info">
                            <div class="d-flex align-items-start mb-4">
                                <div class="icon-box bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-envelope-fill text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Email</h6>
                                    <a href="mailto:flowers@mail.ru" class="text-decoration-none text-dark">
                                        flowers@mail.ru
                                    </a>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-start mb-4">
                                <div class="icon-box bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-telephone-fill text-success fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Телефон</h6>
                                    <a href="tel:+78560061630" class="text-decoration-none text-dark">
                                        +7 (856) 006-16-30
                                    </a>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-start">
                                <div class="icon-box bg-danger bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-geo-alt-fill text-danger fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Адрес</h6>
                                    <p class="mb-0 text-muted">г. Уфа, ул. Рубежного 47</p>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="text-center">
                            <h6 class="mb-2">Режим работы</h6>
                            <p class="text-muted mb-0">
                                <i class="bi bi-clock me-2"></i>
                                Пн-Вс: 9:00 - 20:00
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Карта -->
            <div class="col-lg-8">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="map-container position-relative" style="height: 100%; min-height: 500px;">
                            <img src="{{ asset('img/map.jpg') }}" 
                                 class="img-fluid w-100 h-100" 
                                 alt="Карта проезда"
                                 style="object-fit: cover;">
                            
                            <div class="position-absolute bottom-0 start-0 m-3">
                                <div class="bg-white rounded shadow p-3">
                                    <h6 class="mb-1">
                                        <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                                        Мы находимся здесь
                                    </h6>
                                    <p class="mb-0 text-muted small">г. Уфа, ул. Рубежного 47</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-12">
                <div class="card bg-primary bg-opacity-10 border-0 rounded-3">
                    <div class="card-body p-4 text-center">
                        <h5 class="mb-3">
                            <i class="bi bi-info-circle-fill text-primary me-2"></i>
                            Как до нас добраться
                        </h5>
                        <p class="mb-0 text-muted">
                            Мы находимся в центре города, рядом с площадью Ленина. 
                            Ориентир — городской парк. Вход со стороны ул. Партизанской.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection