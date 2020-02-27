<?php

namespace App\Http\Controllers;

use App\user;
use App\product;
use App\shipment;

class AdminController extends Controller
{
    /**
     * Returns all pending shipments
     *
     * @return Illuminate\View\View 
     */
    public function pending()
    {
        $pending = shipment::pending()->get();
        
        return view('admin.pendingShipments', compact('pending'));
    }

    /**
     * Returns all shipped shipments
     *
     * @return Illuminate\View\View 
     */
    public function shipped()
    {
        $sent = shipment::shipped()->get();
        return view('admin.sentShipments', compact('sent'));
    }
    
    /**
     * Displays product management page 
     *
     * @return Illuminate\View\View 
     */
    public function manage()
    {
        $products = product::all();
        
        return view('admin.manageProduct', compact('products'));
    }

    /**
     * Displays all registered users
     *
     * @return Illuminate\View\View 
     */
    public function users()
    {
        $users = user::all();

        return view('admin.users', compact('users'));
    }

}
