<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlaceCategory extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'label', 'icon', 'description'];

    public function places(): HasMany
    {
        return $this->hasMany(Place::class, 'category_id');
    }
}
