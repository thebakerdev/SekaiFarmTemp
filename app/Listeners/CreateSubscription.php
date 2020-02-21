<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class CreateSubscription implements ShouldQueue
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
    public function handle(UserRegistered $event)
    {
        $user = $event->user;

        try {
            $user->createAsStripeCustomer();

            $user->addPaymentMethod($event->payment_method);

            $user->newSubscription('default', env('STRIPE_PLAN'))
                ->quantity($event->qty)
                ->create($event->payment_method,[
                    'metadata' => [
                        'product_id' => $event->product_id
                    ]
                ]);

        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
