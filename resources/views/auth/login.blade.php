@extends('layouts.app')

@section('title', 'Login - Vicsode')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gray-900 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="fas fa-blender text-white text-2xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Welcome Back</h2>
            <p class="text-gray-500 mt-1 text-sm">Sign in to access the Vicsode admin panel</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition"
                           placeholder="admin@vicsode.com.ng">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <input type="password" id="password" name="password" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition"
                           placeholder="••••••••">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember"
                           class="rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                </div>

                <button type="submit"
                        class="w-full btn-brand text-white py-3.5 rounded-xl font-semibold shadow-lg shadow-brand-600/20 transition">
                    Sign In
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-gray-400 mt-6">
            <a href="{{ route('shop.index') }}" class="hover:text-brand-600 transition">
                <i class="fas fa-arrow-left mr-1"></i> Back to Shop
            </a>
        </p>
    </div>
</div>
@endsection
