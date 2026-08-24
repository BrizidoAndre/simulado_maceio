<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'username',
        'password',
        'token',
    ];

    protected function casts()
    {
        return [
            'password' => 'hashed',
        ];
    }
}
