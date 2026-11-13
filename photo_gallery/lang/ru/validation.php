<?php

return [
    'unique'    => 'Такое значение уже занято.',
    'confirmed' => 'Пароли не совпадают.',
    'required'  => 'Поле :attribute обязательно для заполнения.',
    'email'     => 'Поле :attribute должно быть корректным email-адресом.',
    'string'    => 'Поле :attribute должно быть строкой.',
    'image'     => 'Поле :attribute должно быть изображением.',
    'mimes'     => 'Поле :attribute должно быть файлом одного из типов: :values.',
    'dimensions' => 'Поле :attribute имеет недопустимые размеры изображения.',
    'min'       => [
        'string'  => 'Поле :attribute должно содержать не менее :min символов.',
        'numeric' => 'Поле :attribute должно быть не менее :min.',
        'file'    => 'Файл :attribute должен быть не менее :min килобайт.',
    ],
    'max'       => [
        'string'  => 'Поле :attribute не должно превышать :max символов.',
        'numeric' => 'Поле :attribute не должно превышать :max.',
        'file'    => 'Файл :attribute не должен превышать :max килобайт.',
    ],

    'attributes' => [
        'name'         => 'имя',
        'email'        => 'email',
        'password'     => 'пароль',
        'avatar_image' => 'аватар',
        'image'        => 'изображение',
        'title'        => 'заголовок',
        'description'  => 'описание',
    ],
];