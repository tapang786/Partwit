<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShareRoute extends Model
{
    use HasFactory;
    // use SoftDeletes;

    public $table = 'share_route';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'share_by',
        'share_to',
        'route_id',
        'date',
        'status',
    ];
}
