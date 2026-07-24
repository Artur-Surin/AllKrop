<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportRoute extends Model
{
    use HasFactory;

    protected $table = 'transport_routes';

    protected $fillable = ['number', 'type', 'route_from', 'route_to', 'interval'];
}
