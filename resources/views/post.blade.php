@extends('layouts.index')
@section('content')
@php $pagetype = "wyswyg"; @endphp
<div class="container">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h2>{{ $post->title }}</h2>
                        <h5>{{ $post->subtitle }}</h5>
                        <img src="{{ asset($post->featured) }}" alt="{{ $post->title }}" class="img-fluid mb-3">
                        <p>{!! $post->description !!}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <img src="/images/advert.jpg" width="100%" height="auto" alt="ADVERT">
                <hr>
                <h3>Next Step</h3>
                <hr>
                <p>To Enroll Simply</p>
                <ul>
                    <li>Go to the Courses Page</li>
                    <li>Click on the Course</li>
                    <li>Click on Enroll</li>
                </ul>
            </div>
        </div>
    </div></div>

@endsection