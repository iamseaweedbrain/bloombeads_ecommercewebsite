<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showAuth() {
        return view('authentication');
    }

    public function signUp(Request $request)
    {
        $validated = $request->validate([
            'fullName' => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:useraccount,email',
            'password' => 'required|string|min:6',
            'contact_number' => 'nullable|string|max:20',
            'address'        => 'nullable|string|max:255',
        ]);
        
        try {
            $user = User::create([
                'fullName'   => $validated['fullName'],
                'email'      => $validated['email'],
                'password'   => Hash::make($validated['password']),
                'status'     => 'active',
                'contact_number'  => $validated['contact_number'] ?? null,
                'address'         => $validated['address'] ?? null,
            ]);

            // Create a cart for the new user
            $user->cart()->create();

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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials + ['status' => 'active'])) {
            $request->session()->regenerate();
            
            return redirect()->route('dashboard');
        }

        // If attempt fails
        return redirect()->route('auth.page')
                        ->with('login_error', 'Invalid login credentials or inactive account.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect()->route('auth.page');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('auth.page')->with('login_error', 'Please log in first.');
        }

        $validated = $request->validate([
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            
        ]);

        try {
            DB::table('useraccount')
                ->where('user_id', $user->user_id)
                ->update([
                    'fullName'        => $validated['fullName'],
                    'email'           => $validated['email'],
                    'contact_number'  => $validated['contact_number'] ?? null,
                    'address'         => $validated['address'] ?? null,
                    'updated_at'      => now()
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
        $user = Auth::user();
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

            if (is_object($user)) {
                $user->password = Hash::make($validated['new_password']);
            }

            return back()->with('success', 'Password updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating password: ' . $e->getMessage());
        }
    }
}
