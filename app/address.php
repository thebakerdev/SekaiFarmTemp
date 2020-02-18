<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class address extends Model
{
    protected $fillable = [
        'name',
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

    /**
     * Set default address
     *
     * @param String $id
     * @param String $user_id
     * @return void
     */
    public static function setDefault($id)
    {
        DB::transaction(function() use($id) {
            
            $address = self::findOrFail($id);

            self::where('user_id', $address->user_id)->update([
                'is_default' => '0'
            ]);

            $address->is_default = '1';

            $address->save();
        });
    }
}
