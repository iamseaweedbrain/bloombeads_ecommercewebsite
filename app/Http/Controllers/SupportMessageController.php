<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportMessage;

class SupportMessageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        SupportMessage::create($validated);

        return back()->with('success', 'Your message has been sent!');
    }
    public function notifications()
    {
        $messages = SupportMessage::latest()->get();
        return view('admin.notifications', compact('messages'));
    }
}
