@extends('layouts.admin')

@section('title', 'Add Product - Admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.products.index') }}" class="text-purple-600 hover:text-purple-700 font-medium text-sm">
        <i class="fas fa-arrow-left mr-1"></i> Back to Products
    </a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Add New Product</h1>
</div>

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="max-w-4xl">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Information</h3>

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none"
                               placeholder="e.g., NutriBullet Pro 1200W">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                        <textarea id="description" name="description" rows="5" required
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none"
                                  placeholder="Describe the blender's features, benefits, and what's included...">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (₦) *</label>
                            <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none"
                                   placeholder="1999.99">
                            @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-1">Sale Price (₦)</label>
                            <input type="number" id="sale_price" name="sale_price" value="{{ old('sale_price') }}" step="0.01" min="0"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none"
                                   placeholder="Leave empty if not on sale">
                            @error('sale_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Specifications -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Specifications</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select id="category_id" name="category_id"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none bg-white">
                            <option value="">No Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                        <input type="text" id="brand" name="brand" value="{{ old('brand') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none"
                               placeholder="e.g., NutriBullet">
                        @error('brand') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock *</label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}" min="0" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none">
                        @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="power" class="block text-sm font-medium text-gray-700 mb-1">Power</label>
                        <input type="text" id="power" name="power" value="{{ old('power') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none"
                               placeholder="e.g., 1200W">
                        @error('power') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="capacity" class="block text-sm font-medium text-gray-700 mb-1">Capacity</label>
                        <input type="text" id="capacity" name="capacity" value="{{ old('capacity') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none"
                               placeholder="e.g., 1.5L">
                        @error('capacity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Images -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Product Images</h3>
                <p class="text-sm text-gray-500 mb-4">Upload 3-6 images. First image will be the primary display image.</p>

                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-purple-400 transition relative" id="dropzone">
                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                    <p class="text-gray-600 font-medium">Drop images here or click to upload</p>
                    <p class="text-sm text-gray-400 mt-1">JPG, PNG, or WebP (max 2MB each)</p>
                    <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp"
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                           id="imageInput" onchange="previewImages(this)">
                </div>
                <div id="imagePreview" class="grid grid-cols-4 gap-3 mt-4"></div>
                @error('images') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                @error('images.*') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Settings</h3>

                <div class="space-y-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-700">Active (visible in shop)</span>
                    </label>

                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-700">Featured product</span>
                    </label>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <button type="submit"
                        class="w-full bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
                    <i class="fas fa-save mr-2"></i>Save Product
                </button>
            </div>
        </div>
    </div>
</form>

<script>
function previewImages(input) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';

    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative aspect-square rounded-lg overflow-hidden bg-gray-100';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover">
                    ${index === 0 ? '<span class="absolute top-1 left-1 bg-purple-600 text-white text-xs px-2 py-0.5 rounded">Primary</span>' : ''}
                `;
                preview.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }
}
</script>
@endsection
