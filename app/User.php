<?php

namespace App;

use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    public $table = 'users';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'email_verified_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'profile_pic',
        'banner_image',
        'isEmailVerified',
        'notification_status',
        'is_enable',
        'lat',
        'lng',
        'isRegistrationComplete',
        'password',
        'device_id',
        'customer_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'remember_token',
        'email_verified_at',
        'subscription_plan',
    ];

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;

    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;

    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }

    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));

    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function plan()
    {
        return $this->belongsTo(UserSubscription::class, 'subscription_plan', 'subscription_id');
    }
    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_plan');
    }

    public function AauthAcessToken(){
        return $this->hasMany('\App\OauthAccessToken');
    }

}
