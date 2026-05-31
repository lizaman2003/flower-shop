<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <title>Интернет магазин</title>
</head>


<body>

    <nav class="navbar navbar-expand-lg bg-dark navbar-dark ">
        <div class="container">
            <a class="navbar-brand" href="/"><img src="{{ asset('logo/logo.png') }}" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"> </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('we') }}">О нас</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('contact') }}">Где нас найти</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Каталог</a>
                    </li>

                </ul>
                @auth
                @if (Auth::user()->is_admin == 1)
                <a href="{{route('admin')}}" class="btn btn-primary">
                    Админ панель
                </a>
                <a href="{{ route('logout') }}" class="btn btn-primary ms-2">
                    Выйти
                </a>
                @else
                <a href="{{route('bin')}}" class="btn btn-primary">
                    Корзина
                </a>
                <a href="{{ route('order') }}" class="btn btn-primary ms-2">
                    Мои заказы
                </a>
                <a href="{{ route('logout') }}" class="btn btn-primary ms-2">
                    Выйти
                </a>
                @endif
                @endauth
                @guest
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reg">
                    Регистрация
                </button>
                <button type="button" class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#auth">
                    Авторизация
                </button>
                @endguest

            </div>
        </div>
    </nav>
    <div class="row " id="error" style="display:none">
        <div class="d-flex justify-content-end fixed-bottom pb-5" style="height:100px">
            <div class="col-4 d-flex justify-content-center align-items-center border border-danger rounded-1 bg-light ">
                <p class="fw-bold text-danger">У нас нет такого колличества товара !!</p>
            </div>
        </div>
    </div>
    <div class="row " id="error1" style="display:none">
        <div class="d-flex justify-content-end fixed-bottom pb-5" style="height:100px">
            <div class="col-4 d-flex justify-content-center align-items-center border border-danger rounded-1 bg-light ">
                <p class="fw-bold text-danger">Вы не можете закзать 0 товаров !!</p>
            </div>
        </div>
    </div>

    <!-- Модальные окна -->
    <div class="modal fade" id="reg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('register') }}" id="register" onsubmit="formAction(this,event)">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Регистрация</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="name" id="nameInput" placeholder="Имя">
                            <div id="nameError" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="surname" id="surnameInput"
                                placeholder="Фамилия">
                            <div id="surnameError" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="patronymic" id="patronymicInput"
                                placeholder="Отчество">
                            <div id="patronymicError" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="login" id="loginInput" placeholder="Логин">
                            <div id="loginError" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" name="email" id="emailInput" placeholder="email">
                            <div id="emailError" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password" id="passwordInput"
                                placeholder="Пароль">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password_repeat" id="password_repeatInput"
                                placeholder="Повторите пароль">
                            <div id="passwordError" class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3 ">
                            <input type="checkbox" class="form-check-input" name="rules" id="rulesInput">
                            <label class="form-check-label" for="exampleCheck1">согласие с правилами регистрации</label>
                            <div id="rulesError" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Зарегестрироваться</button>

                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="auth" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('auth') }}" id="auth" onsubmit="formAction(this,event)">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Авторизация</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <input type="text" class="form-control" name="login" id="loginInput"
                                placeholder="Логин">
                            <div id="loginError" class="invalid-feedback"></div>
                        </div>

                        <div class="mb-3">
                            <input type="password" class="form-control" name="password" id="passwordInput"
                                placeholder="Пароль">
                            <div id="passwordError" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Войти</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    @yield('body')
    <main>
        <section class="py-5">
    </main>


    <footer class="bg-dark text-white py-4 mt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-3">
                    <h5>Мир Цветов</h5>
                    <p class="text-secondary">
                        Доставка цветов и подарков в Уфе
                    </p>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <h5>Контакты</h5>
                    <ul class="list-unstyled text-secondary">
                        <li><i class="bi bi-geo-alt"></i> г. Уфа, ул. Рубежного 47</li>
                        <li><i class="bi bi-telephone"></i> +7(856)006-16-30</li>
                        <li><i class="bi bi-envelope"></i> flowers@mail.ru</li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-12 mb-3">
                    <h5>Меню</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('we') }}" class="text-secondary text-decoration-none">О нас</a></li>
                        <li><a href="{{ route('contact') }}" class="text-secondary text-decoration-none">Где нас найти</a></li>
                        <li><a href="/" class="text-secondary text-decoration-none">Каталог</a></li>
                    </ul>
                </div>
            </div>
            <hr class="bg-secondary">
            <div class="text-center text-secondary">
                <p class="mb-0">&copy; {{ date('Y') }} Мир Цветов. Все права защищены.</p>
            </div>
        </div>
    </footer>
    <script src="{{ asset('js/jquery-3.6.0.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>