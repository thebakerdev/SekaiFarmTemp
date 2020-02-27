<?php

namespace App\Listeners;

use App\product;
use App\Events\ShipmentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetOrder
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ShipmentCreated $event)
    {
        $product = product::where('plan_id',$event->plan_id)->first();

        if ($product !== null) {

            $product->stock = $product->stock - $event->quantity;

            $product->orders = $product->orders + $event->quantity;

            $product->save();
        }
    }
}
