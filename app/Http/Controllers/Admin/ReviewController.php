<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('order')->latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);
        return redirect()->back()->with('success', 'Review approved successfully!');
    }

    public function reject(Review $review)
    {
        $review->delete();
        return redirect()->back()->with('success', 'Review deleted successfully!');
    }
}
