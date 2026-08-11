@extends('layouts.admin')

@section('title', 'Edit Product - Admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.products.index') }}" class="text-purple-600 hover:text-purple-700 font-medium text-sm">
        <i class="fas fa-arrow-left mr-1"></i> Back to Products
    </a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Edit Product: {{ $product->name }}</h1>
</div>

<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="max-w-4xl">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Information</h3>

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                        <textarea id="description" name="description" rows="5" required
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none">{{ old('description', $product->description) }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (₦) *</label>
                            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none">
                            @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-1">Sale Price (₦)</label>
                            <input type="number" id="sale_price" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" step="0.01" min="0"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none">
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
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                        <input type="text" id="brand" name="brand" value="{{ old('brand', $product->brand) }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none">
                    </div>
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock *</label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none">
                    </div>
                    <div>
                        <label for="power" class="block text-sm font-medium text-gray-700 mb-1">Power</label>
                        <input type="text" id="power" name="power" value="{{ old('power', $product->power) }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none">
                    </div>
                    <div>
                        <label for="capacity" class="block text-sm font-medium text-gray-700 mb-1">Capacity</label>
                        <input type="text" id="capacity" name="capacity" value="{{ old('capacity', $product->capacity) }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none">
                    </div>
                </div>
            </div>

            <!-- Current Images -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Current Images</h3>

                @if($product->images->count() > 0)
                    <div class="grid grid-cols-4 gap-3 mb-6">
                        @foreach($product->images as $image)
                            <div class="relative aspect-square rounded-lg overflow-hidden bg-gray-100 group">
                                <img src="{{ asset($image->image_path) }}" class="w-full h-full object-cover">
                                @if($image->is_primary)
                                    <span class="absolute top-1 left-1 bg-purple-600 text-white text-xs px-2 py-0.5 rounded">Primary</span>
                                @endif
                                <form method="POST" action="{{ route('admin.products.image.delete', $image) }}"
                                      class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition"
                                      onsubmit="return confirm('Delete this image?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs hover:bg-red-600">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm mb-4">No images uploaded yet.</p>
                @endif

                <h4 class="text-sm font-medium text-gray-700 mb-2">Add More Images</h4>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-purple-400 transition relative">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                    <p class="text-gray-600 font-medium text-sm">Drop images here or click to upload</p>
                    <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp"
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                           onchange="previewImages(this)">
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
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-700">Active (visible in shop)</span>
                    </label>

                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-700">Featured product</span>
                    </label>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-3">
                <button type="submit"
                        class="w-full bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
                    <i class="fas fa-save mr-2"></i>Update Product
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
                div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                preview.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }
}
</script>
@endsection
