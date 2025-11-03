@extends('layouts.admin')

@section('content')
<section id="catalog-view">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-fredoka font-bold">Catalog Management</h2>
        <button onclick="openModal('productModal')" class="py-2 px-5 font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 transition-default shadow-soft">
            Add New Product
        </button>
    </div>
    
    @if(session('success'))
        <div class="bg-success/10 border border-success text-success p-3 rounded-lg text-center font-poppins font-semibold mb-4">
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-white card-radius shadow-soft overflow-hidden">

    <div class="bg-white card-radius shadow-soft overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td><img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://placehold.co/40x40/FF6B81/FFFFFF?text=B' }}" alt="{{ $product->name }}" class="w-10 h-10 card-radius object-cover"></td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category }}</td>
                        <td>₱{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock }}</td>
                        <td class="space-x-2">
                            <button onclick='openEditModal(@json($product))' class="py-1 px-3 text-xs font-poppins font-semibold card-radius text-white bg-sky hover:bg-opacity-80">
                                Edit
                            </button>

                            <form action="{{ route('admin.catalog.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="py-1 px-3 text-xs font-poppins font-semibold card-radius text-white bg-sakura hover:bg-opacity-80">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">No products found. Add one to get started!</td>
                    </tr>
                    @endforelse
                    </tbody>
            </table>
        </div>
    </div>
</section>
@endsection