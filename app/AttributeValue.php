<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeValue extends Model
{
    use HasFactory, SoftDeletes;
    protected $table	= 'attributes_value';
    protected $fillable=[
        'id',
        'attr_id',
        'cat_id',
        'title',
        'created_at',
        'updated_at'
    ];

   
}
