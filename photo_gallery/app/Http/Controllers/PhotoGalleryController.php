<?php

namespace App\Http\Controllers;

use App\Models\PhotoGallery;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use App\Services\ImageManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;

class PhotoGalleryController extends Controller
{

    //показываем страницу входа на сайт
    public function index() 
    {
        return view('index');
    }

    //показываем главную страницу авторизаванного пользователя
    public function photoGallery()
    {
        return view('photo_gallery');
    }

    //показываем страницу категории галереи, которую выбрал авторизаванный пользователь
    public function category(string $category)
    {
        //используем пагинат для ограничений вывода постов на одну страницу
        $photoGalleries = PhotoGallery::where('category', '=', $category)->paginate(6);

        //возвращаем страницу и данные запроса и постов
        return view('gallery_category.category', compact('category', 'photoGalleries'));
    }

    //показываем страницу формы категории, которую выбрал авторизаванный пользователь
    public function create(string $category)
    {
        //возвращаем страницу формы добавления поста и данные категорий
        return view('gallery_category.category_form',  compact('category'));
    }

    //проверка данных, добалнение изображения в файл + форматирование изображения, добавление данных в бд, редирект.
    public function store(Request $request, ImageManager $imageManager, string $category)
    {
      
        //валидация полей
        $validated = $request->validate([
            'image' => ['required', 
                    File::image()
                        ->max(5 * 1024), // 5 МБ
                    'mimes:jpeg,jpg,png,webp',   // разрешенные расширения
                    Rule::dimensions()
                        ->minWidth(300)
                        ->minHeight(300)
                        ->maxWidth(500)
                        ->maxHeight(500) ],
            'title' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:150'],
        ]);

        //проверяем данные, изменяем формат изображения, сохраняем его в папку public, возвращаем путь до файла.
        if ($request->hasFile('image')) {
                $path = $imageManager->storyImage(
                    $request->file('image'),
                    $request->route('category'),
                );
        }
        // добавляем данные в БД
        PhotoGallery::create([
            'user_id'     => Auth::id(),
            'category'    => $request->route('category'),
            'image'       => $path,
            'title'       => $validated['title'],
            'description' => $validated['description'],
        ]);
        // редирект на указанную категориую
        return redirect()->route('gallery.category', ['category' => $category])
        ->with('status', 'Пост добавлен.');

    }

    // показываем изображение с данными
    public function show(string $category, PhotoGallery $photoGallery)
    {

        //возвращаем страницу изображения c данными изображения
        return view('gallery_category.show', compact('category','photoGallery'));
    }

    // показываем форму изображения с данными
    public function edit(string $category, PhotoGallery $photoGallery)
    {
        //возвращаем страницу формы c данными изображения
        return view('gallery_category.edit', compact('category','photoGallery'));
    }

    // проверяем что данные меняет пользователь, которому принадлежит пост, валидация, обновляем данные в бд, редирект
    public function update(Request $request, ImageManager $imageManager, string $category, PhotoGallery $photoGallery)
    {
        //проверка совпадения id
        if ((int)$photoGallery->user_id !== $request->user()->id) {
        abort(403);
        }

        //валидация полей
        $validated = $request->validate([
            'image' => [
                    'nullable',
                    File::image()
                        ->max(5 * 1024), // 5 МБ
                    'mimes:jpeg,jpg,png,webp',   // разрешенные расширения]
                    Rule::dimensions()
                        ->minWidth(300)
                        ->minHeight(300)
                        ->maxWidth(500)
                        ->maxHeight(500) ],
            'title' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:150'],
        ]);

        //проверяем данные, удаляем прошлое изображение из файла если оно есть, изменяем формат изображения, сохраняем его в папку public, возвращаем путь до файла.
        if ($request->hasFile('image')) {
            $path = $imageManager->editImage(
                $photoGallery->image,
                $request->file('image'),
                $photoGallery->category,
            );
        } else {
            $path = $photoGallery->image; // если новый файл не загрузили — оставляем старый путь
        }
        // обновляем данные в БД
        $photoGallery->update([
            'image'       => $path,
            'title'       => $validated['title'],
            'description' => $validated['description'],
        ]);

        // редирект на указанную категориую
        return redirect()->route('gallery.category', ['category' => $category])
        ->with('status', 'Пост обновлен.');
    }

    // проверяем что данные удаляет пользователь, которому принадлежит пост, валидация, удаляем изображение из файла и данные из бд, редирект
    public function destroy(Request $request, ImageManager $imageManager, string $category, PhotoGallery $photoGallery)
    { 
        //проверка совпадения id
        if ((int)$photoGallery->user_id !== $request->user()->id) {
        abort(403);
        }
        
        //удаляем изображение из файла и данные в БД
        $imageManager->delete($photoGallery->image);
        $photoGallery->delete();

        return redirect()->route('gallery.category', ['category' => $category])
        ->with('status', 'Пост удален.');
    }
    public function ban(Request $request, ImageManager $imageManager, string $category, PhotoGallery $photoGallery)
    { 
        // изменяем роль пользователю
        User::where('id', '=', $photoGallery->user_id)->update(['role' => 'ban']);

        //  Удаляем сессии пользователя (разлогиниваем его на всех устройствах)
        DB::table('sessions')->where('user_id', '=', $photoGallery->user_id)->delete();

        // берем все пути к изображениям в виде массива
        $images = PhotoGallery::where('user_id', '=', $photoGallery->user_id)
        ->pluck('image')
        ->toArray();

        // удаляем все изображения из папки
        $imageManager->deleteall($images);

        // удаляем все посты из бд Фотогалереи данного пользователя
        PhotoGallery::where('user_id', '=', $photoGallery->user_id)->delete();


        return redirect()->route('gallery.category', ['category' => $category])
        ->with('status', 'Пользователь забанен и все его посты удалены.');
    }
}
