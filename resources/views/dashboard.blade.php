<x-layout>
    {{-- 1. ADDED STYLES for the bracelet preview --}}
    <style>
        .bracelet-preview-container {
            position: relative;
            width: 350px; /* A bit smaller for the modal */
            height: 350px;
            margin: 1rem auto;
        }
        .bracelet-slot {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 30px;  /* A bit smaller for the modal */
            height: 30px;
            margin: -15px; /* Half of the width/height */
            border-radius: 50%;
            background-color: #f0f0f0;
            border: 2px dashed #d1d5db;
            background-size: cover;
            background-position: center;
        }
        .bracelet-slot.filled {
            border: 2px solid var(--color-sakura);
            background-color: white;
        }
        
        /* Modal Styles */
        #design-preview-modal {
            background-color: rgba(0, 0, 0, 0.5);
            transition: opacity 0.3s ease;
        }
    </style>

    <section id="dashboard-view" class="py-12 md:py-16">
        <h2 class="text-3xl font-fredoka font-bold mb-8 md:mb-12">Account Dashboard</h2>

        <div class="md:grid md:grid-cols-4 gap-8">
            <aside class="md:col-span-1">
                <div class="bg-white p-4 card-radius shadow-soft sticky top-20">
                    <button id="tab-btn-user-info" onclick="setDashboardTab('user-info')" class="dashboard-tab-btn w-full text-left py-3 px-4 font-fredoka font-bold card-radius transition-default mb-2">User Information</button>
                    <button id="tab-btn-designs" onclick="setDashboardTab('designs')" class="dashboard-tab-btn w-full text-left py-3 px-4 font-fredoka font-bold card-radius transition-default mb-2">My Custom Designs</button>
                    <button id="tab-btn-orders" onclick="setDashboardTab('orders')" class="dashboard-tab-btn w-full text-left py-3 px-4 font-fredoka font-bold card-radius transition-default mb-2">Order History</button>
                    <button id="tab-btn-activity" onclick="setDashboardTab('activity')" class="dashboard-tab-btn w-full text-left py-3 px-4 font-fredoka font-bold card-radius transition-default mb-2">Recent Activity</button>
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dashboard-tab-btn w-full text-left py-3 px-4 font-fredoka font-bold card-radius transition-default mb-2 bg-cta text-white mt-4">
                            LOG OUT
                        </button>
                    </form>
                </div>
            </aside>

            <div class="md:col-span-3 bg-white p-6 sm:p-8 card-radius shadow-soft mt-8 md:mt-0">
                
                <div id="dashboard-user-info-content">
                    <h3 class="text-2xl font-fredoka font-bold text-dark mb-4 border-b pb-2 border-sakura">User Info (Shipping & Contact)</h3>
                    <div class="space-y-4 font-poppins">
                        <p><strong>Full Name:</strong> {{ $user->fullName }} </p>
                        <p><strong>Email:</strong> {{ $user->email }} </p>
                        <p><strong>Contact Number:</strong> {{ $user->contact_number ?? 'Not set' }} </p>
                        <p><strong>Shipping Address:</strong> {{ $user->address ?? 'Not set' }} </p>
                        <a href="{{ route('settings') }}" class="mt-4 inline-block py-2 px-6 font-poppins font-semibold card-radius text-white bg-sky hover:bg-opacity-80 transition-default">
                            Update Contact Info
                        </a>
                    </div>
                </div>

                <div id="dashboard-designs-content" class="hidden">
                    <h3 class="text-2xl font-fredoka font-bold text-dark mb-4 border-b pb-2 border-sakura">My Custom Designs</h3>
                    <div class="space-y-4 font-poppins">
                        @forelse ($customDesigns as $design)
                            <div class="border border-neutral card-radius p-4 flex flex-col sm:flex-row justify-between sm:items-center">
                                <div>
                                    <p class="font-semibold text-dark">Design Submitted: <span class="font-normal text-dark/80">{{ $design->created_at->format('M d, Y') }}</span></p>
                                    
                                    @if($design->status == 'pending')
                                        <p class="font-fredoka font-bold text-sm uppercase text-cta">PENDING QUOTE</p>
                                        <p class="text-sm text-dark/70 mt-1">We're reviewing your design and will email you a quote shortly.</p>
                                    
                                    @elseif($design->status == 'quoted')
                                        <p class="font-fredoka font-bold text-sm uppercase text-sky">QUOTE READY</p>
                                        <p class="text-sm text-dark/70 mt-1">Your quote is ready! You can now proceed to payment.</p>
                                    
                                    @elseif($design->status == 'declined')
                                        <p class="font-fredoka font-bold text-sm uppercase text-red-500">DESIGN DECLINED</p>
                                        <p class="text-sm text-dark/70 mt-1">Unfortunately, we cannot fulfill this design. Please check your email.</p>
                                    
                                    @elseif($design->status == 'complete')
                                        <p class="font-fredoka font-bold text-sm uppercase text-green-600">ORDER PLACED</p>
                                        <p class="text-sm text-dark/70 mt-1">This design has been converted into an order.</p>
                                    @endif

                                    {{-- 2. ADDED "View Design" Button --}}
                                    <button onclick="showDesignPreview({{ json_encode($design->design_data) }})" 
                                            class="mt-2 text-sm text-sky font-semibold hover:underline">
                                        View Design
                                    </button>

                                </div>
                                <div class="mt-3 sm:mt-0 text-right">
                                    @if($design->status == 'quoted')
                                        <p class="font-poppins font-bold text-xl text-sakura">₱{{ number_format($design->final_price, 2) }}</p>
                                        
                                        {{-- 3. FIXED "Accept & Pay" BUG --}}
                                        {{-- This is now a simple link to your checkout page. --}}
                                        {{-- You must create this route: route('checkout.design', $design) --}}
                                        {{-- This route should be a GET route that SHOWS the checkout page. --}}
                                       <form action="{{ route('checkout.createFromDesign', $design) }}" method="POST" class="mt-2">
                                        @csrf
                                        <button type="submit" class="inline-block py-2 px-5 font-poppins font-semibold card-radius text-white bg-cta hover:bg-opacity-80 transition-default">
                                            Accept & Pay
                                        </button>
                                    </form> 
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 text-dark/70">
                                <p class="text-lg font-fredoka mb-3">You haven't submitted any designs yet.</p>
                                <a href="{{ route('customize') }}" class="text-sakura hover:underline font-semibold">Design your own bracelet now!</a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div id="dashboard-activity-content" class="hidden">
                    <h3 class="text-2xl font-fredoka font-bold text-dark mb-4 border-b pb-2 border-sakura">Recent Activity</h3>
                    
                    <div class="space-y-4 font-poppins">
                        @forelse ($activities as $activity)
                            <div class="p-3 bg-neutral card-radius border border-gray-200">
                                <p class="text-sm text-dark/70">{{ $activity->created_at->diffForHumans() }}</p>
                                
                                @if($activity->url)
                                    <a href="{{ $activity->url }}" class="font-semibold text-dark hover:text-sakura hover:underline transition-default">
                                        {{ $activity->message }}
                                    </a>
                                @else
                                    <p class="font-semibold text-dark">{{ $activity->message }}</p>
                                @endif
                                </div>
                        @empty
                            <div class="p-3 bg-neutral card-radius border border-gray-200">
                                <p class="font-semibold text-dark">No recent activity to show.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                
                <div id="dashboard-orders-content" class="hidden">
                    <h3 class="text-2xl font-fredoka font-bold text-dark mb-4 border-b pb-2 border-sakura">Order History</h3>
                    
                    <nav class="flex border-b border-neutral overflow-x-auto mb-6">
                        @php
                            $filters = [
                                'all' => 'All',
                                'to-pay' => 'To Pay',
                                'to-ship' => 'To Ship',
                                'to-receive' => 'To Receive',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled'
                            ];
                        @endphp

                        @foreach ($filters as $key => $value)
                            <a href="{{ route('dashboard', ['status' => $key]) }}"
                               class="dashboard-filter-tab py-3 px-4 font-poppins font-semibold whitespace-nowrap
                                  {{ $activeStatusFilter == $key ? 'text-sakura border-b-2 border-sakura' : 'text-dark/60 hover:text-dark' }}">
                                {{ $value }}
                            </a>
                        @endforeach
                    </nav>

                    <div class="space-y-6 font-poppins">
                        
                        @forelse ($orders as $order)
                            <a href="{{ route('order.show', $order->order_tracking_id) }}" 
                               class="block border border-neutral card-radius overflow-hidden shadow-soft hover:shadow-lg hover:border-sakura/40 transition-all duration-300">
                                
                                <div class="bg-neutral/70 p-4 flex justify-between items-center">
                                    <div>
                                        <span class="font-semibold text-dark">
                                            Order #{{ $order->order_tracking_id }}
                                        </span>
                                        <p class="text-sm text-dark/70">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                    @php
                                        $statusClass = 'text-dark/70';
                                        if ($order->order_status == 'delivered') $statusClass = 'text-green-600';
                                        elseif ($order->order_status == 'shipped') $statusClass = 'text-sky';
                                        elseif ($order->order_status == 'processing') $statusClass = 'text-blue-500';
                                        elseif ($order->order_status == 'pending') $statusClass = 'text-cta';
                                        elseif ($order->order_status == 'cancelled') $statusClass = 'text-red-500';
                                    @endphp
                                    <span class="font-fredoka font-bold text-sm uppercase {{ $statusClass }}">
                                        {{ $order->order_status }}
                                    </span>
                                </div>
                                
                                <div class="p-4 space-y-4">
                                    @foreach ($order->items as $item)
                                        <div class="flex items-center space-x-4">
                                            <img src="{{ $item->product->image_path ? asset('storage/' . $item->product->image_path) : 'https://placehold.co/80x80/FF6B81/FFFFFF?text=B' }}"
                                                 alt="{{ $item->product->name }}"
                                                 class="w-16 h-16 card-radius object-cover bg-gray-100 flex-shrink-0">
                                            <div class="flex-grow">
                                                <p class="font-semibold text-dark">{{ $item->product->name }}</p>
                                                <p class="text-sm text-dark/70">x {{ $item->quantity }}</p>
                                            </div>
                                            <p class="font-semibold text-dark">₱{{ number_format($item->price * $item->quantity, 2) }}</p>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="bg-neutral/70 p-4 text-right">
                                    <p class="font-poppins text-dark">
                                        Order Total: 
                                        <span class="font-fredoka font-bold text-xl text-sakura ml-2">₱{{ number_format($order->total_amount, 2) }}</span>
                                    </p>
                                </div>
                            </a> 
                        @empty
                            <div class="text-center py-10 text-dark/70">
                                <p class="text-lg font-fredoka mb-3">No orders found in this category.</p>
                                <p>You have not placed any orders yet, or your orders are in another status.</p>
                            </div>
                        @endforelse

                        <div class="mt-6">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 4. ADDED MODAL HTML --}}
    <div id="design-preview-modal" onclick="closeDesignPreview()" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden opacity-0">
        <div class="bg-white card-radius shadow-soft max-w-lg w-full p-6 relative" onclick="event.stopPropagation()">
            <h3 class="text-2xl font-fredoka font-bold text-dark mb-4">Design Preview</h3>
            
            <div class="bracelet-preview-container">
                <div id="modal-preview-circle"></div>
            </div>

            <button onclick="closeDesignPreview()" 
                    class="absolute top-4 right-4 text-dark/60 hover:text-sakura transition-default">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>


    <script>
        {{-- 5. ADDED JAVASCRIPT LOGIC --}}

        // Assumes your controller passes $allComponents to this view
        const ALL_COMPONENTS = @json($allComponents ?? []); 
        const TOTAL_SLOTS = 50;

        function showDesignPreview(designData) {
            if (Object.keys(ALL_COMPONENTS).length === 0) {
                console.error("Component list is missing. Make sure your controller passes $allComponents.");
                alert("Error: Could not load component data to show preview.");
                return;
            }

            const previewCircle = document.getElementById('modal-preview-circle');
            const modal = document.getElementById('design-preview-modal');
            previewCircle.innerHTML = ''; // Clear previous preview

            const radius = 160; // Smaller radius for 350px container
            const center = 175; // Center for 350px container
            const baseSize = 30;
            
            let i = 0;
            while (i < TOTAL_SLOTS) {
                const componentId = designData[i];
                const component = (componentId && componentId !== 0) ? ALL_COMPONENTS[componentId] : null;

                const slot = document.createElement('div');
                slot.className = 'bracelet-slot';

                const angle = (i / TOTAL_SLOTS) * 2 * Math.PI;
                const x = center + radius * Math.cos(angle);
                const y = center + radius * Math.sin(angle);

                if (component) {
                    const size = component.slot_size || 1;
                    
                    // Use the full_image_url from the Component model
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
            
            // Show the modal
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.remove('opacity-0'), 10);
        }

        function closeDesignPreview() {
            const modal = document.getElementById('design-preview-modal');
            modal.classList.add('opacity-0');
            setTimeout(() => modal.classList.add('hidden'), 300);
        }

        // --- Existing Tab Logic ---
        function setDashboardTab(tabId) {
            // Hide all content panes
            document.getElementById('dashboard-user-info-content').classList.add('hidden');
            document.getElementById('dashboard-activity-content').classList.add('hidden');
            document.getElementById('dashboard-orders-content').classList.add('hidden');
            document.getElementById('dashboard-designs-content').classList.add('hidden'); 
            
            // Show the selected one
            const contentEl = document.getElementById('dashboard-' + tabId + '-content');
            if (contentEl) {
                contentEl.classList.remove('hidden');
            }

            // Update tab button styles
            document.querySelectorAll('.dashboard-tab-btn').forEach(btn => {
                if (!btn.closest('form')) {
                    btn.classList.remove('bg-sakura', 'text-white');
                    // We don't need to add bg-neutral, it should be the default
                }
            });
            
            const activeBtn = document.getElementById('tab-btn-' + tabId);
            if (activeBtn) {
                activeBtn.classList.add('bg-sakura', 'text-white');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const currentUrl = new URL(window.location.href);
            const activeTab = currentUrl.searchParams.get('tab');
            
            if (currentUrl.searchParams.has('status')) {
                setDashboardTab('orders');
            } else if (activeTab) {
                setDashboardTab(activeTab);
            } else {
                setDashboardTab('user-info');
            }
        });
    </script>
</x-layout>