<?php

namespace App\Http\Controllers;

use App\country;
use App\product;
use Stripe\SetupIntent;
use Laravel\Cashier\Cashier;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public $maintience = false;

    /**
     * Displays the product page
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory 
     */
    public function index()
    {

        if ($this->maintience == true) {
            return view('maintience');
        }

        $product = product::first();

        $stripe_key = env('STRIPE_KEY');

        if (session('payment_intent') !== null) {
            
            $payment_intent = session('payment_intent');
        } else {
            $payment_intent = SetupIntent::create([],Cashier::stripeOptions());
        }

        // check if there is a product and redirect to login if no products
        if ($product === null) {

            return redirect('/bluelogin');
        }

        session(['product' => $product->toArray()]);

        $supported_countries = config('dropdowns.countries_asean');

        return view('storefront.index', compact('product', 'supported_countries','payment_intent','stripe_key'));
    }

    /**
     * Displays the success page
     *
     * @param Illuminate\Http\Request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory 
     */
    public function success(Request $request)
    {
        if (session('subscription_details') === null) {
            abort(404);
        }

        $subscription_details = session('subscription_details');

        session()->forget('subscription_details');

        return view('storefront.confirmed')->with([
            'product_name' => $subscription_details['product_name'],
            'product_price' => number_format($subscription_details['product_price']),
            'qty' => $subscription_details['qty'],
            'total' => number_format($subscription_details['qty'] * $subscription_details['product_price'])
        ]);
    }
}
