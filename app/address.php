<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class address extends Model
{
    protected $fillable = [
        'country',
        'state',
        'city',
        'postal',
        'address1',
        'address2',
        'phone',
        'is_default',
        'user_id'
    ];
}
