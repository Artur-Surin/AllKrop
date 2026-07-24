<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RssImportLog extends Model
{
    use HasFactory;

    protected $fillable = ['feed_name', 'feed_type', 'items_found', 'items_imported', 'items_skipped', 'status', 'error_message'];

    protected $casts = [
        'items_found' => 'integer',
        'items_imported' => 'integer',
        'items_skipped' => 'integer',
    ];
}
