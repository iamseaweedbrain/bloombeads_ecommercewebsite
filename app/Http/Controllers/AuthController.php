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

    public function signUp(Request $request)
    {
        $validated = $request->validate([
            'fullName' => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        $email = trim($validated['email']);

        if (DB::table('useraccount')->where('email', $email)->exists()) {
            $message = 'Email already registered.';
            return $request->expectsJson()
                ? response()->json(['message' => $message], 409)
                : redirect()->route('auth.page')->with('login_error', $message);
        }

        try {
            DB::table('useraccount')->insert([
                'fullName'   => $validated['fullName'],
                'email'      => $email,
                'password'   => Hash::make($validated['password']),
                'status'     => 'active',
                'user_id'    => uniqid('user_'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            $message = 'Database error: ' . $e->getMessage();
            return $request->expectsJson()
                ? response()->json(['message' => $message], 500)
                : dd($message);
        }

        $message = 'Account created! Please log in.';
        return $request->expectsJson()
            ? response()->json(['message' => $message], 201)
            : redirect()->route('auth.page')->with('success', $message);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $email = trim($credentials['email']); 
        
        $user = DB::table('useraccount')->where('email', $email)->first();

        if (!$user) {
            return redirect()->route('auth.page')
                            ->with('login_error', 'Invalid login credentials.');
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return redirect()->route('auth.page')
                            ->with('login_error', 'Invalid login credentials.');
        }

        session(['user' => $user]);
        return redirect()->route('dashboard');
    }

    /* ===============================
       SETTINGS: UPDATE PROFILE
       =============================== */
    public function updateProfile(Request $request)
    {
        $user = session('user');
        if (!$user) {
            return redirect()->route('auth.page')->with('login_error', 'Please log in first.');
        }

        $validated = $request->validate([
            'fullName' => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'phone'    => 'nullable|string|max:20',
            'birthday' => 'nullable|date',
        ]);

        try {
            DB::table('useraccount')
                ->where('user_id', $user->user_id)
                ->update([
                    'fullName' => $validated['fullName'],
                    'email'    => $validated['email'],
                    'phone'    => $validated['phone'] ?? null,
                    'birthday' => $validated['birthday'] ?? null,
                    'updated_at' => now(),
                ]);

            // Refresh session
            $updatedUser = DB::table('useraccount')->where('user_id', $user->user_id)->first();
            session(['user' => $updatedUser]);

            return back()->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Database error: ' . $e->getMessage());
        }
    }

    /* ===============================
       SETTINGS: UPDATE PASSWORD
       =============================== */
    public function updatePassword(Request $request)
    {
        $user = session('user');
        if (!$user) {
            return redirect()->route('auth.page')->with('login_error', 'Please log in first.');
        }

        $validated = $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        try {
            DB::table('useraccount')
                ->where('user_id', $user->user_id)
                ->update([
                    'password' => Hash::make($validated['new_password']),
                    'updated_at' => now(),
                ]);

            return back()->with('success', 'Password updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating password: ' . $e->getMessage());
        }
    }
}
