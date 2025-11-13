<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\UserActivity;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
        public function show()
    {
        $fullNameParts = explode(' ', Auth::user()->fullName, 2);
        $user = Auth::user();
        $user->first_name = $fullNameParts[0] ?? '';
        $user->last_name = $fullNameParts[1] ?? '';

        return view('settings', [
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'firstName' => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z\s]+$/u'],
            'lastName'  => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z\s]+$/u'],
            
            'email' => [
                'required', 
                'email:rfc,dns', 
                'max:100', 
                'regex:/@gmail\.com$/',
                Rule::unique('useraccount')->ignore($user->user_id, 'user_id')
            ],
            
            'contact_number' => ['required', 'string', 'regex:/^(09|\+639)\d{9}$/'],
            
            'address' => 'required|string'
        ]);
        
        $fullName = $validated['firstName'] . ' ' . $validated['lastName'];

        $user->update([
            'fullName' => $fullName,
            'email' => $validated['email'],
            'contact_number' => $validated['contact_number'],
            'address' => $validated['address'],
        ]);

        UserActivity::create([
            'user_id' => $user->user_id,
            'message' => 'Updated profile information.',
            'url' => route('settings')
        ]);

        return redirect()->route('settings')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Your current password does not match our records.'
            ]);
        }
        
        if ($validated['current_password'] === $validated['new_password']) {
            return back()->withErrors([
                'new_password' => 'The new password cannot be the same as your current password.'
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