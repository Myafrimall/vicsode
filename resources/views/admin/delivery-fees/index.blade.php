@extends('layouts.admin')

@section('title', 'Delivery Fees - Admin')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Delivery Fees</h1>
    <p class="text-gray-500">Set delivery fees per state. These fees will be charged at checkout.</p>
</div>

@if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('admin.delivery-fees.update') }}">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">State</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Delivery Fee (₦)</th>
                        <th class="text-center px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Active</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($deliveryFees as $fee)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-800">{{ $fee->state }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <input type="number" name="fees[{{ $fee->id }}][fee]" value="{{ $fee->fee }}" step="0.01" min="0"
                                       class="w-32 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none">
                            </td>
                            <td class="px-6 py-4 text-center">
                                <input type="checkbox" name="fees[{{ $fee->id }}][is_active]" value="1"
                                       {{ $fee->is_active ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        <button type="submit" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
            <i class="fas fa-save mr-2"></i>Save All Fees
        </button>
    </div>
</form>
@endsection
