<x-layout>
    <section id="cart-view" class="py-12 md:py-16 bg-neutral">
        <h2 class="text-3xl font-fredoka font-bold mb-8""> Your Shopping Cart </h2>
        <div class="md:grid md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-4" id="cartContainer">
                @foreach ($cartItems as $item)
                    <div
                        class="cart-item bg-white p-4 card-radius shadow-soft flex items-center space-x-4 border border-neutral hover:border-sakura/40 transition-all duration-300">
                        <div
                            class="w-20 h-20 flex items-center justify-center card-radius text-white font-semibold {{ $loop->index == 0 ? 'bg-sakura' : 'bg-sky' }}">
                            {{ $loop->index == 0 ? 'Custom' : 'Key' }} </div>
                        <div class="flex-grow">
                            <h4 class="font-poppins font-semibold text-dark">{{ $item['name'] }}</h4>
                            @if ($loop->index == 0)
                                <p class="text-sm font-poppins text-dark/70">Base price:
                                    ₱{{ number_format($item['price'], 2) }}</p>
                            @else
                                <p class="text-sm font-poppins text-dark/70">Category: Collectibles</p>
                                @endif <p class="font-poppins font-bold text-lg text-sakura mt-1">
                                    ₱{{ number_format($item['price'], 2) }}</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center border border-neutral rounded-lg overflow-hidden">
                                <div
                                    class="px-3 py-1.5 bg-white font-semibold text-dark text-center min-w-[38px] quantity-value">
                                    {{ $item['quantity'] }} </div>
                                <div class="flex flex-col bg-neutral/60"> <button
                                        class="arrow-btn up text-dark hover:text-sakura text-[10px] leading-none px-1 py-0.5"
                                        data-action="increase">▲</button> <button
                                        class="arrow-btn down text-dark hover:text-sakura text-[10px] leading-none px-1 py-0.5"
                                        data-action="decrease">▼</button> </div>
                            </div> <button
                                class="text-dark hover:text-sakura p-1 rounded-full hover:bg-neutral/70 transition-all delete-btn"
                                title="Remove item"> <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h10" />
                                </svg> </button>
                        </div>
                    </div>
                @endforeach
                <div id="emptyCartMessage" class="hidden text-center py-10 text-dark/70">
                    <p class="text-lg font-fredoka mb-3">🛒 Your cart is empty.</p> <a
                        href="{{ url('/browsecatalog') }}"
                        class="inline-block bg-sakura hover:bg-sakura/90 text-white px-6 py-3 card-radius font-semibold shadow-soft transition-default">
                        Continue Browsing </a>
                </div>
            </div>
            <div
                class="md:col-span-1 bg-white p-6 card-radius shadow-soft mt-8 md:mt-0 sticky top-20 h-fit border border-neutral">
                <h3 class="text-xl font-fredoka font-bold border-b pb-3 mb-4 text-sky">Order Summary</h3>
                @php
                    $subtotal = collect($cartItems)->sum(fn($i) => $i['price'] * $i['quantity']);
                    $shipping = 10.0;
                    $total = $subtotal + $shipping;
                @endphp <div class="space-y-2 font-poppins text-dark">
                    <p class="flex justify-between">Subtotal: <span
                            class="subtotal">₱{{ number_format($subtotal, 2) }}</span></p>
                    <p class="flex justify-between">Shipping: <span
                            class="shipping">₱{{ number_format($shipping, 2) }}</span></p>
                    <p class="flex justify-between font-bold text-lg pt-2 border-t border-neutral">Total: <span
                            class="total text-sakura">₱{{ number_format($total, 2) }}</span></p>
                </div> <button id="checkoutBtn"
                    class="mt-6 w-full py-3 font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 shadow-soft transform hover:scale-[1.02] transition-all duration-300">
                    PROCEED TO CHECKOUT </button> <a href="{{ url('/browsecatalog') }}"
                    class="block mt-3 w-full text-center py-3 font-poppins card-radius text-dark border border-neutral hover:bg-neutral/70 transition-all duration-300">
                    CONTINUE BROWSING </a>
            </div>
        </div>

        <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="total" id="checkoutTotal" value="">
        </form>

    </section>

    <script>
    console.log('Checkout script loaded');

    document.addEventListener('DOMContentLoaded', () => {
        const checkoutBtn = document.getElementById('checkoutBtn');

        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', (e) => {
                e.preventDefault(); 
                const totalText = document.querySelector('.total').textContent.replace(/[₱,]/g, '');
                const total = parseFloat(totalText);

                document.getElementById('checkoutTotal').value = total;

                console.log('Submitting checkout with total:', total);
                document.getElementById('checkoutForm').submit();
            });
        }

        const updateTotals = () => {
            const items = document.querySelectorAll('.cart-item');
            let subtotal = 0;

            items.forEach(item => {
                const priceText = item.querySelector('.font-bold.text-sakura');
                if (!priceText) return;

                const price = parseFloat(priceText.textContent.replace(/[₱,]/g, ''));
                const qty = parseInt(item.querySelector('.quantity-value').textContent);
                subtotal += price * qty;
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
                itemRow.classList.add('opacity-0', 'scale-95', 'transition-all', 'duration-200');
                setTimeout(() => {
                    itemRow.remove();
                    updateTotals();
                    checkEmptyCart();
                }, 200);
            });
        });

        updateTotals();
    });
    </script>


</x-layout>
