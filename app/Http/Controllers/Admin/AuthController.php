<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

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
    $credentials = $request->validate([
        'username' => 'required|string',
        'password' => 'required',
    ]);

    $user = DB::table('admin_users')->where('username', $credentials['username'])->first();

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        
        throw ValidationException::withMessages([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    Session::put('admin_users', $user);

    return redirect()->route('admin.dashboard');
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