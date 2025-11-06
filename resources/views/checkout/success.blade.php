<x-layout>
    <section class="px-6 py-12 bg-neutral min-h-screen">
        <main class="max-w-xl mx-auto mt-8">

            <div class="bg-white shadow-soft card-radius p-8 text-center border border-neutral/50">
                
                <h1 class="text-3xl font-fredoka font-bold text-sakura mb-4">
                    Thank You!
                </h1>
                
                <p class="font-poppins text-dark/80 mb-6">
                    Your order has been placed successfully.
                </p>

                <div class="bg-neutral/50 p-4 card-radius border border-neutral">
                    <p class="font-poppins text-sm text-dark/70">
                        Your Order Tracking ID is:
                    </p>
                    <p class="font-fredoka font-bold text-2xl text-sky mt-1">
                        {{ $tracking_id }}
                    </p>
                </div>

                <p class="font-poppins text-sm text-dark/70 mt-6">
                    You can track your order status from your dashboard.
                </p>

                <a href="{{ route('browsecatalog') }}" 
                   class="mt-8 inline-block w-full bg-cta hover:bg-opacity-90 text-white py-3 card-radius font-fredoka font-bold shadow-soft transition-all duration-300">
                    Continue Shopping
                </a>
            </div>

        </main>
    </section>
</x-layout>