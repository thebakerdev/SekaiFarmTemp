<?php

namespace App\Http\Controllers\Auth\Admin;

use App\admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    /**
     * Displays admin register page
     * 
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $admin = admin::all();

        if ($admin->count()) {
            return redirect('/bluelogin');
        }

        return view('admin.register');
    }

    /**
     * Creates a new admin
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:admins'],
            'password' => ['required', 'string'],
        ]);

        $admin = admin::create([
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
        ]);

        Auth::guard('web-admin')->login($admin);

        return redirect('/pending');
    }
}
