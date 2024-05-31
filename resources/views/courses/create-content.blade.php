@extends('layouts.index')
@section('content')
    @php
    $pagetype = "wyswyg";
    @endphp
    <div class="container row">
        <div class="col-md-8">
            @include('courses.content-form')
        </div>
        <div class="col-md-4">
            <h2>Media Gallery</h2>
            <div class="row">
                @php
                    $directory = public_path('media');
                    $files = scandir($directory);
                @endphp

                @foreach ($files as $file)
                @php
                    $extension = pathinfo($file, PATHINFO_EXTENSION);
                @endphp
                @if (in_array($extension, ['png', 'jpg', 'jpeg'], true))
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="{{ asset('media/' . $file) }}" class="card-img-top copy-url" alt="{{ $file }}" data-url="{{ asset('media/' . $file) }}">
                        </div>
                    </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
    
@endsection