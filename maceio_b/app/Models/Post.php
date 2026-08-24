<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected function casts()
    {
        return [
            'published_at' => 'datetime',
            'highlight' => 'boolean',
        ];
    }

    public function image()
    {
        return $this->hasOne(Image::class, 'post_id');
    }

    protected static function booted()
    {
        self::saving(function ($model) {
            if ($model->isDirty('status') && $model->status == 'Published') {
                $model->published_at = Carbon::now();
            } else if ($model->isDirty('status') && $model->status == 'Draft') {
                $model->published_at = null;
            }
        });
        parent::booted();
    }
}
