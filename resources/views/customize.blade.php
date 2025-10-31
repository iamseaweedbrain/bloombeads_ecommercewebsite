<x-layout>
    <div>
        <h2 class="text-4xl font-fredoka font-bold mb-8">Design your Beaded Bracelet<h2>
        Personalize your own bracelet using our very own customization tool.
    </div>
    <br> <br>
    <div class="flex flex-col md:flex-row gap-8">
        <div class="w-full md:w-3/4">
            <div class="bg-white card-radius shadow-soft p-6 h-96 md:h-[600px] flex flex-col">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-poppins font-semibold text-xl">Beaded Bracelet Preview</h3>
                    <div class="space-x-2">
                        <button class="text-dark hover:text-sakura p-2 rounded-full bg-neutral transition-default" title="Save Design">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="grow flex items-center justify-center bg-neutral/50 card-radius">
                    <span id="preview-text" class="text-2xl font-fredoka font-bold transition-colors duration-500" style="color: rgb(0,0,0);">Custom Bead Preview
                    </span>
                </div>
            </div>
            <button onclick="toggleCusotmizationModal()" class="md:hidden mt-4 w-full py-3 font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 transition-default shadow-soft">
                <span class="text-lg">Open Customization Selection</span>
            </button>
        </div>
        <aside class="md:w-1/4 hidden md:block">
            <div class="bg-white p-6 card-radius shadow-soft sticky top-20 h-[600px] overflow-y-auto custom-scrollbar">
                <h3 class="text-xl font-fredoka font-bold mb-4 border-b pb-2 border-neutral">Bead Selection</h3>

                <div class="grid grid-cols-4 gap-4">
    <!-- Example bead button -->
                    <button class="shadow-soft relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 hover:scale-105 hover:shadow-lg transition-transform duration-300">
                        <img src="bead1.png" alt="Bead 1" class="w-full h-full object-cover">
                    </button>

                    <button class="shadow-soft relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 hover:scale-105 hover:shadow-lg transition-transform duration-300">
                        <img src="bead2.png" alt="Bead 2" class="w-full h-full object-cover">
                    </button>

                    <button class="shadow-soft relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 hover:scale-105 hover:shadow-lg transition-transform duration-300">
                        <img src="bead3.png" alt="Bead 3" class="w-full h-full object-cover">
                    </button>

                    <button class="shadow-soft relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 hover:scale-105 hover:shadow-lg transition-transform duration-300">
                        <img src="bead4.png" alt="Bead 4" class="w-full h-full object-cover">
                    </button>

                    <button class="shadow-soft relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 hover:scale-105 hover:shadow-lg transition-transform duration-300">
                        <img src="bead5.png" alt="Bead 5" class="w-full h-full object-cover">
                    </button>

                    <button class="shadow-soft relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 hover:scale-105 hover:shadow-lg transition-transform duration-300">
                        <img src="bead6.png" alt="Bead 6" class="w-full h-full object-cover">
                    </button>

                    <button class="shadow-soft relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 hover:scale-105 hover:shadow-lg transition-transform duration-300">
                        <img src="bead7.png" alt="Bead 7" class="w-full h-full object-cover">
                    </button>

                    <button class="shadow-soft relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 hover:scale-105 hover:shadow-lg transition-transform duration-300">
                        <img src="bead3.png" alt="Bead 3" class="w-full h-full object-cover">
                    </button>

                    <button class="shadow-soft relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 hover:scale-105 hover:shadow-lg transition-transform duration-300">
                        <img src="bead3.png" alt="Bead 3" class="w-full h-full object-cover">
                    </button>

                    <!--Paste more Buttons here-->

                </div>
            </div>
            <div class="bg-white p-6 card-radius shadow-soft mt-8 sticky bottom-4">
                <p class="font-poppins text-lg text-dark/80 flex justify-between">
                    Base Price:
                    <span class="font-fredoka font-bold text-2xl text-sakura">₱49.00</span>
                </p>
                <button class="mt-4 w-full py-3 font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 transition-default shadow-soft transform hover:scale-[1.02]"> ADD TO CART </button>
            </div>
        </aside>
    </div>
</x-layout>

<ul>
    Todo:
    <li>> Learn CSS and Tailwind in order to complete customization page.
    <li>> Figure out how to implement the customization bracelet maker with JS (i think its js at least)
    <li>> Finalize the design for what to do in customization page.
    <li>> make it look good :D
</ul>
