<x-layout>

    @php
        $total = session('checkout_total', 0);
        $shipping = 10.00;
        $subtotal = $total - $shipping;
    @endphp

    <section class="px-6 py-12 bg-neutral min-h-screen">
        <main class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">

            <div class="md:col-span-2 bg-white shadow-soft card-radius p-8 border border-neutral/50">
                <h1 class="text-3xl font-fredoka font-bold mb-8">Select Payment Method</h1>

                <p class="text-center mb-6 font-poppins">
                    <span class="text-sky font-semibold">Payment Confirmed!</span>
                    <span class="text-dark/70">Thank you for your order.</span>
                </p>

                <div class="flex items-center border-2 border-sakura rounded-xl p-5 mb-4 bg-sakura/5 hover:bg-sakura/10 transition-all duration-300 cursor-pointer">
                    <div class="text-sky font-bold text-2xl w-12 text-center">G</div>
                    <div class="ml-3">
                        <h2 class="font-fredoka font-semibold text-dark">GCash (E-Wallet)</h2>
                        <p class="text-sm text-dark/70 font-poppins">Pay easily using your mobile wallet.</p>
                    </div>
                </div>

                <div class="flex items-center border border-neutral rounded-xl p-5 mb-4 hover:border-sakura hover:bg-sakura/10 transition-all duration-300 cursor-pointer">
                    <div class="text-sakura font-bold text-2xl w-12 text-center">M</div>
                    <div class="ml-3">
                        <h2 class="font-fredoka font-semibold text-dark">Maya (E-Wallet)</h2>
                        <p class="text-sm text-dark/70 font-poppins">Instant payment via Maya account or card.</p>
                    </div>
                </div>

                <div class="flex items-center border border-neutral rounded-xl p-5 hover:border-sakura hover:bg-sakura/10 transition-all duration-300 cursor-pointer">
                    <div class="text-sky font-bold text-xl w-14 text-center">COD</div>
                    <div class="ml-3">
                        <h2 class="font-fredoka font-semibold text-dark">Cash on Delivery</h2>
                        <p class="text-sm text-dark/70 font-poppins">Pay in cash when your order is delivered.</p>
                    </div>
                </div>

                <button id="placeOrderBtn"
                    class="mt-8 w-full bg-cta hover:bg-opacity-90 text-white py-3 card-radius font-fredoka font-bold shadow-soft transform hover:scale-[1.02] transition-all duration-300">
                    PLACE ORDER & PAY ₱{{ number_format($total, 2) }}
                </button>
            </div>

            <div class="bg-white shadow-soft card-radius p-8 border border-neutral/50 h-fit md:sticky md:top-24">
                <h2 class="text-xl font-fredoka font-bold text-sky mb-6">Order Summary</h2>

                <div class="space-y-3 font-poppins text-dark/80">
                    <p class="flex justify-between">
                        <span>Subtotal:</span>
                        <span>₱{{ number_format($subtotal, 2) }}</span>
                    </p>
                    <p class="flex justify-between">
                        <span>Shipping:</span>
                        <span>₱{{ number_format($shipping, 2) }}</span>
                    </p>
                    <p class="flex justify-between font-bold text-lg border-t border-neutral pt-3 text-dark">
                        <span>Total Due:</span>
                        <span class="text-sakura">₱{{ number_format($total, 2) }}</span>
                    </p>
                </div>
            </div>
        </main>
    </section>

    <script>
    document.getElementById('placeOrderBtn').addEventListener('click', () => {
        // Redirect to homepage after placing order
        window.location.href = "{{ url('/') }}";
    });
    </script>
</x-layout>
