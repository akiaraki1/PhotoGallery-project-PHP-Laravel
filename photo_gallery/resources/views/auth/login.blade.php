<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Фотогалерея') }} — Вход</title>
        
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
                
                @if (Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                    >
                                {{ __('Register') }}
                    </a>
                @endif
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

                    <div>
                        <label for="email">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                        @error('email')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>

                    <div>
                        <label for="password">Пароль</label>
                        <input type="password" name="password" required autocomplete="current-password">
                        @error('password')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="checkbox-row">
                            <input type="checkbox" name="remember">
                            <span>Запомнить меня</span>
                    </div>

                    <div class="last">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Забыли пароль?</a>
                        @endif
                        <button type="submit">Войти</button>
                    </div>
                </form>
            </div>
        </main>
    </body>
</html>