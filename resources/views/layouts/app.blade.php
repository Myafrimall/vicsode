<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Vicsode - Premium Blenders & Processors')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#fdf4f3',
                            100: '#fce8e5',
                            200: '#fad5d0',
                            300: '#f5b5ac',
                            400: '#ed8a7b',
                            500: '#e2624f',
                            600: '#cf4532',
                            700: '#ae3726',
                            800: '#903123',
                            900: '#782e23',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15); }
        .hero-gradient { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); }
        .announcement-bar { background: linear-gradient(90deg, #1a1a2e 0%, #0f3460 100%); }
        .btn-brand { background: linear-gradient(135deg, #e2624f 0%, #cf4532 100%); }
        .btn-brand:hover { background: linear-gradient(135deg, #cf4532 0%, #ae3726 100%); transform: translateY(-2px); box-shadow: 0 10px 30px rgba(207,69,50,0.3); }

        /* Scroll Animations */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .animate-on-scroll.animated {
            opacity: 1;
            transform: translateY(0);
        }
        .animate-on-scroll.animate-delay-1 { transition-delay: 0.1s; }
        .animate-on-scroll.animate-delay-2 { transition-delay: 0.2s; }
        .animate-on-scroll.animate-delay-3 { transition-delay: 0.3s; }
        .animate-on-scroll.animate-delay-4 { transition-delay: 0.4s; }

        /* Fade in from left/right */
        .animate-slide-left { opacity: 0; transform: translateX(-60px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .animate-slide-right { opacity: 0; transform: translateX(60px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .animate-slide-left.animated, .animate-slide-right.animated { opacity: 1; transform: translateX(0); }

        /* Scale up animation */
        .animate-scale { opacity: 0; transform: scale(0.85); transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1); }
        .animate-scale.animated { opacity: 1; transform: scale(1); }

        /* Floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .animate-float { animation: float 3s ease-in-out infinite; }

        /* Pulse glow */
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(226, 98, 79, 0.4); }
            50% { box-shadow: 0 0 20px 10px rgba(226, 98, 79, 0.1); }
        }
        .pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }

        /* Smooth nav shadow on scroll */
        .nav-scrolled { box-shadow: 0 4px 30px rgba(0,0,0,0.08); backdrop-filter: blur(10px); }

        /* Announcement ticker */
        @keyframes ticker {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .ticker-wrap { overflow: hidden; }
        .ticker { display: inline-flex; white-space: nowrap; animation: ticker 20s linear infinite; }
        .ticker:hover { animation-play-state: paused; }

        /* Shimmer loading effect */
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .shimmer {
            background: linear-gradient(90deg, transparent 25%, rgba(255,255,255,0.3) 50%, transparent 75%);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        /* Count up animation */
        .count-up { font-variant-numeric: tabular-nums; }

        /* Smooth image zoom */
        .img-zoom { transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
        .img-zoom:hover { transform: scale(1.05); }

        /* Glass morphism */
        .glass { background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // Scroll animation observer
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

            document.querySelectorAll('.animate-on-scroll, .animate-slide-left, .animate-slide-right, .animate-scale').forEach(el => {
                observer.observe(el);
            });

            // Nav scroll effect
            const nav = document.querySelector('nav');
            if (nav) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 50) {
                        nav.classList.add('nav-scrolled');
                    } else {
                        nav.classList.remove('nav-scrolled');
                    }
                });
            }
        });
    </script>
</head>
<body class="bg-white font-sans min-h-screen flex flex-col scroll-smooth">
    <!-- Announcement Bar -->
    <div class="announcement-bar text-white py-2.5 text-xs sm:text-sm font-medium tracking-wide ticker-wrap">
        <div class="ticker">
            <span class="mx-8"><i class="fas fa-shield-halved mr-2"></i> 1 YEAR WARRANTY ON ALL PRODUCTS</span>
            <span class="mx-8"><i class="fas fa-rotate-left mr-2"></i> 30-DAY EASY RETURNS</span>
            <span class="mx-8"><i class="fas fa-headset mr-2"></i> EXPERT SUPPORT MON-SAT</span>
            <span class="mx-8"><i class="fas fa-truck mr-2"></i> NATIONWIDE SHIPPING</span>
            <span class="mx-8"><i class="fas fa-shield-halved mr-2"></i> 1 YEAR WARRANTY ON ALL PRODUCTS</span>
            <span class="mx-8"><i class="fas fa-rotate-left mr-2"></i> 30-DAY EASY RETURNS</span>
            <span class="mx-8"><i class="fas fa-headset mr-2"></i> EXPERT SUPPORT MON-SAT</span>
            <span class="mx-8"><i class="fas fa-truck mr-2"></i> NATIONWIDE SHIPPING</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="bg-white/95 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <a href="{{ route('shop.index') }}" class="flex items-center">
                    <img src="{{ asset('images/vicsode_logo.jpeg') }}" alt="Vicsode" class="h-12 w-auto">
                </a>

                <!-- Nav Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('shop.index') }}" class="text-gray-700 hover:text-brand-600 font-medium transition text-sm uppercase tracking-wide">Shop</a>
                    <a href="{{ route('shop.index') }}#featured" class="text-gray-700 hover:text-brand-600 font-medium transition text-sm uppercase tracking-wide">Featured</a>
                    <a href="#" class="text-gray-700 hover:text-brand-600 font-medium transition text-sm uppercase tracking-wide">About</a>
                    <a href="#" class="text-gray-700 hover:text-brand-600 font-medium transition text-sm uppercase tracking-wide">Contact</a>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center space-x-5">
                    <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-brand-600 transition">
                        <i class="fas fa-shopping-bag text-xl"></i>
                        @php $cartCount = array_sum(array_column(session('cart', []), 'quantity')); @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-brand-600 text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed top-24 right-4 z-50 bg-green-600 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center space-x-3">
            <i class="fas fa-check-circle text-lg"></i>
            <span class="font-medium">{{ session('success') }}</span>
            <button @click="show = false" class="ml-2 hover:text-green-200"><i class="fas fa-times"></i></button>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             class="fixed top-24 right-4 z-50 bg-red-600 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center space-x-3">
            <i class="fas fa-exclamation-circle text-lg"></i>
            <span class="font-medium">{{ session('error') }}</span>
            <button @click="show = false" class="ml-2 hover:text-red-200"><i class="fas fa-times"></i></button>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                <div class="md:col-span-1">
                    <div class="flex items-center space-x-3 mb-5">
                        <img src="{{ asset('images/vicsode_logo.jpeg') }}" alt="Vicsode" class="h-12 w-auto">
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">Premium blenders and food processors designed for performance, durability, and results. Elevate your kitchen experience.</p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider mb-4 text-gray-300">Shop</h3>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="{{ route('shop.index') }}" class="hover:text-white transition">All Products</a></li>
                        <li><a href="#" class="hover:text-white transition">Blenders</a></li>
                        <li><a href="#" class="hover:text-white transition">Food Processors</a></li>
                        <li><a href="#" class="hover:text-white transition">On Sale</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider mb-4 text-gray-300">Support</h3>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Shipping & Delivery</a></li>
                        <li><a href="#" class="hover:text-white transition">Returns & Exchange</a></li>
                        <li><a href="#" class="hover:text-white transition">Warranty</a></li>
                        <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider mb-4 text-gray-300">Contact</h3>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-center"><i class="fas fa-envelope w-5 text-brand-500"></i> info@vicsode.com.ng</li>
                        <li class="flex items-center"><i class="fas fa-phone w-5 text-brand-500"></i> +234 801 234 5678</li>
                        <li class="flex items-center"><i class="fas fa-map-marker-alt w-5 text-brand-500"></i> Lagos, Nigeria</li>
                    </ul>
                    <div class="flex space-x-4 mt-5">
                        <a href="#" class="w-9 h-9 bg-gray-800 rounded-full flex items-center justify-center hover:bg-brand-600 transition">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#" class="w-9 h-9 bg-gray-800 rounded-full flex items-center justify-center hover:bg-brand-600 transition">
                            <i class="fab fa-instagram text-sm"></i>
                        </a>
                        <a href="#" class="w-9 h-9 bg-gray-800 rounded-full flex items-center justify-center hover:bg-brand-600 transition">
                            <i class="fab fa-twitter text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} Vicsode. All rights reserved.</p>
                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <i class="fab fa-cc-visa text-2xl text-gray-400"></i>
                    <i class="fab fa-cc-mastercard text-2xl text-gray-400"></i>
                    <i class="fab fa-cc-amex text-2xl text-gray-400"></i>
                    <i class="fab fa-cc-paypal text-2xl text-gray-400"></i>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <div x-data="{ show: false }" @scroll.window="show = window.scrollY > 500" x-cloak>
        <button x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4"
                @click="window.scrollTo({top: 0, behavior: 'smooth'})"
                class="fixed bottom-8 right-8 w-12 h-12 bg-brand-600 text-white rounded-full shadow-lg shadow-brand-600/30 flex items-center justify-center hover:bg-brand-700 transition z-50">
            <i class="fas fa-arrow-up"></i>
        </button>
    </div>
</body>
</html>
