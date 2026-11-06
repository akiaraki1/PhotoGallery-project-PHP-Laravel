<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Фотогалерея') }} — {{ $categoryValidate['categoryName'] }}</title>

        @vite(['resources/css/basic.css'])
        @vite(['resources/css/headerPhotoGalleryProfile.css'])
        @vite(['resources/css/mainCategory.css'])
    </head>
    <body>
        <header>

            <h1>Фотографии в категории «{{ $categoryValidate['categoryName'] }}».</h1>

            <nav>
                <a href="{{ route('gallery.category_form', $categoryValidate['category']) }}">Добавить новый пост в категорию</a>
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
            @forelse ($photoGalleries as $photoGallery)
                <div class="card">
                    <img class="category" src="{{ asset('storage/' . $photoGallery->image) }}" alt="{{ $photoGallery->title }}">

                    <div>
                        <h3>{{ $photoGallery->title }}</h3>
                        <p>{{ $photoGallery->description }}</p>
                    </div>

                    @auth
                        <div class="card-actions">
                            <a href="{{ route('gallery.show', $photoGallery) }}">Посмотреть</a>

                            @if (auth()->id() === $photoGallery->user_id)
                                <a href="{{ route('gallery.edit', $photoGallery) }}">Редактировать</a>

                                <form method="POST" action="{{ route('gallery.destroy', $photoGallery) }}"
                                      onsubmit="return confirm('Удалить это изображение?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Удалить</button>
                                </form>
                            @endif
                        </div>
                    @endauth
                </div>
            @empty
                <p>В этой категории пока нет фотографий.</p>
            @endforelse

            <div class="pagination">
                {{ $photoGalleries->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </main>

    </body>
</html>