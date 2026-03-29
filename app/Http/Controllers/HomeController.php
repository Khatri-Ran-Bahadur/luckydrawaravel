<?php

namespace App\Http\Controllers;

use App\Models\CashDraw;
use App\Models\ProductDraw;
use Illuminate\Http\Request;
use App\Models\Winner;
use App\Http\Controllers\Controller;

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
        return view('web.winner');
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
}
