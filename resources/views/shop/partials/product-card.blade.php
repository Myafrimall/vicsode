<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden card-hover group animate-on-scroll">
    <a href="{{ route('shop.show', $product) }}" class="block">
        <div class="aspect-square bg-gray-50 relative overflow-hidden">
            @if($product->images->count() > 0)
                <img src="{{ asset($product->images->first()->image_path) }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <i class="fas fa-blender text-gray-200 text-6xl"></i>
                </div>
            @endif

            <!-- Badges -->
            <div class="absolute top-3 left-3 flex flex-col gap-2">
                @if($product->is_on_sale)
                    <span class="bg-red-500 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                        Sale
                    </span>
                @endif
                @if($product->is_featured)
                    <span class="bg-gray-900 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                        <i class="fas fa-star mr-1"></i>Featured
                    </span>
                @endif
            </div>

            <!-- Small thumbnails of other images -->
            @if($product->images->count() > 1)
                <div class="absolute bottom-3 right-3 flex gap-1.5">
                    @foreach($product->images->slice(1, 2) as $thumb)
                        <div class="w-10 h-10 rounded-lg overflow-hidden border-2 border-white shadow-md">
                            <img src="{{ asset($thumb->image_path) }}" alt="" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                    @if($product->images->count() > 3)
                        <div class="w-10 h-10 rounded-lg overflow-hidden border-2 border-white shadow-md bg-black/60 flex items-center justify-center">
                            <span class="text-white text-xs font-bold">+{{ $product->images->count() - 3 }}</span>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </a>

    <div class="p-4 sm:p-5">
        <a href="{{ route('shop.show', $product) }}" class="block">
            @if($product->brand)
                <p class="text-[11px] text-brand-600 font-semibold uppercase tracking-wider mb-1">{{ $product->brand }}</p>
            @endif
            <h3 class="font-semibold text-gray-900 text-sm leading-snug mb-3 group-hover:text-brand-600 transition line-clamp-2">{{ $product->name }}</h3>
        </a>

        <div class="flex items-center justify-between mb-3">
            <div>
                @if($product->is_on_sale)
                    <span class="text-brand-600 font-bold text-base sm:text-lg">₦{{ number_format($product->sale_price, 2) }}</span>
                    <span class="text-gray-400 line-through text-xs sm:text-sm ml-1">₦{{ number_format($product->price, 2) }}</span>
                @else
                    <span class="text-gray-900 font-bold text-base sm:text-lg">₦{{ number_format($product->price, 2) }}</span>
                @endif
            </div>
            @if($product->stock > 0)
                <span class="text-[10px] text-green-600 font-medium bg-green-50 px-2 py-1 rounded-full">In Stock</span>
            @else
                <span class="text-[10px] text-red-600 font-medium bg-red-50 px-2 py-1 rounded-full">Sold Out</span>
            @endif
        </div>

        <!-- Add to Cart Button - Always visible -->
        <form method="POST" action="{{ route('cart.add', $product) }}" x-data="{ loading: false }" @submit="loading = true">
            @csrf
            <button type="submit"
                    :class="loading ? 'opacity-75 cursor-wait' : ''"
                    class="w-full bg-gray-900 hover:bg-brand-600 text-white py-2.5 rounded-xl font-semibold text-sm flex items-center justify-center space-x-2 transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5"
                    {{ $product->stock <= 0 ? 'disabled' : '' }}>
                <template x-if="!loading">
                    <span class="flex items-center space-x-2">
                        <i class="fas fa-shopping-bag text-xs"></i>
                        <span>Add to Cart</span>
                    </span>
                </template>
                <template x-if="loading">
                    <span class="flex items-center space-x-2">
                        <i class="fas fa-spinner fa-spin text-xs"></i>
                        <span>Adding...</span>
                    </span>
                </template>
            </button>
        </form>
    </div>
</div>
