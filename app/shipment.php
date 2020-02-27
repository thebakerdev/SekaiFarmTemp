<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class shipment extends Model
{
    protected $fillable = [
        'user_id',
        'stripe_plan',
        'order_number', 
        'sent', 
        'qty',
        'tracking_number',
        'invoice_url', 
        'date_shipped',
        'date_delivered'
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
                ->with('user')
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
                ->with('user')
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

        $shipment->date_shipped = Carbon::now();

        $shipment->save();

        return $shipment;
    }

    /**
     * Get shipment status
     */
    public function getStatusAttribute()
    {
        if ($this->attributes['date_shipped'] !== null && $this->attributes['date_delivered'] === null) {
            return trans('translations.texts.in_transit');
        }

        if ($this->attributes['date_shipped'] !== null && $this->attributes['date_delivered'] !== null) {
            return trans('translations.buttons.delivered');
        }
    }

    /**
     * Get delivery date
     */
    public function getDeliveryDateAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])
                ->addDays(2)
                ->format('M d, Y');
    }
    
    /**
     * Get shipment user
     */
    public function user()
    {
        return $this->belongsTo('App\user');
    }
}
