<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class shipment extends Model
{
    protected $fillable = [
        'order_number', 
        'name', 
        'country', 
        'city', 
        'postal', 
        'address1', 
        'address2', 
        'phone', 
        'sent', 
        'tracking_number', 
        'date', 
        'state',
        'qty'
    ];

    /**
     * Delete shipment
     *
     * @param String $shipment_id
     * @return String 
     */
    public static function deleteShipment($shipment_id)
    {
        $shipment = static::findOrFail($shipment_id);

        $shipment_order_number = $shipment->order_number;

        $shipment->delete();

        return $shipment_order_number;
    }

    /**
     * Returns all pending shipment
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query
                ->latest()
                ->where('sent', 0);
    }

    /**
     * Returns all shipped shipment
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeShipped($query)
    {
        return $query
                ->latest()
                ->where('sent', 1);
    }

    /**
     * Set the status of shipment as send
     *
     * @param String $id
     * @param String $tracking_number
     * @return App\shipment;
     */
    public static function sent($id, $tracking_number)
    {
        $shipment = static::findOrFail($id);

        $shipment->sent = 1;

        $shipment->tracking_number = $tracking_number;

        $shipment->date = Carbon::now();

        $shipment->save();

        return $shipment;
    }
    
}
