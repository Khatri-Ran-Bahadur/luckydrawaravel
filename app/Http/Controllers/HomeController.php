<?php

namespace App\Http\Controllers;

use App\Models\CashDraw;
use App\Models\ProductDraw;
use Illuminate\Http\Request;
use App\Models\Winner;
use App\Http\Controllers\Controller;
use App\Models\Entry;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    private $cashDraw;
    private $productDraw;
    private $winner;


    public function __construct(CashDraw $cashDraw, ProductDraw $productDraw, Winner $winner)
    {
        $this->cashDraw = $cashDraw;
        $this->productDraw = $productDraw;
        $this->winner = $winner;
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('web.index');
    }

    public function cashDraws()
    {
        $perPage = 10;
        $this->cashDraw->updateExpiredDraws();
        $recentWinners = $this->cashDraw
            ->query()
            ->recentWinners($perPage)
            ->latest()
            ->get()
            ->flatMap(function ($draw) {
                return $draw->winners;
            })
            ->take($perPage)
            ->values();
        $data = [
            'cash_draws' => $this->cashDraw->query()->activeDraws()->withCount(['entries', 'approvedWinners', 'claimedWinners'])->get(),
            'recent_winners' => $recentWinners,
            'completed_draws' => $this->cashDraw->query()->completedDraws()->take(10)->get(),
            'upcoming_draws' => $this->cashDraw->upcomingDraws()->take(10)->get(),
        ];
        return view('web.cashdraws', $data);
    }

    public function cashDrawDetail($id)
    {
        $cashDraw = $this->cashDraw->findOrFail($id);
        $userEntry = null;
        $userWallet = null;

        if (Auth::check()) {
            $userEntry = Entry::where('cash_draw_id', $cashDraw->id)->where('user_id', Auth::id())->first();
            $userWallet = Wallet::where('user_id', Auth::id())->first();
        }

        $participants = Entry::select('entries.*', 'users.username', 'users.name as full_name')
            ->join('users', 'users.id', '=', 'entries.user_id')
            ->where('entries.cash_draw_id', $cashDraw->id)
            ->orderBy('entries.created_at', 'DESC')
            ->limit(10)
            ->get();

        $winners = [];
        if ($cashDraw->status === 'completed') {
            $winners = Winner::select('winners.*', 'users.username', 'users.name as full_name', 'users.email', 'cash_draws.title', 'winners.prize_amount')
                ->join('users', 'users.id', '=', 'winners.user_id')
                ->join('cash_draws', 'cash_draws.id', '=', 'winners.cash_draw_id')
                ->where('winners.cash_draw_id', $cashDraw->id)
                ->orderBy('winners.position', 'ASC')
                ->get();
        }
        return view('web.cashdraw-detail', compact('cashDraw', 'userEntry', 'participants', 'winners', 'userWallet'));
    }

    public function productDraws()
    {
        $perPage = 10;
        $this->productDraw->updateExpiredDraws();

        $recentWinners = $this->productDraw
            ->query()
            ->recentWinners($perPage)
            ->latest()
            ->get()
            ->flatMap(function ($draw) {
                return $draw->winners;
            })
            ->take($perPage)
            ->values();

        $data = [
            'product_draws' => $this->productDraw->query()->activeDraws()->withCount(['entries', 'approvedWinners', 'claimedWinners'])->get(),
            'recent_winners' => $recentWinners,
            'completed_draws' => $this->productDraw->query()->completedDraws()->take(10)->get(),
            'upcoming_draws' => $this->productDraw->upcomingDraws()->take(10)->get(),
        ];
        return view('web.productdraws', $data);
    }

    public function winners()
    {
        $allWinners = $this->winner->getAllWinners(20);
        $cashWinners = collect($allWinners)->where('draw_type', 'cash')->values()->all();
        $productWinners = collect($allWinners)->where('draw_type', 'product')->values()->all();
        $userWinnings = null;
        $userTotalWinnings = 0;
        $userClaimStatus = [];

        if (Auth::id()) {
            $userId = Auth::id();

            // Get user's winnings
            $userWinnings = $this->winner->getUserWinnings($userId);

            // Get total winnings amount
            $userTotalWinnings = $this->winner->getUserTotalWinnings($userId);

            // Get claim status for each winning
            foreach ($userWinnings as $winning) {
                $userClaimStatus[$winning['id']] = [
                    'is_claimed' => $winning['is_claimed'],
                    'claim_approved' => $winning['claim_approved'],
                    'claim_details' => $winning['claim_details'] ?? null
                ];
            }
        }
        $data = [
            'winners' => $allWinners,
            'cash_winners' => $cashWinners,
            'product_winners' => $productWinners,
            'user_winnings' => $userWinnings,
            'user_total_winnings' => $userTotalWinnings,
            'user_claim_status' => $userClaimStatus,
            'is_logged_in' => Auth::id() ? true : false
        ];
        return view('web.winner', $data);
    }

    public function contactUs()
    {
        return view('web.contact');
    }

    public function aboutUs()
    {
        return view('web.about');
    }

    public function privacyPolicy()
    {
        return view('web.privacy');
    }

    public function termsAndConditions()
    {
        return view('web.terms');
    }

    public function faq()
    {
        return view('web.faq');
    }


    public function cashDrawEnter(Request $request, $id)
    {


        if (!Auth::check()) {
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => 'Please login to enter the draw']);
            return redirect()->route('login')->with('error', 'Please login to enter the draw');
        }
        $draw = $this->cashDraw->findOrFail($id);


        if ($draw->status !== 'active') {
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => 'Cash draw not found or not active']);
            return redirect()->back()->with('error', 'Cash draw not found or not active');
        }

        if (strtotime($draw->draw_date) <= time()) {
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => 'This draw has already ended']);
            return redirect()->back()->with('error', 'This draw has already ended');
        }

        $userId = Auth::id();
        $existingEntry = Entry::where('user_id', $userId)->where('cash_draw_id', $id)->first();
        if ($existingEntry) {
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => 'You have already entered this cash draw']);
            return redirect()->back()->with('error', 'You have already entered this cash draw');
        }

        $wallet = Wallet::where('user_id', $userId)->first();

        if (!$wallet) {
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => 'Please create a wallet first']);
            return redirect()->back()->with('error', 'Please create a wallet first');
        }

        if ($wallet->balance < $draw->entry_fee) {
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => 'Insufficient wallet balance. Please add funds first.']);
            return redirect()->back()->with('error', 'Insufficient wallet balance. Please add funds first.');
        }

        DB::beginTransaction();
        try {
            $entryNumber = 'ENT-' . strtoupper(Str::random(8));

            $entry = new Entry();
            $entry->user_id = Auth::id();
            $entry->cash_draw_id = $id;
            $entry->type = 'cash';
            $entry->entry_number = $entryNumber;
            $entry->amount_paid = $draw->entry_fee;
            $entry->entry_date = now();
            $entry->save();

            $newBalance = $wallet->balance - $draw->entry_fee;
            $wallet->balance = $newBalance;
            $wallet->save();

            $transaction = new WalletTransaction();
            $transaction->wallet_id = $wallet->id;
            $transaction->type = 'draw_entry';
            $transaction->amount = -$draw->entry_fee;
            $transaction->balance_before = $wallet->balance + $draw->entry_fee;
            $transaction->balance_after = $newBalance;
            $transaction->status = 'completed';
            $transaction->description = 'Cash Draw Entry - ' . $draw->title;
            $transaction->payment_method = 'wallet';
            $transaction->payment_reference = $entryNumber;
            $transaction->save();

            if (isset($draw->participant_count)) {
                $draw->participant_count = $draw->participant_count + 1;
            } else {
                $draw->participant_count = 1;
            }
            $draw->save();

            DB::commit();
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully entered the cash draw! Your entry number is: ' . $entryNumber,
                    'entry_number' => $entryNumber
                ]);
            }
            return redirect()->route('cash-draw-detail', $id)->with('success', 'Successfully entered the cash draw! Your entry number is: ' . $entryNumber);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Cash draw entry failed: ." . $e->getMessage());
            return redirect()->back()->with('error', "Failed to enter the draw. Please try again");
        }
    }


    public function productDrawEnter(Request $request, $id)
    {
        if (!Auth::check()) {
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => 'Please login to enter the draw']);
            return redirect()->route('login')->with('error', 'Please login to enter the draw');
        }

        $draw = $this->productDraw->findOrFail($id);
        if ($draw->status !== 'active') {
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => 'Product draw not found or not active']);
            return redirect()->back()->with('error', 'Product draw not found or not active');
        }

        if (strtotime($draw->draw_date) <= time()) {
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => 'This draw has already ended']);
            return redirect()->back()->with('error', 'This draw has already ended');
        }

        $userId = Auth::id();
        $existingEntry = Entry::where('user_id', $userId)->where('product_draw_id', $id)->first();
        if ($existingEntry) {
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => 'You have already entered this product draw']);
            return redirect()->back()->with('error', 'You have already entered this product draw');
        }

        $wallet = Wallet::where('user_id', $userId)->first();
        if (!$wallet) {
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => 'Please create a wallet first']);
            return redirect()->back()->with('error', 'Please create a wallet first');
        }

        if ($wallet->balance < $draw->entry_fee) {
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => 'Insufficient wallet balance. Please add funds first.']);
            return redirect()->back()->with('error', 'Insufficient wallet balance. Please add funds first.');
        }

        DB::beginTransaction();
        try {
            $entryNumber = 'ENT-' . strtoupper(Str::random(8));

            $entry = new Entry();
            $entry->user_id = $userId;
            $entry->product_draw_id = $id;
            $entry->entry_number = $entryNumber;
            $entry->amount_paid = $draw->entry_fee;
            $entry->entry_date = now();
            $entry->save();

            $newBalance = $wallet->balance - $draw->entry_fee;
            $wallet->balance = $newBalance;
            $wallet->save();

            $transaction = new WalletTransaction();
            $transaction->wallet_id = $wallet->id;
            $transaction->type = 'draw_entry';
            $transaction->amount = -$draw->entry_fee;
            $transaction->balance_before = $wallet->balance + $draw->entry_fee;
            $transaction->balance_after = $newBalance;
            $transaction->status = 'completed';
            $transaction->description = 'Product Draw Entry - ' . $draw->title;
            $transaction->payment_method = 'wallet';
            $transaction->payment_reference = $entryNumber;
            $transaction->save();

            if (isset($draw->participant_count)) {
                $draw->participant_count = $draw->participant_count + 1;
            } else {
                $draw->participant_count = 1;
            }
            $draw->save();

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully entered the product draw! Your entry number is: ' . $entryNumber,
                    'entry_number' => $entryNumber
                ]);
            }
            return redirect()->route('product-draw-detail', $id)->with('success', 'Successfully entered the product draw! Your entry number is: ' . $entryNumber);
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            Log::error('Product draw entry failed: ' . $e->getMessage());
            if ($request->ajax())
                return response()->json(['success' => false, 'message' => 'Failed to enter the draw. Please try again.']);
            return redirect()->back()->with('error', 'Failed to enter the draw. Please try again.');
        }
    }
}
