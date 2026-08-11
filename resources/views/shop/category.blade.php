@extends('layouts.app')

@section('title', $category->name . ' - Vicsode')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('shop.index') }}" class="hover:text-brand-600 transition">Shop</a></li>
            <li><i class="fas fa-chevron-right text-[10px] text-gray-300"></i></li>
            <li class="text-gray-800 font-medium">{{ $category->name }}</li>
        </ol>
    </nav>

    <!-- Category Header -->
    <div class="mb-12">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $category->name }}</h1>
        <p class="text-gray-500 mt-2">{{ $products->total() }} {{ $products->total() === 1 ? 'product' : 'products' }} found</p>
    </div>

    <!-- Category Tabs -->
    <div class="flex flex-wrap gap-3 mb-10">
        <a href="{{ route('shop.index') }}#products"
           class="px-5 py-2.5 rounded-full text-sm font-medium border border-gray-200 text-gray-600 hover:border-brand-500 hover:text-brand-600 transition">
            All Products
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('shop.category', $cat) }}"
               class="px-5 py-2.5 rounded-full text-sm font-medium transition
                   {{ $cat->id === $category->id ? 'bg-brand-600 text-white border border-brand-600' : 'border border-gray-200 text-gray-600 hover:border-brand-500 hover:text-brand-600' }}">
                {{ $cat->name }} <span class="text-xs opacity-75">({{ $cat->active_products_count }})</span>
            </a>
        @endforeach
    </div>

    <!-- Products -->
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($products as $product)
                @include('shop.partials.product-card', ['product' => $product])
            @endforeach
        </div>

        <div class="mt-12">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-20 bg-gray-50 rounded-2xl">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-blender text-gray-300 text-4xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">No Products in This Category</h3>
            <p class="text-gray-500 mb-6">Check back soon or browse other categories.</p>
            <a href="{{ route('shop.index') }}" class="btn-brand text-white px-6 py-3 rounded-xl font-semibold inline-flex items-center space-x-2">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Shop</span>
            </a>
        </div>
    @endif
</div>
@endsection
