import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Базовые стили (общие)
                'resources/css/basic.css',
                'resources/css/headerIndexRegisterLogin.css',
                'resources/css/headerPhotoGalleryProfile.css',

                // Страницы
                'resources/css/mainLoginRegister.css',     // /login и /register
                'resources/css/mainForgotPassword.css',   // /forgot-password
                'resources/css/mainIndexPhotoGallery.css', // главная фотогалерея
                'resources/css/mainCategory.css',         // категория
                'resources/css/mainCategoryFormEdit.css', // форма редактирования
                'resources/css/mainShow.css',              // просмотр поста
                'resources/css/mainProfile.css',           // /profile

                // JS (если есть)
                'resources/js/index.js',
            ],
            refresh: true,
        }),
    ],
});