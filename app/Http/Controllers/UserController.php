<?php

namespace App\Http\Controllers;

use DB;
use App\user;
use App\address;
use Illuminate\Http\Request;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegistrationRequest;
use Laravel\Cashier\Exceptions\IncompletePayment;

class UserController extends Controller
{
    /**
     * Displays user account pge
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $user = auth()->user();

        $user->address = $user->default_address;

        return view('user.account')->with([
            'user' => $user
        ]);
    }

    /**
     * Creates a user account
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\RedirectResponse
     */
    public function store(RegistrationRequest $request)
    {
        $user = DB::transaction(function() use($request) {

            $user = user::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);

            $address = address::create([
                'name' => $request->input('name'),
                'country' => $request->input('country'),
                'state' => $request->input('state'),
                'city' => $request->input('city'),
                'postal' => $request->input('postal'),
                'address1' => $request->input('address1'),
                'address2' => $request->input('address2'),
                'phone' => $request->input('phone'),
                'user_id' => $user->id,
                'is_default' => '1'
            ]);

            //attach user to subscribtion

            return $user;
        });

        //event(new UserRegistered($user, $request->input('qty'), $request->input('payment_method'), $request->input('product_id'))); 
        
        session(['subscription_details' => [
            'product_name' => $request->input('product_name'),
            'product_price' => $request->input('product_price'),
            'qty' => $request->input('qty')
        ]]);

        try {
           
            $user->createAsStripeCustomer();

            $user->addPaymentMethod($request->input('payment_method'));

            $user->newSubscription('default', env('STRIPE_PLAN'))
                ->quantity($request->input('qty'))
                ->create($request->input('payment_method'));

        } catch(IncompletePayment $e) {

            return redirect()->route(
                'cashier.payment',
                [$e->payment->id, 'redirect' => route('success')]
            );
        }
        

        return redirect(route('success'));
    }

    /**
     * Updates user account
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id
        ]);

        $user->name = $request->input('name');

        $user->email = $request->input('email');

        $user->save();

        return response()->json([
            'status' => 'success'
        ],200);
    }

    /**
     * Change user password
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'password' => 'required|confirmed'
        ]);

        $user->password = Hash::make($request->input('password'));

        $user->save();

        return response()->json([
            'status' => 'success'
        ],200);
    }
    

    /**
     * Validate user details
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function validateData(RegistrationRequest $request)
    {
        return response()->json([
            'status' => 'success'
        ],200); 
    }
}
