<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement extends Model
{
    use HasFactory;
    // use SoftDeletes;

    public $table = 'advertisement';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'description',
        'banner_image',
        'status',
        'start_at',
        'end_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}