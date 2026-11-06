<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Фотогалерея') }} — Профиль</title>

        @vite(['resources/css/basic.css'])
        @vite(['resources/css/headerPhotoGalleryProfile.css'])
        @vite(['resources/css/mainProfile.css'])
    </head>
    <body>
        <header>
            <h1>Фотогалерея</h1>
            <nav>
               <div class="user-avatar-block">
                    @if (Auth::user()->avatar_image)
                        <img src="{{ asset('storage/' . Auth::user()->avatar_image) }}" alt="Аватар">
                    @else
                        <div class="avatar-placeholder"></div>
                    @endif
                    <span>{{ Auth::user()->name }}</span>
                </div>
                <a href="/photo_gallery">Галерея</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Выйти</button>
                </form>
            </nav>
        </header>

        <main>
            <h2>Профиль</h2>

            @if (session('status') === 'profile-updated')
                <div class="status-message">
                    Информация профиля обновлена.
                </div>
            @endif

            <!-- Информация профиля -->
            <section>
                <h3>Информация профиля</h3>
                <p>Обновите фотографию, имя и email вашего аккаунта.</p>
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <section>
                        <h3>Аватар</h3>

                        @if ($user->avatar_image)
                            <img src="{{ asset('storage/' . $user->avatar_image) }}" alt="Аватар" class="avatar-preview">
                        @else
                            <div class="avatar-preview avatar-preview--empty"></div>
                        @endif

                        <input type="file" name="avatar_image" accept="image/jpeg,image/png,image/webp">

                        <p>Загрузите изображение или гифку. Максимальный размер изображения: 500×500 px. Максимальный размер файла изображения 5 МБ. Форматы изображений: jpeg,jpg,png,webp,gif.</p>
                    </section>
                    <p>
                        <label for="name">Имя</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                        @error('name')
                            <small>{{ $message }}</small>
                        @enderror
                    </p>
                    <p>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                        @error('email')
                            <small>{{ $message }}</small>
                        @enderror
                    </p>
                    <p>
                        <button type="submit">Сохранить</button>
                    </p>
                </form>
            </section>

            <!-- Смена пароля -->
            <section>
                <h3>Смена пароля</h3>
                <p>Используйте длинный случайный пароль для безопасности.</p>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')
                    <p>
                        <label for="current_password">Текущий пароль</label>
                        <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
                        @error('current_password')
                            <small>{{ $message }}</small>
                        @enderror
                    </p>
                    <p>
                        <label for="password">Новый пароль</label>
                        <input type="password" id="password" name="password" required autocomplete="new-password">
                        @error('password')
                            <small>{{ $message }}</small>
                        @enderror
                    </p>
                    <p>
                        <label for="password_confirmation">Повторите пароль</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                        @error('password_confirmation')
                            <small>{{ $message }}</small>
                        @enderror
                    </p>
                    <p>
                        <button type="submit">Сохранить</button>
                    </p>
                </form>
            </section>

            <!-- Удаление аккаунта -->
            <section>
                <h3>Удаление аккаунта</h3>
                <p>После удаления все данные будут безвозвратно потеряны. Перед удалением сохраните нужные данные.</p>
                <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Вы уверены? Аккаунт будет удалён безвозвратно.')">
                    @csrf
                    @method('DELETE')
                    <p>
                        <label for="delete_password">Пароль</label>
                        <input type="password" id="delete_password" name="password" required placeholder="Введите пароль для подтверждения">
                        @error('password', 'userDeletion')
                            <small>{{ $message }}</small>
                        @enderror
                    </p>
                    <p>
                        <button type="submit">Удалить аккаунт</button>
                    </p>
                </form>
            </section>
        </main>
    </body>
</html>
