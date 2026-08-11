@extends('layouts.app')

@section('title', 'Order Confirmed - Vicsode')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Progress Steps -->
    <div class="flex items-center justify-center mb-12">
        <div class="flex items-center space-x-4 text-sm">
            <span class="flex items-center text-gray-400">
                <span class="w-7 h-7 rounded-full bg-green-500 text-white flex items-center justify-center text-xs mr-2"><i class="fas fa-check"></i></span>
                Cart
            </span>
            <span class="w-8 h-px bg-green-400"></span>
            <span class="flex items-center text-gray-400">
                <span class="w-7 h-7 rounded-full bg-green-500 text-white flex items-center justify-center text-xs mr-2"><i class="fas fa-check"></i></span>
                Checkout
            </span>
            <span class="w-8 h-px bg-green-400"></span>
            <span class="flex items-center text-green-600 font-semibold">
                <span class="w-7 h-7 rounded-full bg-green-500 text-white flex items-center justify-center text-xs mr-2"><i class="fas fa-check"></i></span>
                Confirmed
            </span>
        </div>
    </div>

    <div class="text-center mb-10">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-green-100">
            <i class="fas fa-check text-green-600 text-3xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Confirmed!</h1>
        <p class="text-gray-500 text-lg">Thank you for your purchase. Your order has been received.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Order Header -->
        <div class="bg-gray-50 px-8 py-5 border-b border-gray-100">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Order Number</p>
                    <p class="font-bold text-gray-900 mt-1">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Date</p>
                    <p class="font-medium text-gray-900 mt-1">{{ $order->created_at->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Payment</p>
                    <p class="font-medium text-gray-900 mt-1 capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Total</p>
                    <p class="font-bold text-brand-600 mt-1 text-lg">₦{{ number_format($order->total, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Items -->
        <div class="px-8 py-6">
            <h3 class="font-semibold text-gray-900 mb-4 text-sm uppercase tracking-wider">Items Ordered</h3>
            <div class="space-y-3">
                @foreach($order->items as $item)
                    <div class="flex justify-between items-center py-3 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                        <div>
                            <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
                            <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} × ₦{{ number_format($item->price, 2) }}</p>
                        </div>
                        <p class="font-bold text-gray-900">₦{{ number_format($item->total, 2) }}</p>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-gray-100 mt-4 pt-4 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Subtotal</span>
                    <span class="font-medium">₦{{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Delivery</span>
                    <span class="font-medium">₦{{ number_format($order->delivery_fee, 2) }}</span>
                </div>
                <div class="flex justify-between font-bold text-lg border-t pt-2">
                    <span>Total</span>
                    <span class="text-brand-600">₦{{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Delivery Info -->
        <div class="bg-gray-50 px-8 py-6 border-t border-gray-100">
            <h3 class="font-semibold text-gray-900 mb-3 text-sm uppercase tracking-wider">Delivering To</h3>
            <p class="text-gray-600 leading-relaxed">
                {{ $order->customer_name }}<br>
                {{ $order->delivery_address }}<br>
                {{ $order->delivery_city }}{{ $order->delivery_state ? ', ' . $order->delivery_state : '' }} {{ $order->delivery_zip }}<br>
                {{ $order->delivery_country }}
            </p>
        </div>
    </div>

    <div class="text-center mt-10">
        <a href="{{ route('shop.index') }}" class="btn-brand text-white px-10 py-4 rounded-xl font-semibold inline-flex items-center space-x-2 shadow-lg shadow-brand-600/20">
            <span>Continue Shopping</span>
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</div>
@endsection
