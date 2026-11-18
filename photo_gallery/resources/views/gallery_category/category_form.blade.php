<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Фотогалерея') }} — Добавление поста</title>
        @vite(['resources/css/basic.css'])
        @vite(['resources/css/header.css'])
        @vite(['resources/css/mainForm.css'])
     
    </head>
    <body>
        <header>
                <h1>Добавление поста</h1>

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
            <div class="form-card">
                <form action="{{ route('gallery.store', ['category' => $category]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <h1>Новая запись</h1>

                    @if (session('status'))
                        <div class="status-message">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                        <label for="image">Изображение</label>
                        <input type="file" name="image">
                        <p>Размер файла — до 5 МБ. Габариты изображения — от 300×300 до 500×500 px. Рекомендуемый размер изображения 400x400 px. Форматы: jpeg, jpg, png, webp. </p>
                        @error('image')
                            <small class="error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div>
                        <label for="title">Заголовок</label>
                        <input type="text" name="title" placeholder="Не более 50 символов." value="{{ old('title') }}">
                        @error('title')
                            <small class="error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div>
                        <label for="description">Описание</label>
                        <textarea name="description"  placeholder="Не более 150 символов.">{{ old('description') }}</textarea>
                        @error('description')
                            <small class="error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="last">
                    <button type="submit">Опубликовать</button>
                    </div>
                </form>
            </div>
        </main>
    </body>
</html>