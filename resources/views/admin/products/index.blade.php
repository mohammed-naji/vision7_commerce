@extends('admin.master')

@section('title', 'Dashboard | Admin')

@section('styles')

<style>
    .table th,
    .table td {
        vertical-align: middle
    }
</style>

@stop

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">All Products</h1>

@if (session('msg'))
    <div class="alert alert-{{ session('type') }}">
        {{ session('msg') }}
    </div>
@endif

<table class="table table-bordered table-striped table-hover">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Image</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Category</th>
        <th>Actions</th>
    </tr>
    @foreach ($products as $product)
    <tr>
        <td>{{ $product->id }}</td>
        <td>{!! str_replace('script>', 'p>', $product->trans_name) !!}</td>
        <td><img width="80" src="{{ asset('uploads/products/'.$product->image) }}" alt=""></td>
        <td>{{ $product->price }}</td>
        <td>{{ $product->quantity }}</td>
        <td>{{ $product->category->trans_name }}</td>
        <td>
            <a class="btn btn-sm btn-primary" href="{{ route('admin.products.edit', $product->id) }}"><i class="fas fa-edit"></i></a>
            <form class="d-inline" action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                @csrf
                @method('delete')
                <button onclick="return confirm('Are you sure?!')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
            </form>
        </td>
    </tr>
    @endforeach

</table>
{{ $products->links() }}
@stop
