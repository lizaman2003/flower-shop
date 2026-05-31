@extends('tampletes.header')
@section('body')
    <div class="container mt-5 mb-5">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="display-5 fw-bold mb-2">
                    <i class="bi bi-gear-fill me-2 text-primary"></i>Админ панель
                </h1>
                <p class="text-muted">Управление товарами, категориями и заказами</p>
            </div>
        </div>

        <!-- Статистика -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-primary text-white">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-box-seam display-4 mb-2"></i>
                        <h3 class="mb-0">{{ $items->count() }}</h3>
                        <p class="mb-0 opacity-75">Товаров</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-success text-white">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-tags display-4 mb-2"></i>
                        <h3 class="mb-0">{{ $category->count() }}</h3>
                        <p class="mb-0 opacity-75">Категорий</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-warning text-dark">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-cart-check display-4 mb-2"></i>
                        <h3 class="mb-0">{{ $orders->count() }}</h3>
                        <p class="mb-0 opacity-75">Заказов</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-info text-white">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-people display-4 mb-2"></i>
                        <h3 class="mb-0">{{$clientsCount}}</h3>
                        <p class="mb-0 opacity-75">Клиентов</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Левая колонка: Категории и создание товара -->
            <div class="col-lg-4">
                <!-- Категории -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-tags me-2"></i>Категории</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse ($category as $c)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="bi bi-tag me-2 text-primary"></i>{{ $c->name }}</span>
                                    <a href="{{ route('deleteCategory', ['id' => $c->id]) }}" 
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Удалить категорию?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </li>
                            @empty
                                <li class="list-group-item text-muted text-center py-3">
                                    Нет категорий
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer bg-white">
                        <form action="{{ route('createCategory') }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="name" class="form-control" placeholder="Новая категория" required>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Кнопка создания товара -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-plus-circle display-4 text-primary mb-3"></i>
                        <h5 class="mb-3">Добавить товар</h5>
                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#item">
                            <i class="bi bi-box-seam me-2"></i>Создать товар
                        </button>
                    </div>
                </div>
            </div>

            <!-- Правая колонка: Товары -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-box-seam me-2 text-primary"></i>Товары</h5>
                            <span class="badge bg-primary">{{ $items->count() }} шт.</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                            @forelse ($items as $i)
                                <div class="col">
                                    <div class="card h-100 border-0 shadow-sm product-card">
                                        <div class="position-relative" style="height: 180px; overflow: hidden; background: #f8f9fa;">
                                            <img src="{{ asset($i->img) }}" 
                                                 class="card-img-top" 
                                                 alt="{{ $i->name }}"
                                                 style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 100%; max-height: 100%; object-fit: contain;">
                                            
                                            <span class="position-absolute top-0 end-0 m-2 badge bg-success">
                                                {{ $i->count }} шт.
                                            </span>
                                        </div>
                                        
                                        <div class="card-body p-3">
                                            <h6 class="card-title fw-bold mb-2">{{ $i->name }}</h6>
                                            <p class="card-text text-muted small mb-2">
                                                <i class="bi bi-geo-alt me-1"></i>{{ $i->country }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="fs-5 fw-bold text-primary">{{ $i->price }} ₽</span>
                                            </div>
                                            
                                            <div class="d-grid gap-2">
                                                <a href="{{ route('editItemPage', ['id' => $i->id]) }}" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-pencil me-1"></i>Изменить
                                                </a>
                                                <a href="{{ route('deleteItem', ['id' => $i->id]) }}" 
                                                   class="btn btn-outline-danger btn-sm"
                                                   onclick="return confirm('Удалить товар?')">
                                                    <i class="bi bi-trash me-1"></i>Удалить
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="text-center py-5">
                                        <i class="bi bi-box-seam display-1 text-muted mb-3"></i>
                                        <p class="text-muted">Товары не найдены</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Заказы -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-cart-check me-2 text-success"></i>Заказы</h5>
                            <select class="form-select form-select-sm w-auto" onchange="filter(this)">
                                <option value="Все">Все</option>
                                <option value="Новый">Новые</option>
                                <option value="Подтвержденный">Подтвержденные</option>
                                <option value="Отмененный">Отмененные</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="orders">
                            @include('incl.orders')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно создания товара -->
    <div class="modal fade" id="item" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('createItem') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <i class="bi bi-plus-circle me-2"></i>Создание товара
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Наименование</label>
                                <input type="text" class="form-control" name="name" placeholder="Например: Роза" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Страна</label>
                                <input type="text" class="form-control" name="country" placeholder="Например: Россия" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Тип</label>
                                <input type="text" class="form-control" name="type" placeholder="Например: Цветы" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Цвет</label>
                                <input type="text" class="form-control" name="color" placeholder="Например: Красный" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Цена (₽)</label>
                                <input type="number" class="form-control" name="price" placeholder="1000" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Количество (шт.)</label>
                                <input type="number" class="form-control" name="count" placeholder="10" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Категория</label>
                                <select class="form-select" name="category" required>
                                    @forelse ($category as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @empty
                                        <option value="">Нет категорий</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Изображение</label>
                                <input type="file" class="form-control" name="file" accept="image/*" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-1"></i>Отмена
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Создать товар
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

   
@endsection