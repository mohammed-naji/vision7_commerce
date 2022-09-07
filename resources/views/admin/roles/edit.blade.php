@extends('admin.master')

@section('title', 'Edit Role | Admin')

@section('styles')

<style>
    ul {
        column-count: 2;
    }
</style>

@stop

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Edit Role</h1>
@include('admin.errors')
<form action="{{ route('admin.roles.update', $role->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('put')

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" placeholder="Name" class="form-control" value="{{ $role->name }}" />
    </div>

    <label><input type="checkbox" id="check_all"> Select All</label> <br>
    <ul class="list-unstyled">
        @foreach ($abilities as $ability)
            <li><label><input {{ $role->abilities->find($ability->id) ? 'checked' : '' }} type="checkbox" name="ability[]" value="{{ $ability->id }}"> {{ $ability->name }}</label></li>
        @endforeach
    </ul>

    <button class="btn btn-info w-25">Updated</button>
</form>
@stop

@section('scripts')
<script>
    $('#check_all').on('change', function() {
        $('input[type=checkbox]').prop('checked', $(this).prop('checked'));
    })
</script>
@stop
