@extends('tampletes.header')
@section('body')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h2>Изменить товар</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <form action="{{ route('editItem') }}" method="post" enctype="multipart/form-data">
                    <input type="text" name="name" placeholder="имя" class="form-control mb-3 " required
                        value="{{ $item->name }}">
                    <input type="text" name="color" placeholder="цвет" class="form-control mb-3 " required
                        value="{{ $item->color }}">
                    <input type="text" name="price" placeholder="цена" class="form-control mb-3 " required
                        value="{{ $item->price }}">
                    <input type="text" name="count" placeholder="колличество" class="form-control mb-3 " required
                        value="{{ $item->count }}">
                    <input type="text" name="country" placeholder="страна производителя"
                        class="form-control mb-3 "required value="{{ $item->country }}">
                    <input type="text" name="type" placeholder="тип" class="form-control mb-3 "required
                        value="{{ $item->type }}">
                    <input type="hidden" name="id" id="id" value="{{ $item->id }}">
                    <select name="category" id="category" class="form-select mb-3 " required>

                            @foreach ($category as $c)
                                @if ($c->id == $item->category_id)
                        <option value="{{ $c->id }}" selected>{{ $c->name }}</option>
                    @else
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endif
                        @endforeach

                    </select>
                    <label for="file" class="form-label mt-2">Фото товара</label>
                    <input type="file" id="file" name="file" class="form-control mb-3" accept="image/*">
                    <button type="submit" class="btn btn-primary mb-3">Опубликовать</button>
                </form>
            </div>
            <div class="col-4">
                <div class="border rounded p-4">
                    <img src="{{ asset($item->img) }}" alt="" width="100%">
                </div>
            </div>
        </div>
    </div>
    </div>
    </section>
@endsection
