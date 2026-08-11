<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ReviewRequestMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'review');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        // Generate review token and send review request email when order is delivered
        if ($validated['status'] === 'delivered' && !$order->review_token) {
            $order->update(['review_token' => Str::random(64)]);
            $order->refresh();

            // Send review request email
            try {
                Mail::to($order->customer_email)->send(new ReviewRequestMail($order));
            } catch (\Exception $e) {
                // Log error but don't block the status update
                \Log::error('Failed to send review email: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Order status updated!');
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        $order->update(['payment_status' => $validated['payment_status']]);

        return redirect()->back()->with('success', 'Payment status updated!');
    }
}
