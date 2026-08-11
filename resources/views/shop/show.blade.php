@extends('layouts.app')

@section('title', $product->name . ' - Vicsode')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('shop.index') }}" class="hover:text-brand-600 transition">Shop</a></li>
            <li><i class="fas fa-chevron-right text-[10px] text-gray-300"></i></li>
            <li class="text-gray-800 font-medium">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">
        <!-- Product Images -->
        <div x-data="{
            activeImage: 0,
            totalImages: {{ $product->images->count() }},
            autoplay: null,
            startAutoplay() {
                if (this.totalImages > 1) {
                    this.autoplay = setInterval(() => {
                        this.activeImage = (this.activeImage + 1) % this.totalImages;
                    }, 3000);
                }
            },
            stopAutoplay() {
                clearInterval(this.autoplay);
            }
        }" x-init="startAutoplay()" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()">
            <div class="aspect-square bg-gray-50 rounded-2xl overflow-hidden mb-4 border border-gray-100 relative">
                @if($product->images->count() > 0)
                    @foreach($product->images as $index => $image)
                        <img x-show="activeImage === {{ $index }}"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             src="{{ asset($image->image_path) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover absolute inset-0">
                    @endforeach
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="fas fa-blender text-gray-200 text-8xl"></i>
                    </div>
                @endif
            </div>

            @if($product->images->count() > 1)
                <div class="grid grid-cols-4 sm:grid-cols-4 gap-2 sm:gap-3">
                    @foreach($product->images as $index => $image)
                        <button @click="activeImage = {{ $index }}; stopAutoplay()"
                                :class="activeImage === {{ $index }} ? 'ring-2 ring-brand-500 ring-offset-2' : 'ring-1 ring-gray-200 hover:ring-gray-300'"
                                class="aspect-square rounded-lg sm:rounded-xl overflow-hidden transition">
                            <img src="{{ asset($image->image_path) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div>
            @if($product->brand)
                <p class="text-brand-600 font-semibold uppercase tracking-wider text-sm mb-2">{{ $product->brand }}</p>
            @endif

            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight">{{ $product->name }}</h1>

            <!-- Price -->
            <div class="flex flex-wrap items-center gap-2 mb-8 pb-8 border-b border-gray-100">
                @if($product->is_on_sale)
                    <span class="text-2xl sm:text-4xl font-bold text-brand-600">₦{{ number_format($product->sale_price, 2) }}</span>
                    <span class="text-base sm:text-xl text-gray-400 line-through">₦{{ number_format($product->price, 2) }}</span>
                    @php $discount = round((($product->price - $product->sale_price) / $product->price) * 100); @endphp
                    <span class="bg-red-100 text-red-700 text-xs sm:text-sm font-bold px-2 sm:px-3 py-1 sm:py-1.5 rounded-lg">Save {{ $discount }}%</span>
                @else
                    <span class="text-2xl sm:text-4xl font-bold text-gray-900">₦{{ number_format($product->price, 2) }}</span>
                @endif
            </div>

            <!-- Description -->
            <div class="mb-8">
                <p class="text-gray-600 leading-relaxed text-base">{{ $product->description }}</p>
            </div>

            <!-- Specifications -->
            @if($product->power || $product->capacity || $product->brand)
            <div class="bg-gray-50 rounded-2xl p-6 mb-8">
                <h3 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wider">Specifications</h3>
                <div class="grid grid-cols-2 gap-4">
                    @if($product->power)
                        <div class="bg-white rounded-xl p-4">
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Power</p>
                            <p class="font-semibold text-gray-900">{{ $product->power }}</p>
                        </div>
                    @endif
                    @if($product->capacity)
                        <div class="bg-white rounded-xl p-4">
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Capacity</p>
                            <p class="font-semibold text-gray-900">{{ $product->capacity }}</p>
                        </div>
                    @endif
                    @if($product->brand)
                        <div class="bg-white rounded-xl p-4">
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Brand</p>
                            <p class="font-semibold text-gray-900">{{ $product->brand }}</p>
                        </div>
                    @endif
                    <div class="bg-white rounded-xl p-4">
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Availability</p>
                        <p class="font-semibold {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $product->stock > 0 ? 'In Stock (' . $product->stock . ' available)' : 'Out of Stock' }}
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Add to Cart -->
            <form method="POST" action="{{ route('cart.add', $product) }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
                @csrf
                <div x-data="{ quantity: 1 }" class="flex items-center border-2 border-gray-200 rounded-xl overflow-hidden self-start">
                    <button type="button" @click="quantity = Math.max(1, quantity - 1); $refs.qty.value = quantity"
                            class="px-4 py-3 text-gray-600 hover:text-brand-600 hover:bg-gray-50 transition">
                        <i class="fas fa-minus"></i>
                    </button>
                    <input x-ref="qty" type="number" name="quantity" x-model="quantity" min="1" max="{{ $product->stock }}"
                           class="w-14 text-center border-0 focus:ring-0 font-bold text-lg">
                    <button type="button" @click="quantity = Math.min({{ $product->stock }}, quantity + 1); $refs.qty.value = quantity"
                            class="px-4 py-3 text-gray-600 hover:text-brand-600 hover:bg-gray-50 transition">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <button type="submit"
                        class="flex-1 btn-brand text-white py-4 rounded-xl font-bold text-base sm:text-lg flex items-center justify-center space-x-3 shadow-lg shadow-brand-600/20 disabled:opacity-50 disabled:cursor-not-allowed"
                        {{ $product->stock <= 0 ? 'disabled' : '' }}>
                    <i class="fas fa-shopping-bag"></i>
                    <span>Add to Cart</span>
                </button>
            </form>

            <!-- Trust -->
            <div class="mt-8 grid grid-cols-3 gap-4 pt-8 border-t border-gray-100">
                <div class="text-center">
                    <i class="fas fa-truck-fast text-gray-400 text-lg mb-2"></i>
                    <p class="text-xs text-gray-500">Fast Delivery</p>
                </div>
                <div class="text-center">
                    <i class="fas fa-shield-halved text-gray-400 text-lg mb-2"></i>
                    <p class="text-xs text-gray-500">1 Year Warranty</p>
                </div>
                <div class="text-center">
                    <i class="fas fa-rotate-left text-gray-400 text-lg mb-2"></i>
                    <p class="text-xs text-gray-500">Easy Returns</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <section class="mt-24">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-900">You May Also Like</h2>
                <p class="text-gray-500 mt-2">Customers also viewed these blenders</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($relatedProducts as $relProduct)
                    @include('shop.partials.product-card', ['product' => $relProduct])
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection
