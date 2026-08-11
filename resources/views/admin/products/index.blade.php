@extends('layouts.admin')

@section('title', 'Products - Admin')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Products</h1>
        <p class="text-gray-500">Manage your blender inventory</p>
    </div>
    <a href="{{ route('admin.products.create') }}"
       class="bg-purple-600 text-white px-6 py-2.5 rounded-lg hover:bg-purple-700 transition font-medium flex items-center space-x-2">
        <i class="fas fa-plus"></i>
        <span>Add Product</span>
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Product</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Price</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Stock</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                @if($product->images->count() > 0)
                                    <img src="{{ asset($product->images->first()->image_path) }}"
                                         alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-blender text-gray-300"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $product->name }}</p>
                                <p class="text-sm text-gray-500">{{ $product->brand ?? 'No brand' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800">₦{{ number_format($product->price, 2) }}</p>
                        @if($product->sale_price)
                            <p class="text-sm text-red-600">Sale: ₦{{ number_format($product->sale_price, 2) }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $product->stock > 10 ? 'bg-green-100 text-green-700' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                            {{ $product->stock }} units
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($product->is_active)
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Active</span>
                        @else
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">Inactive</span>
                        @endif
                        @if($product->is_featured)
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700 ml-1">Featured</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                  onsubmit="return confirm('Are you sure you want to delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-box-open text-4xl mb-3 block text-gray-300"></i>
                        No products yet. <a href="{{ route('admin.products.create') }}" class="text-purple-600 hover:underline">Add your first product</a>.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $products->links() }}
</div>
@endsection
