<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Handle an admin login attempt.
     */
    public function login(Request $request)
    {
        //Validate the form data
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        $user = DB::table('admin_users')->where('username', $credentials['username'])->first();

        if (!$user) {
            return redirect()->route('admin.login.form')
                ->with('login_error', 'Invalid login credentials.');
        }

        if (Hash::check($credentials['password'], $user->password)) {
            
            Session::put('admin_user', $user);

            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login.form')
            ->with('login_error', 'Invalid login credentials.');
    }

    /*
     *admin logout
     */
    public function logout()
    {
        Session::forget('admin_users');
        return redirect()->route('admin.login.form');
    }
}