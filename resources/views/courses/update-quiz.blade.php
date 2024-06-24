@extends('layouts.index')
@section('content')
    @php
    $pagetype = "wyswyg";
    @endphp
    <div class="container">
        @include('courses.edit-quiz-form')
    </div>
@endsection