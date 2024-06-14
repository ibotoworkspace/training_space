@extends('layouts.index')
@section('content')
@php $pagetype = "wyswyg"; @endphp
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <h2>Send Post</h2>
            <form action="{{ route('save-post-update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="author" value="{{Auth::id()}}">
                <input type="hidden" name="post_id" value="{{$post->id}}">
                <input type="hidden" name="old_featured" value="{{$post->featured}}">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" value="{{$post->title}}">
                </div>
                <div class="form-group">
                    <label for="subtitle">Subtitle</label>
                    <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Enter subtitle"  value="{{$post->subtitle}}">
                </div>
                <div class="form-group">
                    <label for="wyswyg">Description</label>
                    <textarea class="form-control" id="wyswyg" name="description" rows="5" placeholder="Enter description">{!!$post->description!!}</textarea>
                </div>

                <div class="row">

                    <div class="form-group col-md-4">
                        <label for="category_id">Category:</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <!-- Populate options dynamically from database -->
                            <option  value="{{$post->category_id}}" selected>{{$post->Category->category_name}}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label for="featured">Featured Image</label>
                        <input type="file" class="form-control-file" id="featured" name="featured">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="user_id">Send To (Optional):</label>
                        <select name="user_id" id="user_id" class="form-control">
                            <!-- Populate options dynamically from database -->
                            <option value="{{$post->user_id ?? ""}}" selected>{{$post->SentTo ? $post->SentTo->name : ""}}</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Update Post</button>
            </form>
        </div>
    </div>
</div>


@endsection