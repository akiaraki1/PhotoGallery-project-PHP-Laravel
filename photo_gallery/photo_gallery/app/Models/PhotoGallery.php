<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoGallery extends Model
{
    protected $fillable = [
        'user_id',
        'category',
        'image',
        'title',
        'description',
    ];
}

