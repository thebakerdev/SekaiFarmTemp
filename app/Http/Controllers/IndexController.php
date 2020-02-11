<?php

namespace App\Http\Controllers;

use App\country;
use App\product;
use Stripe\SetupIntent;
use Laravel\Cashier\Cashier;

class IndexController extends Controller
{

    public $maintience = false;

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
}
