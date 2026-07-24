<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'source', 'source_url', 'tag', 'title', 'excerpt', 'date', 'read_time', 'image', 'body', 'is_published'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $casts = [
        'body' => 'array',
        'is_published' => 'boolean',
        'date' => 'string',
    ];
}
