<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductPageController extends Controller
{
    /**
     * Menampilkan halaman toko dengan daftar produk.
     */
    public function index(Request $request)
    {
        $query = Product::with(['translations', 'images'])->where('status', 1);
 
        // Menambahkan logika filter berdasarkan input dari request
        $query->when($request->filled('brand'), function ($q) use ($request) {
            $q->whereIn('brand_id', $request->brand);
        });
 
        $query->when($request->filled('category'), function ($q) use ($request) {
            $q->whereIn('category_id', $request->category);
        });
 
        // Menggunakan withQueryString() agar filter tetap ada saat paginasi
        $products = $query->latest()->paginate(9)->withQueryString();
 
        // Mengambil brand dan kategori yang aktif dan memiliki produk untuk ditampilkan di sidebar
        $brands = Brand::with('translation')->where('status', 1)->has('products')->withCount('products')->get();
        $categories = Category::with('translation')->where('status', 1)->has('products')->withCount('products')->get();

        if ($request->ajax()) {
            $products_html = view('themes.xylo.partials.product-list', compact('products'))->render();
            $pagination_html = $products->links()->toHtml();
            return response()->json(['products_html' => $products_html, 'pagination_html' => $pagination_html]);
        }

        return view('themes.xylo.shop', compact('products', 'brands', 'categories'));
    }

    /**
     * Menampilkan halaman detail untuk satu produk.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['translations', 'images', 'category.translation', 'brand.translation'])
            ->where('status', 1)
            ->firstOrFail();

        // Ambil pengaturan situs untuk mendapatkan nomor kontak (WhatsApp)
        $site_settings = SiteSetting::first();

        return view('themes.xylo.product-detail', compact('product', 'site_settings'));
    }
}