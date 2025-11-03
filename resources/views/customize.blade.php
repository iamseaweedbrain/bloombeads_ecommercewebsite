<x-layout>
<h2 class="text-3xl font-fredoka font-bold mb-8 md:mb-12">Design Your Beaded Bracelet</h2>
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
            <div id="bracelet-preview" class="grow flex flex-wrap justify-center items-center gap-2 bg-neutral/50 card-radius p-4">
                <span id="placeholder-text" class="text-2xl font-fredoka font-bold text-neutral-600">
                    Custom Bead Preview
                </span>
            </div>
            <button id="reset-preview" class="mt-4 px-4 py-2 bg-sakura text-white font-fredoka rounded-lg hover:bg-sakura/80 transition-colors duration-300">Reset Bracelet
            </button>

        </div>
        <button onclick="toggleCustomizationModal()" class="md:hidden mt-4 w-full py-3 font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 transition-default shadow-soft">
        <span class="text-lg">Open Customization Options</span>
        </button>
    </div>
    <aside class="md:w-1/4 hidden md:block">
        <div class="bg-white p-6 card-radius shadow-soft top-20 h-[600px] overflow-y-auto custom-scrollbar">
            <h3 class="text-xl font-fredoka font-bold mb-4 border-b pb-2 border-neutral">Bead Selection</h3>


            <div class="grid grid-cols-4 gap-4">
                <!--Place More Buttons Under Here-->
                <button class="bead-btn relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 shadow-soft hover:scale-105 hover:shadow-lg transition-transform duration-300" data-bead="bead1.jpg">
                    <img src="/custom-beads/bead1.jpg" alt="Bead 1" class="w-full h-full object-cover">
                </button>

                <button class="bead-btn relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 shadow-soft hover:scale-105 hover:shadow-lg transition-transform duration-300" data-bead="bead2.jpg">
                    <img src="/custom-beads/bead2.jpg" alt="Bead 2" class="w-full h-full object-cover">
                </button>

                <button class="bead-btn relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 shadow-soft hover:scale-105 hover:shadow-lg transition-transform duration-300" data-bead="bead3.jpg">
                    <img src="/custom-beads/bead3.jpg" alt="Bead 3" class="w-full h-full object-cover">
                </button>

                <button class="bead-btn relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 shadow-soft hover:scale-105 hover:shadow-lg transition-transform duration-300" data-bead="bead4.jpg">
                    <img src="/custom-beads/bead4.jpg" alt="Bead 4" class="w-full h-full object-cover">
                </button>

                <button class="bead-btn relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 shadow-soft hover:scale-105 hover:shadow-lg transition-transform duration-300" data-bead="bead5.jpg">
                    <img src="/custom-beads/bead5.jpg" alt="Bead 5" class="w-full h-full object-cover">
                </button>

                <button class="bead-btn relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 shadow-soft hover:scale-105 hover:shadow-lg transition-transform duration-300" data-bead="bead6.jpg">
                    <img src="/custom-beads/bead6.jpg" alt="Bead 6" class="w-full h-full object-cover">
                </button>

                <button class="bead-btn relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 shadow-soft hover:scale-105 hover:shadow-lg transition-transform duration-300" data-bead="bead7.jpg">
                    <img src="/custom-beads/bead7.jpg" alt="Bead 7" class="w-full h-full object-cover">
                </button>

                <button class="bead-btn relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 shadow-soft hover:scale-105 hover:shadow-lg transition-transform duration-300" data-bead="bead8.jpg">
                    <img src="/custom-beads/bead8.jpg" alt="Bead 8" class="w-full h-full object-cover">
                </button>

                <button class="bead-btn relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 shadow-soft hover:scale-105 hover:shadow-lg transition-transform duration-300" data-bead="bead9.jpg">
                    <img src="/custom-beads/bead9.jpg" alt="Bead 9" class="w-full h-full object-cover">
                </button>

                <button class="bead-btn relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 shadow-soft hover:scale-105 hover:shadow-lg transition-transform duration-300" data-bead="bead10.jpg">
                    <img src="/custom-beads/bead10.jpg" alt="Bead 10" class="w-full h-full object-cover">
                </button>

                <button class="bead-btn relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 shadow-soft hover:scale-105 hover:shadow-lg transition-transform duration-300" data-bead="bead11.jpg">
                    <img src="/custom-beads/bead11.jpg" alt="Bead 11" class="w-full h-full object-cover">
                </button>

                <button class="bead-btn relative w-full aspect-square rounded-xl overflow-hidden bg-neutral/10 shadow-soft hover:scale-105 hover:shadow-lg transition-transform duration-300" data-bead="bead12.jpg">
                    <img src="/custom-beads/bead12.jpg" alt="Bead 12" class="w-full h-full object-cover">
                </button>



                <!-- Place More Buttons Above Here -->
            </div>

        </div>
        <div class="bg-white p-6 card-radius shadow-soft mt-8 bottom-4">
            <p class="font-poppins text-lg text-dark/80 flex justify-between">Base Price: <span class="font-fredoka font-bold text-2xl text-sakura">₱49.00</span>
            </p>

            <button class="mt-4 w-full py-3 font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 transition-default shadow-soft transform hover:scale-[1.02]"> ADD TO CART
            </button>

</x-layout>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const beadButtons = document.querySelectorAll('.bead-btn');
    const braceletPreview = document.getElementById('bracelet-preview');
    const placeholderText = document.getElementById('placeholder-text');

    beadButtons.forEach(button => {
        button.addEventListener('click', () => {
            const beadSrc = button.getAttribute('data-bead');

            if (placeholderText) placeholderText.style.display = 'none';

            const bead = document.createElement('img');
            bead.src = `/custom-beads/${beadSrc}`;
            bead.alt = beadSrc;
            bead.className = 'w-10 h-10 rounded-full shadow-soft hover:scale-110 transition-transform duration-300';

            braceletPreview.appendChild(bead);
        });
    });
});

document.getElementById('reset-preview').addEventListener('click', () => {
    const braceletPreview = document.getElementById('bracelet-preview');
    const placeholderText = document.getElementById('placeholder-text');

    braceletPreview.innerHTML = '';
    placeholderText.style.display = 'block';
});
</script>
