@extends('layouts.app')

@section('title', 'Vicsode - Premium Blenders & Food Processors')

@section('content')
<!-- Hero Carousel Slider -->
<section x-data="{
    current: 0,
    slides: [
        {
            badge: 'New 2024 Collection',
            title: 'Powerful Blending.',
            highlight: 'Effortless Processing.',
            description: 'Premium commercial-grade blenders and food processors designed for performance, durability, and reliability.',
            btnText: 'Shop Collection',
            btnLink: '#products',
            image: '{{ asset("images/blenders/IMG_3076.jpg") }}'
        },
        {
            badge: 'Best Sellers',
            title: 'Heavy Duty Blenders.',
            highlight: 'Built to Last.',
            description: 'Our professional blenders crush ice, blend soups, and make smoothies with ease. Designed for everyday power.',
            btnText: 'Shop Blenders',
            btnLink: '#products',
            image: '{{ asset("images/blenders/IMG_3090.jpg") }}'
        },
        {
            badge: 'Top Rated',
            title: 'Food Processors.',
            highlight: 'Chop. Slice. Dice.',
            description: 'Multi-function food processors that save you time in the kitchen. From chopping vegetables to kneading dough.',
            btnText: 'Shop Processors',
            btnLink: '#products',
            image: '{{ asset("images/blenders/IMG_3093.jpg") }}'
        }
    ],
    autoplay: null,
    startAutoplay() {
        this.autoplay = setInterval(() => { this.next() }, 5000);
    },
    stopAutoplay() {
        clearInterval(this.autoplay);
    },
    next() {
        this.current = (this.current + 1) % this.slides.length;
    },
    prev() {
        this.current = (this.current - 1 + this.slides.length) % this.slides.length;
    }
}" x-init="startAutoplay()" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()" class="relative overflow-hidden bg-gradient-to-br from-[#1a1a2e] via-[#16213e] to-[#0f3460]">

    <!-- Slides -->
    <template x-for="(slide, index) in slides" :key="index">
        <div x-show="current === index"
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-500"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="text-white relative">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- Text Content -->
                    <div>
                        <span class="inline-block bg-brand-600/20 border border-brand-500/30 text-brand-300 text-xs font-semibold uppercase tracking-wider px-4 py-1.5 rounded-full mb-6"
                              x-text="slide.badge"></span>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-black mb-6 leading-tight">
                            <span x-text="slide.title"></span><br>
                            <span class="text-brand-400" x-text="slide.highlight"></span>
                        </h1>
                        <p class="text-lg text-gray-300 mb-8 leading-relaxed max-w-lg" x-text="slide.description"></p>
                        <a :href="slide.btnLink" class="btn-brand text-white px-8 py-4 rounded-xl font-semibold text-lg inline-flex items-center space-x-2 shadow-lg shadow-brand-600/30">
                            <span x-text="slide.btnText"></span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <!-- Image -->
                    <div class="hidden lg:flex justify-center">
                        <div class="relative animate-float">
                            <div class="absolute -inset-4 bg-brand-500/20 rounded-3xl blur-2xl"></div>
                            <img :src="slide.image" :alt="slide.title"
                                 class="relative w-full max-w-md h-[400px] object-cover rounded-2xl shadow-2xl ring-1 ring-white/10">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <!-- Navigation Arrows -->
    <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/20 transition z-10">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/20 transition z-10">
        <i class="fas fa-chevron-right"></i>
    </button>

    <!-- Dots Indicator -->
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex items-center space-x-3 z-10">
        <template x-for="(slide, index) in slides" :key="'dot-'+index">
            <button @click="current = index"
                    :class="current === index ? 'w-8 bg-brand-500' : 'w-3 bg-white/40 hover:bg-white/60'"
                    class="h-3 rounded-full transition-all duration-300"></button>
        </template>
    </div>
</section>

