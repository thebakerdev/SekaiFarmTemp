<?php

namespace App\Http\Controllers;

use App\shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    /**
     * Creates a shipment
     *
     * @param Illuminate\Http\Request $request
     * @return 
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Deletes the shipment
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response;
     */
    public function destroy(Request $request)
    {
        $shipment_id = $request->input('shipment_id');

        $shipment = shipment::deleteShipment($shipment_id);

        session()->flash("notification", [
            'message' => $shipment." ".trans('translations.notifications.deleted'),
            'type' => 'error',
        ]);

        return back();
    }

    /**
     * Set shipment status as sent
     *
     * @param Illuminate\Http\Request
     * @return void
     */
    public function sent(Request $request)
    {
        $shipment_id = $request->input('shipment_id');

        $tracking_number = $request->input('tracking_number');

        $shipment = shipment::sent($shipment_id, $tracking_number);

        session()->flash("notification", [
            'message' => trans('translations.notifications.shipment_sent'),
            'type' => 'success',
        ]);

        return back();
    }
}
