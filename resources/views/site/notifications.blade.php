@extends('site.master')

@section('title', 'Cart | ' . config('app.name'))

@section('content')
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Notifications</h1>
					<ol class="breadcrumb">
						<li><a href="index-2.html">Home</a></li>
						<li class="active">Notifications</li>
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
                <div class="list-group">
                    @foreach ($user->notifications as $item)
                    <a href="{{ route('rn', $item->id) }}" class="list-group-item {{ $item->read_at ? 'active' : '' }}">
                        <span class="pull-left">{{ $item->data['msg'] }}</span>
                        <small class="pull-right">{{ $item->created_at->diffForHumans() }}</small>
                        <div class="clearfix"></div>
                    </a>
                    @endforeach
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop

