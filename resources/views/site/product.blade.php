@extends('site.master')

@section('title', $product->trans_name . ' | ' . config('app.name'))

@section('content')
<section class="single-product">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<ol class="breadcrumb">
					<li><a href="{{ route('site.index') }}">Home</a></li>
					<li><a href="{{ route('site.shop') }}">Shop</a></li>
					<li class="active">{{ $product->trans_name }}</li>
				</ol>
			</div>
			<div class="col-md-6">
				<ol class="product-pagination text-right">
                    @if ($next)
                        <li><a href="{{ route('site.product', $next->id) }}"><i class="tf-ion-ios-arrow-left"></i> Next </a></li>
                    @endif

                    @if ($prev)
                    <li><a href="{{ route('site.product', $prev->id) }}">Preview <i class="tf-ion-ios-arrow-right"></i></a></li>
                    @endif

				</ol>
			</div>
		</div>
		<div class="row mt-20">
			<div class="col-md-5">
				<img width="100%" src="{{ asset('uploads/products/'.$product->image) }}" alt="">
			</div>
			<div class="col-md-7">
				<div class="single-product-details">
					<h2>{{ $product->trans_name }}</h2>
					<p class="product-price">${{ $product->sale_price ? $product->sale_price : $product->price }}</p>

					<p class="product-description mt-20">
						{{ Str::words(strip_tags($product->trans_content), 30, '...') }}
                    </p>
					{{-- <div class="color-swatches">
						<span>color:</span>
						<ul>
							<li>
								<a href="#!" class="swatch-violet"></a>
							</li>
							<li>
								<a href="#!" class="swatch-black"></a>
							</li>
							<li>
								<a href="#!" class="swatch-cream"></a>
							</li>
						</ul>
					</div>
					<div class="product-size">
						<span>Size:</span>
						<select class="form-control">
							<option>S</option>
							<option>M</option>
							<option>L</option>
							<option>XL</option>
						</select>
					</div> --}}
					<div class="product-category">
						<span>Category:</span>
						<ul>
							<li><a href="product-single.html">{{ $product->category->trans_name }}</a></li>
						</ul>
					</div>
					<div class="product-quantity">
						<span>Quantity:</span>
						<div class="product-quantity-slider">
							<input id="product-quantity" type="text" value="0" name="product-quantity">
						</div>
					</div>
					<a href="cart.html" class="btn btn-main mt-20">Add To Cart</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="tabCommon mt-20">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#details" aria-expanded="true">Details</a></li>
						<li class=""><a data-toggle="tab" href="#reviews" aria-expanded="false">Reviews ({{ $product->reviews->count() }})</a></li>
					</ul>
					<div class="tab-content patternbg">
						<div id="details" class="tab-pane fade active in">
							<h4>Product Description</h4>
							{!! $product->trans_content !!}
						</div>
						<div id="reviews" class="tab-pane fade">
							<div class="post-comments">
						    	<ul class="media-list comments-list m-bot-50 clearlist">
                                    @foreach ($product->reviews as $review)
                                    <li class="media">
								        <a class="pull-left" href="#!">
								            <img class="media-object comment-avatar" src="https://ui-avatars.com/api/?name={{ $review->user->name }}" alt="" width="50" height="50" />
								        </a>

								        <div class="media-body">
								            <div class="comment-info">
								                <h4 class="comment-author">
								                    <a href="#!">{{ $review->user->name }}</a>

								                </h4>
								                <time datetime="2013-04-06T13:53">
                                                    {{ $review->created_at->format('F d, Y') }}, at {{ $review->created_at->format('h:m a') }}</time>
								                <a class="comment-button" href="#!"><i class="tf-ion-star"></i>{{ $review->star }}</a>
								            </div>

								            <p>
								                {{ $review->comment }}
								            </p>
								        </div>

								    </li>
                                    @endforeach
							</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="products related-products section">
	<div class="container">
		<div class="row">
			<div class="title text-center">
				<h2>Related Products</h2>
			</div>
		</div>
		<div class="row">
			@foreach ($related as $product)
            <div class="col-md-3">
				@include('site.parts.product_box')
			</div>
            @endforeach
		</div>
	</div>
</section>
@stop
