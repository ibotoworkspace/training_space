@extends('layouts.index')
@section('content')
@php
    $pagetype = "wyswyg";
@endphp
<div class="container">
        {!! Form::model($course, ['method' => 'PATCH', 'files' => 'true', 'action' => ['CourseController@update',  $course->id ?? ""], 'id' => 'course_create_form']) !!}
        @include('courses.edit-content-form')
</div>
@endsection