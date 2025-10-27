@extends('layouts.admin')

@section('content')
<section id="approvals-view">
    <h2 class="text-3xl font-fredoka font-bold mb-6">Pending Approvals</h2>

    <div class="bg-white card-radius shadow-soft p-6">
        <h3 class="text-xl font-fredoka font-bold mb-4 border-b pb-2 border-neutral">Custom Beaded Bracelets</h3>
        <div class="space-y-4">
            <div class="flex flex-col md:flex-row justify-between md:items-center p-4 bg-neutral card-radius border border-gray-200 gap-4">
                <div>
                    <h4 class="font-poppins font-semibold">Custom Design: 'Sakura Dream'</h4>
                    <p class="text-sm font-poppins text-dark/80">Submitted by: <span class="font-semibold">jane.doe@example.com</span></p>
                    <p class="text-sm font-poppins text-dark/80">Details: 12 Beads, 3 Charms (Heart, Star, Moon)</p>
                    <p class="text-sm font-poppins font-bold text-sakura">Calculated Price: ₱85.00</p>
                </div>
                <div class="space-x-2 shrink-0">
                    <button class="py-2 px-4 text-sm font-poppins font-semibold card-radius text-white bg-sky hover:bg-opacity-80">View Design</button>
                    <button class="py-2 px-4 text-sm font-poppins font-semibold card-radius text-white bg-success hover:bg-opacity-80">Approve</button>
                    <button class="py-2 px-4 text-sm font-poppins font-semibold card-radius text-white bg-sakura hover:bg-opacity-80">Deny</button>
                </div>
            </div>
            <div class="flex flex-col md:flex-row justify-between md:items-center p-4 bg-neutral card-radius border border-gray-200 gap-4">
                <div>
                    <h4 class="font-poppins font-semibold">Custom Design: 'Oceanic Blue'</h4>
                    <p class="text-sm font-poppins text-dark/80">Submitted by: <span class="font-semibold">john.smith@example.com</span></p>
                    <p class="text-sm font-poppins text-dark/80">Details: 20 Beads (All Blue), 1 Charm (Sun)</p>
                    <p class="text-sm font-poppins font-bold text-sakura">Calculated Price: ₱69.00</p>
                </div>
                <div class="space-x-2 shrink-0">
                    <button class="py-2 px-4 text-sm font-poppins font-semibold card-radius text-white bg-sky hover:bg-opacity-80">View Design</button>
                    <button class="py-2 px-4 text-sm font-poppins font-semibold card-radius text-white bg-success hover:bg-opacity-80">Approve</button>
                    <button class="py-2 px-4 text-sm font-poppins font-semibold card-radius text-white bg-sakura hover:bg-opacity-80">Deny</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection