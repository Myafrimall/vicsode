<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('images')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'brand' => 'nullable|string|max:255',
            'power' => 'nullable|string|max:255',
            'capacity' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'images' => 'required|array|min:3|max:6',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $product = Product::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'sale_price' => $validated['sale_price'],
            'stock' => $validated['stock'],
            'brand' => $validated['brand'],
            'power' => $validated['power'],
            'capacity' => $validated['capacity'],
            'category_id' => $validated['category_id'],
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active', true),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $fileName = uploadFile(
                    $image,
                    ['jpeg', 'jpg', 'png', 'webp'],
                    'uploads/products',
                    10 * 1024 * 1024 // 10MB
                );
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'uploads/products/' . $fileName,
                    'sort_order' => $index,
                    'is_primary' => $index === 0,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $product->load('images');
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'brand' => 'nullable|string|max:255',
            'power' => 'nullable|string|max:255',
            'capacity' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'images' => 'nullable|array|max:6',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $product->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'sale_price' => $validated['sale_price'],
            'stock' => $validated['stock'],
            'brand' => $validated['brand'],
            'power' => $validated['power'],
            'capacity' => $validated['capacity'],
            'category_id' => $validated['category_id'],
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active', true),
        ]);

        if ($request->hasFile('images')) {
            $currentCount = $product->images()->count();
            foreach ($request->file('images') as $index => $image) {
                $fileName = uploadFile(
                    $image,
                    ['jpeg', 'jpg', 'png', 'webp'],
                    'uploads/products',
                    10 * 1024 * 1024 // 10MB
                );
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'uploads/products/' . $fileName,
                    'sort_order' => $currentCount + $index,
                    'is_primary' => $currentCount === 0 && $index === 0,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Delete images from public folder
        foreach ($product->images as $image) {
            deleteExistFile('', $image->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    public function deleteImage(ProductImage $image)
    {
        deleteExistFile('', $image->image_path);
        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully!');
    }
}
