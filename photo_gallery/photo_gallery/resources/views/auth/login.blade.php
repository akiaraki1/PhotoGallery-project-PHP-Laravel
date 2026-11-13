<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Фотогалерея') }} — Вход</title>
        
        @vite(['resources/css/basic.css'])
        @vite(['resources/css/headerIndexRegisterLogin.css'])
        @vite(['resources/css/mainLoginRegister.css']) 
        
    </head>
    <body>
        <header>
            <div class="header-title">Фотогалерея</div>
            <nav>
                <a href="{{ '/'}}">На главную</a>
                <a href="{{ route('register') }}">Регистрация</a>
            </nav>
        </header>

        <main>
            <div class="form-card">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <h2>Вход</h2>

                    @if (session('status'))
                        <div class="status-message">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                        @error('email')
                            <small>{{ $message }}</small>
                        @enderror
                    </p>

                    <p>
                        <label for="password">Пароль</label>
                        <input type="password" id="password" name="password" required autocomplete="current-password">
                        @error('password')
                            <small>{{ $message }}</small>
                        @enderror
                    </p>

                    <p class="checkbox-row">
                        <label>
                            <input type="checkbox" id="remember_me" name="remember">
                            <span>Запомнить меня</span>
                        </label>
                    </p>

                    <p>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Забыли пароль?</a>
                        @endif
                        <button type="submit">Войти</button>
                    </p>
                </form>
            </div>
        </main>
    </body>
</html>