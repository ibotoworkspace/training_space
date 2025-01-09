@extends('layouts.index')
@section('content')

@if (Auth::check() && (Auth::user()->role->first()->name == 'Instructor' or Auth::user()->role->first()->name == "Admin"))
@php $pagetype = "report"; @endphp
    <div class="container mt-5">
        <div class="row">
            <a href="{{url('publish-post')}}" class="btn btn-primary">New Post</a>
        </div>
        <h3>All Posts</h3>
        <table class="table table-striped table-responsive" id="products">
            <thead>
            <tr>
                <th>Post Title</th>
                <th>Category</th>
                <th>Sent To</th>
                <th>Created By</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            
            @foreach ($posts as $po)
                <tr>
                    <td>{{$po->title}} <br> <small>{{$po->subtitle}}</small></td>
                    <td>{{$po->category->category_name}}</td>
                    <td>{{$po->SentTo->name ?? ""}}</td>
                    <td>{{$po->Author->name ?? ""}}</td>
                    <td>{{$po->created_at}}</td>
                    <td class="btn-group">
                        <a href="{{url('post/'.$po->id)}}" class="btn btn-primary">View</a>
                        <a href="{{url('update-post/'.$po->id)}}" class="btn btn-secondary">Update</a>
                        <a href="{{url('delete-post/'.$po->id)}}" class="btn btn-danger  roledlink Admin" onclick="confirm('Are you sure want to delete this post?')">Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif


@endsection