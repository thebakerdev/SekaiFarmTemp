<?php

namespace App\Http\Controllers;

use App\address;
use Illuminate\Http\Request;

class AddressController extends Controller
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

        $addresses = $user->addresses->toArray();

        $countries = config('dropdowns.countries_asean');

        return view('user.addresses')->with([
            'user' => $user,
            'addresses' => $addresses,
            'countries' => $countries
        ]);
    }

    /**
     * Creates a new address for user
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'address1' => ['required'],
            'postal' => ['required', 'string', 'max:255'],
            'phone' => ['required'],
        ]);

        $address = address::create([
            'user_id' => $request->input('id'),
            'name' => $request->input('name'),
            'country' => $request->input('country'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'address1' => $request->input('address1'),
            'address2' => $request->input('address2'),
            'postal' => $request->input('postal'),
            'phone' => $request->input('phone')
        ]);

        return response()->json([
            'status' => 'success',
            'address' => $address
        ]);
    }

    /**
     * Set address as default
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function setDefault(Request $request)
    {
        
        address::setDefault($request->input('id'));

        $user = auth()->user();

        return response()->json([
            'status' => 'success',
            'addresses' => $user->addresses->toArray()
        ]);
    }
}
