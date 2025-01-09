@extends('layouts.index')

@section('content')

<div class="row">
    @if (Auth::check() && (Auth::user()->role->first()->name == 'Instructor' or Auth::user()->role->first()->name == "Admin"))
    <a href="{{ route('course.create') }}" class="btn btn-secondary" id="course_button">Add New Course</a>
    <a href="{{ route('content-form') }}" class="btn btn-primary" id="course_button">Add Course Contents</a>
    <a href="{{ route('quiz-form') }}" class="btn btn-success" id="course_button">Add Quiz/Tests</a>
    <a href="{{ route('create-category') }}" class="btn btn-danger" id="course_button">Course Categories</a>
@endif
</div>
<div class="container">
    @isset($posts)       
    
        <div class="row" style="background-color: black; opacity: 0.8;">
            <div class="col-md-8">
                <style>
                    .carousel-item {
                        background-color: transparent;
                        color: white;
                    }
                    .carousel-caption {
                        background-color: rgba(0, 0, 0, 0.5); /* Transparent black background */
                        width: 100%;
                    }

                    .carousel-item img {
                        height: 500px !important;
                        width: 100% !important;
                    }
                </style>
                
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($posts as $key => $post)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <img class="d-block w-100" src="{{ asset($post->featured) }}" alt="{{ $post->title }}">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>{{ $post->title }}</h5>
                                    <p>{{ $post->subtitle }}</p>
                                    <a href="{{ route('post', $post->id) }}" class="btn btn-primary">Read More</a>

                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                
            </div>
            <div class="col-md-4">
                <img src="/images/advert.jpg" width="100%" height="auto" alt="ADVERT">
            </div>
       </div>
            
        </div>
    @endisset
    @if (auth())
        <h1 class="my-4">My Course(s)</h1>

    @else
        <h1 class="my-4">All Courses</h1>

    @endif
    <div class="row">
        
            @if ($courses->isEmpty())
                @if (session('course'))
                    <div class="card-body">
                        <h2 class="alert alert-info">
                            {{ session('course') }}
                        </h2>
                    </div>
                @endif
            @else
                
                @foreach ($courses as $course)

                        <div class="col-md-6" style="float: left;">
                            <div class="card mb-4">
                                <img class="card-img-top" src="{{'/'.$course->thumbnail}}" alt="{{ $course['thumbnail'] }}" width="100%" style="width: 100% !important; ">
                                {{-- <a href = "{{ route('course.show', [$course->id]) }}">{!! Html::image( '/storage/'.$course->thumbnail, 'Thumbnail') !!}</a> --}}
                                <div class="card-body">
                                    <h2 class="card-title"><a href = "{{ route('course.show', [$course->id]) }}">{{ $course['title'] }}</a></h2>
                                    <p class="card-text">{!!  \Illuminate\Support\Str::limit($course['description'], 200, '...') !!}</p>
                                </div>
                                <div class="card-footer text-muted">
                                    Author: {{ $course->author['name'] }}

                                    <a href="{{ route('course.show', [$course->id]) }}" class="btn btn-primary btn-xs" style="float: right;">Read More</a>
                                </div>
                            </div>
                        </div>

                @endforeach
            @endif
        
    </div>
</div>


@endsection