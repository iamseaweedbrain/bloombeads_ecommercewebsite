@extends('layouts.admin')

@section('content')
<style>
    .bracelet-preview-container {
        position: relative;
        width: 400px;
        height: 400px;
        margin: 2rem auto;
    }
    .bracelet-slot {
        position: absolute;
        left: 50%;
        top: 50%;
        width: 32px;
        height: 32px;
        margin: -16px;
        border-radius: 50%;
        background-color: #f0f0f0;
        border: 2px dashed #d1d5db;
        background-size: cover;
        background-position: center;
    }
    .bracelet-slot.filled {
        border: 2px solid var(--color-sakura);
    }
</style>

<section id="approval-details-view" class="font-poppins">

    <a href="{{ route('admin.approvals') }}" class="flex items-center text-sky hover:text-opacity-80 font-fredoka font-semibold mb-4">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        Back to Approvals
    </a>

    @if(session('success'))
        <div class="bg-success/20 text-success p-4 card-radius mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="md:col-span-2 space-y-8">
            
            <div class="bg-white p-6 card-radius shadow-soft">
                <h2 class="text-2xl font-fredoka font-bold">Submitted Design</h2>
                <div class="bracelet-preview-container">
                    <div id="preview-circle"></div>
                </div>
            </div>

            <div class="bg-white p-6 card-radius shadow-soft">
                <h2 class="text-2xl font-fredoka font-bold mb-4">Component List</h2>
                <div id="custom-items-list" class="space-y-2 font-poppins text-sm">
                </div>
            </div>
        </div>
        
        <div class="md:col-span-1 space-y-8">
            <div class="bg-white p-6 card-radius shadow-soft h-fit md:sticky md:top-24">
                <h2 class="text-xl font-fredoka font-bold mb-4">Customer Details</h2>
                <div class="space-y-2 text-dark/90 mb-6">
                    <p>
                        <strong>Name:</strong>
                        <span>{{ $design->customer_name }}</span>
                    </p>
                    <p>
                        <strong>Email:</strong>
                        <span>{{ $design->customer_email }}</span>
                    </p>
                    <p>
                        <strong>Submitted:</strong>
                        <span>{{ $design->created_at->format('M d, Y') }}</span>
                    </p>
                </div>
                
                <hr class="my-6 border-neutral/60">

                <h2 class="text-xl font-fredoka font-bold mb-4">Set Quote & Status</h2>
                <form action="{{ route('admin.approvals.update', $design) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="final_price" class="block font-semibold mb-1">Set Price (₱)</label>
                            <input type="number" step="0.01" min="0" name="final_price" id="final_price" 
                                   value="{{ old('final_price', $design->final_price) }}" 
                                   class="w-full p-2 card-radius border border-gray-300">
                            @error('final_price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="status" class="block font-semibold mb-1">Set Status</label>
                            
                            <select name="status" id="status" class="w-full p-2 card-radius border border-gray-300">
                                <option value="pending" @selected($design->status == 'pending')>Pending (Quote not sent)</option>
                                <option value="quoted" @selected($design->status == 'quoted')>Quoted (Price sent to customer)</option>
                                <option value="declined" @selected($design->status == 'declined')>Declined (Reject Design)</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-cta text-white font-fredoka font-bold py-3 card-radius shadow-soft hover:bg-opacity-90">
                            Save & Send Quote
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const TOTAL_SLOTS = 50;
    const designData = @json($design->design_data);
    const components = @json($components);
    
    const previewCircle = document.getElementById('preview-circle');
    const itemsListEl = document.getElementById('custom-items-list');

    function createAndFillSlots() {
        const radius = 170;
        const center = 200;
        const baseSize = 32;
        let componentCounts = {};
        
        let i = 0;
        while (i < TOTAL_SLOTS) {
            const componentId = designData[i];
            const component = (componentId && componentId !== 0) ? components[componentId] : null;

            const slot = document.createElement('div');
            slot.className = 'bracelet-slot';

            const angle = (i / TOTAL_SLOTS) * 2 * Math.PI;
            const x = center + radius * Math.cos(angle);
            const y = center + radius * Math.sin(angle);

            if (component) {
                const size = component.slot_size || 1;
                
                slot.style.backgroundImage = `url(${component.full_image_url})`;
                slot.classList.add('filled');
                slot.style.zIndex = '10';

                if (size > 1) {
                    const midAngle = ((i + (size - 1) / 2) / TOTAL_SLOTS) * 2 * Math.PI;
                    const midX = center + radius * Math.cos(midAngle);
                    const midY = center + radius * Math.sin(midAngle);
                    
                    const newSize = baseSize * (1 + (size - 1) * 0.3); 

                    slot.style.width = `${newSize}px`;
                    slot.style.height = `${newSize}px`;
                    slot.style.margin = `-${newSize / 2}px`;
                    slot.style.left = `${midX}px`;
                    slot.style.top = `${midY}px`;
                    slot.style.transform = 'rotate(0rad)';
                    slot.style.backgroundSize = 'contain';
                } else {
                    slot.style.width = `${baseSize}px`;
                    slot.style.height = `${baseSize}px`;
                    slot.style.margin = `-${baseSize / 2}px`;
                    slot.style.left = `${x}px`;
                    slot.style.top = `${y}px`;
                    slot.style.transform = `rotate(${angle + Math.PI/2}rad)`;
                    slot.style.backgroundSize = 'cover';
                }
                
                previewCircle.appendChild(slot);
                componentCounts[componentId] = (componentCounts[componentId] || 0) + 1;
                i += size;

            } else {
                slot.style.width = `${baseSize}px`;
                slot.style.height = `${baseSize}px`;
                slot.style.margin = `-${baseSize / 2}px`;
                slot.style.left = `${x}px`;
                slot.style.top = `${y}px`;
                slot.style.transform = `rotate(${angle + Math.PI/2}rad)`;
                
                previewCircle.appendChild(slot);
                i++;
            }
        }
        return componentCounts;
    }

    function buildSummary(counts) {
        itemsListEl.innerHTML = '';
        
        let i = 0;
        let finalCounts = {};
        while(i < TOTAL_SLOTS) {
            const componentId = designData[i];
            if (componentId && componentId !== 0) {
                const component = components[componentId];
                if (component) {
                    finalCounts[component.id] = (finalCounts[component.id] || 0) + 1;
                    i += component.slot_size;
                } else { i++; }
            } else { i++; }
        }

        if (Object.keys(finalCounts).length === 0) {
            itemsListEl.innerHTML = '<p class="text-dark/70 text-center">This design is empty.</p>';
            return;
        }

        for (const id in finalCounts) {
            const component = components[id];
            if (!component) continue;
            const count = finalCounts[id];
            const itemEl = document.createElement('p');
            itemEl.className = 'text-dark flex justify-between';
            itemEl.innerHTML = `
                <span><span class="font-semibold">${count}x</span> ${component.name}</span>
                <span class="text-dark/70">(${component.slot_size} slot${component.slot_size > 1 ? 's' : ''})</span>
            `;
            itemsListEl.appendChild(itemEl);
        }
    }

    const counts = createAndFillSlots();
    buildSummary(counts); 
});
</script>
@endsection