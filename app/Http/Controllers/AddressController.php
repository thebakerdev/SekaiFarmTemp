<?php

namespace App\Http\Controllers;

use App\address;
use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;

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
     * @param App\Http\Requests\AddressRequest
     * @return Illuminate\Http\Response
     */
    public function store(AddressRequest $request)
    {
        $address = address::create([
            'user_id' => $request->input('user_id'),
            'name' => $request->input('name'),
            'country' => $request->input('country'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'address1' => $request->input('address1'),
            'address2' => $request->input('address2'),
            'postal' => $request->input('postal'),
            'phone' => $request->input('phone')
        ]);

        $user = auth()->user();

        return response()->json([
            'status' => 'success',
            'action' => 'store',
            'addresses' => $user->addresses->toArray()
        ]);
    }

    /**
     * Updates user address
     *
     * @param App\Http\Requests\AddressRequest
     * @return Illuminate\Http\Response
     */
    public function update(AddressRequest $request)
    {
        $address = address::findOrFail($request->input('id'));

        $address->name = $request->input('name');
        $address->country = $request->input('country');
        $address->city = $request->input('city');
        $address->state = $request->input('state');
        $address->address1 = $request->input('address1');
        $address->address2 = $request->input('address2');
        $address->postal = $request->input('postal');
        $address->phone = $request->input('phone');

        $address->save();

        $user = auth()->user();

        return response()->json([
            'status' => 'success',
            'action' => 'update',
            'addresses' => $user->addresses->toArray()
        ]);
    }

    /**
     * Deletes specified address
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = auth()->user();

        // get the address based on id and owner
        $address = address::where('user_id',$user->id)
                    ->where('id',$request->input('id'))
                    ->first();

        if ($address === null) {

            return abort(403, 'Unauthorized action.');
        }

        $address->delete();

        return response()->json([
            'status' => 'success',
            'addresses' => $user->addresses->toArray()
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
