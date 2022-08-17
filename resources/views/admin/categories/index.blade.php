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
<h1 class="h3 mb-4 text-gray-800">All Categories</h1>

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
        <th>Parent</th>
        <th>Actions</th>
    </tr>
    @foreach ($categories as $category)
    <tr>
        <td>{{ $category->id }}</td>
        <td>{{ $category->name }}</td>
        {{-- <td>{{ json_decode($category->name) }}</td> --}}
        {{-- <td>{{ json_decode($category->name, true)[app()->currentLocale()] }}</td> --}}
        {{-- <td>@dump(json_decode($category->name, true)[app()->currentLocale()])</td> --}}
        <td><img width="80" src="{{ asset('uploads/categories/'.$category->image) }}" alt=""></td>
        <td>{{ $category->parent->name }}</td>
        <td>
            <a class="btn btn-sm btn-primary" href="{{ route('admin.categories.edit', $category->id) }}"><i class="fas fa-edit"></i></a>
            <form class="d-inline" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                @csrf
                @method('delete')
                <button onclick="return confirm('Are you sure?!')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
            </form>
        </td>
    </tr>
    @endforeach

</table>
{{ $categories->links() }}
@stop