<!-- Trust Badges -->
<section id="features" class="border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="flex items-center space-x-3 animate-on-scroll animate-delay-1">
                <div class="w-12 h-12 bg-brand-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-truck-fast text-brand-600 text-lg"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 text-sm">Nationwide Shipping</p>
                    <p class="text-xs text-gray-500">Fast delivery</p>
                </div>
            </div>
            <div class="flex items-center space-x-3 animate-on-scroll animate-delay-2">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-shield-halved text-green-600 text-lg"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 text-sm">1 Year Warranty</p>
                    <p class="text-xs text-gray-500">Full coverage</p>
                </div>
            </div>
            <div class="flex items-center space-x-3 animate-on-scroll animate-delay-3">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-rotate-left text-blue-600 text-lg"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 text-sm">30-Day Returns</p>
                    <p class="text-xs text-gray-500">Hassle-free</p>
                </div>
            </div>
            <div class="flex items-center space-x-3 animate-on-scroll animate-delay-4">
                <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-headset text-purple-600 text-lg"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 text-sm">Expert Support</p>
                    <p class="text-xs text-gray-500">Mon-Sat, 8am-6pm</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Browse By</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Shop By Category</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- All Products Card -->
            <a href="{{ route('shop.index') }}#products" class="group relative rounded-2xl overflow-hidden h-80 bg-gray-900 block animate-on-scroll animate-delay-1">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent z-10"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <i class="fas fa-blender text-gray-700 text-8xl"></i>
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-6 z-20">
                    <div class="flex items-end justify-between">
                        <div>
                            <h3 class="text-white text-xl font-bold uppercase">All Products</h3>
                            <p class="text-gray-400 text-sm mt-1">Check out all our products</p>
                        </div>
                        <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center group-hover:bg-brand-600 transition">
                            <i class="fas fa-arrow-right text-white"></i>
                        </div>
                    </div>
                </div>
            </a>

            @foreach($categories as $category)
                <a href="{{ route('shop.category', $category) }}" class="group relative rounded-2xl overflow-hidden h-80 bg-gray-100 block">
                    @if($category->image)
                        <img src="{{ asset($category->image) }}"
                             alt="{{ $category->name }}"
                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center bg-gray-50">
                            <i class="fas fa-blender text-gray-200 text-8xl"></i>
                        </div>
                    @endif
                    <div class="absolute bottom-0 left-0 right-0 p-6 bg-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-gray-900 text-lg font-bold">{{ $category->name }}<sup class="text-brand-600 text-xs ml-1">{{ $category->active_products_count }}</sup></h3>
                            </div>
                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-brand-600 group-hover:text-white transition">
                                <i class="fas fa-arrow-right text-sm"></i>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
