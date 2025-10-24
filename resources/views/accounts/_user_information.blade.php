<h2 class="text-xl font-semibold mb-3 border-b pb-2 text-pink-600">
    User Info (Shipping & Contact)
</h2>

@php
    $user = $user ?? (object) [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'contact_number' => '0917 123 4567',
        'address' => "123 Example St.\nQuezon City, Metro Manila",
        'payment' => 'GCash',
    ];
@endphp

<p><strong>Full Name:</strong> {{ $user->name }}</p>
<p><strong>Email:</strong> {{ $user->email }}</p>
<p><strong>Contact Number:</strong> {{ $user->contact_number }}</p>
<p><strong>Shipping Address:</strong><br>{!! nl2br(e($user->address)) !!}</p>
<p><strong>Primary Payment:</strong> {{ $user->payment }}</p>

<button class="mt-4 bg-gray-100 hover:bg-gray-200 text-sm font-semibold px-4 py-2 rounded-md">
    Update Contact Info
</button>