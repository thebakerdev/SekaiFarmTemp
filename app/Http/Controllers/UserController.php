<?php

namespace App\Http\Controllers;

use DB;
use App\user;
use App\address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth')->except(['store']);
    }

    public function index()
    {
        return "this is the user index";
    }

    /**
     * Creates a user account
     *
     * @param Illuminate\Http\Request
     * @return 
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $user = DB::transaction(function() use($request) {

            $user = user::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);

            $address = address::create([
                'country' => $request->input('country'),
                'state' => $request->input('state'),
                'city' => $request->input('city'),
                'postal' => $request->input('postal'),
                'address1' => $request->input('address1'),
                'address2' => $request->input('address2'),
                'phone' => $request->input('calling_code')." ".$request->input('phone'),
                'user_id' => $user->id
            ]);

            return $user;
        });
        
        //logs the user after creation
        Auth::login($user);

        return redirect('/success');
    }

}
