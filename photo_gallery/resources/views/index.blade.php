<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Фотогалерея') }}</title>

        @vite(['resources/css/basic.css'])
        @vite(['resources/css/header.css'])
        @vite(['resources/css/mainIndexPhotoGallery.css'])
    </head>
    <body>
        <header>
            <h1>Фотогалерея</h1>

            <nav>
                @auth
                    @if (Route::has('photo_gallery'))
                        <a
                            href="{{ route('photo_gallery') }}"
                        >
                            {{ __('Log in') }}
                        </a>
                    @endif
                @endauth

                @guest
                    @if (Route::has('login'))
                        <a
                            href="{{ route('login') }}"
                        >
                            {{ __('Log in') }}
                        </a>
                    @endif

                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                        >
                                {{ __('Register') }}
                        </a>
                    @endif
                @endguest
            </nav>
        </header>
        <main>
            <div class="card">
                <img src="{{ asset('images/categories/nature.jpg') }}" alt="Природа">
                <div class="card-text">
                    <h3>Природа</h3>
                    <p>Горы, леса, реки и нетронутые уголки дикой природы.</p>
                </div>
            </div>

            <div class="card">
                <img src="{{ asset('images/categories/city.jpg') }}" alt="Города">
                <div class="card-text">
                    <h3>Города</h3>
                    <p>Уличная жизнь, небоскрёбы и огни мегаполисов ночью и днём.</p>
                </div>
            </div>

            <div class="card">
                 <img src="{{ asset('images/categories/architecture.jpg') }}" alt="Архитектура">
                <div class="card-text">
                    <h3>Архитектура</h3>
                    <p>Фасады, мосты и инженерные сооружения разных эпох и стилей.</p>
                </div>
            </div>

            <div class="card">
                <img src="{{ asset('images/categories/portrait.jpg') }}" alt="Портреты">
                <div class="card-text">
                    <h3>Портреты</h3>
                    <p>Эмоции, характеры и истории людей в кадре.</p>
                </div>
            </div>

            <div class="card">
                <img src="{{ asset('images/categories/travel.jpg') }}" alt="Путешествия">
                <div class="card-text">
                    <h3>Путешествия</h3>
                    <p>Достопримечательности, культуры и виды со всего мира.</p>
                </div>
            </div>

            <div class="card">
                <img src="{{ asset('images/categories/animal.jpg') }}" alt="Животные">
                <div class="card-text">
                    <h3>Животные</h3>
                    <p>Дикие и домашние животные в их естественной среде.</p>
                </div>
            </div>
        </main>
    </body>
</html>
