@extends('site.master')

@section('title', $product->trans_name . ' | ' . config('app.name'))

@section('styles')

<style>

.rate {
    float: left;
    height: 46px;
    padding: 0 10px;
}
.rate:not(:checked) > input {
    display: none;
}
.rate:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:20px;
    color:#ccc;
}
.rate:not(:checked) > label:before {
    content: '★ ';
}
.rate > input:checked ~ label {
    color: #000;
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
    color: #000;
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
    color: #000;
}

#product-quantity::-webkit-outer-spin-button,
#product-quantity::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>
@stop

@section('content')
@include('admin.errors')
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
                    @if (session('msg'))
                        <div class="alert alert-success">
                            {{ session('msg') }}
                        </div>
                    @endif
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
							<li><a href="{{ route('site.category', $product->category_id) }}">{{ $product->category->trans_name }}</a></li>
						</ul>
					</div>
                    <form action="{{ route('site.add_to_cart', $product->id) }}" method="POST">
                        @csrf
                        <div class="product-quantity">
                            <span>Quantity:</span>
                            <div class="product-quantity-slider">
                                <input id="product-quantity" type="number" value="1" min="1" max="{{ $product->quantity }}" name="quantity">
                            </div>
                        </div>
                        <button class="btn btn-main mt-20">Add To Cart</button>
                    </form>

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
                            @if ($product->reviews->count() == 0)
                                <p>There is no reviews yet, be the first one</p>
                            @endif
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

                            @auth
                            <h4>Post New Review</h4>
                            <form action="{{ route('site.product_review', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="rate">
                                    <input type="radio" id="star5" name="rate" value="5" />
                                    <label for="star5" title="text">5 stars</label>
                                    <input type="radio" id="star4" name="rate" value="4" />
                                    <label for="star4" title="text">4 stars</label>
                                    <input type="radio" id="star3" name="rate" value="3" />
                                    <label for="star3" title="text">3 stars</label>
                                    <input type="radio" id="star2" name="rate" value="2" />
                                    <label for="star2" title="text">2 stars</label>
                                    <input type="radio" id="star1" name="rate" value="1" />
                                    <label for="star1" title="text">1 star</label>
                                </div>
                                <br>
                                <textarea class="form-control" placeholder="Write Review Here..." rows="5" name="comment"></textarea>
                                <br>
                                <button class="btn btn-main">Sumbit</button>
                            </form>
                            @endauth

                            @guest
                            <p>To be able to add a review you need to be <b><a href="{{ route('login') }}">login</a></b> first</p>
                            @endguest

                            {{-- @if (Auth::check())
                                <h4>Post New Review</h4>
                                <form action="{{ route('site.product_review', $product->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="rate">
                                        <input type="radio" id="star5" name="rate" value="5" />
                                        <label for="star5" title="text">5 stars</label>
                                        <input type="radio" id="star4" name="rate" value="4" />
                                        <label for="star4" title="text">4 stars</label>
                                        <input type="radio" id="star3" name="rate" value="3" />
                                        <label for="star3" title="text">3 stars</label>
                                        <input type="radio" id="star2" name="rate" value="2" />
                                        <label for="star2" title="text">2 stars</label>
                                        <input type="radio" id="star1" name="rate" value="1" />
                                        <label for="star1" title="text">1 star</label>
                                    </div>
                                    <br>
                                    <textarea class="form-control" placeholder="Write Review Here..." rows="5" name="comment"></textarea>
                                    <br>
                                    <button class="btn btn-main">Sumbit</button>
                                </form>
                            @else
                            <p>To be able to add a review you need to be <b><a href="{{ route('login') }}">login</a></b> first</p>
                            @endif --}}


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
