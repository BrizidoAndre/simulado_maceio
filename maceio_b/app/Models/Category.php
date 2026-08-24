<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    public function images()
    {
        return $this->hasMany(Image::class, 'category_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }
}
