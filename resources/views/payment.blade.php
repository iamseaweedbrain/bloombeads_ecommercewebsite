<x-layout>
    @php
        $total = session('checkout_total', 0);
        $shipping = 10.00;
        $subtotal = $total > 0 ? $total - $shipping : 0; 
    @endphp

    <section class="px-6 py-12 bg-neutral min-h-screen">
        <main class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">

            {{-- Payment Method Selection --}}
            <div class="md:col-span-2 bg-white shadow-soft card-radius p-8 border border-neutral/50">
                <h1 class="text-3xl font-fredoka font-bold mb-8">Select Payment Method</h1>

                <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="total_amount" value="{{ $total }}">
                    
                    @if(session('error'))
                        <div class="bg-sakura/10 text-sakura p-4 card-radius font-poppins mb-6">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="bg-sakura/10 text-sakura p-4 card-radius font-poppins mb-6">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="space-y-4">
                        
                        {{-- Option 1: Cash on Delivery --}}
                        <div>
                            <input type="radio" name="payment_method" id="pay-cod" value="cod" class="hidden peer" checked>
                            <label for="pay-cod" class="flex items-center border border-neutral rounded-xl p-5 cursor-pointer peer-checked:border-sakura peer-checked:ring-2 peer-checked:ring-sakura/50 peer-checked:bg-sakura/5 transition-all duration-300">
                                <div class="text-sky font-bold text-xl w-14 text-center">COD</div>
                                <div class="ml-3">
                                    <h2 class="font-fredoka font-semibold text-dark">Cash on Delivery</h2>
                                    <p class="text-sm text-dark/70 font-poppins">Pay in cash when your order is delivered.</p>
                                </div>
                            </label>
                        </div>

                        {{-- Option 2: GCash --}}
                        <div>
                            <input type="radio" name="payment_method" id="pay-gcash" value="gcash" class="hidden peer">
                            <label for="pay-gcash" class="flex items-center border border-neutral rounded-xl p-5 cursor-pointer peer-checked:border-sky peer-checked:ring-2 peer-checked:ring-sky/50 peer-checked:bg-sky/5 transition-all duration-300">
                                <div class="text-sky font-bold text-2xl w-12 text-center">G</div>
                                <div class="ml-3">
                                    <h2 class="font-fredoka font-semibold text-dark">GCash (E-Wallet)</h2>
                                    <p class="text-sm text-dark/70 font-poppins">Pay easily using your mobile wallet.</p>
                                </div>
                            </label>
                        </div>

                        {{-- Option 3: Maya --}}
                        <div>
                            <input type="radio" name="payment_method" id="pay-maya" value="maya" class="hidden peer">
                            <label for="pay-maya" class="flex items-center border border-neutral rounded-xl p-5 cursor-pointer peer-checked:border-sakura peer-checked:ring-2 peer-checked:ring-sakura/50 peer-checked:bg-sakura/5 transition-all duration-300">
                                <div class="text-sakura font-bold text-2xl w-12 text-center">M</div>
                                <div class="ml-3">
                                    <h2 class="font-fredoka font-semibold text-dark">Maya (E-Wallet)</h2>
                                    <p class="text-sm text-dark/70 font-poppins">Instant payment via Maya account or card.</p>
                                </div>
                            </label>
                        </div>

                        <button type="button" id="placeOrderBtn"
                                class="mt-8 w-full bg-cta hover:bg-opacity-90 text-white py-3 card-radius font-fredoka font-bold shadow-soft transform hover:scale-[1.02] transition-all duration-300">
                            PLACE ORDER
                        </button>
                    </div>

                    <div id="payment-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 hidden">
                        <div id="modal-backdrop" class="absolute inset-0"></div>
                        <div class="bg-white p-6 md:p-8 card-radius shadow-soft w-full max-w-md relative">
                            <button id="close-modal-btn" type="button" class="absolute top-4 right-4 text-dark/50 hover:text-sakura transition-default">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>

                            {{-- GCash QR Code Content --}}
                            <div id="gcash-qr-content" class="hidden text-center">
                                <h3 class="font-fredoka font-bold text-lg text-sky mb-2">Pay with GCash</h3>
                                <p class="font-poppins text-sm text-dark/80 mb-4">Scan the QR code to pay <strong class="text-dark">₱{{ number_format($total, 2) }}</strong>.</p>
                                <img src="{{ asset('images/gcash_qr.png') }}" alt="GCash QR Code" class="w-full max-w-xs h-auto border rounded-md mx-auto">
                                
                                <div class="mt-4">
                                    <label for="payment_receipt_gcash" class="block font-poppins text-sm font-semibold text-dark mb-1">Upload Receipt:</label>
                                    <input type="file" name="payment_receipt" id="payment_receipt_gcash" class="w-full text-sm text-dark file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-sky/20 file:text-sky hover:file:bg-sky/30">
                                </div>
                            </div>

                            {{-- Maya QR Code Content --}}
                            <div id="maya-qr-content" class="hidden text-center">
                                <h3 class="font-fredoka font-bold text-lg text-sakura mb-2">Pay with Maya</h3>
                                <p class="font-poppins text-sm text-dark/80 mb-4">Scan the QR code to pay <strong class="text-dark">₱{{ number_format($total, 2) }}</strong>.</p>
                                <img src="{{ asset('images/maya qr.png') }}" alt="Maya QR Code" class="w-full max-w-xs h-auto border rounded-md mx-auto">
                                
                                <div class="mt-4">
                                    <label for="payment_receipt_maya" class="block font-poppins text-sm font-semibold text-dark mb-1">Upload Receipt:</label>
                                    <input type="file" name="payment_receipt" id="payment_receipt_maya" class="w-full text-sm text-dark file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-sakura/20 file:text-sakura hover:file:bg-sakura/30">
                                </div>
                            </div>

                            <button type="button" id="i-have-paid-btn" class="mt-6 w-full bg-cta hover:bg-opacity-90 text-white py-3 card-radius font-fredoka font-bold shadow-soft">
                                I HAVE PAID, PLACE ORDER
                            </button>
                        </div>
                    </div>
                    </form> </div>

            {{-- Order Summary --}}
            <div class="bg-white shadow-soft card-radius p-8 border border-neutral/50 h-fit md:sticky md:top-24">
                <h2 class="text-xl font-fredoka font-bold text-sky mb-6">Order Summary</h2>
                <div class="font-poppins text-dark/80">
                    <div class="flex justify-between mb-2">
                        <span>Subtotal:</span>
                        <span class="font-semibold">₱{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Shipping:</span>
                        <span class="font-semibold">₱{{ number_format($shipping, 2) }}</span>
                    </div>
                    <hr class="border-neutral/70 my-4">
                    <div class="flex justify-between font-bold text-lg text-dark">
                        <span>Total Due:</span>
                        <span class="text-sakura">₱{{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>

        </main>
    </section>

    {{-- This loads the payment JavaScript --}}
    <script src="{{ asset('js/payment.js') }}"></script>
</x-layout>