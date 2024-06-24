@extends('layouts.index')
@section('content')
@php
    $pagetype = "wyswyg";
@endphp
<div class="container" style="padding-bottom: 30px;">
        @include('courses.edit-content-form')
</div>
@endsection