<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product; 


class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('front-user.pages.home');
    }

    public function productList()
    {
        $products = Product::get();

        return view('front-user.products', compact('products'));
    }

  }
