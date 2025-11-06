<x-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <section id="cart-view" 
             class="py-12 md:py-16 bg-neutral"
             data-cart-remove-url="{{ route('cart.remove') }}"
             data-cart-update-url="{{ route('cart.update.quantity') }}">
        
        <h2 class="text-3xl font-fredoka font-bold mb-8"> Your Shopping Cart </h2>
        
        @if(session('error'))
            <div class="md:col-span-3 bg-sakura/10 text-sakura p-4 card-radius font-poppins mb-4">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="md:grid md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-4" id="cartContainer">

                @forelse ($cartItems as $item)
                    <div
                        class="cart-item bg-white p-4 card-radius shadow-soft flex items-center space-x-4 border border-neutral hover:border-sakura/40 transition-all duration-300"
                        data-cart-item-id="{{ $item['cart_item_id'] }}"
                        data-price="{{ $item['price'] ?? 0 }}"> 
                        
                        <input type="checkbox" 
                               class="item-checkout-checkbox h-5 w-5 rounded text-cta focus:ring-cta border-neutral/50 flex-shrink-0"
                               checked>

                        <img src="{{ $item['image_path'] ? asset('storage/' . $item['image_path']) : 'https://placehold.co/80x80/FF6B81/FFFFFF?text=B' }}" 
                             alt="{{ $item['name'] ?? 'Product Image' }}" 
                             class="w-20 h-20 flex-shrink-0 card-radius object-cover bg-gray-100">

                        <div class="flex-grow">
                            <h4 class="font-poppins font-semibold text-dark">{{ $item['name'] ?? 'Product Name' }}</h4>
                            <p class="text-sm font-poppins text-dark/70">Category: {{ $item['category'] ?? 'N/A' }}</p>
                            <p class="font-poppins font-bold text-lg text-sakura mt-1">
                                ₱{{ number_format($item['price'] ?? 0, 2) }}
                            </p>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            
                            <div class="flex items-center border border-neutral rounded-lg overflow-hidden">
                                <button
                                    class="quantity-btn p-2 text-dark hover:bg-neutral/70"
                                    data-action="decrease"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                </button>
                                <div
                                    class="px-3 py-1.5 bg-white font-semibold text-dark text-center min-w-[38px] quantity-value"
                                    data-quantity="{{ $item['quantity'] ?? 1 }}"
                                >
                                    {{ $item['quantity'] ?? 1 }}
                                </div>
                                <button
                                    class="quantity-btn p-2 text-dark hover:bg-neutral/70"
                                    data-action="increase"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            </div>

                            <button
                                class="text-dark hover:text-sakura p-1 rounded-full hover:bg-neutral/70 transition-all delete-btn"
                                title="Remove item">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h10" /></svg>
                            </button>
                        </div>
                    </div>

                @empty
                    <div id="emptyCartMessage" class="text-center py-10 text-dark/70">
                        <p class="text-lg font-fredoka mb-3">🛒 Your cart is empty.</p>
                        <a href="{{ route('browsecatalog') }}"
                           class="inline-block bg-sakura hover:bg-sakura/90 text-white px-6 py-3 card-radius font-semibold shadow-soft transition-default">
                            Continue Browsing
                        </a>
                    </div>
                @endforelse

            </div>
            
            {{-- Order Summary --}}
            <div
                class="md:col-span-1 bg-white p-6 card-radius shadow-soft mt-8 md:mt-0 sticky top-20 h-fit border border-neutral">
                <h3 class="text-xl font-fredoka font-bold border-b pb-3 mb-4 text-sky">Order Summary</h3>
                <div class="space-y-2 font-poppins text-dark">
                    <p class="flex justify-between">Subtotal: <span class="subtotal">₱0.00</span></p>
                    <p class="flex justify-between">Shipping: <span class="shipping">₱0.00</span></p>
                    <p class="flex justify-between font-bold text-lg pt-2 border-t border-neutral">Total: <span class="total text-sakura">₱0.00</span></p>
                </div>
                
                <button id="checkoutBtn"
                        class="mt-6 w-full py-3 font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 shadow-soft transform hover:scale-[1.02] transition-all duration-300
                        opacity-50 cursor-not-allowed"
                        disabled>
                    PROCEED TO CHECKOUT
                </button>
                
                <a href="{{ url('/browsecatalog') }}"
                   class="block mt-3 w-full text-center py-3 font-poppins card-radius text-dark border border-neutral hover:bg-neutral/70 transition-all duration-300">
                    CONTINUE BROWSING
                </a>
            </div>
        </div>

        <form id="checkoutForm" action="{{ route('cart.proceed') }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="selected_items" id="selectedItemsInput">
        </form>

    </section>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const cartView = document.getElementById('cart-view');
        const removeUrl = cartView.dataset.cartRemoveUrl; 
        const updateUrl = cartView.dataset.cartUpdateUrl;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const checkoutBtn = document.getElementById('checkoutBtn');
        const checkoutForm = document.getElementById('checkoutForm');
        const selectedItemsInput = document.getElementById('selectedItemsInput');

        //The Total Calculation Function ---
        const updateTotals = () => {
            const items = document.querySelectorAll('.cart-item');
            const checkoutBtn = document.getElementById('checkoutBtn');
            let subtotal = 0;
            let checkedItemCount = 0;

            items.forEach(item => {
                const checkbox = item.querySelector('.item-checkout-checkbox');
                if (!checkbox || !checkbox.checked) {
                    return; 
                }
                
                checkedItemCount++;
                const price = parseFloat(item.dataset.price);
                const qtyEl = item.querySelector('.quantity-value');
                const qty = parseInt(qtyEl.dataset.quantity);
                subtotal += price * qty;
            });

            const shipping = checkedItemCount > 0 ? 10.00 : 0.00;
            const total = subtotal + shipping;

            document.querySelector('.subtotal').textContent = '₱' + subtotal.toFixed(2);
            document.querySelector('.shipping').textContent = '₱' + shipping.toFixed(2);
            document.querySelector('.total').textContent = '₱' + total.toFixed(2);
            
            if (checkedItemCount === 0) {
                checkoutBtn.disabled = true;
                checkoutBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                checkoutBtn.disabled = false;
                checkoutBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        };

        //Listen for Checkbox Clicks ---
        document.querySelectorAll('.item-checkout-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateTotals);
        });

        //Checkout Button Click ---
        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', (e) => {
                e.preventDefault(); 
                if(checkoutBtn.disabled) return;
                const selectedItems = [];
                document.querySelectorAll('.item-checkout-checkbox:checked').forEach(cb => {
                    const itemRow = cb.closest('.cart-item');
                    selectedItems.push(itemRow.dataset.cartItemId);
                });
                selectedItemsInput.value = JSON.stringify(selectedItems);
                checkoutForm.submit();
            });
        }

        //Delete Button Logic ---
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const itemRow = this.closest('.cart-item');
                const cartItemId = itemRow.dataset.cartItemId; 

                if (!removeUrl || !cartItemId || !csrfToken) {
                    console.error('Missing data for delete');
                    return;
                }
                
                fetch(removeUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: new URLSearchParams({
                        'cart_item_id': cartItemId,
                        '_token': csrfToken
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        itemRow.classList.add('opacity-0', 'scale-95', 'transition-all', 'duration-200');
                        setTimeout(() => {
                            itemRow.remove();
                            updateTotals();
                            checkEmptyCart();
                        }, 200);
                    } else {
                        alert(data.message || 'Error removing item.');
                    }
                })
                .catch(error => console.error('Fetch error:', error));
            });
        });
        
        //Quantity Button Logic ---
        document.querySelectorAll('.quantity-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.dataset.action;
                const itemRow = this.closest('.cart-item');
                const cartItemId = itemRow.dataset.cartItemId;
                const qtyEl = itemRow.querySelector('.quantity-value');
                
                let currentQty = parseInt(qtyEl.dataset.quantity);

                if (action === 'increase') {
                    currentQty++;
                } else if (action === 'decrease' && currentQty > 1) {
                    currentQty--;
                } else {
                    return;
                }

                qtyEl.textContent = currentQty;
                qtyEl.dataset.quantity = currentQty;
                updateTotals(); // Re-calculate totals

                fetch(updateUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        cart_item_id: cartItemId,
                        quantity: currentQty
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        console.error('Failed to update quantity on server.');
                    }
                })
                .catch(error => console.error('Fetch error:', error));
            });
        });

        const checkEmptyCart = () => {
            const container = document.getElementById('cartContainer');
            if (!container) return;
            const items = container.querySelectorAll('.cart-item');
            let emptyMsg = container.querySelector('#emptyCartMessage');
            
            if (items.length === 0 && !emptyMsg) {
                container.innerHTML = `
                    <div id="emptyCartMessage" class="text-center py-10 text-dark/70">
                        <p class="text-lg font-fredoka mb-3">🛒 Your cart is empty.</p>
                        <a href="{{ route('browsecatalog') }}"
                           class="inline-block bg-sakura hover:bg-sakura/90 text-white px-6 py-3 card-radius font-semibold shadow-soft transition-default">
                            Continue Browsing
                        </a>
                    </div>`;
            } else if (items.length > 0 && emptyMsg) {
                emptyMsg.remove();
            }
        };

        updateTotals();
    });
    </script>
</x-layout>