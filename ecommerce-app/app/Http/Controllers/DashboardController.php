<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ViewedProduct;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('userReviews')
            ->withAvg('userReviews', 'rating')
            ->withCount('userReviews');

        $sortAlphabet = $request->input('sort-alphabet');
        $sortPrice = $request->input('sort-price');
        $sortRating = $request->input('sort-rating');
        $filterCategory = $request->input('category');
        $search = $request->input('search');

        // Check if multiple sorting options are selected at once
        $sortingOptionsSelected = array_filter([$sortAlphabet, $sortPrice, $sortRating]);
        if (count($sortingOptionsSelected) > 1) {
            // Redirect back with an error message
            return redirect('/dashboard')->with('error', 'Please select only one sorting option at a time.');
        }

        // Filter by category
        if ($filterCategory) {
            $products = $products->where('product_category_id', $filterCategory);
        }

        if ($search)
        {
            $products = $products->where('name', 'LIKE', '%' . $search . '%');
        }
        
        switch (true) {
            case $sortAlphabet === 'az':
                $products = $products->orderBy('name', 'ASC');
                break;
            case $sortAlphabet === 'za':
                $products = $products->orderBy('name', 'DESC');

                break;
            case $sortPrice === 'low-high':
                $products = $products->orderBy('price', 'ASC');
                break;
            case $sortPrice === 'high-low':
                $products = $products->orderBy('price', 'DESC');
                break;
            case $sortRating === 'low-high':
                $products = $products->orderBy('user_reviews_avg_rating', 'asc');
                break;
            case $sortRating === 'high-low':
                $products = $products->orderBy('user_reviews_avg_rating', 'desc');
                break;
        }
        $recentlyViewedProducts = collect();
        if (Auth::check()) {
            $recentlyViewedProducts = ViewedProduct::where('user_id', Auth::id())
                ->with('product')
                ->orderBy('viewed_at', 'desc')
                ->take(5)
                ->get();
        }

        $products = $products->get();

        return view('dashboard', [
            'products' => $products,
            'recentlyViewedProducts' => $recentlyViewedProducts,
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        if ($search)
        {
            $products = DB::table('products')->where('name', $search)->get();
            return view('dashboard', [
                'products' => $products,
            ]);
        }

        $products = Product::all();
        return view('dashboard', [
            'products' => $products,
            'recentlyViewedProducts' => [],
        ]);
    }
}
