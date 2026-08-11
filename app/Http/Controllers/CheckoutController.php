<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }

        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $id => $item) {
            $product = Product::with('images')->find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'total' => $product->display_price * $item['quantity'],
                ];
                $subtotal += $product->display_price * $item['quantity'];
            }
        }

        $deliveryFees = \App\Models\DeliveryFee::where('is_active', true)->pluck('fee', 'state');
        $deliveryFee = 0; // Will be set by user selecting state
        $total = $subtotal; // Initially just subtotal
        $paystackPublicKey = config('services.paystack.public_key');

        return view('checkout.index', compact('cartItems', 'subtotal', 'deliveryFee', 'total', 'paystackPublicKey', 'deliveryFees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'delivery_address' => 'required|string|max:255',
            'delivery_city' => 'required|string|max:255',
            'delivery_state' => 'nullable|string|max:255',
            'delivery_zip' => 'required|string|max:20',
            'delivery_country' => 'required|string|max:255',
            'delivery_notes' => 'nullable|string|max:500',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }

        $subtotal = 0;
        $orderItems = [];

        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $itemTotal = $product->display_price * $item['quantity'];
                $subtotal += $itemTotal;
                $orderItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->display_price,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal,
                ];
            }
        }

        $deliveryFee = \App\Models\DeliveryFee::getFeeForState($validated['delivery_state'] ?? '');
        $total = $subtotal + $deliveryFee;

        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'status' => 'pending',
            'subtotal' => $subtotal,
            'delivery_fee' => $deliveryFee,
            'total' => $total,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'delivery_address' => $validated['delivery_address'],
            'delivery_city' => $validated['delivery_city'],
            'delivery_state' => $validated['delivery_state'],
            'delivery_zip' => $validated['delivery_zip'],
            'delivery_country' => $validated['delivery_country'],
            'delivery_notes' => $validated['delivery_notes'],
            'payment_method' => 'paystack',
            'payment_status' => 'pending',
        ]);

        foreach ($orderItems as $item) {
            $order->items()->create($item);
        }

        // Initialize Paystack transaction
        $response = Http::withToken(config('services.paystack.secret_key'))
            ->post(config('services.paystack.payment_url') . '/transaction/initialize', [
                'email' => $validated['customer_email'],
                'amount' => (int) round($total * 100), // Paystack expects amount in kobo
                'reference' => $order->order_number,
                'callback_url' => route('checkout.paystack.callback'),
                'metadata' => [
                    'order_id' => $order->id,
                    'customer_name' => $validated['customer_name'],
                ],
            ]);

        if ($response->successful() && $response->json('status')) {
            $order->update(['payment_reference' => $order->order_number]);

            // Clear the cart
            session()->forget('cart');

            // Redirect to Paystack payment page
            return redirect($response->json('data.authorization_url'));
        }

        // If Paystack initialization fails, delete the order and show error
        $order->items()->delete();
        $order->delete();

        Log::error('Paystack initialization failed', ['response' => $response->json()]);

        return redirect()->back()->with('error', 'Unable to initialize payment. Please try again.');
    }

    public function paystackCallback(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return redirect()->route('shop.index')->with('error', 'Invalid payment reference.');
        }

        // Verify the transaction
        $response = Http::withToken(config('services.paystack.secret_key'))
            ->get(config('services.paystack.payment_url') . '/transaction/verify/' . $reference);

        if ($response->successful() && $response->json('data.status') === 'success') {
            $order = Order::where('order_number', $reference)->first();

            if ($order) {
                $order->update([
                    'payment_status' => 'paid',
                    'payment_reference' => $response->json('data.reference'),
                ]);

                return redirect()->route('checkout.success', $order)->with('success', 'Payment successful! Your order has been confirmed.');
            }
        }

        // Payment failed or couldn't verify
        $order = Order::where('order_number', $reference)->first();
        if ($order) {
            $order->update(['payment_status' => 'failed']);
        }

        return redirect()->route('shop.index')->with('error', 'Payment could not be verified. Please contact support if you were charged.');
    }

    public function success(Order $order)
    {
        $order->load('items');
        return view('checkout.success', compact('order'));
    }
}
