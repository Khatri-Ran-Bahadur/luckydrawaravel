@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">🏆 Congratulations to Our Winners! 🏆</h1>
            <p class="text-xl text-gray-600">Celebrating the lucky participants who won amazing prizes.</p>
        </div>

        @if(empty($cashWinners) && empty($productWinners))
        <!-- Empty State -->
        <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-trophy text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">No Winners Yet</h3>
            <p class="text-gray-500">Winners will be announced here once draws are completed!</p>
            <div class="mt-8">
                <a href="{{ route('cash-draws') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                    Join a Draw Now
                </a>
            </div>
        </div>
        @else
        <!-- Tabs Navigation -->
        <div class="border-b border-gray-200 mb-8">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="winnerTabs" data-tabs-toggle="#winnerTabsContent" role="tablist">
                @if(!empty($cashWinners))
                <li class="mr-2" role="presentation">
                    <button class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 group {{ !empty($cashWinners) ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500' }}" id="cash-tab" data-tabs-target="#cash-winners" type="button" role="tab" aria-controls="cash-winners" aria-selected="true" onclick="switchTab('cash')">
                        <i class="fas fa-money-bill-wave mr-2 {{ !empty($cashWinners) ? 'text-green-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                        Cash Draws
                    </button>
                </li>
                @endif

                @if(!empty($productWinners))
                <li class="mr-2" role="presentation">
                    <button class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 group {{ empty($cashWinners) ? 'border-purple-600 text-purple-600' : 'border-transparent text-gray-500' }}" id="product-tab" data-tabs-target="#product-winners" type="button" role="tab" aria-controls="product-winners" aria-selected="false" onclick="switchTab('product')">
                        <i class="fas fa-gift mr-2 {{ empty($cashWinners) ? 'text-purple-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                        Product Draws
                    </button>
                </li>
                @endif
            </ul>
        </div>

        <!-- Tabs Content -->
        <div id="winnerTabsContent">
            <!-- Cash Winners Tab -->
            @if(!empty($cashWinners))
            <div class="{{ !empty($cashWinners) ? 'block' : 'hidden' }}" id="cash-winners" role="tabpanel" aria-labelledby="cash-tab">
                @foreach($cashWinners as $drawId => $drawWinners)
                <div class="mb-12 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center justify-between">
                            <span>{{ $drawWinners[0]->title }}</span>
                            <span class="text-sm font-normal bg-white/20 px-3 py-1 rounded-full">Cash Draw</span>
                        </h3>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($drawWinners as $winner)
                            <div class="relative bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                                @if($winner->position == 1)
                                <div class="absolute -top-4 -right-4 w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center shadow-lg transform rotate-12">
                                    <i class="fas fa-crown text-white text-xl"></i>
                                </div>
                                @elseif($winner->position == 2)
                                <div class="absolute -top-4 -right-4 w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-medal text-white text-xl"></i>
                                </div>
                                @elseif($winner->position == 3)
                                <div class="absolute -top-4 -right-4 w-12 h-12 bg-orange-400 rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-medal text-white text-xl"></i>
                                </div>
                                @endif

                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-green-600 text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $winner->full_name }}</p>
                                            <p class="text-sm text-gray-500">{{ '@' . $winner->username }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-end">
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Position</p>
                                        <p class="font-semibold text-gray-900">{{ getOrdinal($winner->position) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500 mb-1">Prize Won</p>
                                        <p class="font-bold text-green-600 text-xl">Rs. {{ number_format($winner->prize_amount, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Product Winners Tab -->
            @if(!empty($productWinners))
            <div class="{{ empty($cashWinners) ? 'block' : 'hidden' }}" id="product-winners" role="tabpanel" aria-labelledby="product-tab">
                @foreach($productWinners as $drawId => $drawWinners)
                <div class="mb-12 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center justify-between">
                            <span>{{ $drawWinners[0]->title }}</span>
                            <span class="text-sm font-normal bg-white/20 px-3 py-1 rounded-full">Product Draw</span>
                        </h3>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($drawWinners as $winner)
                            <div class="relative bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                                @if($winner->position == 1)
                                <div class="absolute -top-4 -right-4 w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center shadow-lg transform rotate-12">
                                    <i class="fas fa-crown text-white text-xl"></i>
                                </div>
                                @endif

                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-purple-600 text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $winner->full_name }}</p>
                                            <p class="text-sm text-gray-500">{{ '@' . $winner->username }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <div class="flex items-start space-x-4">
                                        @if(!empty($drawWinners[0]->product_image))
                                        <img src="{{ asset('uploads/' . $drawWinners[0]->product_image) }}" alt="Prize" class="w-16 h-16 rounded-lg object-cover">
                                        @else
                                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-gift text-gray-400 text-2xl"></i>
                                        </div>
                                        @endif
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-500 mb-1">Prize Won ({{ getOrdinal($winner->position) }} Place)</p>
                                            <p class="font-bold text-purple-600 line-clamp-2">{{ $drawWinners[0]->product_name ?? 'Mystery Prize' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
<script>
    function switchTab(tabId) {
        // Hide all tabs
        document.getElementById('cash-winners').classList.add('hidden');
        document.getElementById('product-winners').classList.add('hidden');

        // Reset styles
        document.getElementById('cash-tab').classList.remove('border-green-600', 'text-green-600');
        document.getElementById('cash-tab').classList.add('border-transparent', 'text-gray-500');
        document.querySelector('#cash-tab i').classList.remove('text-green-600');
        document.querySelector('#cash-tab i').classList.add('text-gray-400');

        document.getElementById('product-tab').classList.remove('border-purple-600', 'text-purple-600');
        document.getElementById('product-tab').classList.add('border-transparent', 'text-gray-500');
        document.querySelector('#product-tab i').classList.remove('text-purple-600');
        document.querySelector('#product-tab i').classList.add('text-gray-400');

        // Show selected tab
        document.getElementById(tabId + '-winners').classList.remove('hidden');

        // Apply active styles
        if (tabId === 'cash') {
            document.getElementById('cash-tab').classList.add('border-green-600', 'text-green-600');
            document.getElementById('cash-tab').classList.remove('border-transparent', 'text-gray-500');
            document.querySelector('#cash-tab i').classList.add('text-green-600');
            document.querySelector('#cash-tab i').classList.remove('text-gray-400');
        } else {
            document.getElementById('product-tab').classList.add('border-purple-600', 'text-purple-600');
            document.getElementById('product-tab').classList.remove('border-transparent', 'text-gray-500');
            document.querySelector('#product-tab i').classList.add('text-purple-600');
            document.querySelector('#product-tab i').classList.remove('text-gray-400');
        }
    }
</script>
@endsection