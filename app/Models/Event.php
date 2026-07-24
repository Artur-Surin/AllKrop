<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'source', 'source_url', 'image', 'title', 'category', 'date', 'time', 'place', 'price', 'description', 'is_published'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $casts = [
        'description' => 'array',
        'is_published' => 'boolean',
    ];
}
