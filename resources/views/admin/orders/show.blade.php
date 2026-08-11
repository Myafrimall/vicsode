@extends('layouts.admin')

@section('title', 'Order ' . $order->order_number . ' - Admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.orders.index') }}" class="text-purple-600 hover:text-purple-700 font-medium text-sm">
        <i class="fas fa-arrow-left mr-1"></i> Back to Orders
    </a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Order {{ $order->order_number }}</h1>
    <p class="text-gray-500">Placed on {{ $order->created_at->format('d M Y \a\t H:i') }}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Order Items -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Items</h3>
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                                @if($item->product && $item->product->images->count() > 0)
                                    <img src="{{ asset($item->product->images->first()->image_path) }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-blender text-gray-400 text-xs"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $item->product_name }}</p>
                                <p class="text-sm text-gray-500">₦{{ number_format($item->price, 2) }} × {{ $item->quantity }}</p>
                            </div>
                        </div>
                        <p class="font-bold text-gray-800">₦{{ number_format($item->total, 2) }}</p>
                    </div>
                @endforeach
            </div>

            <div class="border-t mt-6 pt-4 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Subtotal</span>
                    <span class="font-medium">₦{{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Delivery Fee</span>
                    <span class="font-medium">₦{{ number_format($order->delivery_fee, 2) }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold border-t pt-2">
                    <span>Total</span>
                    <span class="text-purple-600">₦{{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Delivery Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Delivery Details</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Address</p>
                    <p class="font-medium text-gray-800">{{ $order->delivery_address }}</p>
                </div>
                <div>
                    <p class="text-gray-500">City</p>
                    <p class="font-medium text-gray-800">{{ $order->delivery_city }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Province</p>
                    <p class="font-medium text-gray-800">{{ $order->delivery_state ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Postal Code</p>
                    <p class="font-medium text-gray-800">{{ $order->delivery_zip }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Country</p>
                    <p class="font-medium text-gray-800">{{ $order->delivery_country }}</p>
                </div>
                @if($order->delivery_notes)
                    <div class="col-span-2">
                        <p class="text-gray-500">Notes</p>
                        <p class="font-medium text-gray-800">{{ $order->delivery_notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Customer Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Customer</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-gray-500">Name</p>
                    <p class="font-medium text-gray-800">{{ $order->customer_name }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Email</p>
                    <p class="font-medium text-gray-800">{{ $order->customer_email }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Phone</p>
                    <p class="font-medium text-gray-800">{{ $order->customer_phone }}</p>
                </div>
            </div>
        </div>

        <!-- Order Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Status</h3>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                @csrf
                @method('PATCH')
                <select name="status" onchange="this.form.submit()"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </form>
        </div>

        <!-- Payment Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment</h3>
            <div class="space-y-3 text-sm mb-4">
                <div>
                    <p class="text-gray-500">Method</p>
                    <p class="font-medium text-gray-800 capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Reference</p>
                    <p class="font-medium text-gray-800 font-mono text-xs break-all">{{ $order->payment_reference ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Status</p>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                        {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $order->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $order->payment_status === 'failed' ? 'bg-red-100 text-red-700' : '' }}
                        {{ $order->payment_status === 'refunded' ? 'bg-blue-100 text-blue-700' : '' }}">
                        <i class="fas fa-circle text-[6px] mr-1.5"></i>
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.orders.payment', $order) }}">
                @csrf
                @method('PATCH')
                <label class="block text-xs text-gray-500 mb-1">Update Payment Status</label>
                <select name="payment_status" onchange="this.form.submit()"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none">
                    <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </form>
        </div>

        <!-- Review Link -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Review</h3>
            @if($order->review_token)
                @if($order->review)
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $order->review->is_approved ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                <i class="fas fa-{{ $order->review->is_approved ? 'check-circle' : 'clock' }} mr-1"></i>
                                {{ $order->review->is_approved ? 'Approved' : 'Pending Approval' }}
                            </span>
                        </div>
                        <div class="flex items-center text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $order->review->rating)
                                    <i class="fas fa-star text-sm"></i>
                                @else
                                    <i class="far fa-star text-gray-200 text-sm"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="text-gray-600 text-sm italic">"{{ Str::limit($order->review->review, 100) }}"</p>
                    </div>
                @else
                    <div class="space-y-3 text-sm">
                        <p class="text-gray-500">Review link sent to customer:</p>
                        <div x-data="{ copied: false }" class="relative">
                            <input type="text" readonly value="{{ route('review.show', $order->review_token) }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs font-mono bg-gray-50 pr-16">
                            <button @click="navigator.clipboard.writeText('{{ route('review.show', $order->review_token) }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 px-2 py-1 bg-gray-200 hover:bg-gray-300 rounded text-xs font-medium transition"
                                    x-text="copied ? 'Copied!' : 'Copy'">
                                Copy
                            </button>
                        </div>
                        <p class="text-xs text-gray-400"><i class="fas fa-info-circle mr-1"></i> Customer hasn't reviewed yet.</p>
                    </div>
                @endif
            @else
                <p class="text-sm text-gray-500">Review link will be generated when the order is marked as delivered.</p>
            @endif
        </div>
    </div>
</div>
@endsection
