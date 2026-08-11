<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function show($token)
    {
        $order = Order::where('review_token', $token)
            ->with('items.product')
            ->firstOrFail();

        // Check if review already exists for this order
        $existingReview = Review::where('order_id', $order->id)->first();

        if ($existingReview) {
            return redirect()->route('review.success', $token);
        }

        return view('reviews.show', compact('order', 'token'));
    }

    public function store(Request $request, $token)
    {
        $order = Order::where('review_token', $token)->firstOrFail();

        // Check if review already exists
        $existingReview = Review::where('order_id', $order->id)->first();

        if ($existingReview) {
            return redirect()->route('review.success', $token);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10',
            'city' => 'nullable|string|max:255',
        ]);

        Review::create([
            'order_id' => $order->id,
            'customer_name' => $order->customer_name,
            'customer_email' => $order->customer_email,
            'city' => $validated['city'] ?? $order->delivery_city,
            'rating' => $validated['rating'],
            'review' => $validated['review'],
            'is_approved' => false,
            'review_token' => $token,
        ]);

        return redirect()->route('review.success', $token);
    }

    public function success($token)
    {
        return view('reviews.success');
    }
}
