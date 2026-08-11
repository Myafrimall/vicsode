@extends('layouts.app')

@section('title', 'Checkout - Vicsode')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Progress Steps -->
    <div class="flex items-center justify-center mb-12">
        <div class="flex items-center space-x-4 text-sm">
            <span class="flex items-center text-gray-400">
                <span class="w-7 h-7 rounded-full bg-green-500 text-white flex items-center justify-center text-xs mr-2"><i class="fas fa-check"></i></span>
                Cart
            </span>
            <span class="w-8 h-px bg-gray-300"></span>
            <span class="flex items-center text-brand-600 font-semibold">
                <span class="w-7 h-7 rounded-full bg-brand-600 text-white flex items-center justify-center text-xs mr-2">2</span>
                Checkout
            </span>
            <span class="w-8 h-px bg-gray-300"></span>
            <span class="flex items-center text-gray-400">
                <span class="w-7 h-7 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center text-xs mr-2">3</span>
                Confirmation
            </span>
        </div>
    </div>

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('checkout.store') }}"
          x-data="{
              selectedState: '{{ old('delivery_state', '') }}',
              deliveryFees: {{ $deliveryFees->toJson() }},
              subtotal: {{ $subtotal }},
              get deliveryFee() {
                  return parseFloat(this.deliveryFees[this.selectedState]) || 0;
              },
              get total() {
                  return this.subtotal + this.deliveryFee;
              },
              formatMoney(amount) {
                  return '₦' + Number(amount).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
              }
          }">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Forms -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Customer Information -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
                        <span class="w-8 h-8 bg-brand-100 text-brand-600 rounded-lg flex items-center justify-center mr-3 text-sm">
                            <i class="fas fa-user"></i>
                        </span>
                        Your Details
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1.5">Full Name *</label>
                            <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition"
                                   placeholder="John Doe">
                            @error('customer_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1.5">Email *</label>
                            <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition"
                                   placeholder="john@example.com">
                            @error('customer_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number *</label>
                            <input type="tel" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition"
                                   placeholder="+234 801 234 5678">
                            @error('customer_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Delivery Details -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
                        <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mr-3 text-sm">
                            <i class="fas fa-truck"></i>
                        </span>
                        Delivery Address
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-1.5">Street Address *</label>
                            <input type="text" id="delivery_address" name="delivery_address" value="{{ old('delivery_address') }}" required
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition"
                                   placeholder="123 Main Street, Apt 4B">
                            @error('delivery_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="delivery_city" class="block text-sm font-medium text-gray-700 mb-1.5">City *</label>
                            <input type="text" id="delivery_city" name="delivery_city" value="{{ old('delivery_city') }}" required
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition"
                                   placeholder="Lagos">
                            @error('delivery_city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="delivery_state" class="block text-sm font-medium text-gray-700 mb-1.5">State *</label>
                            <select id="delivery_state" name="delivery_state" x-model="selectedState"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition bg-white">
                                <option value="">Select State</option>
                                <option value="Abia" {{ old('delivery_state') == 'Abia' ? 'selected' : '' }}>Abia</option>
                                <option value="Adamawa" {{ old('delivery_state') == 'Adamawa' ? 'selected' : '' }}>Adamawa</option>
                                <option value="Akwa Ibom" {{ old('delivery_state') == 'Akwa Ibom' ? 'selected' : '' }}>Akwa Ibom</option>
                                <option value="Anambra" {{ old('delivery_state') == 'Anambra' ? 'selected' : '' }}>Anambra</option>
                                <option value="Bauchi" {{ old('delivery_state') == 'Bauchi' ? 'selected' : '' }}>Bauchi</option>
                                <option value="Bayelsa" {{ old('delivery_state') == 'Bayelsa' ? 'selected' : '' }}>Bayelsa</option>
                                <option value="Benue" {{ old('delivery_state') == 'Benue' ? 'selected' : '' }}>Benue</option>
                                <option value="Borno" {{ old('delivery_state') == 'Borno' ? 'selected' : '' }}>Borno</option>
                                <option value="Cross River" {{ old('delivery_state') == 'Cross River' ? 'selected' : '' }}>Cross River</option>
                                <option value="Delta" {{ old('delivery_state') == 'Delta' ? 'selected' : '' }}>Delta</option>
                                <option value="Ebonyi" {{ old('delivery_state') == 'Ebonyi' ? 'selected' : '' }}>Ebonyi</option>
                                <option value="Edo" {{ old('delivery_state') == 'Edo' ? 'selected' : '' }}>Edo</option>
                                <option value="Ekiti" {{ old('delivery_state') == 'Ekiti' ? 'selected' : '' }}>Ekiti</option>
                                <option value="Enugu" {{ old('delivery_state') == 'Enugu' ? 'selected' : '' }}>Enugu</option>
                                <option value="FCT" {{ old('delivery_state') == 'FCT' ? 'selected' : '' }}>FCT - Abuja</option>
                                <option value="Gombe" {{ old('delivery_state') == 'Gombe' ? 'selected' : '' }}>Gombe</option>
                                <option value="Imo" {{ old('delivery_state') == 'Imo' ? 'selected' : '' }}>Imo</option>
                                <option value="Jigawa" {{ old('delivery_state') == 'Jigawa' ? 'selected' : '' }}>Jigawa</option>
                                <option value="Kaduna" {{ old('delivery_state') == 'Kaduna' ? 'selected' : '' }}>Kaduna</option>
                                <option value="Kano" {{ old('delivery_state') == 'Kano' ? 'selected' : '' }}>Kano</option>
                                <option value="Katsina" {{ old('delivery_state') == 'Katsina' ? 'selected' : '' }}>Katsina</option>
                                <option value="Kebbi" {{ old('delivery_state') == 'Kebbi' ? 'selected' : '' }}>Kebbi</option>
                                <option value="Kogi" {{ old('delivery_state') == 'Kogi' ? 'selected' : '' }}>Kogi</option>
                                <option value="Kwara" {{ old('delivery_state') == 'Kwara' ? 'selected' : '' }}>Kwara</option>
                                <option value="Lagos" {{ old('delivery_state') == 'Lagos' ? 'selected' : '' }}>Lagos</option>
                                <option value="Nasarawa" {{ old('delivery_state') == 'Nasarawa' ? 'selected' : '' }}>Nasarawa</option>
                                <option value="Niger" {{ old('delivery_state') == 'Niger' ? 'selected' : '' }}>Niger</option>
                                <option value="Ogun" {{ old('delivery_state') == 'Ogun' ? 'selected' : '' }}>Ogun</option>
                                <option value="Ondo" {{ old('delivery_state') == 'Ondo' ? 'selected' : '' }}>Ondo</option>
                                <option value="Osun" {{ old('delivery_state') == 'Osun' ? 'selected' : '' }}>Osun</option>
                                <option value="Oyo" {{ old('delivery_state') == 'Oyo' ? 'selected' : '' }}>Oyo</option>
                                <option value="Plateau" {{ old('delivery_state') == 'Plateau' ? 'selected' : '' }}>Plateau</option>
                                <option value="Rivers" {{ old('delivery_state') == 'Rivers' ? 'selected' : '' }}>Rivers</option>
                                <option value="Sokoto" {{ old('delivery_state') == 'Sokoto' ? 'selected' : '' }}>Sokoto</option>
                                <option value="Taraba" {{ old('delivery_state') == 'Taraba' ? 'selected' : '' }}>Taraba</option>
                                <option value="Yobe" {{ old('delivery_state') == 'Yobe' ? 'selected' : '' }}>Yobe</option>
                                <option value="Zamfara" {{ old('delivery_state') == 'Zamfara' ? 'selected' : '' }}>Zamfara</option>
                            </select>
                            @error('delivery_state') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="delivery_zip" class="block text-sm font-medium text-gray-700 mb-1.5">Postal Code *</label>
                            <input type="text" id="delivery_zip" name="delivery_zip" value="{{ old('delivery_zip') }}" required
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition"
                                   placeholder="100001">
                            @error('delivery_zip') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="delivery_country" class="block text-sm font-medium text-gray-700 mb-1.5">Country *</label>
                            <input type="text" id="delivery_country" name="delivery_country" value="{{ old('delivery_country', 'Nigeria') }}" required readonly
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 outline-none">
                            @error('delivery_country') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="delivery_notes" class="block text-sm font-medium text-gray-700 mb-1.5">Delivery Notes <span class="text-gray-400">(optional)</span></label>
                            <textarea id="delivery_notes" name="delivery_notes" rows="3"
                                      class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition"
                                      placeholder="Gate code, building name, special instructions...">{{ old('delivery_notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
                        <span class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mr-3 text-sm">
                            <i class="fas fa-credit-card"></i>
                        </span>
                        Payment Method
                    </h3>
                    <div class="p-4 border-2 border-brand-500 bg-brand-50/50 rounded-xl">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-brand-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-lock text-brand-600"></i>
                            </div>
                            <div class="flex-1">
                                <span class="font-semibold text-gray-900 text-sm">Pay with Paystack</span>
                                <p class="text-xs text-gray-500 mt-0.5">Card, Bank Transfer, USSD, or Mobile Money</p>
                            </div>
                            <div class="flex space-x-2">
                                <i class="fab fa-cc-visa text-xl text-gray-400"></i>
                                <i class="fab fa-cc-mastercard text-xl text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-3 flex items-center">
                        <i class="fas fa-shield-halved mr-1.5 text-green-500"></i>
                        You will be redirected to Paystack's secure payment page to complete your order.
                    </p>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-gray-50 rounded-2xl p-6 sticky top-24 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-5">Order Summary</h3>

                    <div class="space-y-4 mb-6 max-h-64 overflow-y-auto">
                        @foreach($cartItems as $item)
                            <div class="flex items-center gap-3">
                                <div class="w-14 h-14 bg-white rounded-xl overflow-hidden flex-shrink-0 border border-gray-100">
                                    @if($item['product']->images->count() > 0)
                                        <img src="{{ asset($item['product']->images->first()->image_path) }}"
                                             alt="{{ $item['product']->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-blender text-gray-200 text-xs"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-gray-900 truncate">{{ $item['product']->name }}</p>
                                    <p class="text-xs text-gray-400">Qty: {{ $item['quantity'] }}</p>
                                </div>
                                <p class="text-sm font-bold text-gray-900">₦{{ number_format($item['total'], 2) }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-200 pt-4 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Subtotal</span>
                            <span class="font-semibold">₦{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Delivery</span>
                            <span class="font-semibold" x-text="deliveryFee > 0 ? formatMoney(deliveryFee) : 'Select state'"></span>
                        </div>
                        <div class="border-t border-gray-200 pt-3 flex justify-between">
                            <span class="font-bold text-gray-900 text-lg">Total</span>
                            <span class="font-bold text-brand-600 text-xl" x-text="formatMoney(total)"></span>
                        </div>
                    </div>

                    <button type="submit"
                            class="mt-6 w-full btn-brand text-white py-4 rounded-xl font-bold flex items-center justify-center space-x-2 shadow-lg shadow-brand-600/20 text-lg">
                        <i class="fas fa-lock text-sm"></i>
                        <span x-text="'Pay ' + formatMoney(total)"></span>
                    </button>

                    <p class="text-[11px] text-gray-400 text-center mt-3 flex items-center justify-center">
                        <i class="fas fa-shield-halved mr-1.5"></i>Secured by Paystack
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
