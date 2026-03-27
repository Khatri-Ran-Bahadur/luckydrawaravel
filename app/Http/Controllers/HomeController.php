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
        $this->cashDraw->updateExpiredDraws();
        return view('web.cashdraws');
    }

    public function productDraws()
    {
        return view('web.productdraws');
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
