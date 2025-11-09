<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportMessage;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class SupportMessageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $message = SupportMessage::create($validated);

        // Check if the user is logged in before logging
        if (Auth::check()) {
            UserActivity::create([
                'user_id' => Auth::id(),
                'message' => 'Sent a support message: "' . $validated['subject'] . '"',
                'url' => route('support.show', $message)
            ]);
        }

        return back()->with('success', 'Your message has been sent!');
    }

    /**
     * Show the notifications list in the admin panel.
     */
    public function notifications(Request $request)
    {
        $filter = $request->query('filter', 'all');

        $query = SupportMessage::query();

        if ($filter === 'unread') {
            $query->whereNull('read_at');
        } elseif ($filter === 'read') {
            $query->whereNotNull('read_at');
        }
        
        $messages = $query->orderBy('read_at', 'asc')
                         ->orderBy('created_at', 'desc')
                         ->paginate(20)
                         ->withQueryString();

        $lowStockProducts = Product::where('stock', '<=', 5)
                                   ->orderBy('stock', 'asc')
                                   ->get();

        return view('admin.notifications', [
            'messages' => $messages,
            'activeFilter' => $filter,
            'lowStockProducts' => $lowStockProducts
        ]);
    }

    /**
     * Show a single notification message in the admin panel.
     */
    public function show(SupportMessage $message)
    {
        if (is_null($message->read_at)) {
            $message->update(['read_at' => now()]);
        }

        return view('admin.notification_details', [
            'message' => $message
        ]);
    }

    /**
     * Show a single support message for the user.
     */
    public function showUserMessage(SupportMessage $message)
    {
        if (Auth::user()->email !== $message->email) {
            abort(404);
        }

        return view('support_message_details', [
            'message' => $message
        ]);
    }
}