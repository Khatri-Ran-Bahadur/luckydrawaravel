@extends('layouts.app')
@section('content')
<!-- hero section -->
<section class="gradient-bg text-white py-24 relative overflow-hidden">
    <!-- background decoration -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-blue-900/20 to-purple-900/20"></div>
        <div class="absolute top-20 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-72 h-72 bg-purple-500/10 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h1 class="text-5xl md:text-7xl font-bold mb-8 leading-tight">Win Amazing Prizes with Our<span class="text-yellow-300 block">Lucky Draw System</span></h1>
        <p class="text-xl md:text-2xl mb-12 text-blue-100 max-w-4xl mx-auto leading-relaxed">
            Join exciting lucky draws and stand a chance to win incredible cash prizes and amazing products!
            Choose between cash draws for instant money or product draws for exclusive items.
        </p>
    </div>

    <div class="flex flex-col sm:flex-row gap-6 justify-center">
        @auth
        <a href="/cash-draws" class="relative overflow-hidden bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 hover:from-amber-600 hover:via-orange-600 hover:to-red-600 text-white font-bold text-lg px-12 py-5 rounded-2xl transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl border border-white/20 group">
            <span class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></span>
            <span class="relative flex items-center justify-center">
                <i class="fas fa-dollar-sign mr-3"></i>Join Cash Draw
            </span>
        </a>
        <a href="/product-draws" class="relative overflow-hidden bg-gradient-to-r from-emerald-500 via-green-500 to-teal-500 hover:from-emerald-600 hover:via-green-600 hover:to-teal-600 text-white font-bold text-lg px-12 py-5 rounded-2xl transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl border border-white/20 group">
            <span class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></span>
            <span class="relative flex items-center justify-center">
                <i class="fas fa-gift mr-3"></i>Join Product Draw
            </span>
        </a>
        @else
        <a href="/register" class="relative overflow-hidden bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 hover:from-amber-600 hover:via-orange-600 hover:to-red-600 text-white font-bold text-lg px-12 py-5 rounded-2xl transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl border border-white/20 group">
            <span class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></span>
            <span class="relative flex items-center justify-center">
                <i class="fas fa-user-plus mr-3"></i>Get Started
            </span>
        </a>
        <a href="/login" class="relative overflow-hidden bg-white/10 backdrop-blur-md border-2 border-white/30 text-white hover:bg-white/20 hover:border-white/50 font-bold py-5 px-12 rounded-2xl text-lg transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl group">
            <span class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></span>
            <span class="relative flex items-center justify-center">
                <i class="fas fa-sign-in-alt mr-3"></i>Login
            </span>
        </a>
        @endauth
    </div>



</section>


<!-- Stats Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="card-hover bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-2xl text-center border border-blue-200">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="fas fa-users text-2xl text-white"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">1000</h3>
                <p class="text-gray-600 font-medium">Happy Users</p>
            </div>
            <div class="card-hover bg-gradient-to-br from-green-50 to-green-100 p-8 rounded-2xl text-center border border-green-200">
                <div class="w-16 h-16 bg-gradient-to-r from-green-600 to-green-700 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="fas fa-dice text-2xl text-white"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">111</h3>
                <p class="text-gray-600 font-medium">Lucky Draws</p>
            </div>
            <div class="card-hover bg-gradient-to-br from-purple-50 to-purple-100 p-8 rounded-2xl text-center border border-purple-200">
                <div class="w-16 h-16 bg-gradient-to-r from-purple-600 to-purple-700 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="fas fa-trophy text-2xl text-white"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">2002</h3>
                <p class="text-gray-600 font-medium">Winners</p>
            </div>
            <div class="card-hover bg-gradient-to-br from-orange-50 to-orange-100 p-8 rounded-2xl text-center border border-orange-200">
                <div class="w-16 h-16 bg-gradient-to-r from-orange-600 to-orange-700 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="fas fa-star text-2xl text-white"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">100%</h3>
                <p class="text-gray-600 font-medium">Fair & Secure</p>
            </div>
        </div>
    </div>
</section>

<!-- Product Draw Achievements Section -->
<section class="py-16 bg-gradient-to-r from-green-50 to-teal-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Product Draw Achievements</h2>
            <p class="text-lg text-gray-600">See how many amazing products our users have won</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="card-hover bg-white p-8 rounded-2xl text-center border border-green-200 shadow-lg">
                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-teal-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="fas fa-gift text-2xl text-white"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">100</h3>
                <p class="text-gray-600 font-medium">Product Winners</p>
            </div>
            <div class="card-hover bg-white p-8 rounded-2xl text-center border border-green-200 shadow-lg">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="fas fa-box text-2xl text-white"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">Rs. 1000</h3>
                <p class="text-gray-600 font-medium">Total Value Won</p>
            </div>
            <div class="card-hover bg-white p-8 rounded-2xl text-center border border-green-200 shadow-lg">
                <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="fas fa-star text-2xl text-white"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">Rs. 202</h3>
                <p class="text-gray-600 font-medium">Average Product Value</p>
            </div>
        </div>
    </div>
</section>


@endsection