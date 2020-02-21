<?php

namespace App\Http\Controllers;

use App\shipment;
use Laravel\Cashier\Cashier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class StripeWebhookController extends CashierController
{
    /**
     * Handle invoice payment succeeded.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleInvoicePaymentSucceeded($payload)
    {
        //get stripe id,
        $stripe_id = $payload['data']['object']['customer'];

        $invoice_url  = $payload['data']['object']['hosted_invoice_url'];

        // find user related to stripe
        $user = Cashier::findBillable($stripe_id);

        $subscription = $user->subscription(); 

        $shipment = [ 
             'user_id' => $user->id, 
             'stripe_plan' => $subscription->stripe_plan, 
             'order_number' => strtoupper(\App::getLocale()).time(), 
             'sent' => 0, 
             'qty' => $subscription->quantity, 
             'tracking_number' => null,
             'invoice_url' => $invoice_url
        ];

        $created_shipment = shipment::create($shipment);
    }
}
