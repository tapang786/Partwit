<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttribute extends Model
{
    use HasFactory;
    // use SoftDeletes;

    public $table = 'product_attributes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'product_id',
        'category_id',
        'attribute_id',
        'attribute_value_id',
        'category_title',
        'attribute_title',
        'value_title',
    ];

}