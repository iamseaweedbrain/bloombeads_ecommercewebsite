<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showAuth() {
        return view('authentication');
    }

    public function signUp(Request $request) {
        DB::table('useraccount')->insert([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'username' => explode('@', $request->email)[0],
            'password' => Hash::make($request->password),
            'status' => 'active',
            'date_joined' => Carbon::now(),
            'user_id' => uniqid('user_')
        ]);

        return redirect()->back()->with('success', 'Account created! Please log in.');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = DB::table('useraccount')->where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            session(['user' => $user]);
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }


}

