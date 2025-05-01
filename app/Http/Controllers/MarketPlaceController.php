<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;

class MarketPlaceController extends Controller
{
    /* to handle index view */
    public function index ()
    {
        /* get banner and product data */
        $banner = Banner::where('is_active', 1)->get();
        $product = Product::where('is_active', 1)->get();

        /* parsing to view */
        return view('marketplace.index', compact('banner', 'product'));
    }

    /* to handle mycart view */
    public function myCart ()
    {
        /* parsing to view */
        return view('marketplace.mycart');
    }

    /* to handle detail product */
    public function detailProduct ($slug)
    {
        /* get data from slug */
        $products = Product::where('is_active', 1)->get();

        $product = $products->firstWhere('slug', $slug);
        if (!$product) {
            abort(404);
        }

        $anotherProduct = $products->where('slug', '!=', $slug)->values();
        /* parsing to view */
        return view('marketplace.detail', compact('product', 'anotherProduct'));
    }
}
