<x-layout>
<section class="px-6 py-8 bg-gray-50 min-h-screen">
    <main class="max-w-6xl mx-auto mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- 🛒 Left: Cart Items --}}
        <div class="md:col-span-2 bg-white shadow-md rounded-2xl p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Your Shopping Cart</h1>

            {{-- Cart Items --}}
            <div id="cartContainer">
                @foreach($cartItems as $item)
                <div class="cart-item flex items-center justify-between bg-white border rounded-xl shadow-sm p-4 mb-4 transition duration-300">
                    <div class="flex items-center gap-4">
                        {{-- Badge (Custom / Key) --}}
                        <div class="w-14 h-14 flex items-center justify-center rounded-xl text-white font-semibold 
                            {{ $loop->index == 0 ? 'bg-pink-400' : 'bg-cyan-500' }}">
                            {{ $loop->index == 0 ? 'Custom' : 'Key' }}
                        </div>

                        {{-- Item Info --}}
                        <div>
                            <h2 class="font-semibold text-gray-900">{{ $item['name'] }}</h2>

                            @if($loop->index == 0)
                                <p class="text-sm text-gray-600">Base price: ₱{{ number_format($item['price'], 2) }}</p>
                            @else
                                <p class="text-sm text-gray-600">Category: Collectibles</p>
                            @endif

                            <p class="font-bold text-pink-500 mt-1">₱{{ number_format($item['price'], 2) }}</p>
                        </div>
                    </div>

                    {{-- Right side: Quantity + Delete --}}
                    <div class="flex items-center gap-4">
                        {{-- Quantity box --}}
                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                            <div class="px-3 py-1.5 bg-white font-semibold text-gray-800 text-center min-w-[38px] quantity-value">
                                {{ $item['quantity'] }}
                            </div>
                            <div class="flex flex-col bg-gray-100">
                                <button class="arrow-btn up text-gray-600 hover:text-gray-800 text-[10px] leading-none px-1 py-0.5" data-action="increase">▲</button>
                                <button class="arrow-btn down text-gray-600 hover:text-gray-800 text-[10px] leading-none px-1 py-0.5" data-action="decrease">▼</button>
                            </div>
                        </div>

                        {{-- Delete button --}}
                        <button class="text-black hover:text-pink-500 delete-btn transition duration-150" title="Remove item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h10" />
                            </svg>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- 🩶 Empty Cart Message --}}
            <div id="emptyCartMessage" class="hidden text-center py-10 text-gray-600">
                <p class="text-lg font-semibold mb-3">🛒 Your cart is empty.</p>
                <a href="{{ url('/browsecatalog') }}" 
                   class="inline-block bg-pink-400 hover:bg-pink-500 text-white px-6 py-3 rounded-lg font-semibold transition">
                   Continue Browsing
                </a>
            </div>
        </div>

        {{-- 💳 Right: Order Summary --}}
        <div class="bg-white shadow-md rounded-2xl p-6">
            <h2 class="text-lg font-bold text-cyan-500 mb-4">Order Summary</h2>

            @php
                $subtotal = collect($cartItems)->sum(fn($i) => $i['price'] * $i['quantity']);
                $shipping = 10.00;
                $total = $subtotal + $shipping;
            @endphp

            <div class="flex justify-between text-gray-700 mb-2">
                <span>Subtotal:</span>
                <span class="subtotal">₱{{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between text-gray-700 mb-2">
                <span>Shipping:</span>
                <span class="shipping">₱{{ number_format($shipping, 2) }}</span>
            </div>
            <div class="flex justify-between font-bold text-lg text-gray-900 mt-4 border-t pt-2">
                <span>Total:</span>
                <span class="total text-pink-500">₱{{ number_format($total, 2) }}</span>
            </div>

            {{-- Buttons --}}
            <button id="checkoutBtn"
                class="mt-6 w-full bg-orange-400 hover:bg-orange-500 text-white py-3 rounded-lg font-semibold transition">
                PROCEED TO CHECKOUT
            </button>

            <a href="{{ url('/browsecatalog') }}"
                class="block mt-3 w-full text-center border border-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                CONTINUE BROWSING
            </a>
        </div>
    </main>
</section>

{{-- ✨ JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const updateTotals = () => {
        const items = document.querySelectorAll('.cart-item');
        let subtotal = 0;
        items.forEach(item => {
            const priceText = item.querySelector('.font-bold.text-pink-500').textContent.replace(/[₱,]/g, '');
            const qty = parseInt(item.querySelector('.quantity-value').textContent);
            subtotal += parseFloat(priceText) * qty;
        });
        const shipping = 10.00;
        const total = subtotal + (items.length > 0 ? shipping : 0);

        document.querySelector('.subtotal').textContent = '₱' + subtotal.toFixed(2);
        document.querySelector('.total').textContent = '₱' + total.toFixed(2);
    };

    const checkEmptyCart = () => {
        const container = document.getElementById('cartContainer');
        const emptyMsg = document.getElementById('emptyCartMessage');
        if (container.children.length === 0) {
            container.classList.add('hidden');
            emptyMsg.classList.remove('hidden');
        }
    };

    document.querySelectorAll('.arrow-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.dataset.action;
            const qtyDisplay = this.closest('.flex.items-center.border').querySelector('.quantity-value');
            let qty = parseInt(qtyDisplay.textContent);

            if (action === 'increase') qty++;
            else if (action === 'decrease' && qty > 1) qty--;

            qtyDisplay.textContent = qty;
            updateTotals();
        });
    });

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const itemRow = this.closest('.cart-item');
            itemRow.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                itemRow.remove();
                updateTotals();
                checkEmptyCart();
            }, 200);
        });
    });

    document.getElementById('checkoutBtn').addEventListener('click', () => {
        window.location.href = "{{ route('payment.index') }}";
    });
});
</script>
</x-layout>