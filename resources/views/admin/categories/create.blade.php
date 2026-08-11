@extends('layouts.admin')

@section('title', 'Add Category - Admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.categories.index') }}" class="text-brand-600 hover:text-brand-700 font-medium text-sm">
        <i class="fas fa-arrow-left mr-1"></i> Back to Categories
    </a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Add New Category</h1>
</div>

<form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="max-w-2xl">
    @csrf

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-5">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category Name *</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none"
                   placeholder="e.g., Blenders, Food Processors, Juicers">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Category Image</label>
            <p class="text-xs text-gray-500 mb-2">This image will be displayed on the category card. Use a clear product photo.</p>
            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-brand-400 transition relative">
                <i class="fas fa-image text-3xl text-gray-400 mb-2"></i>
                <p class="text-sm text-gray-600 font-medium">Click to upload image</p>
                <p class="text-xs text-gray-400 mt-1">JPG, PNG, or WebP (max 2MB)</p>
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                       onchange="document.getElementById('preview').src = URL.createObjectURL(this.files[0]); document.getElementById('preview').classList.remove('hidden');">
            </div>
            <img id="preview" class="hidden mt-3 w-32 h-32 object-cover rounded-xl">
            @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none">
            </div>
            <div class="flex items-end">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                    <span class="ml-2 text-sm text-gray-700">Active (visible on site)</span>
                </label>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-brand-600 text-white px-8 py-3 rounded-lg hover:bg-brand-700 transition font-semibold">
                <i class="fas fa-save mr-2"></i>Create Category
            </button>
        </div>
    </div>
</form>
@endsection
