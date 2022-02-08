<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attributes extends Model
{
    use HasFactory, SoftDeletes;
    protected $table	= 'attributes';
    protected $fillable = [
        'id',
        'cat_id',
        'title',
        'created_at',
        'updated_at'
    ];

    public function category(){
        return $this->belongsTo('App\Categories', 'cat_id');
    }

    public function values(){
        // 
        return $this->hasMany('App\AttributeValue', 'attr_id');
    }
}