@if($featuredProducts->count() > 0)
<section id="featured" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 animate-on-scroll">
            <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Handpicked for You</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Featured Products</h2>
            <p class="text-gray-500 mt-3 max-w-lg mx-auto">Our top-rated blenders and processors chosen for exceptional performance, build quality, and customer satisfaction.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($featuredProducts as $product)
                @include('shop.partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- All Products -->
<section id="products" class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 animate-on-scroll">
            <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Full Collection</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">All Products</h2>
            <p class="text-gray-500 mt-3 max-w-lg mx-auto">Browse our complete range of professional-grade blenders and food processors for home and commercial use.</p>
        </div>

        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($products as $product)
                    @include('shop.partials.product-card', ['product' => $product])
                @endforeach
            </div>

            <div class="mt-12">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-gray-50 rounded-2xl">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-blender text-gray-300 text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">No Products Yet</h3>
                <p class="text-gray-500">Our collection is coming soon. Check back shortly!</p>
            </div>
        @endif
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-20 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 animate-on-scroll">
            <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Customer Love</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">What Our Customers Say</h2>
            <p class="text-gray-500 mt-3 max-w-lg mx-auto">Real reviews from real customers who trust Vicsode for their kitchen needs.</p>
        </div>

        @if($reviews->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($reviews as $review)
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-lg transition duration-300 relative">
                <div class="absolute -top-4 left-8">
                    <div class="w-8 h-8 bg-brand-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-quote-left text-white text-xs"></i>
                    </div>
                </div>
                <div class="flex items-center text-yellow-400 mb-4 mt-2">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->rating)
                            <i class="fas fa-star"></i>
                        @else
                            <i class="far fa-star text-gray-200"></i>
                        @endif
                    @endfor
                </div>
                <p class="text-gray-600 leading-relaxed mb-6">"{{ $review->review }}"</p>
                <div class="flex items-center border-t border-gray-100 pt-5">
                    @php
                        $colors = ['from-brand-500 to-brand-700', 'from-green-500 to-green-700', 'from-purple-500 to-purple-700', 'from-orange-500 to-orange-700', 'from-blue-500 to-blue-700', 'from-pink-500 to-pink-700'];
                        $color = $colors[$loop->index % count($colors)];
                    @endphp
                    <div class="w-12 h-12 bg-gradient-to-br {{ $color }} rounded-full flex items-center justify-center text-white font-bold text-lg">
                        {{ strtoupper(substr($review->customer_name, 0, 1)) }}
                    </div>
                    <div class="ml-4">
                        <p class="font-semibold text-gray-900">{{ $review->customer_name }}</p>
                        @if($review->city)
                            <p class="text-sm text-gray-400">{{ $review->city }}, Nigeria</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Fallback static testimonials when no reviews exist yet -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
            $staticReviews = [
                ['name' => 'Adebayo Johnson', 'city' => 'Lagos', 'rating' => 5, 'review' => 'This blender is an absolute beast! I use it daily for smoothies and it crushes ice like butter. Best purchase I\'ve made this year.'],
                ['name' => 'Chioma Okafor', 'city' => 'Abuja', 'rating' => 5, 'review' => 'I bought the food processor for my restaurant and it\'s been a game changer. Saves me so much time. Delivery was fast!'],
                ['name' => 'Emeka Nwankwo', 'city' => 'Port Harcourt', 'rating' => 5, 'review' => 'My wife loves this juicer! Fresh orange juice every morning. Truly premium quality at a fair price.'],
            ];
            $colors = ['from-brand-500 to-brand-700', 'from-green-500 to-green-700', 'from-purple-500 to-purple-700'];
            @endphp
            @foreach($staticReviews as $index => $sr)
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-lg transition duration-300 relative">
                <div class="absolute -top-4 left-8">
                    <div class="w-8 h-8 bg-brand-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-quote-left text-white text-xs"></i>
                    </div>
                </div>
                <div class="flex items-center text-yellow-400 mb-4 mt-2">
                    @for($i = 0; $i < $sr['rating']; $i++)
                        <i class="fas fa-star"></i>
                    @endfor
                </div>
                <p class="text-gray-600 leading-relaxed mb-6">"{{ $sr['review'] }}"</p>
                <div class="flex items-center border-t border-gray-100 pt-5">
                    <div class="w-12 h-12 bg-gradient-to-br {{ $colors[$index] }} rounded-full flex items-center justify-center text-white font-bold text-lg">
                        {{ strtoupper(substr($sr['name'], 0, 1)) }}
                    </div>
                    <div class="ml-4">
                        <p class="font-semibold text-gray-900">{{ $sr['name'] }}</p>
                        <p class="text-sm text-gray-400">{{ $sr['city'] }}, Nigeria</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Stats Bar -->
        <div class="mt-14 bg-white rounded-2xl border border-gray-100 shadow-sm p-8 animate-scale">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <p class="text-3xl font-bold text-gray-900">2,500+</p>
                    <p class="text-sm text-gray-500 mt-1">Happy Customers</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-gray-900">4.9<span class="text-yellow-400 text-xl ml-1"><i class="fas fa-star"></i></span></p>
                    <p class="text-sm text-gray-500 mt-1">Average Rating</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-gray-900">98%</p>
                    <p class="text-sm text-gray-500 mt-1">Satisfaction Rate</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-gray-900">24hrs</p>
                    <p class="text-sm text-gray-500 mt-1">Avg. Delivery (Lagos)</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-gray-900 py-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-72 h-72 bg-brand-500 rounded-full filter blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-brand-600 rounded-full filter blur-3xl translate-x-1/3 translate-y-1/3"></div>
    </div>
    <div class="max-w-4xl mx-auto px-4 text-center relative z-10 animate-on-scroll">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Ready to Upgrade Your Kitchen?</h2>
        <p class="text-gray-400 text-lg mb-8">Join thousands of satisfied customers who trust Vicsode for their daily blending and processing needs.</p>
        <a href="#products" class="btn-brand text-white px-10 py-4 rounded-xl font-semibold text-lg inline-flex items-center space-x-2 shadow-lg pulse-glow">
            <span>Shop Now</span>
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</section>
@endsection
