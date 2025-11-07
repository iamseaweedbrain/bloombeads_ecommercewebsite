<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\UserActivity; // <-- Import the activity model

class SettingsController extends Controller
{
    /**
     * Show the user's profile settings page.
     */
    public function show()
    {
        return view('settings', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'fullName' => 'required|string|max:100',
            'email' => [
                'required', 'email', 'max:100',
                Rule::unique('useraccount')->ignore($user->user_id, 'user_id')
            ],
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string'
        ]);

        $user->update($validated);

        UserActivity::create([
            'user_id' => $user->user_id,
            'message' => 'Updated profile information.',
            'url' => route('settings')
        ]);

        return redirect()->route('settings')->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Your current password does not match our records.'
            ]);
        }

        $user->update([
            'password' => Hash::make($validated['new_password'])
        ]);

        UserActivity::create([
            'user_id' => $user->user_id,
            'message' => 'Updated password.',
            'url' => route('settings')
        ]);

        return redirect()->route('settings')->with('success', 'Password updated successfully!');
    }
}