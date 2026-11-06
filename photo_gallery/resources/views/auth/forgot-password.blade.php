<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Фотогалерея') }} — Сброс пароля</title>

        @vite(['resources/css/basic.css'])
        @vite(['resources/css/headerIndexRegisterLogin.css'])
        @vite(['resources/css/mainLoginRegister.css'])
    </head>
    <body>
        <header>
            <div class="header-title">Фотогалерея</div>
            <nav>
                <a href="{{ '/'}}">На главную</a>
                <a href="{{ route('login') }}">Войти</a>
            </nav>
        </header>

        <main>
            <div class="form-card">
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <h2>Забыли пароль?</h2>

                    <p class="intro-text">
                        Нет проблем. Укажите свой email — мы отправим ссылку для сброса пароля, по которой вы сможете выбрать новый.
                    </p>

                    @if (session('status'))
                        <div class="status-message">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <small>{{ $message }}</small>
                        @enderror
                    </p>

                    <p>
                        <button type="submit">Отправить ссылку</button>
                    </p>
                </form>
            </div>
        </main>
    </body>
</html>
