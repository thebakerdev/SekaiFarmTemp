<?php

namespace App\Http\Controllers;

use App\product;
use Carbon\Carbon;
use Stripe\SetupIntent;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

class SubscriptionController extends Controller
{
    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Displays user address list
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $user = auth()->user();

        $product = product::first();

        $subscription = $user->subscription();

        $subscription->expiry = Carbon::parse($subscription->ends_at)->format('M d, Y');

        $stripe_key = env('STRIPE_KEY');

        if (session('payment_intent') !== null) {
            
            $payment_intent = session('payment_intent');
        } else {
            $payment_intent = SetupIntent::create([],Cashier::stripeOptions());

            //session(['payment_intent' => $payment_intent]);
        }

        return view('user.subscription')->with([
            'user' => $user,
            'product' => $product,
            'subscription' => $subscription,
            'stripe_key' => $stripe_key,
            'payment_intent' => $payment_intent
        ]); 
    }

    /**
     * Cancels user subscription
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\RedirectResponse
     */
    public function cancel(Request $request) 
    {
        $user = auth()->user();

        $user->subscription('default')->cancel();

        return response()->json([
            'status' => 'success'
        ],200);
    }

    /**
     * Resumes user subscription
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function resume(Request $request)
    {
        $user = auth()->user();

        $user->subscription('default')->resume();

        return response()->json([
            'status' => 'success'
        ],200);
    }

    /**
     * Check if user's subscription status
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function checkSubscriptionStatus(Request $request)
    {
        $user = auth()->user();

        $subscription_status = '';

        if ($user->subscribed('default')) {
            $subscription_status = 'subscribed';
        }

        if ($user->subscription('default')->cancelled()) {
            $subscription_status = 'cancelled';
        } 

        if ($user->subscription('default')->ended()) {
            $subscription_status = 'unsubscribed';
        }

        return response()->json([
            'status' => 'success',
            'subscription_status' => $subscription_status
        ],200);
    }

    /**
     * Update subscription quantity
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function updateQuantity(Request $request) 
    {
        $user = auth()->user();

        $user->subscription('default')->updateQuantity($request->input('qty'));

        return response()->json([
            'status' => 'success'
        ],200);
    }

    /**
     * Update credit card
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function updateCard(Request $request)
    {
        $payment_method = $request->input('payment_method');

        $user = auth()->user();

        $user->updateDefaultPaymentMethod($payment_method);

        if (session('payment_intent') !== null) {
            session()->forget('payment_intent');
        } 

        $payment_intent = SetupIntent::create([],Cashier::stripeOptions());

       // session(['payment_intent' => $payment_intent]);

        return response()->json([
            'status' => 'success',
            'payment_intent' => $payment_intent
        ],200);
    }
}
