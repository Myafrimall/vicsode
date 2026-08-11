<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Vicsode')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#fdf4f3', 100: '#fce8e5', 200: '#fad5d0', 300: '#f5b5ac',
                            400: '#ed8a7b', 500: '#e2624f', 600: '#cf4532', 700: '#ae3726',
                            800: '#903123', 900: '#782e23',
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 min-h-screen fixed left-0 top-0">
            <div class="p-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <img src="{{ asset('images/vicsode_logo.jpeg') }}" alt="Vicsode" class="h-12 w-auto">
                </a>
            </div>

            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white border-r-4 border-brand-500' : '' }}">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
                <a href="{{ route('admin.products.index') }}"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs('admin.products.*') ? 'bg-gray-800 text-white border-r-4 border-brand-500' : '' }}">
                    <i class="fas fa-box w-5"></i>
                    <span class="ml-3">Products</span>
                </a>
                <a href="{{ route('admin.categories.index') }}"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs('admin.categories.*') ? 'bg-gray-800 text-white border-r-4 border-brand-500' : '' }}">
                    <i class="fas fa-folder w-5"></i>
                    <span class="ml-3">Categories</span>
                </a>
                <a href="{{ route('admin.orders.index') }}"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs('admin.orders.*') ? 'bg-gray-800 text-white border-r-4 border-brand-500' : '' }}">
                    <i class="fas fa-shopping-bag w-5"></i>
                    <span class="ml-3">Orders</span>
                </a>
                <a href="{{ route('admin.reviews.index') }}"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs('admin.reviews.*') ? 'bg-gray-800 text-white border-r-4 border-brand-500' : '' }}">
                    <i class="fas fa-star w-5"></i>
                    <span class="ml-3">Reviews</span>
                </a>
                <a href="{{ route('admin.delivery-fees.index') }}"
                   class="flex items-center px-6 py-3 {{ request()->routeIs('admin.delivery-fees.*') ? 'bg-gray-800 text-white border-r-4 border-purple-500' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }} transition">
                    <i class="fas fa-truck w-5"></i>
                    <span class="ml-3">Delivery Fees</span>
                </a>
                <a href="{{ route('shop.index') }}"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition">
                    <i class="fas fa-store w-5"></i>
                    <span class="ml-3">View Shop</span>
                </a>

                <div class="border-t border-gray-800 mt-6 pt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition w-full">
                            <i class="fas fa-sign-out-alt w-5"></i>
                            <span class="ml-3">Logout</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="ml-64 flex-1 p-8">
            <!-- Flash Messages -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                     class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center justify-between">
                    <span><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
                    <button @click="show = false"><i class="fas fa-times"></i></button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                     class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg flex items-center justify-between">
                    <span><i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}</span>
                    <button @click="show = false"><i class="fas fa-times"></i></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
