<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVerificationToken extends Model
{
    use HasFactory;

    public $table = 'user_verifications_token';

    protected $fillable = [
        'user_id',
        'otp',
        'expire',
        'type',
    ];

}
