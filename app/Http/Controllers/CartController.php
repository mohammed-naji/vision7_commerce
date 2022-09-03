<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function cart()
    {
        return view('site.cart');
    }

    public function update_cart(Request $request)
    {
        // dd($request->all());
        foreach($request->qyt as $product_id => $q) {
            Cart::where('user_id', Auth::id())
            ->where('product_id', $product_id)
            ->update(['quantity' => $q]);
        }

        return redirect()->back();
    }

    public function remove_cart($id)
    {
        Cart::destroy($id);
        return redirect()->back();
    }

    public function checkout()
    {
        $total = Cart::where('user_id', Auth::id())->sum(DB::raw('price * quantity'));
        // dd($total);

        $url = "https://eu-test.oppwa.com/v1/checkouts";
        $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
                    "&amount=$total" .
                    "&currency=USD" .
                    "&paymentType=DB";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $responseData = json_decode($responseData, true);
        $id = $responseData['id'];

        return view('site.checkout', compact('id'));
    }

    public function payment(Request $request)
    {
        $resourcePath = $request->resourcePath;
        $url = "https://eu-test.oppwa.com$resourcePath";
        $url .= "?entityId=8a8294174b7ecb28014b9699220015ca";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $responseData = json_decode($responseData, true);

        // dd($responseData);
        $total = $responseData['amount'];
        $transaction_id = $responseData['id'];

        $code = $responseData['result']['code'];
        if($code == '000.100.110') {

            DB::beginTransaction();
            try {
                // Create New Order
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'total' => $total
                ]);

                // Add Cart Items To Order Items Table
                foreach(Auth::user()->carts as $cart) {
                    OrderItem::create([
                        'price' => $cart->price,
                        'quantity' => $cart->quantity,
                        'user_id' => $cart->user_id,
                        'product_id' => $cart->product_id,
                        'order_id' => $order->id
                    ]);

                    $cart->product()->update([
                        'quantity' => $cart->product->quantity - $cart->quantity
                    ]);
                    $cart->delete();
                }

                // Remove Carts From Cart Table

                // Crteate New Payment

                Payment::create([
                    'total' => $total,
                    'user_id' => Auth::id(),
                    'order_id' => $order->id,
                    'transaction_id' => $transaction_id
                ]);

                // Send Notification to Admin "New Order Create"



                DB::commit();
            }catch(Exception $e) {
                DB::rollBack();
                throw new Exception($e->getMessage());
            }

            return redirect()->route('site.payment_success');
        }else {
            return redirect()->route('site.payment_fail');
        }
    }

    public function payment_success()
    {
        return view('site.payment_success');
    }

    public function payment_fail()
    {
        return view('site.payment_fail');
    }
}
