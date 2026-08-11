@extends('layouts.app')

@section('title', 'Leave a Review - Vicsode')

@section('content')
<section class="py-12 bg-gray-50 min-h-[80vh]">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-brand-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-star text-brand-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">How was your experience?</h1>
            <p class="text-gray-500 mt-2">We'd love to hear your feedback on your recent order.</p>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Order {{ $order->order_number }}</h3>
            <div class="space-y-3">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                @if($item->product && $item->product->images->count() > 0)
                                    <img src="{{ asset($item->product->images->first()->image_path) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-blender text-gray-300 text-xs"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $item->product_name }}</p>
                                <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                            </div>
                        </div>
                        <p class="text-sm font-semibold text-gray-700">₦{{ number_format($item->total, 2) }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Review Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <form method="POST" action="{{ route('review.store', $token) }}" x-data="{ rating: 0, hoverRating: 0 }">
                @csrf

                <!-- Star Rating -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Your Rating</label>
                    <div class="flex items-center space-x-1">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button"
                                    @click="rating = {{ $i }}"
                                    @mouseenter="hoverRating = {{ $i }}"
                                    @mouseleave="hoverRating = 0"
                                    class="text-3xl transition-transform hover:scale-110 focus:outline-none"
                                    :class="(hoverRating >= {{ $i }} || (!hoverRating && rating >= {{ $i }})) ? 'text-yellow-400' : 'text-gray-200'">
                                <i class="fas fa-star"></i>
                            </button>
                        @endfor
                        <span class="ml-3 text-sm text-gray-500" x-show="rating > 0">
                            <span x-text="rating"></span>/5
                        </span>
                    </div>
                    <input type="hidden" name="rating" :value="rating">
                    @error('rating')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Review Text -->
                <div class="mb-6">
                    <label for="review" class="block text-sm font-semibold text-gray-700 mb-2">Your Review</label>
                    <textarea name="review" id="review" rows="5"
                              class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none resize-none transition"
                              placeholder="Tell us about your experience with the product. What did you love? How has it helped you?"
                    >{{ old('review') }}</textarea>
                    @error('review')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- City -->
                <div class="mb-8">
                    <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">Your City <span class="font-normal text-gray-400">(optional)</span></label>
                    <input type="text" name="city" id="city"
                           value="{{ old('city', $order->delivery_city) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition"
                           placeholder="e.g. Lagos">
                    @error('city')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit"
                        class="w-full btn-brand text-white px-6 py-4 rounded-xl font-semibold text-lg shadow-lg shadow-brand-600/30 hover:shadow-brand-600/50 transition">
                    <i class="fas fa-paper-plane mr-2"></i> Submit Review
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
