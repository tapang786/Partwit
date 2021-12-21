<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reports extends Model
{
    use HasFactory;
    // use SoftDeletes;

    public $table = 'reports';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'type',
        'product_id',
        'user_id',
        'reason',
        'description',
        'status',
        'extra_data',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}