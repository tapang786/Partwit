<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverAssignRoutes extends Model
{
    use HasFactory;
    // use SoftDeletes;

    public $table = 'driver_assign_route';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'assigned_driver_id',
        'route_id',
        'route_name',
        'assign_date',
        'assign_day',
        'start_time',
        'finished_time',
        'reassign_to',
        'assign_by',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}