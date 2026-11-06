<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageManager
{
    public function updateAvatar(UploadedFile $avatar_image, User $user)
    {
        // удаляем старый аватар, если он есть
        if ($user->avatar_image) {
            Storage::disk('public')->delete($user->avatar_image);
        }

        // новое уникальное имя файла
        $filename = uniqid() . '.' . $avatar_image->getClientOriginalExtension();

        // форматируем (обрезка под квадрат 300x300)
        $image = Image::decode($avatar_image)->cover(300, 300);

        $path = 'avatars/' . $filename;
        Storage::disk('public')->put($path, (string) $image->encode());

        return $path;
    }

    public function storyImage(UploadedFile $category_image, $category)
    {
        
        // новое уникальное имя файла
        $filename = uniqid() . '.' . $category_image->getClientOriginalExtension();

        // форматируем (обрезка под квадрат 400x400)
        $image = Image::decode($category_image)->cover(400, 400);

        $path = 'categories/' . "$category/". $filename;
        Storage::disk('public')->put($path, (string) $image->encode());

        return $path;
    }
    public function editImage($oldImage = null, UploadedFile $category_image, $category)
    {
         // удаляем старое изображение.
        if ($oldImage) {
            $this->delete($oldImage);
        }

        // новое уникальное имя файла
        $filename = uniqid() . '.' . $category_image->getClientOriginalExtension();

        // форматируем (обрезка под квадрат 400x400)
        $image = Image::decode($category_image)->cover(400, 400);

        $path = 'categories/' . "$category/". $filename;
        Storage::disk('public')->put($path, (string) $image->encode());

        return $path;
    }

    public function delete($oldImage)
    {
            Storage::disk('public')->delete($oldImage);
    }
}