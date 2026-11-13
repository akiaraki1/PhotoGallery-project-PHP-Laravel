<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Фотогалерея') }} — {{ __('categories.' . $category) }}</title>

        @vite(['resources/css/basic.css'])
        @vite(['resources/css/headerPhotoGalleryProfile.css'])
        @vite(['resources/css/mainCategory.css'])
    </head>
    <body>
        <header>

            <h1>Фотографии в категории «{{ __('categories.' . $category) }}».</h1>

            <nav>
                @auth
                    <a href="{{ route('gallery.category_form', $category) }}">Добавить новый пост в категорию</a>
                
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
            
            @forelse ($photoGalleries as $photoGallery)

                <div class="card">
                    <img class="category" src="{{ asset('storage/' . $photoGallery->image) }}" alt="{{ $photoGallery->title }}">

                    <div>
                        <h3>{{ $photoGallery->title }}</h3>
                        <p>{{ $photoGallery->description }}</p>
                    </div>

                    @auth
                        <div class="card-actions">

                            <a href="{{ route('gallery.show', ['category' => $category, 'photoGallery' => $photoGallery]) }}">Посмотреть</a>

                            @if (auth()->id() === $photoGallery->user_id)
                                <a href="{{ route('gallery.edit', ['category' => $category, 'photoGallery' => $photoGallery]) }}">Редактировать</a>

                                <form method="POST" action="{{ route('gallery.destroy', ['category' => $category, 'photoGallery' => $photoGallery]) }}"
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