@extends('layouts.admin')

@section('content')
<section id="component-management" class="font-poppins">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-fredoka font-bold">Component Management</h2>
        {{-- This uses the correct component modal function --}}
        <button onclick="openComponentModal('add')" class="py-2 px-4 font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 transition-default shadow-soft">
            Add New Component
        </button>
    </div>

    @if(session('success'))
        <div class="bg-success/20 text-success p-4 card-radius mb-6 font-poppins">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="bg-white card-radius shadow-soft overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-neutral">
                        <th class="p-4 text-left font-semibold">Image</th>
                        <th class="p-4 text-left font-semibold">Name</th>
                        <th class="p-4 text-left font-semibold">Category</th>
                        <th class="p-4 text-left font-semibold">Stock</th>
                        <th class="p-4 text-left font-semibold">Slots</th>
                        <th class="p-4 text-left font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- THIS IS THE CORRECT VARIABLE: $components --}}
                    @forelse ($components as $component)
                        <tr class="border-b border-neutral/50 hover:bg-neutral/50">
                            <td class="p-4">
                                <img src="{{ asset('storage/' . $component->image_path) }}" alt="{{ $component->name }}" class="w-12 h-12 object-cover rounded-md">
                            </td>
                            <td class="p-4 font-semibold text-dark">{{ $component->name }}</td>
                            <td class="p-4 text-dark/80">{{ $component->componentCategory->name }}</td>
                            <td class="p-4 text-dark/80">{{ $component->stock }}</td>
                            <td class="p-4 text-dark/80">{{ $component->slot_size }}</td>
                            <td class="p-4 space-x-2">
                                {{-- This uses the correct component modal function --}}
                                <button onclick="openComponentModal('edit', {{ $component->id }})" class="py-1 px-3 text-xs font-poppins card-radius text-white bg-sky hover:bg-opacity-80">Edit</button>
                                <form action="{{ route('admin.components.destroy', $component) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete {{ $component->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="py-1 px-3 text-xs font-poppins card-radius text-white bg-red-500 hover:bg-red-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-dark/70">No custom components found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4">
            {{ $components->links() }}
        </div>
    </div>
</section>


{{-- This is the component modal (NOT the product modal) --}}
<div id="componentModal" class="modal-overlay">
    <div class="modal-content">
        <div class="flex justify-between items-center mb-4">
            <h3 id="component-modalTitle" class="text-2xl font-fredoka font-bold text-sakura">Add New Component</h3>
            <button onclick="closeComponentModal()" class="text-dark hover:text-sakura text-3xl font-bold">&times;</button>
        </div>
        <form id="componentForm" action="{{ route('admin.components.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="hidden" name="_method" id="component-formMethod" value="POST">

            <div>
                <label for="componentName" class="form-label">Component Name</label>
                <input type="text" id="componentName" name="name" class="form-input" placeholder="e.g., Star Charm" required>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="componentCategory" class="form-label">Category</label>
                    <select id="componentCategory" name="component_category_id" class="form-select" required>
                        <option value="" disabled selected>Select category...</option>
                        {{-- THIS IS THE CORRECT VARIABLE: $categories --}}
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="slotSize" class="form-label">Slots Taken</label>
                    <input type="number" id="slotSize" name="slot_size" class="form-input" placeholder="e.g., 3" min="1" required>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="componentStock" class="form-label">Stock Quantity</label>
                    <input type="number" id="componentStock" name="stock" class="form-input" placeholder="e.g., 100" min="0" required>
                </div>
                <div>
                    <label for="componentImage" class="form-label" id="imageLabel">Component Image</label>
                    <input type="file" id="componentImage" name="image" class="form-input" accept="image/jpeg, image/png">
                    <span id="component-currentImage" class="text-xs text-gray-500 mt-1 block"></span>
                </div>
            </div>
            <div class="flex justify-end space-x-3 pt-4 border-t border-neutral">
                <button type="button" onclick="closeComponentModal()" class="py-2 px-5 font-poppins font-semibold card-radius text-dark bg-neutral hover:bg-gray-200 transition-default">Cancel</button>
                <button type="submit" id="component-saveButton" class="py-2 px-5 font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 transition-default shadow-soft">Save Component</button>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
    // Component Management Logic (Modal and Fetching)
    const componentModal = document.getElementById('componentModal');
    const componentForm = document.getElementById('componentForm');
    const componentModalTitle = document.getElementById('component-modalTitle');
    const componentFormMethod = document.getElementById('component-formMethod');
    const componentSaveButton = document.getElementById('component-saveButton');
    const componentCurrentImageSpan = document.getElementById('component-currentImage');
    const componentImageInput = document.getElementById('componentImage');
    
    const baseEditUrl = '{{ url("admin/components") }}';
    const baseStoreUrl = '{{ route("admin.components.store") }}';
    
    function openComponentModal(mode, componentId = null) {
        if (!componentModal) return; 
        
        componentForm.reset();
        componentCurrentImageSpan.textContent = '';
        componentForm.action = baseStoreUrl;
        componentFormMethod.value = 'POST';

        if (mode === 'add') {
            componentModalTitle.textContent = 'Add New Component';
            componentSaveButton.textContent = 'Add Component';
            componentImageInput.required = true;
        } else if (mode === 'edit' && componentId) {
            componentModalTitle.textContent = 'Edit Component';
            componentSaveButton.textContent = 'Update Component';
            componentImageInput.required = false;

            fetch(`${baseEditUrl}/${componentId}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('componentName').value = data.name;
                    document.getElementById('componentCategory').value = data.component_category_id;
                    document.getElementById('componentStock').value = data.stock;
                    document.getElementById('slotSize').value = data.slot_size;
                    componentCurrentImageSpan.textContent = data.image_path ? `Current: ${data.image_path.split('/').pop()}` : 'No image uploaded.';
                    
                    componentForm.action = `${baseEditUrl}/${componentId}`;
                    componentFormMethod.value = 'PUT'; 
                })
                .catch(error => {
                    alert('Failed to load component data. See console for details.');
                    console.error('Fetch Error:', error);
                    closeComponentModal();
                });
        }
        componentModal.classList.add('open');
        document.body.classList.add('overflow-hidden');
    }
    window.openComponentModal = openComponentModal; 

    function closeComponentModal() {
        if (!componentModal) return;
        componentModal.classList.remove('open');
        document.body.classList.remove('overflow-hidden');
    }
    window.closeComponentModal = closeComponentModal;
    
    if (componentModal) {
        componentModal.addEventListener('click', (e) => {
            if (e.target === componentModal) {
                closeComponentModal();
            }
        });
    }

    @if($errors->any() && session()->has('error_component_id'))
        document.addEventListener('DOMContentLoaded', () => {
            const componentId = {{ session('error_component_id') }};
            openComponentModal('edit', componentId);
            alert('Validation failed. Please correct the errors in the form.');
        });
    @endif
</script>
@endpush
@endsection