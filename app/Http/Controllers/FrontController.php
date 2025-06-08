<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Seller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Services\FrontService;


class FrontController extends Controller
{
    protected $frontService;

    public function __construct(FrontService $frontService)
    {
        $this->frontService = $frontService;
    }
    //konsep service repository pattern
    public function index()
    {

        $data = $this->frontService->getFrontPageData();
        // dd($data);
        return view('front.index', $data);
    }
    //model binding

    public function details(Ticket $ticket)
    {
        // dd($ticket);
        return view('front.details', compact('ticket'));
    }

    public function booking(Ticket $ticket)
    {
        return view('front.booking', compact('category'));
    }

    public function category(Category $category)
    {
        // dd($category);
        return view('front.category', compact('category'));
    }
    public function explore(Seller $seller)
    {
        // dd($category);
        return view('front.seller', compact('seller'));
    }

    public function testimoni()
    {
        return view('front.testimoni');
    }
    public function support()
    {
        return view('front.support');
    }
}
