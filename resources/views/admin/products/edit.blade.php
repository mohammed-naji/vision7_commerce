@extends('admin.master')

@section('title', 'Edit Product | Admin')


@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Edit Product</h1>
@include('admin.errors')
<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('put')

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label>English Name</label>
                <input type="text" name="name_en" placeholder="English Name" class="form-control" value="{{ $product->name_en }}" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label>Arabic Name</label>
                <input type="text" name="name_ar" placeholder="Arabic Name" class="form-control" value="{{ $product->name_ar }}"/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label>English Content</label>
                <textarea name="content_en" placeholder="English Content" class="form-control customarea">{{ $product->content_en }}</textarea>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label>Arabic Name</label>
                <textarea name="content_ar" placeholder="Arabic Content" class="form-control customarea">{{ $product->content_ar }}</textarea>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label>Image</label>
        <input type="file" name="image" class="form-control" />
        <img width="80" src="{{ asset('uploads/products/'.$product->image) }}" alt="">
    </div>

    <div class="mb-3">
        <label>Price</label>
        <input type="number" name="price" placeholder="Price" class="form-control" value="{{ $product->price }}" />
    </div>

    <div class="mb-3">
        <label>Sale Price</label>
        <input type="number" name="sale_price" placeholder="Sale Price" class="form-control" value="{{ $product->sale_price }}" />
    </div>

    <div class="mb-3">
        <label>Quantity</label>
        <input type="number" name="quantity" placeholder="Quantity" class="form-control" value="{{ $product->quantity }}" />
    </div>

    <div class="mb-3">
        <label>Category</label>
        <select name="category_id" class="form-control">
            <option value="">--Select Parent--</option>
            @foreach ($categories as $item)
                <option {{ $product->category_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->trans_name }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-info w-25">Updated</button>
</form>
@stop

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.1.2/tinymce.min.js"></script>

<script>
    tinymce.init({
        selector: '.customarea',
        plugins: ['code']
    })
</script>

@stop
