@extends('layouts.app')

@section('title', 'Thank You - Vicsode')

@section('content')
<section class="py-20 bg-gray-50 min-h-[80vh] flex items-center">
    <div class="max-w-lg mx-auto px-4 text-center">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check-circle text-green-500 text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-3">Thank You!</h1>
            <p class="text-gray-500 text-lg mb-8">Your review has been submitted successfully. It will appear on our website once approved.</p>
            <a href="{{ route('shop.index') }}"
               class="btn-brand text-white px-8 py-3 rounded-xl font-semibold inline-flex items-center space-x-2 shadow-lg">
                <span>Continue Shopping</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
@endsection
