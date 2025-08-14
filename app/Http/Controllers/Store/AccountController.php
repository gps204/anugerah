<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Menampilkan halaman profil pelanggan.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $customer = Auth::guard('customer')->user();
        // Pastikan Anda membuat view di: resources/views/themes/xylo/customer/profile.blade.php
        return view('themes.xylo.customer.profile', compact('customer'));
    }

    /**
     * Menampilkan halaman pesanan pelanggan.
     *
     * @return \Illuminate\View\View
     */
    public function orders()
    {
        $customer = Auth::guard('customer')->user();
        // Asumsi relasi 'orders' ada di model Customer
        $orders = $customer->orders()->latest()->paginate(10);
        // Pastikan Anda membuat view di: resources/views/themes/xylo/customer/orders.blade.php
        return view('themes.xylo.customer.orders', compact('orders'));
    }
}