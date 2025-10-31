<x-layout>
<section class="px-6 py-8 bg-gray-50 min-h-screen">
    <main class="max-w-6xl mx-auto mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
        
        {{-- 🧾 Left: Payment Options --}}
        <div class="md:col-span-2 bg-white shadow-md rounded-2xl p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Select Payment Method</h1>

            {{-- Payment Confirmed Notice --}}
            <p class="text-center mb-4">
                <span class="text-cyan-500 font-semibold">Payment Confirmed!</span>
                <span class="text-gray-700">Thank you for your order.</span>
            </p>

            {{-- 💙 GCash --}}
            <div class="flex items-center border-2 border-pink-400 rounded-xl p-4 mb-4">
                <div class="text-cyan-500 font-bold text-2xl w-10 text-center">G</div>
                <div class="ml-3">
                    <h2 class="font-semibold text-gray-800">GCash (E-Wallet)</h2>
                    <p class="text-sm text-gray-600">Pay easily using your mobile wallet.</p>
                </div>
            </div>

            {{-- 💗 Maya --}}
            <div class="flex items-center border border-gray-200 rounded-xl p-4 mb-4 hover:border-pink-400 transition">
                <div class="text-pink-500 font-bold text-2xl w-10 text-center">M</div>
                <div class="ml-3">
                    <h2 class="font-semibold text-gray-800">Maya (E-Wallet)</h2>
                    <p class="text-sm text-gray-600">Instant payment via Maya account or card.</p>
                </div>
            </div>

            {{-- 🟧 COD --}}
            <div class="flex items-center border border-gray-200 rounded-xl p-4 hover:border-pink-400 transition">
                <div class="text-yellow-500 font-bold text-xl w-12 text-center">COD</div>
                <div class="ml-3">
                    <h2 class="font-semibold text-gray-800">Cash on Delivery</h2>
                    <p class="text-sm text-gray-600">Pay in cash when your order is delivered.</p>
                </div>
            </div>

            {{-- 💳 Place Order Button --}}
            <button id="placeOrderBtn"
                class="mt-6 w-full bg-pink-400 hover:bg-pink-500 text-white py-3 rounded-lg font-semibold transition">
                PLACE ORDER & PAY ₱45.00
            </button>
        </div>

        {{-- 🧾 Right: Order Summary --}}
        <div class="bg-white shadow-md rounded-2xl p-6">
            <h2 class="text-lg font-bold text-cyan-500 mb-4">Order Summary</h2>
            <div class="flex justify-between text-gray-700 mb-2">
                <span>Subtotal (2 items):</span>
                <span>₱35.00</span>
            </div>
            <div class="flex justify-between text-gray-700 mb-2">
                <span>Shipping:</span>
                <span>₱10.00</span>
            </div>
            <div class="flex justify-between font-bold text-lg text-gray-900 mt-4 border-t pt-2">
                <span>Total Due:</span>
                <span class="text-pink-500">₱45.00</span>
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