<?php

namespace App\Listeners;

use Laravel\Cashier\Cashier;
use Laravel\Cashier\Payment;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Cashier\Exceptions\IncompletePayment;

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
                ->create($event->payment_method);

        } catch(IncompletePayment $e) {

            //$payment_intent = StripePaymentIntent::retrieve($e->payment->id, Cashier::stripeOptions());

            Log::error($e);
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
