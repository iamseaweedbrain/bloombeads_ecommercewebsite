<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloombeads - Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400..700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        tailwind.config = { 
            theme: {
                extend: {
                    colors: {
                        sakura: 'var(--color-sakura)',
                        sky: 'var(--color-sky)',
                        cta: 'var(--color-cta)',
                        dark: 'var(--color-dark)',
                        neutral: 'var(--color-neutral)',
                        success: 'var(--color-success)',
                    },
                    fontFamily: {
                        fredoka: ['Fredoka', 'sans-serif'],
                        poppins: ['Poppins', 'sans-serif'],
                    },
                },
            },
        }
    </script>

    @yield('styles')
</head>

<body class="min-h-screen bg-neutral"
      data-add-product-url="{{ route('admin.catalog.store') }}"
      data-base-update-url="{{ url('admin/catalog') }}"
      data-session-success="{{ session('success') }}"
      data-session-error="{{ session('error') }}">

    <div class="flex h-screen bg-neutral">
        <aside id="admin-sidebar" class="w-64 bg-white p-4 shadow-soft flex flex-col shrink-0 md:flex custom-scrollbar overflow-y-auto">
            <div class="shrink-0">
                <h1 class="text-2xl font-fredoka font-bold text-sakura text-center mb-6">Bloombeads Admin</h1>
            </div>

            <nav class="grow space-y-2">
                <a href="{{ route('admin.dashboard') }}" id="nav-dashboard" class="admin-nav-link w-full {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6-4a1 1 0 001-1v-1a1 1 0 10-2 0v1a1 1 0 001 1zm5 0a1 1 0 001-1v-1a1 1 0 10-2 0v1a1 1 0 001 1z"></path></svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.catalog.index') }}" id="nav-catalog" class="admin-nav-link w-full {{ request()->routeIs('admin.catalog.index*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span>Catalog Management</span>
                </a>
                <a href="{{ route('admin.transactions') }}" id="nav-transactions" class="admin-nav-link w-full {{ request()->routeIs('admin.transactions*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    <span>Transactions</span>
                </a>
                <a href="{{ route('admin.approvals') }}" id="nav-approvals" class="admin-nav-link w-full {{ request()->routeIs('admin.approvals*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Approvals</span>
                </a>
                <a href="{{ route('admin.notifications') }}" id="nav-notifications" class="admin-nav-link w-full {{ request()->routeIs('admin.notifications*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span>Notifications</span>
                </a>
            </nav>

            <div class="shrink-0 mt-6 pt-4 border-t border-neutral">
                <div class="flex items-center">
                    <img src="https://placehold.co/40x40/FFB347/333333?text=A" alt="Admin User" class="w-10 h-10 rounded-full">
                    <div class="ml-3">
                        <p class="text-sm font-poppins font-semibold">{{ Session::get('admin_user')->username ?? 'Admin User' }}</p>

                        <a href="{{ route('admin.logout') }}"
                           class="text-xs font-poppins text-sakura hover:underline"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Log Out
                        </a>
                    </div>
                </div>
            </div>
        </aside>

        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
            @csrf
        </form>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-soft p-4 flex justify-between items-center md:hidden">
                <h1 class="text-xl font-fredoka font-bold text-sakura">Admin Menu</h1>
                <button onclick="document.getElementById('admin-sidebar').classList.toggle('hidden')" class="text-dark hover:text-sakura p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </header>

            <main class="flex-1 overflow-y-auto custom-scrollbar p-6 md:p-8">

                @yield('content')

            </main>
        </div>
    </div>

    <div id="productModal" class="modal-overlay">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-4">
                <h3 id="modalTitle" class="text-2xl font-fredoka font-bold text-sakura">Add New Product</h3>
                <button onclick="closeModal()" class="text-dark hover:text-sakura text-3xl font-bold">&times;</button>
            </div>
            <form id="productForm" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div>
                    <label for="productName" class="form-label">Product Name</label>
                    <input type="text" id="productName" name="name" class="form-input" placeholder="e.g., Sakura Blossom Bracelet" required>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="productPrice" class="form-label">Price (₱)</label>
                        <input type="number" id="productPrice" name="price" class="form-input" placeholder="e.g., 65.00" min="0" step="0.01" required>
                    </div>
                    <div>
                        <label for="productStock" class="form-label">Stock Quantity</label>
                        <input type="number" id="productStock" name="stock" class="form-input" placeholder="e.g., 50" min="0" required>
                    </div>
                </div>
                <div>
                    <label for="productCategory" class="form-label">Category</label>
                    <select id="productCategory" name="category" class="form-select" required>
                        <option value="" disabled selected>Select a category...</option>
                        <option value="Fashion Accessories">Fashion Accessories</option>
                        <option value="Home Supplies">Home Supplies</option>
                        <option value="Luggage & Bags">Luggage & Bags</option>
                        <option value="Collectibles">Collectibles</option>
                    </select>
                </div>
                <div>
                    <label for="productImage" class="form-label" id="imageLabel">Product Image</label>
                    <input type="file" id="productImage" name="image" class="form-input" accept="image/png, image/jpeg">
                    <span id="currentImage" class="text-xs text-gray-500 mt-1 block"></span>
                </div>
                <div class="flex justify-end space-x-3 pt-4 border-t border-neutral">
                    <button type="button" onclick="closeModal()" class="py-2 px-5 font-poppins font-semibold card-radius text-dark bg-neutral hover:bg-gray-200 transition-default">Cancel</button>
                    <button type="submit" id="saveButton" class="py-2 px-5 font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 transition-default shadow-soft">Save Product</button>
                </div>
            </form>
        </div>
    </div>

    <div id="toast-container" class="fixed bottom-5 right-5 z-100 space-y-2">
    </div>

    @stack('scripts')
    </body>
</html>