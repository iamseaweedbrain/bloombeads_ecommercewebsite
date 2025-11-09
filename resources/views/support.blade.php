<x-layout>
    <section id="support" class="py-20 bg-neutral min-h-screen">
        <div class="max-w-6xl mx-auto px-6 md:px-10">
            <h1 class="text-4xl md:text-5xl font-fredoka font-bold text-center mb-4">
                Help & Support Center
            </h1>
            <p class="text-center text-dark/70 font-poppins mb-12">
                We're here to help you with your orders and inquiries.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-stretch">
                <div class="bg-white rounded-[2rem] shadow-soft p-10 border border-gray-100 flex flex-col justify-between">
                    <div>
                        <h2 class="text-2xl font-fredoka font-bold mb-6 border-b-4 border-sky pb-2">
                            Frequently Asked Questions (FAQ)
                        </h2>
                        <div class="space-y-6 font-poppins text-dark/90">
                            <div>
                                <p class="font-semibold">Q: How long does customization take?</p>
                                <p>A: Custom designs typically ship within 3–5 business days after payment confirmation.</p>
                            </div>
                            <div class="border-t border-gray-200 pt-4">
                               <p class="font-semibold">Q: Can I change my order after checkout?</p>
                                <p>A: Due to the custom nature of our products, changes must be requested within 2 hours of placing the order.</p>
                            </div>
                            <div class="border-t border-gray-200 pt-4">
                                <p class="font-semibold">Q: What materials are used?</p>
                                <p>A: We use durable resin, glass beads, and hypoallergenic stainless steel findings.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[2rem] shadow-soft p-10 border border-gray-100 flex flex-col justify-between">
                    <div>
                        <h2 class="text-2xl font-fredoka font-bold mb-6 border-b-4 border-sky pb-2">
                            Contact Our Support Team
                        </h2>

                        <form class="space-y-4" action="{{ route('contact.store') }}" method="POST">
                            @csrf

                            <div>
                                <input type="text" name="name" placeholder="Your Full Name" value="{{ old('name') }}"
                                       class="w-full border border-gray-300 rounded-xl px-4 py-3 font-poppins focus:ring-2 focus:ring-black outline-none">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1 font-poppins">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <input type="email" name="email" placeholder="Your Email Address" value="{{ old('email') }}"
                                       class="w-full border border-gray-300 rounded-xl px-4 py-3 font-poppins focus:ring-2 focus:ring-black outline-none">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1 font-poppins">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <input type="text" name="subject" placeholder="Subject of Inquiry" value="{{ old('subject') }}"
                                       class="w-full border border-gray-300 rounded-xl px-4 py-3 font-poppins focus:ring-2 focus:ring-black outline-none">
                                @error('subject')
                                    <p class="text-red-500 text-sm mt-1 font-poppins">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <textarea name="message" rows="4" placeholder="Please describe your issue..."
                                          class="w-full border border-gray-300 rounded-xl px-4 py-3 font-poppins focus:ring-2 focus:ring-black outline-none resize-none">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="text-red-500 text-sm mt-1 font-poppins">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                    class="w-full py-3 bg-sakura text-white font-fredoka font-bold rounded-xl hover:bg-sakura/90 transition">
                                SEND MESSAGE
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>