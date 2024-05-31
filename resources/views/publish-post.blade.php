@extends('layouts.index')
@section('content')
@php $pagetype = "wyswyg"; @endphp
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <h2>Publish Post</h2>
            <form action="{{ route('save-post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
                </div>
                <div class="form-group">
                    <label for="subtitle">Subtitle</label>
                    <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Enter subtitle">
                </div>
                <div class="form-group">
                    <label for="wyswyg">Description</label>
                    <textarea class="form-control" id="wyswyg" name="description" rows="5" placeholder="Enter description"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="featured">Featured Image</label>
                    <input type="file" class="form-control-file" id="featured" name="featured">
                </div>
                
                <button type="submit" class="btn btn-primary">Publish</button>
            </form>
        </div>
    </div>
</div>


@endsection