<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceGroup extends Model
{
    use HasFactory;

    protected $fillable = ['category', 'position'];

    public function items(): HasMany
    {
        return $this->hasMany(ServiceItem::class, 'service_group_id');
    }
}
