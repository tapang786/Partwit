<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSubscription extends Model
{
    use HasFactory;
    // use SoftDeletes;

    public $table = 'user_subscription';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'subscription_id',
        'title',
        'description',
        'price',
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // public function user()
    // {
    //     return $this->hasOne(User::class, 'user_id');
    // }

    // public function subscription()
    // {
    //     return $this->hasOne(Subscription::class, 'subscription_id');
    // }
    
}
