<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Notifications\NewOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function index()
    {
        $slider_products = Product::orderByDesc('id')->where('quantity', '>', '0')->take(3)->get();
        $categories = Category::orderByDesc('id')->get();
        $products = Product::inRandomOrder()->where('quantity', '>', '0')->take(6)->get();

        return view('site.index', compact('slider_products', 'categories', 'products'));
    }

    public function product($id)
    {
        $product = Product::findOrFail($id);
        $related = Product::where('category_id', $product->category_id)
        ->where('quantity', '>', '0')
        ->where('id', '!=', $product->id)
        ->orderByDesc('id')
        ->limit(4)
        ->get();

        $next = Product::where('id', '>', $product->id)->where('quantity', '>', '0')->first();
        $prev = Product::where('id', '<', $product->id)->orderByDesc('id')->where('quantity', '>', '0')->first();

        return view('site.product', compact('product', 'related', 'next', 'prev'));
    }

    public function shop()
    {
        $products = Product::orderByDesc('id')->where('quantity', '>', '0')->paginate(9);
        return view('site.shop', compact('products'));
    }

    public function about()
    {
        return view('site.about');
    }

    public function contact()
    {
        return view('site.contact');
    }

    public function category($id)
    {
        $category = Category::find($id);
        $products = $category->products()->where('quantity', '>', '0')->paginate(9);
        return view('site.shop', compact('products', 'category'));
    }

    public function search()
    {
        $products = Product::orderByDesc('id')
        ->where('quantity', '>', '0')
        ->where('name', 'like', '%' . request()->s . '%')
        ->get();
        return view('site.search', compact('products'));
    }

    public function product_review(Request $request, $id)
    {
        $request->validate([
            'rate' => 'required',
            'comment' => 'required',
        ]);

        Review::create([
            'comment' => $request->comment,
            'star' => $request->rate,
            'product_id' => $request->product_id,
            'user_id' => Auth::id()
        ]);

        return redirect()->back();
    }

    public function add_to_cart(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // $cart = Cart::where('user_id', Auth::id())->where('product_id', $id)->first();

        // if($cart) {
        //     $cart->update([
        //         'quantity' => $cart->quantity + $request->quantity
        //     ]);
        // }else {
        //     Cart::create([
        //         'user_id' => Auth::id(),
        //         'product_id' => $id,
        //         'price' => $product->sale_price ? $product->sale_price : $product->price,
        //         'quantity' => $request->quantity,
        //     ]);
        // }

        Cart::updateOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $id
        ],[
            'price' => $product->sale_price ? $product->sale_price : $product->price,
            'quantity' => DB::raw('quantity + '. $request->quantity),
        ]);

        return redirect()->back()->with('msg', 'Product added to cart successfully');
    }





    // Dont Use This function on live website
    public function send_notification()
    {
        $user = User::where('type', 'admin')->first();
        $order = [
            'msg' => 'New like on your post'
        ];
        $user->notify(new NewOrder($order));
    }

    public function user_notification()
    {
        $user = User::where('type', 'admin')->first();
        return view('site.notifications', compact('user'));
    }

    public function read_notification($id)
    {
        $user = User::where('type', 'admin')->first();
        $user->notifications()->find($id)->markAsRead();
        return redirect()->back();
    }
}
