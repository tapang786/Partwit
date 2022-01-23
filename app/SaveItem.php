<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaveItem extends Model
{
    use HasFactory;
    // use SoftDeletes;

    public $table = 'save_items';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'type',
        'product_id',
        'user_id',
        'product_name',
        'price',
        'meta',
    ];
}