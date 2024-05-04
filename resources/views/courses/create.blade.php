@extends('layouts.index')
@section('content')
@php
    $pagetype = "wyswyg";
@endphp
    <div class="container">
        {!! Form::open(['method' => 'POST', 'action' => 'CourseController@store', 'id' => 'course_create_form', 'files' => 'true']) !!}
        @include('courses.form')
    </div>
@endsection