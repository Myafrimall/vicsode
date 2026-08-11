@extends('layouts.admin')

@section('title', 'Admin Dashboard - Vicsode')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-500">Welcome back! Here's an overview of your store.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Products</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalProducts }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-box text-purple-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Orders</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalOrders }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-shopping-bag text-blue-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Revenue</p>
                <p class="text-3xl font-bold text-gray-800">₦{{ number_format($totalRevenue, 2) }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-dollar-sign text-green-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Pending Orders</p>
                <p class="text-3xl font-bold text-gray-800">{{ $pendingOrders }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>
        <div class="space-y-3">
            <a href="{{ route('admin.products.create') }}" class="flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                <i class="fas fa-plus-circle text-purple-600 mr-3"></i>
                <span class="font-medium text-gray-800">Add New Product</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                <i class="fas fa-list text-blue-600 mr-3"></i>
                <span class="font-medium text-gray-800">View All Orders</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition">
                <i class="fas fa-edit text-green-600 mr-3"></i>
                <span class="font-medium text-gray-800">Manage Products</span>
            </a>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Orders</h3>
        @if($recentOrders->count() > 0)
            <div class="space-y-3">
                @foreach($recentOrders as $order)
                    <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition">
                        <div>
                            <p class="font-medium text-gray-800">{{ $order->order_number }}</p>
                            <p class="text-sm text-gray-500">{{ $order->customer_name }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-gray-800">₦{{ number_format($order->total, 2) }}</p>
                            <span class="text-xs px-2 py-1 rounded-full
                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $order->status === 'shipped' ? 'bg-purple-100 text-purple-700' : '' }}
                                {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                            ">{{ ucfirst($order->status) }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No orders yet.</p>
        @endif
    </div>
</div>
@endsection
