@extends('admin.master')

@section('title', 'Dashboard | Admin')


@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Add new Product</h1>
@include('admin.errors')
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label>English Name</label>
                <input type="text" name="name_en" placeholder="English Name" class="form-control" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label>Arabic Name</label>
                <input type="text" name="name_ar" placeholder="Arabic Name" class="form-control" />
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label>English Content</label>
                <textarea name="content_en" placeholder="English Content" class="form-control customarea"></textarea>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label>Arabic Name</label>
                <textarea name="content_ar" placeholder="Arabic Content" class="form-control customarea"></textarea>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label>Image</label>
        <input type="file" name="image" class="form-control" />
    </div>

    <div class="mb-3">
        <label>Price</label>
        <input type="number" name="price" placeholder="Price" class="form-control" />
    </div>

    <div class="mb-3">
        <label>Sale Price</label>
        <input type="number" name="sale_price" placeholder="Sale Price" class="form-control" />
    </div>

    <div class="mb-3">
        <label>Quantity</label>
        <input type="number" name="quantity" placeholder="Quantity" class="form-control" />
    </div>

    <div class="mb-3">
        <label>Parent</label>
        <select name="category_id" class="form-control">
            <option value="">--Select Parent--</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->trans_name }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-success w-25">Add</button>
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
