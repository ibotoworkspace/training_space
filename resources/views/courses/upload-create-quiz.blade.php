@extends('layouts.index')
@section('content')
    @php
    $pagetype = "wyswyg";
    @endphp
    <div class="container">
        @include('courses.upload-quiz-form')
    </div>
@endsection