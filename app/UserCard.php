<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCard extends Model
{
    use HasFactory;
    // use SoftDeletes;

    public $table = 'user_cards';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'user_customer_id',
        'card_token',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
