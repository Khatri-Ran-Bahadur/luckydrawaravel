@extends('layouts.app')

@section('content')
@php

$userName = is_array($user) ? ($user['name'] ?? '') : ($user->name ?? '');
$isSpecialUser = is_array($user) ? ($user['is_special_user'] ?? false) : ($user->is_special_user ?? false);

$winningsCollection = collect($userWinnings ?? []);
$totalWinnings = $winningsCollection->sum(function ($item) {
if (is_array($item)) {
return (float) ($item['prize_amount'] ?? $item['resolved_prize_amount'] ?? 0);
}

return (float) ($item->prize_amount ?? $item->resolved_prize_amount ?? 0);
});
@endphp

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Welcome Back! {{ $userName }}</h1>
                <p class="text-gray-600 mt-2">Manage your lucky draws and wallet</p>
            </div>
            <a href="{{ route('user.profile') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                <i class="fas fa-user-circle mr-2"></i>
                My Profile
            </a>
        </div>

        @if(!empty($unclaimedWinnings) && count($unclaimedWinnings))
        <div class="mb-8">
            <div class="bg-gradient-to-r from-yellow-400 to-orange-500 rounded-2xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-trophy text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold">🎉 Congratulations! You Have Prizes to Manage</h3>
                            <p class="text-yellow-100">
                                You've won {{ count($unclaimedWinnings) }} prize{{ count($unclaimedWinnings) > 1 ? 's' : '' }} that need attention
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-3 py-1 bg-white/20 rounded-full text-sm font-medium">
                            {{ count($unclaimedWinnings) }} Prize{{ count($unclaimedWinnings) > 1 ? 's' : '' }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach(collect($unclaimedWinnings)->take(3) as $winning)
                    @php
                    $winning = is_array($winning) ? (object) $winning : $winning;
                    $winningPrize = $winning->prize_amount ?? $winning->resolved_prize_amount ?? 0;
                    @endphp

                    <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-crown text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-sm">{{ getOrdinal($winning->position) }} Place</p>
                                    <p class="text-yellow-100 text-xs">{{ $winning->draw_title ?? 'Unknown Draw' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                @if(($winning->draw_type ?? '') === 'cash')
                                <p class="text-lg font-bold">Rs. {{ number_format((float) $winningPrize, 2) }}</p>
                                @else
                                <p class="text-lg font-bold">Product Prize</p>
                                @endif
                            </div>

                            @if(($winning->status ?? '') === 'waiting_claim')
                            <a href="{{ url('claim-prize/' . $winning->id) }}"
                                class="inline-flex items-center px-3 py-2 bg-white text-orange-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-gift mr-1"></i>
                                Claim Now
                            </a>
                            @elseif(($winning->status ?? '') === 'rejected')
                            <div class="text-center">
                                <span class="inline-flex items-center px-3 py-2 bg-red-500 bg-opacity-20 text-red-200 text-sm font-medium rounded-lg mb-2">
                                    <i class="fas fa-times mr-1"></i>
                                    Rejected
                                </span>
                                @if(!empty($winning->reject_comment))
                                <div class="text-xs text-red-200 mb-2 px-2 py-1 bg-red-600 bg-opacity-20 rounded">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    {{ $winning->reject_comment }}
                                </div>
                                @endif
                                <a href="{{ url('claim-prize/' . $winning->id) }}"
                                    class="block text-xs text-yellow-200 hover:text-white underline">
                                    Re-submit Claim
                                </a>
                            </div>
                            @elseif(($winning->status ?? '') === 'approved')
                            <span class="inline-flex items-center px-3 py-2 bg-green-500 bg-opacity-20 text-green-200 text-sm font-medium rounded-lg">
                                <i class="fas fa-check mr-1"></i>
                                Approved
                            </span>
                            @elseif(($winning->status ?? '') === 'claimed')
                            <span class="inline-flex items-center px-3 py-2 bg-yellow-500 bg-opacity-20 text-yellow-200 text-sm font-medium rounded-lg">
                                <i class="fas fa-clock mr-1"></i>
                                Pending
                            </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                @if(count($unclaimedWinnings) > 3)
                <div class="mt-4 text-center">
                    <a href="{{ url('my-winnings') }}" class="inline-flex items-center px-6 py-3 bg-white text-orange-600 font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                        <i class="fas fa-list mr-2"></i>
                        View All Prizes ({{ count($unclaimedWinnings) }})
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif

        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl shadow-xl p-8 text-white mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-semibold mb-2">Wallet Balance</h2>
                    <p class="text-4xl font-bold">Rs. {{ number_format((float) $walletBalance, 2) }}</p>
                    <p class="text-blue-100 mt-2">Available for lucky draw entries</p>
                </div>
                <div class="text-right">
                    <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-wallet text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-4 mt-6">
                <a href="{{ route('user.wallet.deposit') }}" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Top Up Wallet
                </a>
                <a href="{{ route('user.wallet.withdrawal') }}" class="inline-flex items-center px-6 py-3 bg-white/20 text-white font-semibold rounded-xl hover:bg-white/30 transition-colors">
                    <i class="fas fa-arrow-down mr-2"></i>
                    Withdraw Funds
                </a>
                <a href="{{ route('user.wallet.index') }}" class="inline-flex items-center px-6 py-3 bg-white/20 text-white font-semibold rounded-xl hover:bg-white/30 transition-colors">
                    <i class="fas fa-history mr-2"></i>
                    View Transactions
                </a>

                @if($isSpecialUser)
                <a href="{{ route('user.wallet.deposit') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white font-semibold rounded-xl hover:from-yellow-600 hover:to-orange-600 transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-star mr-2"></i>
                    Request Top-up
                </a>
                @endif

                @if(!$isSpecialUser)
                @if(empty($hasPendingSpecialUserRequest))
                <a href="{{ route('user.request-special-user.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-pink-600 transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-crown mr-2"></i>
                    Become a Special User
                </a>
                @else
                <span class="inline-flex items-center px-6 py-3 bg-gray-400 text-white font-semibold rounded-xl cursor-not-allowed">
                    <i class="fas fa-clock mr-2"></i>
                    Request Pending
                </span>
                @endif
                @endif
            </div>
        </div>

        @if($isSpecialUser)
        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 rounded-2xl shadow-xl p-6 text-white mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mr-4">
                        <i class="fas fa-star text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold">Special User Dashboard</h3>
                        <p class="text-yellow-100">Manage user requests and request funding</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <a href="{{ route('user.wallet.deposit') }}" class="bg-white/20 rounded-xl p-4 hover:bg-white/30 transition-all duration-300 transform hover:scale-105">
                    <div class="flex items-center">
                        <i class="fas fa-plus text-xl mr-3"></i>
                        <div>
                            <h4 class="font-semibold">Request Top-up</h4>
                            <p class="text-yellow-100 text-sm">Get funding from admin</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('user.wallet.user-requests') }}" class="bg-white/20 rounded-xl p-4 hover:bg-white/30 transition-all duration-300 transform hover:scale-105">
                    <div class="flex items-center">
                        <i class="fas fa-list-alt text-xl mr-3"></i>
                        <div>
                            <h4 class="font-semibold">User Requests</h4>
                            <p class="text-yellow-100 text-sm">Manage pending requests</p>
                            @if(($pendingCounts['user_requests_to_approve'] ?? 0) > 0)
                            <div class="mt-1">
                                <span class="inline-flex items-center px-2 py-1 bg-red-500 text-white text-xs font-medium rounded-full">
                                    {{ $pendingCounts['user_requests_to_approve'] }} pending
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                </a>

                <a href="{{ route('user.profile') }}" class="bg-white/20 rounded-xl p-4 hover:bg-white/30 transition-all duration-300 transform hover:scale-105">
                    <div class="flex items-center">
                        <i class="fas fa-user-cog text-xl mr-3"></i>
                        <div>
                            <h4 class="font-semibold">Wallet Settings</h4>
                            <p class="text-yellow-100 text-sm">Update wallet details</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900">Cash Lucky Draws</h3>
                    </div>
                    <a href="{{ url('cash-draws') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        View All
                    </a>
                </div>

                @if(empty($cashDraws) || count($cashDraws) === 0)
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-dice text-2xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500">No active cash draws</p>
                </div>
                @else
                <div class="space-y-4">
                    @foreach(collect($cashDraws)->take(3) as $draw)
                    @php
                    $draw = is_array($draw) ? (object) $draw : $draw;
                    $hasEntry = collect($userEntries ?? [])->contains(function ($entry) use ($draw) {
                    $entry = is_array($entry) ? (object) $entry : $entry;
                    return (int) ($entry->cash_draw_id ?? 0) === (int) $draw->id;
                    });
                    @endphp

                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-900">{{ $draw->title }}</h4>
                            <span class="text-sm text-gray-500">Rs. {{ number_format((float) $draw->entry_fee, 2) }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">{{ \Illuminate\Support\Str::limit($draw->description, 80) }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ \Carbon\Carbon::parse($draw->draw_date)->format('M j, Y') }}
                            </span>
                            @if((float) $walletBalance >= (float) $draw->entry_fee)
                            @if($hasEntry)
                            <button class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors" disabled>
                                <i class="fas fa-check-circle mr-2"></i>Already Entered
                            </button>
                            @else
                            <a href="{{ route('cash-draw-detail', $draw->id) }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                                <i class="fas fa-dice mr-2"></i>
                                ENTER
                            </a>
                            @endif
                            @else
                            <a href="{{ url('wallet/topup') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                <i class="fas fa-plus mr-2"></i>
                                TOP UP
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-gift text-purple-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900">Product Lucky Draws</h3>
                    </div>
                    <a href="{{ url('product-draws') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        View All
                    </a>
                </div>

                @if(empty($productDraws) || count($productDraws) === 0)
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-gift text-2xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500">No active product draws</p>
                </div>
                @else
                <div class="space-y-4">
                    @foreach(collect($productDraws)->take(3) as $draw)
                    @php
                    $draw = is_array($draw) ? (object) $draw : $draw;
                    $hasEntry = collect($userEntries ?? [])->contains(function ($entry) use ($draw) {
                    $entry = is_array($entry) ? (object) $entry : $entry;
                    return (int) ($entry->product_draw_id ?? 0) === (int) $draw->id;
                    });
                    @endphp

                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-900">{{ $draw->title }}</h4>
                            <span class="text-sm text-gray-500">Rs. {{ number_format((float) $draw->entry_fee, 2) }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">{{ \Illuminate\Support\Str::limit($draw->description, 80) }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ \Carbon\Carbon::parse($draw->draw_date)->format('M j, Y') }}
                            </span>
                            @if((float) $walletBalance >= (float) $draw->entry_fee)
                            @if($hasEntry)
                            <button class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors" disabled>
                                <i class="fas fa-check-circle mr-2"></i>Already Entered
                            </button>
                            @else
                            <a href="{{ route('product-draw-detail', $draw->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                <i class="fas fa-gift mr-2"></i>
                                ENTER
                            </a>
                            @endif
                            @else
                            <a href="{{ url('wallet/topup') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                <i class="fas fa-plus mr-2"></i>
                                TOP UP
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-wallet text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Wallet Balance</p>
                        <p class="text-2xl font-bold text-gray-900">Rs. {{ number_format((float) $walletBalance, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-dice text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Active Draws</p>
                        <p class="text-2xl font-bold text-gray-900">{{ count($cashDraws) + count($productDraws) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-trophy text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">My Entries</p>
                        <p class="text-2xl font-bold text-gray-900">{{ count($userEntries ?? []) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center relative">
                        <i class="fas fa-star text-orange-600 text-xl"></i>
                        @if(!empty($unclaimedWinnings) && count($unclaimedWinnings))
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center font-bold">
                            {{ count($unclaimedWinnings) }}
                        </span>
                        @endif
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Winnings</p>
                        <p class="text-2xl font-bold text-gray-900">Rs. {{ number_format((float) $totalWinnings, 2) }}</p>
                        @if(!empty($unclaimedWinnings) && count($unclaimedWinnings))
                        <p class="text-sm text-red-600 font-medium">
                            {{ count($unclaimedWinnings) }} unclaimed prize{{ count($unclaimedWinnings) > 1 ? 's' : '' }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="px-8 py-6 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900">Recent Activity</h3>
            </div>

            <div class="p-8">
                @if((empty($recent_transactions) || count($recent_transactions) === 0) && (empty($winnings) || count($winnings) === 0))
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-activity text-2xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500 text-lg">No recent activity</p>
                    <p class="text-gray-400 mt-2">Start participating in lucky draws to see your activity here</p>
                </div>
                @else
                <div class="space-y-4">
                    @if(!empty($recent_transactions) && count($recent_transactions))
                    <h4 class="font-medium text-gray-900 mb-3">Recent Transactions</h4>
                    @foreach(collect($recent_transactions)->take(5) as $transaction)
                    @php
                    $transaction = is_array($transaction) ? (object) $transaction : $transaction;
                    @endphp

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($transaction->type, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $transaction->type)) }}</p>
                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($transaction->created_at)->format('M j, Y g:i A') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold {{ (float) $transaction->amount >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ (float) $transaction->amount >= 0 ? '+' : '' }}Rs. {{ number_format(abs((float) $transaction->amount), 2) }}
                            </p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' : ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                    @endif

                    @if(!empty($winnings) && count($winnings))
                    <h4 class="font-medium text-gray-900 mb-3 mt-6">Recent Winnings</h4>
                    @foreach(collect($winnings)->take(3) as $winning)
                    @php
                    $winning = is_array($winning) ? (object) $winning : $winning;
                    $winningPrize = $winning->prize_amount ?? $winning->resolved_prize_amount ?? 0;
                    @endphp

                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg border border-yellow-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center text-white font-bold">
                                <i class="fas fa-crown"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ getOrdinal($winning->position) }} Place</p>
                                <p class="text-sm text-gray-500">{{ $winning->draw_title ?? 'Unknown Draw' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            @if(($winning->draw_type ?? '') === 'cash')
                            <p class="font-semibold text-green-600">Rs. {{ number_format((float) $winningPrize, 2) }}</p>
                            @else
                            <p class="font-semibold text-blue-600">Product Prize</p>
                            @endif

                            @if(($winning->status ?? '') === 'waiting_claim')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Ready to Claim
                            </span>
                            @elseif(($winning->status ?? '') === 'approved')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Approved
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection