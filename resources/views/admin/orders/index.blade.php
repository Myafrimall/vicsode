@extends('layouts.admin')

@section('title', 'Orders - Admin')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Orders</h1>
    <p class="text-gray-500">Manage customer orders</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Order</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Customer</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Total</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Payment</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800">{{ $order->order_number }}</p>
                        <p class="text-xs text-gray-500">{{ $order->items->count() }} items</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800">{{ $order->customer_name }}</p>
                        <p class="text-xs text-gray-500">{{ $order->customer_email }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-800">₦{{ number_format($order->total, 2) }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $order->status === 'shipped' ? 'bg-purple-100 text-purple-700' : '' }}
                            {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                        ">{{ ucfirst($order->status) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $order->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $order->payment_status === 'failed' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $order->payment_status === 'refunded' ? 'bg-gray-100 text-gray-700' : '' }}
                        ">{{ ucfirst($order->payment_status) }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $order->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.orders.show', $order) }}"
                           class="text-purple-600 hover:text-purple-800 font-medium text-sm">
                            View <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-shopping-bag text-4xl mb-3 block text-gray-300"></i>
                        No orders yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $orders->links() }}
</div>
@endsection
