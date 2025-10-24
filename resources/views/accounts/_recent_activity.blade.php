<h2 class="text-xl font-semibold mb-3 border-b pb-2 text-pink-600">Recent Activity</h2>

@php
    $activities = $activities ?? [
        (object) ['action' => 'Updated profile information', 'timestamp' => '2025-10-20 14:30'],
        (object) ['action' => 'Placed an order #ORD-1024', 'timestamp' => '2025-10-19 09:15'],
        (object) ['action' => 'Changed password', 'timestamp' => '2025-10-18 21:47'],
    ];
@endphp

@forelse ($activities as $activity)
    <div class="bg-gray-50 p-3 rounded-lg mb-2">
        <p class="mb-1 font-medium">{{ $activity->action }}</p>
        <small class="text-gray-500">{{ $activity->timestamp }}</small>
    </div>
@empty
    <p class="text-gray-500 italic">No recent activity yet.</p>
@endforelse