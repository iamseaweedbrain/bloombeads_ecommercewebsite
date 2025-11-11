@extends('layouts.admin')

@section('content')
<section id="approvals-view" class="font-poppins">
    <h2 class="text-3xl font-fredoka font-bold mb-6">Custom Design Approvals</h2>

    @if(session('success'))
        <div class="bg-success/20 text-success p-4 card-radius mb-6 font-poppins">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex border-b border-neutral mb-4">
        @php
            $filters = [
                'all' => 'All Designs',
                'pending' => 'Pending Quote',
                'quoted' => 'Quote Sent',
                'complete' => 'Complete',
                'declined' => 'Declined'
            ];
        @endphp

        @foreach ($filters as $key => $value)
            <a href="{{ route('admin.approvals', ['status' => $key]) }}"
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
                        <th class="p-4 text-left font-semibold">Customer</th>
                        <th class="p-4 text-left font-semibold">Email</th>
                        <th class="p-4 text-left font-semibold">Submitted</th>
                        <th class="p-4 text-left font-semibold">Status</th>
                        <th class="p-4 text-left font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($designs as $design)
                        <tr class="border-b border-neutral/50 hover:bg-neutral/50">
                            <td class="p-4">
                                <span class="font-semibold text-dark">{{ $design->customer_name }}</span>
                            </td>
                            <td class="p-4 text-dark/80">
                                {{ $design->customer_email }}
                            </td>
                            <td class="p-4 text-dark/80">
                                {{ $design->created_at->format('M d, Y') }}
                            </td>
                            <td class="p-4">
                                @php
                                    $statusClass = 'bg-gray-400/20 text-gray-400';
                                    if ($design->status == 'pending') $statusClass = 'bg-cta/20 text-cta';
                                    elseif ($design->status == 'quoted') $statusClass = 'bg-sky/20 text-sky';
                                    elseif ($design->status == 'complete') $statusClass = 'bg-success/20 text-success';
                                    elseif ($design->status == 'declined') $statusClass = 'bg-red-500/20 text-red-500';
                                @endphp
                                <span class="py-1 px-2 text-xs font-poppins font-semibold rounded {{ $statusClass }}">
                                    {{ ucfirst($design->status) }}
                                </span>
                                </td>
                            <td class="p-4">
                                <a href="{{ route('admin.approvals.show', $design) }}" class="py-1 px-3 text-xs font-poppins card-radius text-dark bg-neutral hover:bg-gray-200">
                                    View Design
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-dark/70">
                                No custom designs match this filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $designs->links() }}
        </div>
    </div>
</section>
@endsection