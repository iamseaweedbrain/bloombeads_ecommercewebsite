@extends('layouts.admin')

@section('content')
<section id="notifications-view" class="font-poppins">
    <h2 class="text-3xl font-fredoka font-bold mb-6">Notifications & Logs</h2>

    @if($lowStockProducts->isNotEmpty())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 card-radius shadow-soft mb-6" role="alert">
            <h3 class="font-fredoka font-bold text-lg">Low Stock Alerts!</h3>
            <p class="font-poppins text-sm mb-3">The following items are running low. Please restock soon.</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($lowStockProducts as $product)
                    <li class="font-poppins text-sm">
                        
                        <a href="{{ route('admin.catalog.index') }}" class="font-semibold text-red-800 hover:underline">
                            {{ $product->name }}
                        </a>
                        - <span class="font-bold">{{ $product->stock }} {{ Str::plural('item', $product->stock) }} left.</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="flex border-b border-neutral mb-4">
        @php
            $filters = [
                'all' => 'All Messages',
                'unread' => 'Unread',
                'read' => 'Read'
            ];
        @endphp

        @foreach ($filters as $key => $value)
            <a href="{{ route('admin.notifications', ['filter' => $key]) }}"
               class="py-3 px-4 font-poppins font-semibold whitespace-nowrap
                  {{ $activeFilter == $key ? 'text-sakura border-b-2 border-sakura' : 'text-dark/60 hover:text-dark' }}">
                {{ $value }}
            </a>
        @endforeach
    </div>

    <div class="bg-white card-radius shadow-soft overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-neutral">
                        <th class="p-4 text-left font-semibold">From</th>
                        <th class="p-4 text-left font-semibold">Subject</th>
                        <th class="p-4 text-left font-semibold">Received</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($messages as $message)
                        <tr class="border-b border-neutral/50 hover:bg-neutral/50">
                            <td class="p-4">
                                <a href="{{ route('admin.notifications.show', $message) }}" 
                                   class="hover:text-sky transition-default {{ is_null($message->read_at) ? 'font-bold text-dark' : 'text-dark/70' }}">
                                    {{ $message->name }}
                                    <span class="text-sm">({{ $message->email }})</span>
                                </a>
                            </td>
                            <td class="p-4">
                                <a href="{{ route('admin.notifications.show', $message) }}" 
                                   class="hover:text-sky transition-default {{ is_null($message->read_at) ? 'font-bold text-dark' : 'text-dark/70' }}">
                                    {{ $message->subject }}
                                </a>
                            </td>
                            <td class="p-4 text-sm {{ is_null($message->read_at) ? 'font-bold text-dark' : 'text-dark/70' }}">
                                {{ $message->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-8 text-center text-dark/70">
                                No messages found in this filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $messages->links() }}
        </div>
    </div>
</section>
@endsection