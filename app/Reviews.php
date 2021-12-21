<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reviews extends Model
{
    use HasFactory;
    // use SoftDeletes;

    public $table = 'seller_reviews';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'seller_id',
        'user_id',
        'stars',
        'description',
        'extra_data',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}