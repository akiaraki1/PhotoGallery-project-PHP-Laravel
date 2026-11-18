<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Фотогалерея') }} — Регистрация</title>

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
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <h2>Регистрация</h2>

                    @if (session('status'))
                        <div class="status-message">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                        <label for="name">Имя</label> 
                        <input type="text" name="name" placeholder="Максимальное количество символов 15." value="{{ old('name') }}" required autofocus autocomplete="name">
                        @error('name')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>

                    <div>
                        <label for="email">Email</label>
                        <input type="email" name="email" placeholder="Максимальное количество символов 255." value="{{ old('email') }}" required autocomplete="username">
                        @error('email')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>

                    <div>
                        <label for="password">Пароль</label>
                        <input type="password" name="password" required autocomplete="new-password">
                        @error('password')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation">Подтвердите пароль</label>
                        <input type="password" name="password_confirmation" placeholder="Введите повторно пароль." required autocomplete="new-password">
                        @error('password_confirmation')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="last">
                        <a href="{{ route('login') }}">Уже зарегистрированы?</a>
                        <button type="submit">Зарегистрироваться</button>
                    </div>
                </form>
            </div>
        </main>
    </body>
</html>
