<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Фотогалерея') }} — Профиль</title>

        @vite(['resources/css/basic.css'])
        @vite(['resources/css/header.css'])
        @vite(['resources/css/mainForm.css'])
    </head>
    <body>
        <header>

            <h1>Фотогалерея</h1>

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

                    <a href="{{route('photo_gallery')}}">{{ __('Gallery') }}</a>

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
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <h2>Профиль</h2>

                    @if (session('status'))
                        <div class="status-message">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Обновите фотографию, имя и email вашего аккаунта.</p>
                    
                    <div>
                        <p>Аватар</p>

                        @if (Auth::user()->avatar_image)
                            <img src="{{ asset('storage/' . Auth::user()->avatar_image) }}" class="avatar-preview" alt="Аватар">
                        @else
                            <div class="avatar-preview avatar-preview--empty"></div>
                        @endif

                        <input type="file" name="avatar_image" accept="image/jpeg,image/png,image/webp">

                        <p>Загрузите изображение или гифку. Максимальный размер изображения: 500×500 px. Максимальный размер файла изображения 5 МБ. Форматы изображений: jpeg,jpg,png,webp,gif.</p>
                    </div>

                    <div>
                        <label for="name">Имя</label>
                        <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required autofocus autocomplete="name">
                        @error('name')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>

                    <div>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required autocomplete="username">
                        @error('email')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="last">
                        <button type="submit">Сохранить</button>
                    </div>
                </form>
            </div>

            <div class="form-card">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <h2>Смена пароля</h2>
        
                    <p>Используйте длинный случайный пароль для безопасности.</p>
                    
                    <div>
                        <label for="current_password">Текущий пароль</label>
                        <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
                        @error('current_password')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>

                    <div>
                        <label for="password">Новый пароль</label>
                        <input type="password" id="password" name="password" required autocomplete="new-password">
                        @error('password')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation">Повторите пароль</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                        @error('password_confirmation')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="last">
                        <button type="submit">Сохранить</button>
                    </div>
                 </form>
            </div>

            <div class="form-card">
                <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Вы уверены? Аккаунт будет удалён безвозвратно.')">
                    @csrf
                    @method('DELETE')

                    <h2>Удаление аккаунта</h2>

                    <p>После удаления все данные будут безвозвратно потеряны. Перед удалением сохраните нужные данные.</p>
                    
                    <div>
                        <label for="delete_password">Пароль</label>
                        <input type="password" id="delete_password" name="password" required placeholder="Введите пароль для подтверждения">
                        @error('password', 'userDeletion')
                            <small>{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="last">
                        <button type="submit">Удалить аккаунт</button>
                    </div>
            
                </form>
            </div>
        </main>
    </body>
</html>
