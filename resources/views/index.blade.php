@extends('tampletes.header')
@section('body')
<div class="container mt-5 mb-5">
    <!-- Заголовок -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold">Каталог товаров</h1>
            <p class="text-muted">Выберите категорию или воспользуйтесь сортировкой</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Левая колонка: Категории и сортировка -->
        <div class="col-lg-3 col-md-4">
            <!-- Категории -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-collection me-2"></i>Категории</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item {{ !request('category') ? 'active bg-primary' : '' }}">
                            <a href="/" class="text-decoration-none {{ !request('category') ? 'text-white' : 'text-dark' }}">
                                <i class="bi bi-grid me-2"></i>Все товары
                            </a>
                        </li>
                        @forelse ($category as $c)
                        <li class="list-group-item {{ request('category') == $c->id ? 'active bg-primary' : '' }}">
                            <a href="{{ route('category', ['id' => $c->id]) }}"
                                class="text-decoration-none {{ request('category') == $c->id ? 'text-white' : 'text-dark' }}">
                                <i class="bi bi-tag me-2"></i>{{ $c->name }}
                            </a>
                        </li>
                        @empty
                        <li class="list-group-item text-muted">Нет категорий</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Сортировка -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-sort-down me-2"></i>Сортировка</h5>
                </div>
                <div class="card-body">
                    <select class="form-select" onchange="sorting({{ $categorys }}, this.value)">
                        <option value="name_asc">По наименованию (А→Я)</option>
                        <option value="name_desc">По наименованию (Я→А)</option>
                        <option value="price_asc">По цене (возрастание)</option>
                        <option value="price_desc">По цене (убывание)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Правая колонка: Товары -->
        <div class="col-lg-9 col-md-8">
            <!-- Количество товаров -->
            <div class="mb-4">
                <p class="mb-0 text-muted">
                    <i class="bi bi-box-seam me-2"></i>
                    Найдено: <strong>{{ $items->total() }}</strong> товар(ов)
                </p>
            </div>

            <!-- Сетка товаров -->
            <div id="items" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @include('incl.items')
            </div>

            <!-- Пагинация -->
            @if($items->hasPages())
            <div class="row mt-5">
                <div class="col-12">
                    <nav aria-label="Пагинация товаров">
                        <ul class="pagination justify-content-center">
                            @if ($items->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="bi bi-chevron-left me-1"></i>Предыдущая
                                </span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $items->previousPageUrl() }}" rel="prev">
                                    <i class="bi bi-chevron-left me-1"></i>Предыдущая
                                </a>
                            </li>
                            @endif

                            @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                            @if ($page == $items->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                            @endif
                            @endforeach

                            @if ($items->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $items->nextPageUrl() }}" rel="next">
                                    Следующая<i class="bi bi-chevron-right ms-1"></i>
                                </a>
                            </li>
                            @else
                            <li class="page-item disabled">
                                <span class="page-link">
                                    Следующая<i class="bi bi-chevron-right ms-1"></i>
                                </span>
                            </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .hover-shadow {
        transition: box-shadow 0.3s, transform 0.3s;
    }

    .hover-shadow:hover {
        box-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.15) !important;
        transform: translateY(-5px);
    }

    .pagination .page-link {
        border-radius: 0.5rem;
        margin: 0 0.25rem;
        border: none;
    }
</style>
@endsection