<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the temporary public homepage.
     */
    public function index(): View
    {
        $seller = null;
        if (Auth::check() && Auth::user()->isSeller()) {
            $seller = Auth::user()->seller;
        }

        return view('home.index', [
            'seller' => $seller,
        ]);
    }
}

