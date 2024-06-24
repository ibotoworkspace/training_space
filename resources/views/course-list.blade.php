@extends('layouts.index')
@section('content')

@if (Auth::check() && (Auth::user()->role->first()->name == 'Instructor' or Auth::user()->role->first()->name == "Admin"))
@php $pagetype = "report"; @endphp
    <div class="container mt-5">
        <div class="row">
            <a href="{{url('course/create')}}" class="btn btn-primary">New Course</a>
        </div>
        <h3>All Courses</h3>
       <div class="col-md-12">
        <table class="table table-striped table-responsive" style="width: 100%" id="products">
            <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Fee(USD)</th>
                <th>Instructor</th>
                <th># of Students</th>
                <th>Date Published</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            
            @foreach ($courses as $co)
                <tr>
                    <td>{{$co->title ?? ""}}</td>
                    <td>{{$co->Category->category_name ?? ""}}</td>
                    <td>{{$co->fee ?? ""}}</td>
                    <td>{{$co->Author->name ?? ""}}</td>
                    <th>{{$co->userCourse ? $co->userCourse->count() : 0 }}</th>
                    <td>{{$co->created_at ?? ""}}</td>
                    <td class="btn-group">                        
                        <a href="{{ route('course.edit', [$co->id]) }}" class="btn btn-secondary">Edit Course</a>
                        <a href="{{url('course/'.$co->id)}}" class="btn btn-primary">View</a>
                        {!! Form::open(['method' =>"delete", 'action' => ['CourseController@destroy', $co->id]]) !!}                        
                                <input class="btn btn-danger" type = "submit" value = "Delete" onclick="confirm('Are you sure want to delete this Course?')">
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
       </div>
    </div>
@endif


@endsection