<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'image', 'title', 'category', 'date', 'time', 'place', 'price', 'description'];

    protected $casts = [
        'description' => 'array',
    ];
}
