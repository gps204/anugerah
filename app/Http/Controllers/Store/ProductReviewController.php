<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $customer = Auth::guard('customer')->user();

        // Check if the user has already reviewed this product
        $existingReview = ProductReview::where('customer_id', $customer->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already submitted a review for this product.');
        }

        ProductReview::create([
            'product_id' => $request->product_id,
            'customer_id' => $customer->id,
            'rating' => $request->rating,
            'review' => $request->review,
            'is_approved' => false, // Reviews should be approved by an admin by default
        ]);

        return back()->with('success', 'Your review has been submitted and is pending approval. Thank you!');
    }
}