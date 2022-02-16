<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attributes extends Model
{
    use HasFactory;
    protected $table	= 'attributes';
    protected $fillable = [
        'id',
        'cat_id',
        'title',
        'type'
    ];

    public function category(){
        return $this->belongsTo('App\Categories', 'cat_id');
    }

    public function values(){
        // 
        return $this->hasMany('App\AttributeValue', 'attr_id');
    }
}
