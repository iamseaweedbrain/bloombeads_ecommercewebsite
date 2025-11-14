@extends('layouts.admin')

@section('content')
<section id="notification-details-view" class="font-poppins">
    
    <a href="{{ route('admin.notifications') }}" class="flex items-center text-dark hover:text-sakura font-fredoka font-semibold mb-4">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        Back to Notifications
    </a>

    <div class="bg-white card-radius shadow-soft overflow-hidden">
        <div class="p-6 border-b border-neutral">
            <h2 class="text-2xl font-fredoka font-bold mb-1">{{ $message->subject }}</h2>
            <p class="text-dark/80">
                From: <span class="font-semibold text-dark">{{ $message->name }}</span>
                &lt;<a href="mailto:{{ $message->email }}" class="text-sky hover:underline">{{ $message->email }}</a>&gt;
            </p>
            <p class="text-sm text-dark/70 mt-1">
                Received: {{ $message->created_at->format('M d, Y \a\t h:i A') }}
            </p>
        </div>

        <div class="p-6">
            <h3 class="font-fredoka font-semibold mb-2">Message:</h3>
            <div class="prose max-w-none text-dark/90 whitespace-pre-line">
                {{ $message->message }}
            </div>
        </div>
    </div>
</section>
@endsection