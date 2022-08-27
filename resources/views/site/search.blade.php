@extends('site.master')

@section('title', 'Shop | ' . config('app.name'))

@section('content')
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
                    <form action="{{ route('site.search') }}" method="GET">
                        <div class="row">
                            <div class="col-md-11">
                                <input type="search" class="form-control" placeholder="Search..." name="s" value="{{ request()->s }}">
                            </div>
                            <div class="col-md-1">
                                <button style="padding: 9px 17px" class="btn btn-main">Search</button>
                            </div>
                        </div>
                    </form>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="products section">
	<div class="container">
		<div class="row">
            @foreach ($products as $product)
            <div class="col-md-4">
				@include('site.parts.product_box')
			</div>
            @endforeach
		</div>
	</div>
</section>
@stop
