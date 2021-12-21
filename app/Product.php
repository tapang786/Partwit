<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    // use SoftDeletes;

    public $table = 'products';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'seller_id',
        'short_desc',
        'description',
        'price',
        'category_id',
        'listed_on',
        'expires_on',
        'featured_image',
        'all_images',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}