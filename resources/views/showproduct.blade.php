<x-layout>
<div class="max-w-3xl mx-auto p-6">
    <img src="{{ asset('storage/' . $product->image_path) }}" class="w-full rounded-lg mb-4"/>

    <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>
    <p class="text-gray-600">{{ $product->category }}</p>

    <p class="text-lg font-semibold mt-3">₱{{ number_format($product->price, 2) }}</p>

    <p class="mt-4 text-sm text-gray-700">
        {{ $product->description }}
    </p>

    <p class="mt-2 text-sm text-gray-600">
        Stock: {{ $product->stock }}
    </p>

    <a href="{{ url()->previous() }}" class="mt-6 inline-block text-sky hover:underline">
        ← Back to catalog
    </a>
</div>
</x-layout>
