<x-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            width: 48px;
            height: 48px;
            margin: -24px;
            border-radius: 50%;
            background-color: #f0f0f0;
            border: 2px dashed #d1d5db;
            cursor: pointer;
            transition: all 0.2s ease;
            background-size: cover;
            background-position: center;
        }
        .bracelet-slot.filled {
            border: 2px solid var(--color-sakura);
            box-shadow: 0 0 5px var(--color-sakura);
            background-repeat: no-repeat;
        }
        .bracelet-slot.hover-target {
            background-color: #fef2f2;
            border: 2px dashed var(--color-sakura);
            transform: scale(1.2);
        }
        .component-btn.selected {
            border-color: var(--color-sky);
            ring: 2;
            ring-color: var(--color-sky);
            box-shadow: 0 0 10px var(--color-sky);
        }
    </style>

    <main class="max-w-7xl mx-auto px-4 py-16">
        <h1 class="text-4xl font-fredoka font-bold text-center">Design Your Beaded Bracelet</h1>
        <p class="text-center text-dark/70 font-poppins mt-2 mb-8">Click a bead or charm, then click an empty slot on the preview.</p>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 bg-white p-6 card-radius shadow-soft">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-fredoka font-bold">Beaded Bracelet Preview</h2>
                    <span class="font-poppins text-dark/80">
                        Slots remaining: <strong id="slots-remaining" class="font-fredoka text-xl text-sakura">50</strong>
                    </span>
                </div>
                
                <div class="bracelet-preview-container">
                    <div id="preview-circle"></div>
                </div>

                <button id="reset-bracelet-btn" class="w-full mt-6 py-3 font-fredoka font-bold card-radius text-white bg-sakura hover:bg-opacity-90 transition-default shadow-soft">
                    Reset Bracelet
                </button>
            </div>

            <aside class="lg:col-span-1 space-y-8">
                
                <div class="bg-white p-6 card-radius shadow-soft sticky top-24">
                    <h2 class="text-2xl font-fredoka font-bold mb-4">Components</h2>
                            
                    <div id="component-library" class="space-y-6 max-h-96 overflow-y-auto pr-2">
                        @forelse ($categories as $category)
                            <div>
                                <h3 class="font-fredoka font-semibold text-lg mb-3">{{ $category->name }}</h3>
                                
                                <div class="grid grid-cols-4 gap-2"> 
                                    @forelse ($category->components as $component)
                                        @php
                                            $imageUrl = $component->image_path ? asset('storage/' . $component->image_path) : 'https://placehold.co/64x64/f0f0f0/333?text=B';
                                        @endphp
                                        <button class="component-btn border border-neutral rounded-lg p-1 text-center hover:border-sky"
                                                data-id="{{ $component->id }}"
                                                data-name="{{ $component->name }}"
                                                data-image="{{ $imageUrl }}"
                                                data-slots="{{ $component->slot_size }}"
                                                title="{{ $component->name }} (Takes {{ $component->slot_size }} slot{{ $component->slot_size > 1 ? 's' : '' }})">
                                            
                                            <img src="{{ $imageUrl }}" 
                                                 alt="{{ $component->name }}" class="w-12 h-12 mx-auto object-cover rounded-md"> 
                                            
                                            <p class="text-xs font-poppins mt-1 truncate">{{ $component->name }}</p>
                                        </button>
                                    @empty
                                        <p class="text-xs text-dark/60 col-span-full">No components in this category yet.</p>
                                    @endforelse
                                </div>
                            </div>
                        @empty
                            <p class="font-poppins text-dark/70">No components have been added to the admin panel yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white p-6 card-radius shadow-soft">
                    <h2 class="text-2xl font-fredoka font-bold mb-4">Design Summary</h2>
                    
                    <div id="custom-items-list" class="space-y-2 border-b border-neutral pb-2 mb-2 max-h-48 overflow-y-auto font-poppins text-sm">
                        <p class="text-dark/70 text-center">Your added items will appear here...</p>
                    </div>

                    <button id="submit-design-btn" class="mt-6 w-full py-3 font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 transition-default shadow-soft">
                        Submit for Quote
                    </button>
                </div>
            </aside>

        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const TOTAL_SLOTS = 50;
            let braceletSlots = new Array(TOTAL_SLOTS).fill(null);
            let selectedComponent = null;

            const previewCircle = document.getElementById('preview-circle');
            const itemsListEl = document.getElementById('custom-items-list');
            const slotsRemainingEl = document.getElementById('slots-remaining');
            const submitBtn = document.getElementById('submit-design-btn');
            
            const csrfTokenEl = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfTokenEl ? csrfTokenEl.getAttribute('content') : null;
            const submitUrl = '{{ route("customize.submit") }}';

            function createSlots() {
                const radius = 180;
                const center = 200; 
                
                for (let i = 0; i < TOTAL_SLOTS; i++) {
                    const angle = (i / TOTAL_SLOTS) * 2 * Math.PI;
                    const x = center + radius * Math.cos(angle);
                    const y = center + radius * Math.sin(angle);
                    
                    const slot = document.createElement('div');
                    slot.className = 'bracelet-slot';
                    slot.style.left = `${x}px`;
                    slot.style.top = `${y}px`;
                    slot.style.transform = `rotate(${angle + Math.PI/2}rad)`; 
                    slot.dataset.index = i;

                    slot.addEventListener('click', () => onSlotClick(i));
                    slot.addEventListener('mouseenter', () => onSlotHover(i, true));
                    slot.addEventListener('mouseleave', () => onSlotHover(i, false));
                    
                    previewCircle.appendChild(slot);
                }
            }

            document.querySelectorAll('.component-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.querySelector('.component-btn.selected')?.classList.remove('selected');
                    btn.classList.add('selected');
                    
                    selectedComponent = {
                        id: btn.dataset.id,
                        name: btn.dataset.name,
                        image: btn.dataset.image,
                        slots: parseInt(btn.dataset.slots)
                    };
                });
            });

            //REPLACED FUNCTION
            function onSlotClick(index) {
                if (!selectedComponent) {
                    clearSlots(index);
                    updateSummary();
                    return;
                }

                if (!canPlaceComponent(index, selectedComponent.slots)) {
                    if (typeof showToast === 'function') {
                        showToast('Not enough empty space to place this item here.', 'error');
                    } else {
                        alert('Not enough empty space to place this item here.');
                    }
                    return;
                }

                braceletSlots[index] = {
                    id: selectedComponent.id,
                    name: selectedComponent.name,
                    image: selectedComponent.image,
                    slots: selectedComponent.slots,
                    is_primary: true
                };

                for (let i = 1; i < selectedComponent.slots; i++) {
                    const slotIndex = (index + i) % TOTAL_SLOTS;
                    braceletSlots[slotIndex] = { primary_slot: index };
                }
                
                updateVisuals();
                updateSummary();
            }

            function clearSlots(index) {
                let componentData = braceletSlots[index];
                if (!componentData) return;

                let primarySlotIndex = index;
                if (componentData.primary_slot !== undefined) {
                    primarySlotIndex = componentData.primary_slot;
                    componentData = braceletSlots[primarySlotIndex];
                }
                
                if (!componentData || !componentData.is_primary) return;

                const size = componentData.slots;
                for (let i = 0; i < size; i++) {
                    const slotIndex = (primarySlotIndex + i) % TOTAL_SLOTS;
                    braceletSlots[slotIndex] = null;
                }
                
                updateVisuals();
            }

            function canPlaceComponent(startIndex, size) {
                for (let i = 0; i < size; i++) {
                    const slotIndex = (startIndex + i) % TOTAL_SLOTS;
                    if (braceletSlots[slotIndex] !== null) {
                        return false;
                    }
                }
                return true;
            }

            function onSlotHover(index, isEntering) {
                if (!selectedComponent) return; 

                const size = selectedComponent.slots;
                for (let i = 0; i < size; i++) {
                    const slotIndex = (index + i) % TOTAL_SLOTS;
                    const slot = previewCircle.querySelector(`.bracelet-slot[data-index="${slotIndex}"]`);
                    if (slot && braceletSlots[slotIndex] === null) {
                        slot.classList.toggle('hover-target', isEntering);
                    }
                }
            }

            function updateVisuals() {
                const radius = 180;
                const center = 200;
                const baseSize = 48;
                
                previewCircle.querySelectorAll('.bracelet-slot').forEach((slot, i) => {
                    const data = braceletSlots[i];
                    
                    slot.style.display = 'block';
                    slot.style.zIndex = '1';
                    slot.classList.remove('filled');
                    slot.style.backgroundImage = 'none';
                    
                    if (data && data.is_primary) {
                        const size = data.slots;
                        
                        slot.style.backgroundImage = `url(${data.image})`;
                        slot.classList.add('filled');
                        slot.style.transform = 'rotate(0rad)';
                        slot.style.zIndex = '10';

                        if (size > 1) {
                            
                            const midAngle = ((i + (size - 1) / 2) / TOTAL_SLOTS) * 2 * Math.PI;

                            const x = center + radius * Math.cos(midAngle);
                            const y = center + radius * Math.sin(midAngle);
                            
                            const newSize = baseSize * (1 + (size - 1) * 0.3);
                            
                            slot.style.width = `${newSize}px`;
                            slot.style.height = `${newSize}px`;
                            slot.style.margin = `-${newSize / 2}px`;
                            slot.style.left = `${x}px`;
                            slot.style.top = `${y}px`;
                            slot.style.backgroundSize = 'contain';

                        } else {
                            
                            slot.style.width = `${baseSize}px`;
                            slot.style.height = `${baseSize}px`;
                            slot.style.margin = `-${baseSize / 2}px`;
                            slot.style.backgroundSize = 'cover';
                            
                            const angle = (i / TOTAL_SLOTS) * 2 * Math.PI;
                            const x = center + radius * Math.cos(angle);
                            const y = center + radius * Math.sin(angle);
                            
                            slot.style.left = `${x}px`;
                            slot.style.top = `${y}px`;
                        }

                    } else if (data && data.primary_slot !== undefined) {
                        slot.style.display = 'none';

                    } else {
                        
                        slot.style.width = `${baseSize}px`;
                        slot.style.height = `${baseSize}px`;
                        slot.style.margin = `-${baseSize / 2}px`;
                        slot.style.backgroundSize = 'cover';
                        
                        const angle = (i / TOTAL_SLOTS) * 2 * Math.PI;
                        const x = center + radius * Math.cos(angle);
                        const y = center + radius * Math.sin(angle);
                        
                        slot.style.left = `${x}px`;
                        slot.style.top = `${y}px`;
                        slot.style.transform = `rotate(${angle + Math.PI/2}rad)`;
                        
                    }
                });
                
                slotsRemainingEl.textContent = TOTAL_SLOTS - (braceletSlots.filter(s => s !== null).length);
            }


            function updateSummary() {
                itemsListEl.innerHTML = '';
                const componentCounts = {};
                let i = 0;
                while (i < TOTAL_SLOTS) {
                    const slot = braceletSlots[i];
                    if (slot && slot.is_primary) {
                        const component = ALL_COMPONENTS.find(c => c.id == slot.id);
                        if(component) {
                            componentCounts[component.id] = (componentCounts[component.id] || 0) + 1;
                            i += component.slot_size;
                        } else { i++; }
                    } else { i++; }
                }
                
                if (Object.keys(componentCounts).length === 0) {
                    itemsListEl.innerHTML = '<p class="text-dark/70 text-center">Your added items will appear here...</p>';
                } else {
                    for (const id in componentCounts) {
                        const component = ALL_COMPONENTS.find(c => c.id == id);
                        const count = componentCounts[id];
                        const itemEl = document.createElement('p');
                        itemEl.className = 'text-dark';
                        itemEl.innerHTML = `<span class="font-semibold">${count}x</span> ${component.name}`;
                        itemsListEl.appendChild(itemEl);
                    }
                }
            }

            document.getElementById('reset-bracelet-btn').addEventListener('click', () => {
                braceletSlots = new Array(TOTAL_SLOTS).fill(null);
                selectedComponent = null;
                document.querySelector('.component-btn.selected')?.classList.remove('selected');
                updateVisuals();
                updateSummary();
            });

            submitBtn.addEventListener('click', () => {
                const design = braceletSlots.map(s => (s && s.is_primary) ? s.id : 0);
                if (design.every(id => id === 0)) {
                    if (typeof showToast === 'function') {
                        showToast('Your bracelet is empty! Add some components first.', 'error');
                    }
                    return;
                }
                
                @if(Auth::check())
                    submitDesign(design, "{{ Auth::user()->fullName }}", "{{ Auth::user()->email }}");
                @else
                    if (typeof showToast === 'function') {
                        showToast('Please log in to submit a design for a quote.', 'error');
                    } else {
                        alert('Please log in to submit a design for a quote.');
                    }
                    setTimeout(() => {
                        window.location.href = '{{ route("auth.page") }}';
                    }, 2000);
                @endif
            });

            function submitDesign(design, name, email) {
                if (!csrfToken) {
                    console.error('CSRF token not found!');
                    if (typeof showToast === 'function') {
                        showToast('Security token missing. Please refresh the page.', 'error');
                    }
                    return;
                }

                submitBtn.disabled = true;
                submitBtn.textContent = 'SUBMITTING...';

                fetch(submitUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        customer_name: name,
                        customer_email: email,
                        design_data: design
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (typeof showToast === 'function') {
                            showToast(data.message, 'success');
                        }
                        document.getElementById('reset-bracelet-btn').click();
                    } else {
                        throw new Error(data.message || 'Submission failed.');
                    }
                })
                .catch(err => {
                    if (typeof showToast === 'function') {
                        showToast(err.message, 'error');
                    }
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Submit for Quote';
                });
            }
            
            const ALL_COMPONENTS = @json($categories->flatMap(fn($cat) => $cat->components->map(fn($comp) => [
                'id' => $comp->id,
                'name' => $comp->name,
                'slot_size' => $comp->slot_size
            ])));

            createSlots();
        });
    </script>
</x-layout>