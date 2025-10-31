<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function dashboard()
    {
        // view path: resources/views/account/dashboard.blade.php
        return view('account.dashboard');
    }

    public function info()
    {
        return view('account.info');
    }

    public function activity()
    {
        return view('account.activity');
    }

    public function orders()
    {
        return view('account.orders');
    }
}
