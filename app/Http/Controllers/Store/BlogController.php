<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Menampilkan daftar semua postingan blog yang sudah dipublikasikan.
     */
    public function index()
    {
        $blogs = Blog::with('user')
            ->where('status', 'published')
            ->latest()
            ->paginate(9); // Menampilkan 9 postingan per halaman

        return view('themes.xylo.blog', compact('blogs'));
    }

    /**
     * Menampilkan satu postingan blog secara detail.
     */
    public function show($slug)
    {
        $blog = Blog::with('user')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('themes.xylo.blog-show', compact('blog'));
    }
}