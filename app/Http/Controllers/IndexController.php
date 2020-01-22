<?php

namespace App\Http\Controllers;

use App\country;
use App\cryptocurrency;
use App\product;

class IndexController extends Controller {
  
  public $maintience = false;

  public function index() {
    
    //return "tester";


    if ($this->maintience == true) {
      return view('maintience');
    }

    $product = product::first();

    // check if there is a product and redirect to login if no products
    if ($product === null) {

      return redirect('/bluelogin');
    }
 
    // get crypto rate
    $crypto_rate = cryptocurrency::getRate();


    session(['product' => $product->toArray()]);


    if ($crypto_rate !== false) {
      session([
        'crypto_rate' => ['crypto_rate' => $crypto_rate],
      ]);
    } else {

      session()->flash("notification", [
        'message' => __('translations.notifications.crypto_api_error', ['tickerSymbol' => cryptocurrency::$tickerSymbol]),
        'type' => 'error',
      ]);
    }

    $supported_countries = country::orderBy('name', 'asc')->get();

    return view('storefront.index', compact('product', 'supported_countries'));
  }
}
