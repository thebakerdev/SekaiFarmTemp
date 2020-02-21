<?php

namespace App\Http\Controllers;

use App\product;
use Illuminate\Http\Request;

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

        return view('user.subscription')->with([
            'user' => $user,
            'product' => $product
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

        $user->subscription('default')->cancelNow();

        return redirect()->back();
    }

    /**
     * Resumes user subscription
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\RedirectResponse
     */
    public function resume(Request $request)
    {
        $user = auth()->user();

        $user->subscription('default')->resume();

        return redirect()->back();
    }
}
