<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Landmark extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'image', 'title', 'description', 'address', 'working_hours', 'category', 'body'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $casts = [
        'body' => 'array',
    ];
}
