<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $photoGallery->title }}</title>
    @vite(['resources/css/basic.css'])
    @vite(['resources/css/headerPhotoGalleryProfile.css'])
    @vite(['resources/css/mainShow.css'])
</head>
    <body>
        <header>
                <h1>Просмотр фото</h1>


                <nav>
                    <div class="user-avatar-block">
                        @if (Auth::user()->avatar_image)
                            <img src="{{ asset('storage/' . Auth::user()->avatar_image) }}" alt="Аватар">
                        @else
                            <div class="avatar-placeholder"></div>
                        @endif
                        <span>{{ Auth::user()->name }}</span>
                    </div>
                    <a href="/profile">Профиль</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Выйти</button>
                    </form>
                </nav>
        </header>

        <main>
            <section>
                <img class="show" src="{{ asset('storage/' . $photoGallery->image) }}" alt="{{ $photoGallery->title }}">

                <h1 class="show">{{ $photoGallery->title }}</h1>

                <p class="show">{{ $photoGallery->description }}</p>

                <div class="show">
                    <a class="show" href="{{ route('gallery.category', ['category' => $photoGallery->category]) }}">← Назад в категорию</a>

                    @auth
                        @if (auth()->id() === $photoGallery->user_id)
                            <a class="show" href="{{ route('gallery.edit', $photoGallery) }}">Редактировать</a>

                            <form class="show" action="{{ route('gallery.destroy', $photoGallery) }}" method="POST"
                                onsubmit="return confirm('Удалить это изображение?');">
                                @csrf
                                @method('DELETE')
                                <button class="show" type="submit">Удалить</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </section>
        </main>
    </body>
</html>