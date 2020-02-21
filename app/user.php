<?php

namespace App;

use Laravel\Cashier\Billable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class user extends Authenticatable {

    use Notifiable, Billable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
    protected $fillable = [
        'email', 'password','name'
    ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get user's addresses
     */
    public function addresses()
    {
        return $this->hasMany('App\address')
                ->orderBy('is_default','desc')
                ->orderBy('created_at','desc');
    }

    /**
     * Get user's default address
     *
     * @return App\address
     */
    public function getDefaultAddressAttribute() 
    {
        $addresses = $this->addresses;

        $default = $addresses->where('is_default','1');

        return $default->first();
    }

    /**
     * Get users undelivered order
     *
     */
    public function undelivered()
    {
        return $this->hasMany('App\shipment')
                ->where('sent','0')
                ->orderBy('created_at', 'desc');
    }

    /**
     * Get users delivered orders
     *
     */
    public function delivered()
    {
        return $this->hasMany('App\shipment')
                ->where('sent','1')
                ->orderBy('created_at', 'desc');
    }
}
