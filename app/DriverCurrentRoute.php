<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverCurrentRoute extends Model
{
    use HasFactory;
    // use SoftDeletes;

    public $table = 'driver_current_route';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'driver_id',
        'route_id',
        'route_name',
        'route_coordinates',
    ];
}
