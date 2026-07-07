<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = ['title', 'slug', 'featured_image', 'excerpt', 'body', 'status', 'published_at'];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
