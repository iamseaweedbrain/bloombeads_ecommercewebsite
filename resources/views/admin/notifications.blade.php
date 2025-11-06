@extends('layouts.admin')

@section('content')
<section id="notifications-view">
    <h2 class="text-3xl font-fredoka font-bold mb-6">Notifications & Logs</h2>

    <div class="bg-white card-radius shadow-soft p-6">
        <div class="space-y-3 font-poppins">
           @foreach($messages as $msg)
            <div class="p-3 bg-neutral card-radius border border-gray-200">
                <p><span class="font-bold text-success">CUSTOMER:</span> {{ $msg->name }}
                needs assistance for "{{ $msg->subject }}" ({{ $msg->created_at->diffForHumans() }})</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection