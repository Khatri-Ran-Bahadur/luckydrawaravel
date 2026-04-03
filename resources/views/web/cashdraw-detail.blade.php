@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('cash-draws') }}"
                class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Cash Draws
            </a>
        </div>

        <!-- so success or failed message -->
        <!-- show error or sucess message -->
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded relative success-msg " role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded relative failed-msg" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif


        <!-- Draw Header -->
        <div class="bg-gradient-to-r from-green-500 to-blue-600 rounded-2xl shadow-lg p-8 text-white mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="w-16 h-16 rounded-full flex items-center justify-center" style="background-color: rgba(255,255,255,0.2);">
                    <i class="fas fa-dollar-sign text-2xl"></i>
                </div>
                <span class="px-4 py-2 rounded-full text-sm font-medium" style="background-color: rgba(255,255,255,0.2);">
                    Cash Draw
                </span>
            </div>

            <h1 class="text-3xl font-bold mb-4">{{ $cashDraw->title }}</h1>
            <p class="text-lg opacity-90 mb-6">{{ $cashDraw->description }}</p>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold">Rs. {{ number_format($cashDraw->prize_amount, 2) }}</div>
                    <div class="text-sm opacity-80">Total Prize</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold">{{ $cashDraw->total_winners }}</div>
                    <div class="text-sm opacity-80">Winners</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold">{{ $cashDraw->participant_count ?? 0 }}</div>
                    <div class="text-sm opacity-80">Participants</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold">Rs. {{ number_format($cashDraw->entry_fee, 2) }}</div>
                    <div class="text-sm opacity-80">Entry Fee</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Draw Status -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                    @if ($cashDraw->status === 'active')
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Draw Status</h3>

                        <!-- Countdown Timer -->
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <div class="text-sm text-gray-600 mb-2">Time Remaining</div>
                            <div class="countdown-timer text-2xl font-bold text-red-600"
                                data-draw-date="{{ \Carbon\Carbon::parse($cashDraw->draw_date)->toIso8601String() }}">
                                <span class="days">00</span>d
                                <span class="hours">00</span>h
                                <span class="minutes">00</span>m
                                <span class="seconds">00</span>s
                            </div>
                        </div>

                        <!-- Entry Status -->
                        @auth
                        @if ($userEntry)
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                            <div class="flex items-center justify-center mb-4">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-green-600 text-xl"></i>
                                </div>
                            </div>
                            <h4 class="text-lg font-semibold text-green-800 mb-2">You're Entered!</h4>
                            <p class="text-green-700 mb-2">Entry Number: <strong>{{ $userEntry->entry_number }}</strong>
                            </p>
                            <p class="text-sm text-green-600">Good luck! Winners will be announced after the draw date.
                            </p>
                        </div>
                        <div class="mt-8">
                            <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
                                <div class="flex items-center justify-center space-x-3 mb-4">
                                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-check text-green-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-green-900">Already Entered!</h3>
                                        <p class="text-green-600">You have successfully entered this cash draw</p>
                                    </div>
                                </div>

                                <div class="bg-white rounded-lg p-4 mb-4">
                                    <p class="text-sm text-gray-600 mb-2">Your Entry Details:</p>
                                    <div class="flex items-center justify-center space-x-4 text-sm">
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                                            <i class="fas fa-ticket mr-1"></i>Entry #{{ $userEntry->entry_number }}
                                        </span>
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full">
                                            <i class="fas fa-calendar mr-1"></i>{{ date('M j, Y',
                                            strtotime($userEntry->entry_date)) }}
                                        </span>
                                    </div>
                                </div>

                                <button
                                    class="w-full bg-gray-400 text-white font-semibold py-4 px-6 rounded-xl cursor-not-allowed"
                                    disabled>
                                    <i class="fas fa-check-circle mr-2"></i>Already Entered
                                </button>
                            </div>
                        </div>
                        @else
                        <div class="mt-8">
                            @if (strtotime($cashDraw->draw_date) > time())
                            <form action="{{ route('cash-draw-enter', $cashDraw->id) }}" method="post"
                                class="space-y-4">
                                @csrf
                                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-semibold text-blue-900">Ready to Join?</h3>
                                            <p class="text-blue-600">Entry fee: Rs. {{
                                                number_format($cashDraw->entry_fee, 2) }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-gray-600">Prize Pool:</p>
                                            <p class="font-semibold text-gray-900">Rs. {{
                                                number_format($cashDraw->prize_amount, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                                    <i class="fas fa-dollar-sign mr-2"></i>Join Cash Draw
                                </button>
                            </form>
                            @else
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 text-center">
                                <div
                                    class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-clock text-gray-400 text-xl"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Draw Has Ended</h3>
                                <p class="text-gray-600">The entry period for this draw has ended.</p>
                                <button
                                    class="w-full bg-gray-400 text-white font-semibold py-4 px-6 rounded-xl cursor-not-allowed mt-4"
                                    disabled>
                                    <i class="fas fa-times mr-2"></i>Cannot Join
                                </button>
                            </div>
                            @endif
                        </div>
                        @endif
                        @else
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Join This Draw</h4>
                            <p class="text-gray-600 mb-4">Please login to enter this cash draw</p>
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Login to Enter
                            </a>
                        </div>
                        @endauth
                    </div>
                    @elseif ($cashDraw->status === 'completed')
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">🏆 Draw Completed - Winners Announced! 🏆</h3>
                        @if (!empty($winners))
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($winners as $winner)
                            <div class="bg-gradient-to-r from-yellow-400 to-orange-500 rounded-xl p-6 text-white">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4" style="background-color: rgba(255,255,255,0.2);">
                                    <i class="fas fa-trophy text-xl"></i>
                                </div>
                                <h4 class="text-lg font-semibold mb-2">{{ getOrdinal($winner->position) }} Place</h4>
                                <p class="text-2xl font-bold mb-2">Rs. {{ number_format($winner->prize_amount, 2) }}</p>
                                <p class="text-sm opacity-90">{{ '@' . $winner->username }}</p>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-gray-600">Winners information not available.</p>
                        @endif
                    </div>
                    @else
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-pause text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-600 mb-2">Draw Not Active</h3>
                        <p class="text-gray-500">This draw is currently inactive.</p>
                    </div>
                    @endif
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Draw Details</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600">Draw Date:</span>
                            <span class="font-semibold text-gray-900">{{ date('M d, Y \a\t H:i',
                                strtotime($cashDraw->draw_date)) }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600">Total Prize Pool:</span>
                            <span class="font-semibold text-green-600">Rs. {{ number_format($cashDraw->prize_amount, 2)
                                }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600">Number of Winners:</span>
                            <span class="font-semibold text-gray-900">{{ $cashDraw->total_winners }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600">Entry Fee:</span>
                            <span class="font-semibold text-gray-900">Rs. {{ number_format($cashDraw->entry_fee, 2)
                                }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <span class="text-gray-600">Current Participants:</span>
                            <span class="font-semibold text-blue-600">{{ $cashDraw->participant_count ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Recent Participants -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Participants</h3>

                    @if (!empty($participants) && count($participants) > 0)
                    <div class="space-y-3">
                        @foreach ($participants as $participant)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ '@' . $participant->username }}</div>
                                    <div class="text-xs text-gray-500">{{ date('M d, H:i',
                                        strtotime($participant->created_at)) }}</div>
                                </div>
                            </div>
                            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-users text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 text-sm">No participants yet</p>
                    </div>
                    @endif
                </div>

                <!-- How It Works -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">How It Works</h3>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-3 mt-0.5">
                                <span class="text-xs font-bold text-blue-600">1</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm">Enter the Draw</h4>
                                <p class="text-xs text-gray-600">Pay the entry fee from your wallet</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-3 mt-0.5">
                                <span class="text-xs font-bold text-blue-600">2</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm">Wait for Draw</h4>
                                <p class="text-xs text-gray-600">Winners selected on draw date</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-3 mt-0.5">
                                <span class="text-xs font-bold text-blue-600">3</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm">Win Prizes</h4>
                                <p class="text-xs text-gray-600">Cash prizes sent to winners</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateCountdowns() {
        document.querySelectorAll('.countdown-timer').forEach(function(timer) {
            const drawDateStr = timer.dataset.drawDate;
            if (!drawDateStr) return;
            const drawDate = new Date(drawDateStr).getTime();
            const now = new Date().getTime();
            const distance = drawDate - now;

            if (distance > 0) {
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                timer.querySelector('.days').textContent = String(days).padStart(2, '0');
                timer.querySelector('.hours').textContent = String(hours).padStart(2, '0');
                timer.querySelector('.minutes').textContent = String(minutes).padStart(2, '0');
                timer.querySelector('.seconds').textContent = String(seconds).padStart(2, '0');
            } else {
                timer.innerHTML = '<span class="text-red-600 font-bold">Draw Ended</span>';
            }
        });
    }

    setInterval(updateCountdowns, 1000);
    updateCountdowns();
</script>
@endpush