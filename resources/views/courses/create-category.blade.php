@extends('layouts.index')
@section('content')
    <div class="container">
        @include('courses.category-form')

        @if ($categories->isEmpty())
    <div class="card-body">
        <h2 class="alert alert-info">No course categories created</h2>
    </div>
@else
    <div class="card-body">
        <h2 class="alert alert-info">All Course Categories</h2>
    </div>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Category Name</th>
            <th scope="col">Description</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($categories as $cat)
                <tr>
                    <td>{{ $cat->category_name }}</td>
                    <td>{{ $cat->description }}</td>
                    <td>
                        <a class="btn btn-danger" onclick="confirm('Are you sure you want to delete the category: {{$cat->category_name}} ?')" href = "{{route('delete-category', [$cat->id])}}">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
    </div>
@endsection