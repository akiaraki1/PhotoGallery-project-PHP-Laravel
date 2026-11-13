<?php

namespace App\Http\Controllers;

use App\Models\PhotoGallery;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use App\Services\ImageManager;
use Illuminate\Support\Facades\Auth;

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

     //проверка валидации параметра url, делает редирект, если параметр не соответствует доступным категориям,
     //  иначе возвращает ассоциативный масиив: 1) категория для поиска в базе данных, 2) категория для отображения заголовка на русском.
    public function categoryValidate(Request $request) 
    {
        //берем значение пареметра из строки запроса
        $category = $request->route('category');

        //если категория пуста делаем редирект.
        if(!$category) {
            return redirect()->route('photo_gallery');
        }

        //проверяем название категории из доступных категорий
        $categoryName = match($category) {
            'nature' => 'Природа',
            'cities' => 'Города',
            'architecture' => 'Архитекрута',
            'portrairs' => 'Портреты',
            'travel' => 'Путешествия',
            'animals' => 'Животные',
            default => null,
        };

        //параметр не соответствует категории доступных категорий, происходит редирект
        if($categoryName === null) {
            return redirect()->route('photo_gallery');
        }

        //если проверка прошла, возвращаем массив: 1) категория для поиска в базе данных, 2) категория для отображения заголовка на русском.
        return [
            'category' => $category,
            'categoryName' => $categoryName,
        ];
    }

    //показываем страницу категории галереи, которую выбрал авторизаванный пользователь
    public function category(Request $request)
    {
       
        $categoryValidate = $this->categoryValidate($request);

        // редирект, если  $categoryValidate === RedirectResponse
        if (!is_array($categoryValidate)) {
            return $categoryValidate;
        }


        //используем пагинат для ограничений вывода постов на одну страницу
        $photoGalleries = PhotoGallery::where('category', $categoryValidate['category'])->paginate(6);

        //возвращаем страницу и данные постов
        return view('gallery_category.category', compact('categoryValidate','photoGalleries'));
        
    }

    //показываем страницу формы категории, которую выбрал авторизаванный пользователь
    public function create(Request $request)
    {
        $categoryValidate = $this->categoryValidate($request);

        // редирект, если  $categoryValidate === RedirectResponse
        if (!is_array($categoryValidate)) {
            return $categoryValidate;
        }

        //возвращаем страницу формы добавления поста и данные категорий
        return view('gallery_category.category_form', compact('categoryValidate'));
    }

    //проверка данных, добалнение изображения в файл + форматирование изображения, добавление данных в бд, редирект.
    public function store(Request $request, ImageManager $imageManager, PhotoGallery $photoGallery)
    {
      
        $categoryValidate = $this->categoryValidate($request); 

        // редирект, если  $categoryValidate === RedirectResponse
        if (!is_array($categoryValidate)) {
            return $categoryValidate;
        }

        //валидация полей
        $validated = $request->validate([
            'image' => ['required', 
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

        //проверяем данные, изменяем формат изображения, сохраняем его в папку public, возвращаем путь до файла.
        if ($request->hasFile('image')) {
                $path = $imageManager->storyImage(
                    $request->file('image'),
                    $categoryValidate['category'],
                );
        }
        // добавляем данные в БД
        $photoGallery->create([
            'user_id'     => Auth::id(),
            'category'    => $categoryValidate['category'],
            'image'       => $path,
            'title'       => $validated['title'],
            'description' => $validated['description'],
        ]);
        // редирект на указанную категориую
        return redirect()->route('gallery.category', ['category' => $categoryValidate['category']])
        ->with('status', 'photo-added');

    }

    // показываем изображение с данными
    public function show(PhotoGallery $photoGallery)
    {

        //возвращаем страницу изображения c данными изображения
        return view('gallery_category.show', compact('photoGallery'));
    }

    // показываем форму изображения с данными
    public function edit(PhotoGallery $photoGallery)
    {
        //возвращаем страницу формы c данными изображения
        return view('gallery_category.edit', compact('photoGallery'));
    }

    // проверяем что данные меняет пользователь, которому принадлежит пост, валидация, обновляем данные в бд, редирект
    public function update(Request $request, ImageManager $imageManager, PhotoGallery $photoGallery)
    {
        //проверка совпадения id
        if ($photoGallery->user_id !== $request->user()->id) {
            abort(403);
        }

        //валидация полей
        $validated = $request->validate([
            'image' => [
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
        return redirect()->route('gallery.category', ['category' => $photoGallery->category])
        ->with('status', 'photo-updated');
    }

    // проверяем что данные удаляет пользователь, которому принадлежит пост, валидация, удаляем изображение из файла и данные из бд, редирект
    public function destroy(Request $request, ImageManager $imageManager,PhotoGallery $photoGallery)
    { 
        //проверка совпадения id
        if ((int)$photoGallery->user_id !== $request->user()->id) {
        abort(403);
        }

        // берём категорию из самой записи
        $category = $photoGallery->category;
        
        //удаляем изображение из файла и данные в БД
        $imageManager->delete($photoGallery->image);
        $photoGallery->delete();

        return redirect()->route('gallery.category', ['category' => $category])
        ->with('status', 'photo-deleted');
    }
}
