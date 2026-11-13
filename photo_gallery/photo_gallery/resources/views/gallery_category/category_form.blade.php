<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Фотогалерея') }} — {{ $categoryValidate['categoryName'] }}</title>
        @vite(['resources/css/basic.css'])
        @vite(['resources/css/headerPhotoGalleryProfile.css'])
        @vite(['resources/css/mainCategoryFormEdit.css'])
     
    </head>
    <body>
        <header>
                <h1>Добавление поста</h1>

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

            <h1>Новая запись</h1>

            <form action="{{ route('gallery.store', $categoryValidate['category']) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="field">
                    <label for="image">Изображение</label>
                    <input type="file" name="image">
                    <p>Размер файла — до 5 МБ. Габариты изображения — от 300×300 до 500×500 px. Рекомендуемый размер изображения 400x400 px. Форматы: jpeg, jpg, png, webp. </p>
                    @error('image')
                        <small class="error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="field">
                    <label for="title">Заголовок</label>
                    <input type="text" name="title" placeholder="Не более 50 символов." value="{{ old('title') }}">
                    @error('title')
                        <small class="error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="field">
                    <label for="description">Описание</label>
                    <textarea name="description" rows="4" placeholder="Не более 150 символов.">{{ old('description') }}</textarea>
                    @error('description')
                        <small class="error">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn-save">Опубликовать</button>
            </form>
        </main>
    </body>
</html>