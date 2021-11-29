<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverFriends extends Model
{
    use HasFactory;
    // use SoftDeletes;

    public $table = 'driver_friends';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'send_by',
        'send_to',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}