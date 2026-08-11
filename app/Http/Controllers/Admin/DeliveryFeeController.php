<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryFee;
use Illuminate\Http\Request;

class DeliveryFeeController extends Controller
{
    public function index()
    {
        $deliveryFees = DeliveryFee::orderBy('state')->get();
        return view('admin.delivery-fees.index', compact('deliveryFees'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'fees' => 'required|array',
            'fees.*.fee' => 'required|numeric|min:0',
            'fees.*.is_active' => 'nullable|boolean',
        ]);

        foreach ($validated['fees'] as $id => $data) {
            DeliveryFee::where('id', $id)->update([
                'fee' => $data['fee'],
                'is_active' => isset($data['is_active']) ? true : false,
            ]);
        }

        return redirect()->back()->with('success', 'Delivery fees updated successfully!');
    }
}
