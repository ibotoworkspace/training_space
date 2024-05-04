@extends('layouts.index')
@section('content')
@php $pagetype = "wyswyg"; @endphp
<div class="container">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <h2>{{ $post->title }}</h2>
                        <h5>{{ $post->subtitle }}</h5>
                        <img src="{{ asset($post->featured) }}" alt="{{ $post->title }}" class="img-fluid mb-3">
                        <p>{{ $post->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div></div>

@endsection