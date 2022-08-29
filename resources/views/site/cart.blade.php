@extends('site.master')

@section('title', 'Cart | ' . config('app.name'))

@section('content')
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Cart</h1>
					<ol class="breadcrumb">
						<li><a href="index-2.html">Home</a></li>
						<li class="active">cart</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="page-wrapper">
    <div class="cart shopping">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <div class="block">
              <div class="product-list">
                <form method="post" action="{{ route('site.update_cart') }}">
                    @csrf
                  <table class="table">
                    <thead>
                      <tr>
                        <th class="">Item Name</th>
                        <th class="">Item Quantity</th>
                        <th class="">Item Price</th>
                        <th class="">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp

						@foreach (Auth::user()->carts as $cart)
                        <tr class="">
                        <td class="">
                            <div class="product-info">
                            <img width="80" src="{{ asset('uploads/products/'.$cart->product->image) }}" alt="">
                            <a href="{{ route('site.product', $cart->product_id) }}">{{ $cart->product->trans_name }}</a>
                            </div>
                        </td>
                        <td class=""><input style="width: 80px " type="number" name="qyt[{{ $cart->product_id }}]" value="{{ $cart->quantity }}"></td>
                        <td class="">${{ $cart->price }}</td>
                        <td class="">
                            <a class="product-remove" href="{{ route('site.remove_cart', $cart->id) }}">Remove</a>
                        </td>
                        </tr>
                        @php
                            $total += $cart->price * $cart->quantity;
                        @endphp
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2">Total</th>
                            <th colspan="2">${{ $total }}</th>
                        </tr>
                    </tfoot>
                  </table>
                  <button class="btn btn-main pull-left">Update Cart</button>
                  <a href="{{ route('site.checkout') }}" class="btn btn-main pull-right">Checkout</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- <div id="smart-button-container">
    <div style="text-align: center;">
      <div id="paypal-button-container"></div>
    </div>
  </div>
<script src="https://www.paypal.com/sdk/js?client-id=sb&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
<script>
  function initPayPalButton() {
    paypal.Buttons({
      style: {
        shape: 'rect',
        color: 'gold',
        layout: 'vertical',
        label: 'paypal',

      },

      createOrder: function(data, actions) {
        return actions.order.create({
          purchase_units: [{"amount":{"currency_code":"USD","value":1}}]
        });
      },

      onApprove: function(data, actions) {
        return actions.order.capture().then(function(orderData) {

          // Full available details
          console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

          // Show a success message within this page, e.g.
          const element = document.getElementById('paypal-button-container');
          element.innerHTML = '';
          element.innerHTML = '<h3>Thank you for your payment!</h3>';

          // Or go to another URL:  actions.redirect('thank_you.html');

        });
      },

      onError: function(err) {
        console.log(err);
      }
    }).render('#paypal-button-container');
  }
  initPayPalButton();
</script> --}}
@stop

