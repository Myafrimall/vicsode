@extends('layouts.admin')

@section('title', 'Categories - Admin')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Categories</h1>
        <p class="text-gray-500">Manage product categories</p>
    </div>
    <a href="{{ route('admin.categories.create') }}"
       class="bg-brand-600 text-white px-6 py-2.5 rounded-lg hover:bg-brand-700 transition font-medium flex items-center space-x-2">
        <i class="fas fa-plus"></i>
        <span>Add Category</span>
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Category</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Products</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Order</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($categories as $category)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-14 h-14 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                                @if($category->image)
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-folder text-gray-300"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">{{ $category->name }}</p>
                                <p class="text-xs text-gray-400">/category/{{ $category->slug }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-gray-800 font-medium">{{ $category->products_count }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-gray-600">{{ $category->sort_order }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($category->is_active)
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Active</span>
                        @else
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('admin.categories.edit', $category) }}"
                               class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                  onsubmit="return confirm('Delete this category? Products won\'t be deleted.')">
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
                        <i class="fas fa-folder-open text-4xl mb-3 block text-gray-300"></i>
                        No categories yet. <a href="{{ route('admin.categories.create') }}" class="text-brand-600 hover:underline">Add your first category</a>.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
