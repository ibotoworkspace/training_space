@extends('layouts.index')
@section('content')
    <div class="container">
        <h2>Upload Media</h2>
        <form action="{{ route('saveMedia') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="media">Choose File(s):</label>
                <input type="file" name="media[]" id="media" multiple class="form-control-file">
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
    <hr>
    <div class="container">
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
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <img src="{{ asset('media/' . $file) }}" class="card-img-top copy-url" alt="{{ $file }}" data-url="{{ asset('media/' . $file) }}">
                    </div>
                </div>
            @endif
            @endforeach
        </div>
    </div>
    
@endsection