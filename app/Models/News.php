<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'source', 'source_url', 'tag', 'title', 'excerpt', 'date', 'read_time', 'image', 'body'];

    protected $casts = [
        'body' => 'array',
    ];
}
