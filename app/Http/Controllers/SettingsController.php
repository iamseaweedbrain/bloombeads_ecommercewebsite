<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Session::get('user');
        if (!$user) {
            return redirect()->route('auth.page');
        }

        return view('account_settings.settings', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Session::get('user');
        if (!$user) {
            return redirect()->route('auth.page');
        }

        $validated = $request->validate([
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        DB::table('useraccount')
            ->where('user_id', $user->user_id)
            ->update([
                'fullName' => $validated['fullName'],
                'email' => $validated['email'],
                'updated_at' => now(),
            ]);

        // Refresh session user
        $updatedUser = DB::table('useraccount')->where('user_id', $user->user_id)->first();
        Session::put('user', $updatedUser);

        return redirect()->route('settings.page')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $user = Session::get('user');
        if (!$user) {
            return redirect()->route('auth.page');
        }

        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        DB::table('useraccount')
            ->where('user_id', $user->user_id)
            ->update([
                'password' => Hash::make($validated['new_password']),
                'updated_at' => now(),
            ]);

        return redirect()->route('settings.page')->with('success', 'Password updated successfully!');
    }
}
