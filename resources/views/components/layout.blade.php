<x-format>
    <x-header />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    <footer class="bg-[#CFE7FF] mt-20">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center px-10 py-10 md:px-0">
            
            <div class="text-center md:text-left md:mb-0">
                <h1 class="text-5xl font-fredoka font-bold text-[#F77AA6]">BloombeadsbyJinx</h1>
            </div>

            <div class="text-center md:text-right">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Visit us on</h2>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-center justify-center md:justify-end space-x-3">
                        <a href="https://facebooklink.com" class="text-gray-800 hover:underline">https://facebooklink.com//</a>
                        <span class="bg-[#F77AA6] text-white rounded-full p-2 flex items-center justify-center">
                            <i class="fa-brands fa-facebook" class="w-4 h-4"></i>
                        </span>
                    </li>
                    <li class="flex items-center justify-center md:justify-end space-x-3">
                        <a href="https://instagramlink.com" class="text-gray-800 hover:underline">https://instagramlink.com//</a>
                        <span class="bg-[#F77AA6] text-white rounded-full p-2 flex items-center justify-center">
                            <i class="fa-brands fa-instagram" class="w-4 h-4"></i>
                        </span>
                    </li>
                    <li class="flex items-center justify-center md:justify-end space-x-3">
                        <a href="https://tiktoklink.com" class="text-gray-800 hover:underline">https://tiktoklink.com//</a>
                        <span class="bg-[#F77AA6] text-white rounded-full p-2 flex items-center justify-center">
                            <i class="fa-brands fa-tiktok" class="w-4 h-4"></i>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

        <div class="text-center py-3 border-t border-gray-200 text-sm text-gray-600">
            ©2025 Bloombeads. All Rights Reserved.
        </div>

</x-format>
