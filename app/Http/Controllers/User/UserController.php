<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CashDraw;
use App\Models\ProductDraw;
use App\Models\WalletTransaction;
use App\Models\Winner;
use App\Models\Entry;
use App\Models\SpecialUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $userId = $user->id;
        // auto update expired draws
        CashDraw::updateExpiredDraws();
        ProductDraw::updateExpiredDraws();

        $walletBalance = optional($user->wallet)->balance ?? 0;

        // active draws
        $cashDraws = CashDraw::activeDraws()->get();
        $productDraws = ProductDraw::activeDraws()->get();

        // user winnings
        $winnings = Winner::getUserWinnings($userId);

        // unclimaned winnifgs
        $unclaimedWinnings = Winner::getUserUnclaimedWinnings($userId);


        //recent wallet tractions
        $recentTransactions = WalletTransaction::getUserTransactions($userId);


        // User entries for active draws
        $cashDrawIds = $cashDraws->pluck('id')->all();
        $productDrawIds = $productDraws->pluck('id')->all();

        $userEntries = Entry::query()
            ->where('user_id', $userId)
            ->where(function ($query) use ($cashDrawIds, $productDrawIds) {
                if (!empty($cashDrawIds)) {
                    $query->whereIn('cash_draw_id', $cashDrawIds);
                }

                if (!empty($productDrawIds)) {
                    $query->orWhereIn('product_draw_id', $productDrawIds);
                }
            })
            ->get();

        // Pending request counts
        $pendingCounts = $this->getPendingRequestCounts($userId, $user);

        // Pending special user request
        $hasPendingSpecialUserRequest = SpecialUserRequest::query()
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->exists();


        return view('web.user.dashboard', [
            'user' => $user,
            'cashDraws' => $cashDraws,
            'productDraws' => $productDraws,
            'walletBalance' => $walletBalance,
            'winnings' => $winnings,
            'unclaimedWinnings' => $unclaimedWinnings,
            'recentTransactions' => $recentTransactions,
            'userEntries' => $userEntries,
            'pendingCounts' => $pendingCounts,
            'hasPendingSpecialUserRequest' => $hasPendingSpecialUserRequest,
        ]);
    }


    private function getPendingRequestCounts(int $userId, $user): array
    {
        return [
            'special_user_requests' => SpecialUserRequest::query()
                ->where('user_id', $userId)
                ->where('status', 'pending')
                ->count(),
        ];
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function winnings()
    {
        return view('user.winnings');
    }
}
