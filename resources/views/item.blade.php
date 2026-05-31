@extends('tampletes.header')
@section('body')
<div class="container mt-5">
    <div class="row">
        <!-- Картинка товара -->
        <div class="col-lg-4 col-md-6 col-12 mb-4">
            <div class="ratio ratio-4x3 bg-light rounded" style="border-radius: 12px;">
                <img src="{{ asset($item->img) }}"
                    alt="{{ $item->name }}"
                    style="object-fit: contain; padding: 20px;">
            </div>
        </div>

        <!-- Информация о товаре -->
        <div class="col-lg-8 col-md-6 col-12 px-lg-5">
            <h2>{{ $item->name }}</h2>

            <div class="mt-4">
                <p class="mb-2"><strong>Страна производитель:</strong> {{ $item->country }}</p>
                <p class="mb-2"><strong>Вид товара:</strong> {{ $item->type }}</p>
                <p class="mb-2"><strong>Цвет:</strong> {{ $item->color }}</p>
                <p class="mb-3"><strong>Цена:</strong> {{ $item->price }} ₽</p>
                <p class="mb-3"><strong>В наличии:</strong> {{ $item->count }} шт.</p>
            </div>

            @auth
            @if (Auth::user()->is_admin == 1)
            <a href="{{ route('editItemPage', $item->id) }}" class="btn btn-warning">Изменить</a>
            @else
            <button type="button" class="btn btn-primary" onclick="addBin({{ $item->id }})">
                В корзину
            </button>
            @endif
            @endauth

            @guest
            <p class="text-muted mt-3">
                <button type="button" class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#auth">Войдите</button> чтобы добавить в корзину
            </p>
            @endguest
        </div>
    </div>
</div>
@endsection