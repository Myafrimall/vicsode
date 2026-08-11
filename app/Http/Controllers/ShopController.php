<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount('activeProducts')
            ->orderBy('sort_order')
            ->get();

        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->with('images')
            ->latest()
            ->take(4)
            ->get();

        $products = Product::where('is_active', true)
            ->with('images')
            ->latest()
            ->paginate(12);

        $reviews = \App\Models\Review::where('is_approved', true)
            ->latest()
            ->take(6)
            ->get();

        return view('shop.index', compact('categories', 'featuredProducts', 'products', 'reviews'));
    }

    public function category(Category $category)
    {
        $categories = Category::where('is_active', true)
            ->withCount('activeProducts')
            ->orderBy('sort_order')
            ->get();

        $products = Product::where('is_active', true)
            ->where('category_id', $category->id)
            ->with('images')
            ->latest()
            ->paginate(12);

        return view('shop.category', compact('category', 'categories', 'products'));
    }

    public function show(Product $product)
    {
        $product->load('images', 'category');
        $relatedProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->when($product->category_id, function ($query) use ($product) {
                $query->where('category_id', $product->category_id);
            })
            ->with('images')
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('shop.show', compact('product', 'relatedProducts'));
    }
}
