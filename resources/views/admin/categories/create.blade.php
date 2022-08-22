@extends('admin.master')

@section('title', 'Dashboard | Admin')


@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Add new Category</h1>
@include('admin.errors')
<form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
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

    <div class="mb-3">
        <label>Image</label>
        <input type="file" name="image" class="form-control" />
    </div>

    <div class="mb-3">
        <label>Parent</label>
        <select name="parent_id" class="form-control">
            {{-- <option value="" disabled selected>--Select Parent--</option> --}}
            <option value="">--Select Parent--</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->trans_name }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-success w-25">Add</button>
</form>
@stop
