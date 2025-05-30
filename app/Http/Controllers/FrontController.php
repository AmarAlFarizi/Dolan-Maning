<?php

namespace App\Http\Controllers;

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
    public function index(){

        $data = $this->frontService->getFrontPageData();
        dd($data);
    }
    
}
