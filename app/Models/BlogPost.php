<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = ['title', 'slug', 'excerpt', 'body', 'published_at'];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
