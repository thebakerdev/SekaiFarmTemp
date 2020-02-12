<?php

namespace App\Http\Controllers;

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
        //$this->middleware('auth');
    }
    
    /**
     * Displays user address list
     *
     * @param 
     * @return 
     */
    public function index()
    {
        return view('user.addresses');
    }
}
