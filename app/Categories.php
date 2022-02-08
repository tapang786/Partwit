<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use HasFactory, SoftDeletes;
    protected $table	= 'categories';
    protected $fillable=[
        'id',
        'parent_id',
        'title',
        'description',
        'created_at',
        'updated_at'
    ];


    public function product(){
        // 
        return $this->hasMany('App\Product');
    }

    public function attributes(){
        // 
        return $this->hasMany('App\Attributes', 'cat_id');
    }
}
