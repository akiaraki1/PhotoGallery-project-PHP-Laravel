<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Фотогалерея') }} — Сброс пароля</title>

        @vite(['resources/css/basic.css'])
        @vite(['resources/css/header.css'])
        @vite(['resources/css/mainForm.css'])
    </head>
    <body>
        <header>
            <h1>Фотогалерея</h1>
            <nav>
                @if (Route::has('index'))
                    <a 
                        href="{{ route('index') }}"
                    >
                        {{ __('Back to home page') }}
                    </a>
                @endif
                @if (Route::has('login'))
                    <a
                        href="{{ route('login') }}"
                    >
                        {{ __('Log in') }}
                    </a>
                @endif
            </nav>
        </header>

        <main>
            <div class="form-card">
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <h2>Забыли пароль?</h2>

                    @if (session('status'))
                        <div class="status-message">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>
                        Нет проблем. Укажите свой email — мы отправим ссылку для сброса пароля, по которой вы сможете выбрать новый.
                    </p>

                    

                    <div>
                        <label for="email">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="last">
                        <button type="submit">Отправить ссылку</button>
                    </div>
                </form>
            </div>
        </main>
    </body>
</html>
