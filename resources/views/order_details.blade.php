<x-layout>
    <section class="py-12 md:py-16">
        <main class="max-w-4xl mx-auto px-4">

            <div class="flex justify-between">
                <a href="{{ route('dashboard', ['status=all']) }}" class="flex items-center text-dark hover:text-sakura font-fredoka font-semibold mb-4">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back to Order History
                </a>

                <div class="flex items-center gap-3 text-dark hover:text-sakura font-fredoka font-semibold mb-4 cursor-pointer" onclick="downloadReceipt('{{ $order->order_tracking_id }}')">
                    <p>Download Receipt</p>
                    <i data-lucide="arrow-big-down-dash" id="downloadReceipt" class="w-5 h-5"></i>
                </div>
            </div>

            <div class="bg-white p-6 card-radius shadow-soft" id="orderReceiptWebView">
                <div class="flex flex-col sm:flex-row justify-between sm:items-center border-b border-neutral pb-4">
                    <div>
                        <h1 class="text-3xl font-fredoka font-bold">Order Details</h1>
                        <p class="font-poppins text-dark/70">
                            Tracking Number #<span class="font-semibold text-dark">{{ $order->order_tracking_id }}</span>
                            &middot; Placed on {{ $order->created_at->format('M d, Y') }}
                        </p>
                    </div>
                    @php
                        $statusClass = 'text-dark/70'; // Default
                        if ($order->order_status == 'delivered') $statusClass = 'text-green-600';
                        elseif ($order->order_status == 'shipped') $statusClass = 'text-sky';
                        elseif ($order->order_status == 'processing') $statusClass = 'text-blue-500';
                        elseif ($order->order_status == 'pending') $statusClass = 'text-cta';
                        elseif ($order->order_status == 'cancelled') $statusClass = 'text-red-500';
                    @endphp
                    <span class="font-fredoka font-bold text-lg uppercase {{ $statusClass }} mt-3 sm:mt-0">
                        {{ $order->order_status }}
                    </span>
                </div>

                <div class="space-y-4 py-6 border-b border-neutral">
                    @foreach($order->items as $item)
                        <div class="flex items-center space-x-4">
                            <img src="{{ $item->product->image_path ? asset('storage/' . $item->product->image_path) : 'https://placehold.co/80x80/FF6B81/FFFFFF?text=B' }}"
                                 alt="{{ $item->product->name }}"
                                 class="w-20 h-20 card-radius object-cover bg-gray-100 flex-shrink-0">
                            <div class="flex-grow">
                                <p class="font-poppins font-semibold text-dark">{{ $item->product->name }}</p>
                                <p class="text-sm text-dark/70">x {{ $item->quantity }}</p>
                            </div>
                            <p class="font-poppins font-semibold text-dark text-lg">₱{{ number_format($item->price * $item->quantity, 2) }}</p>
                        </div>
                    @endforeach
                </div>

                @if(in_array($order->order_status, ['pending', 'processing']))
                <div class="border-t border-neutral mt-6 pt-6 text-right">
                    <form action="{{ route('order.cancel', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order? This action cannot be undone.');">
                        @csrf
                        <button type-="submit" class="py-2 px-6 font-poppins font-semibold card-radius text-white bg-red-500 hover:bg-red-600 transition-default">
                            Cancel Order
                        </button>
                    </form>
                </div>
                @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 py-6">
                    
                    @if($order->payment_method == 'cod')
                        <div>
                            <h3 class="text-xl font-fredoka font-bold mb-3">Shipping Information</h3>
                            <div class="font-poppins text-dark/90 space-y-1">
                                <p class="font-semibold">{{ $order->user->fullName }}</p>
                                <p>{{ $order->user->contact_number ?? 'No contact number' }}</p>
                                <p class="text-dark/70">{{ $order->user->address ?? 'No shipping address set' }}</p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <h3 class="text-xl font-fredoka font-bold mb-3">Order Summary</h3>
                            <div class="flex justify-between font-poppins">
                                <span class="text-dark/70">Subtotal:</span>
                                <span>₱{{ number_format($order->total_amount - 10, 2) }}</span>
                            </div>
                            <div class="flex justify-between font-poppins">
                                <span class="text-dark/70">Shipping:</span>
                                <span>₱10.00</span>
                            </div>
                            <div class="flex justify-between font-fredoka font-bold text-lg pt-2 border-t border-neutral">
                                <span class="text-dark">Total:</span>
                                <span class="text-sakura">₱{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between font-poppins text-sm">
                                <span class="text-dark/70">Payment Method:</span>
                                <span class="font-semibold">{{ strtoupper($order->payment_method) }}</span>
                            </div>
                        </div>

                    @else
                        <div class="space-y-8">
                            <div>
                                <h3 class="text-xl font-fredoka font-bold mb-3">Shipping Information</h3>
                                <div class="font-poppins text-dark/90 space-y-1">
                                    <p class="font-semibold">{{ $order->user->fullName }}</p>
                                    <p>{{ $order->user->contact_number ?? 'No contact number' }}</p>
                                    <p class="text-dark/70">{{ $order->user->address ?? 'No shipping address set' }}</p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <h3 class="text-xl font-fredoka font-bold mb-3">Order Summary</h3>
                                <div class="flex justify-between font-poppins">
                                    <span class="text-dark/70">Subtotal:</span>
                                    <span>₱{{ number_format($order->total_amount - 10, 2) }}</span>
                                </div>
                                <div class="flex justify-between font-poppins">
                                    <span class="text-dark/70">Shipping:</span>
                                    <span>₱10.00</span>
                                </div>
                                <div class="flex justify-between font-fredoka font-bold text-lg pt-2 border-t border-neutral">
                                    <span class="text-dark">Total:</span>
                                    <span class="text-sakura">₱{{ number_format($order->total_amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between font-poppins text-sm">
                                    <span class="text-dark/70">Payment Method:</span>
                                    <span class="font-semibold">{{ strtoupper($order->payment_method) }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-xl font-fredoka font-bold mb-3">Payment Receipt</h3>
                            @if($order->payment_receipt_path)
                                <a href="{{ asset('storage/' . $order->payment_receipt_path) }}" target="_blank" title="View full receipt">
                                    <img src="{{ asset('storage/'. $order->payment_receipt_path) }}" alt="Payment Receipt" 
                                         class="w-full card-radius border border-neutral hover:border-sky transition-all object-cover max-h-96">
                                </a>
                            @else
                                <p class="font-poppins text-sm text-dark/70">
                                    No receipt was uploaded.
                                </p>
                            @endif
                        </div>
                    @endif

                </div>
            </div>

            <div class="absolute -left-[9999px]">
                <div class=" bg-white p-28 card-radius shadow-soft" id="orderReceipt">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center border-b border-neutral pb-4">
                        <div>
                            <p class="text-3xl font-fredoka font-bold">Order Details</p>
                            <p class="font-poppins text-dark/70">
                                Tracking Number #<span class="font-semibold text-dark">{{ $order->order_tracking_id }}</span>
                                &middot; Placed on {{ $order->created_at->format('M d, Y') }}
                            </p>
                        </div>

                        @php
                            $statusClass = 'text-dark/70';
                            if ($order->order_status == 'delivered') $statusClass = 'text-green-600';
                            elseif ($order->order_status == 'shipped') $statusClass = 'text-sky-500';
                            elseif ($order->order_status == 'processing') $statusClass = 'text-blue-500';
                            elseif ($order->order_status == 'pending') $statusClass = 'text-amber-500';
                            elseif ($order->order_status == 'cancelled') $statusClass = 'text-red-500';
                        @endphp
                        <span class="font-fredoka font-bold text-lg uppercase {{ $statusClass }} mt-3 sm:mt-0">
                            {{ $order->order_status }}
                        </span>
                    </div>

                    <div class="space-y-4 py-6 border-b border-neutral">
                        @foreach($order->items as $item)
                            <div class="flex items-center space-x-4">
                                <img src="{{ $item->product->image_path ? asset('storage/' . $item->product->image_path) : 'https://placehold.co/80x80/FF6B81/FFFFFF?text=B' }}"
                                    alt="{{ $item->product->name }}"
                                    class="w-20 h-20 card-radius object-cover bg-gray-100 flex-shrink-0">
                                <div class="flex-grow">
                                    <p class="font-poppins font-semibold text-dark">{{ $item->product->name }}</p>
                                    <p class="text-sm text-dark/70">x {{ $item->quantity }}</p>
                                </div>
                                <p class="font-poppins font-semibold text-dark text-lg">₱{{ number_format($item->price * $item->quantity, 2) }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 py-6">
                        <div>
                            <h3 class="text-xl font-fredoka font-bold mb-3">Shipping Information</h3>
                            <div class="font-poppins text-dark/90 space-y-1">
                                <p class="font-semibold">{{ $order->user->fullName }}</p>
                                <p>{{ $order->user->contact_number ?? 'No contact number' }}</p>
                                <p class="text-dark/70">{{ $order->user->address ?? 'No shipping address set' }}</p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <h3 class="text-xl font-fredoka font-bold mb-3">Order Summary</h3>
                            <div class="flex justify-between font-poppins">
                                <span class="text-dark/70">Subtotal:</span>
                                <span>₱{{ number_format($order->total_amount - 10, 2) }}</span>
                            </div>
                            <div class="flex justify-between font-poppins">
                                <span class="text-dark/70">Shipping:</span>
                                <span>₱10.00</span>
                            </div>
                            <div class="flex justify-between font-fredoka font-bold text-lg pt-2 border-t border-neutral">
                                <span class="text-dark">Total:</span>
                                <span class="text-sakura">₱{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between font-poppins text-sm">
                                <span class="text-dark/70">Payment Method:</span>
                                <span class="font-semibold">{{ strtoupper($order->payment_method) }}</span>
                            </div>
                        </div>

                        @if($order->payment_method != 'cod')
                            <div class="col-span-1 md:col-span-2 mt-4 pt-4 border-t border-neutral">
                                <h3 class="text-xl font-fredoka font-bold mb-3">Payment Receipt</h3>
                                @if($order->payment_receipt_path)
                                    <a href="{{ asset('storage/' . $order->payment_receipt_path) }}" target="_blank" title="View full receipt">
                                        <img src="{{ asset('storage/'. $order->payment_receipt_path) }}" alt="Payment Receipt" 
                                            class="w-full card-radius border border-neutral hover:border-sky transition-all object-cover max-h-96">
                                    </a>
                                @else
                                    <p class="font-poppins text-sm text-dark/70">
                                        No receipt was uploaded.
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </section>

    <script>
        async function downloadReceipt(orderId) {
            const { jsPDF } = window.jspdf;
            const receipt = document.getElementById('orderReceipt');

            const btn = document.getElementById('downloadReceipt');
            btn.classList.add('animate-bounce');
            
            const canvas = await html2canvas(receipt, {
                scale: 2,
                useCORS: true
            });

            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF('p', 'mm', 'a4');

            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            pdf.save(`Order_${orderId}_Receipt.pdf`);

            btn.classList.remove('animate-bounce');
        }
        </script>
</x-layout>