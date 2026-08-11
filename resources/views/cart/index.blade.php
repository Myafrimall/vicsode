@extends('layouts.app')

@section('title', 'Shopping Cart - Vicsode')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Shopping Cart</h1>
    <p class="text-gray-500 mb-8">{{ count($cartItems) }} {{ count($cartItems) === 1 ? 'item' : 'items' }} in your cart</p>

    @if(count($cartItems) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                    <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-5 shadow-sm hover:shadow-md transition">
                        <div class="flex items-start gap-3 sm:gap-5">
                            <!-- Product Image -->
                            <a href="{{ route('shop.show', $item['product']) }}" class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-50 rounded-xl overflow-hidden flex-shrink-0 border border-gray-100">
                                @if($item['product']->images->count() > 0)
                                    <img src="{{ asset($item['product']->images->first()->image_path) }}"
                                         alt="{{ $item['product']->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-blender text-gray-200 text-2xl"></i>
                                    </div>
                                @endif
                            </a>

                            <!-- Product Info -->
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('shop.show', $item['product']) }}" class="font-semibold text-gray-900 hover:text-brand-600 transition text-sm line-clamp-2">
                                    {{ $item['product']->name }}
                                </a>
                                @if($item['product']->brand)
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $item['product']->brand }}</p>
                                @endif
                                <p class="text-brand-600 font-bold mt-1 text-sm">₦{{ number_format($item['product']->display_price, 2) }}</p>

                                <!-- Mobile: Quantity + Total + Remove inline -->
                                <div class="flex items-center justify-between mt-3">
                                    <!-- Quantity Controls -->
                                    <div class="flex items-center gap-2">
                                        <form method="POST" action="{{ route('cart.update', $item['product']) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="quantity" value="{{ $item['quantity'] - 1 }}">
                                            <button type="submit" class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-gray-200 transition text-xs">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </form>

                                        <span class="w-6 text-center font-bold text-gray-900 text-sm">{{ $item['quantity'] }}</span>

                                        <form method="POST" action="{{ route('cart.update', $item['product']) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                            <button type="submit" class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-gray-200 transition text-xs">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Total -->
                                    <p class="font-bold text-gray-900 text-sm">₦{{ number_format($item['total'], 2) }}</p>

                                    <!-- Remove -->
                                    <form method="POST" action="{{ route('cart.remove', $item['product']) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg hover:bg-red-50 flex items-center justify-center text-gray-400 hover:text-red-500 transition">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-gray-50 rounded-2xl p-6 sticky top-24 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Order Summary</h3>

                    <div class="space-y-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Subtotal</span>
                            <span class="font-semibold text-gray-900">₦{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Delivery</span>
                            <span class="font-semibold text-gray-900">₦{{ number_format($deliveryFee, 2) }}</span>
                        </div>
                        <div class="border-t border-gray-200 pt-4 flex justify-between">
                            <span class="font-bold text-gray-900 text-lg">Total</span>
                            <span class="font-bold text-brand-600 text-xl">₦{{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}"
                       class="mt-6 w-full btn-brand text-white py-4 rounded-xl font-bold flex items-center justify-center space-x-2 block text-center shadow-lg shadow-brand-600/20">
                        <i class="fas fa-lock text-sm"></i>
                        <span>Proceed to Checkout</span>
                    </a>

                    <a href="{{ route('shop.index') }}" class="mt-4 block text-center text-gray-500 hover:text-brand-600 font-medium text-sm transition">
                        <i class="fas fa-arrow-left mr-1"></i> Continue Shopping
                    </a>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-center space-x-3 text-gray-400">
                            <i class="fab fa-cc-visa text-xl"></i>
                            <i class="fab fa-cc-mastercard text-xl"></i>
                            <i class="fab fa-cc-amex text-xl"></i>
                            <i class="fas fa-lock text-sm"></i>
                        </div>
                        <p class="text-xs text-gray-400 text-center mt-2">Secure checkout</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-24">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-shopping-bag text-gray-300 text-4xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Your cart is empty</h2>
            <p class="text-gray-500 mb-8">Looks like you haven't added any blenders to your cart yet.</p>
            <a href="{{ route('shop.index') }}" class="btn-brand text-white px-8 py-3.5 rounded-xl font-semibold inline-flex items-center space-x-2 shadow-lg">
                <i class="fas fa-arrow-left"></i>
                <span>Start Shopping</span>
            </a>
        </div>
    @endif
</div>
@endsection
