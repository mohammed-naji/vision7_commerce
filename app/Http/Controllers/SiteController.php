<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $slider_products = Product::orderByDesc('id')->take(3)->get();
        $categories = Category::orderByDesc('id')->get();
        $products = Product::inRandomOrder()->take(6)->get();

        return view('site.index', compact('slider_products', 'categories', 'products'));
    }

    public function product($id)
    {
        $product = Product::findOrFail($id);
        $related = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->orderByDesc('id')
        ->limit(4)
        ->get();

        $next = Product::where('id', '>', $product->id)->first();
        $prev = Product::where('id', '<', $product->id)->orderByDesc('id')->first();

        return view('site.product', compact('product', 'related', 'next', 'prev'));
    }
}
