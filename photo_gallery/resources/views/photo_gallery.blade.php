<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Фотогалерея') }} — гелереи</title>

        @vite(['resources/css/basic.css'])
        @vite(['resources/css/header.css'])
        @vite(['resources/css/mainIndexPhotoGallery.css'])
    </head>
    <body>
        <header>
            <h1>Фотогалерея</h1>

            <p>Добавляйте свои фотографии в указанные ниже категории галерей.</p>

            <nav>
                @auth
                    <div class="user-avatar-block">
                        @if (Auth::user()->avatar_image)
                            <img src="{{ asset('storage/' . Auth::user()->avatar_image) }}" alt="Аватар">
                        @else
                            <div class="avatar-placeholder"></div>
                        @endif
                        <span>{{ Auth::user()->name }}</span>
                    </div>

                    @if (Route::has('profile.edit'))
                        <a
                            href="{{ route('profile.edit') }}"
                        >
                                    {{ __('Profile') }}
                        </a>
                    @endif
            
                    @if (Route::has('logout'))
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">{{ __('Log Out') }} </button>
                        </form>
                    @endif
                @endauth
            </nav>
        </header>

        <main>

            @if (session('status'))
                <script>
                    confirm(@json(session('status')));
                </script>
            @endif

            <div class="card">
                <a href="{{ route('gallery.category', ['category' => 'nature']) }}">
                    <img src="{{ asset('images/categories/nature.jpg') }}" alt="Природа">
                    <div class="card-body">
                        <h3>Природа</h3>
                        <p>Горы, леса, реки и нетронутые уголки дикой природы.</p>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="{{ route('gallery.category', ['category' => 'cities']) }}">
                    <img src="{{ asset('images/categories/city.jpg') }}" alt="Города">
                    <div class="card-body">
                        <h3>Города</h3>
                        <p>Уличная жизнь, небоскрёбы и огни мегаполисов ночью и днём.</p>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="{{ route('gallery.category', ['category' => 'architecture']) }}">
                    <img src="{{ asset('images/categories/architecture.jpg') }}" alt="Архитектура">
                    <div class="card-body">
                        <h3>Архитектура</h3>
                        <p>Фасады, мосты и инженерные сооружения разных эпох и стилей.</p>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="{{ route('gallery.category', ['category' => 'portraits']) }}">
                    <img src="{{ asset('images/categories/portrait.jpg') }}" alt="Портреты">
                    <div class="card-body">
                        <h3>Портреты</h3>
                        <p>Эмоции, характеры и истории людей в кадре.</p>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="{{ route('gallery.category', ['category' => 'travel']) }}">
                    <img src="{{ asset('images/categories/travel.jpg') }}" alt="Путешествия">
                    <div class="card-body">
                        <h3>Путешествия</h3>
                        <p>Достопримечательности, культуры и виды со всего мира.</p>
                    </div>
                </a>
            </div>

            <div class="card">
                <a href="{{ route('gallery.category', ['category' => 'animals']) }}">
                    <img src="{{ asset('images/categories/animal.jpg') }}" alt="Животные">
                    <div class="card-body">
                        <h3>Животные</h3>
                        <p>Дикие и домашние животные в их естественной среде.</p>
                    </div>
                </a>
            </div>
        </main>
    </body>
</html>
