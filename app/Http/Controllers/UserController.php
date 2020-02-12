<?php

namespace App\Http\Controllers;

use DB;
use App\user;
use App\address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegistrationRequest;

class UserController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth')->except(['store','validateData','index']);
    }

    public function index()
    {
        return view('user.account');
    }

    /**
     * Creates a user account
     *
     * @param Illuminate\Http\Request
     * @return 
     */
    public function store(RegistrationRequest $request)
    {
        //dd($request->all());

        $user = DB::transaction(function() use($request) {

            $user = user::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);
/* 
            $address = address::create([
                'country' => $request->input('country'),
                'state' => $request->input('state'),
                'city' => $request->input('city'),
                'postal' => $request->input('postal'),
                'address1' => $request->input('address1'),
                'address2' => $request->input('address2'),
                'phone' => $request->input('calling_code')." ".$request->input('phone'),
                'user_id' => $user->id
            ]); */

            //attach user to subscribtion

            return $user;
        });
        
        //logs the user after creation
        Auth::login($user);

        return redirect('/success');
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
        ]); 
    }
}
