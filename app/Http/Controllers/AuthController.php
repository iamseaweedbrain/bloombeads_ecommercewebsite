<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showAuth() {
        return view('authentication');
    }

    public function signUp(Request $request)
    {
        $validated = $request->validate([
            'firstName' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z\s]+$/u'],
            'lastName'  => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z\s]+$/u'],
            'email'     => ['required', 'email:rfc,dns', 'max:100', 'unique:useraccount,email', 'regex:/@gmail\.com$/'],
            'password'  => [
                'required',
                'confirmed',
                Password::min(8)
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
            ],
            'contact_number' => ['required', 'string', 'regex:/^(09|\+639)\d{9}$/'],
            'address'        => ['required', 'string', 'max:255'],
        ]);
        
        try {
            $userId = DB::table('useraccount')->insertGetId([
                'fullName'   => $validated['firstName'] . ' ' . $validated['lastName'],
                'email'      => $validated['email'],
                'password'   => Hash::make($validated['password']),
                'status'     => 'active',
                'contact_number'  => $validated['contact_number'],
                'address'         => $validated['address'],
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            $user = User::find($userId);
            if ($user) {
                $user->cart()->create();
            }

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

    public function resetPassword(Request $request)
    {
        // 1. Password Format Validation
        $validated = $request->validate([
            'reset_token' => 'required|string',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
            ],
        ]);
        
        // 2. Token Check
        $tokenData = DB::table('password_reset_tokens')
                        ->where('token', $validated['reset_token'])
                        ->first();

        if (!$tokenData || Carbon::parse($tokenData->created_at)->addMinutes(config('auth.passwords.users.expire', 60))->isPast()) {
            return response()->json(['message' => 'Invalid or expired token.'], 422);
        }

        // 3. Find the user from the correct table
        $user = DB::table('useraccount')->where('email', $tokenData->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // --- REMOVED: Custom Old Password Check (Hash::check logic) ---

        // 4. Update the password
        try {
            DB::table('useraccount')
                ->where('email', $user->email)
                ->update([
                    'password' => Hash::make($validated['password']),
                    'updated_at' => now()
                ]);

            DB::table('password_reset_tokens')->where('email', $user->email)->delete();

            return response()->json(['message' => 'Password has been reset successfully. You can now log in.'], 200);

        } catch (\Exception $e) {
            \Log::error('Password Reset DB Error: ' . $e->getMessage());
            return response()->json(['message' => 'A server error occurred during password reset.'], 500);
        }
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

            $updatedUser = DB::table('useraccount')->where('user_id', $user->user_id)->first();
            session(['user' => $updatedUser]);

            return back()->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Database error: ' . $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('auth.page')->with('login_error', 'Please log in first.');
        }

        $validated = $request->validate([
            'current_password' => 'required',
            'new_password'     => [
                'required',
                'confirmed',
                Password::min(8)
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
            ],
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        if ($validated['current_password'] === $validated['new_password']) {
            return back()->with('error', 'New password cannot be the same as the old password.');
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