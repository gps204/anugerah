<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalCustomers = Customer::count();

        $recentProducts = Product::with('translation')->latest()->take(5)->get();
        $recentCustomers = Customer::latest()->take(5)->get();

        return view('admin.home', compact(
            'totalProducts',
            'totalCategories',
            'totalCustomers',
            'recentProducts',
            'recentCustomers'
        ));
    }
}
