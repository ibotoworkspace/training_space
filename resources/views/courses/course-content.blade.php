@extends('layouts.index')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div>
            <div class="course-title">
                <h1 class = "display-4">{{ $coursecontent->title }}</h4>
            </div>
            
                @php $lastThreeLetters = substr($coursecontent->file_path, -4); @endphp
            
                @if ($lastThreeLetters==".jpg" || $lastThreeLetters==".png" || $lastThreeLetters=="jpeg")
                    <div class="course-image">
                        {!! Html::image('/'.$coursecontent->file_path, 'thumbnail') !!}
                    </div>
                @endif

                <div class="published">
                    <h6>Published on: <b>{{ $coursecontent->created_at->toFormattedDateString() }}</b></h6>
                </div>
                <div class="author">
                    <h6>Author: <b>{{ $coursecontent->user_id }}</b></h6>
                </div>
                <hr>
                <h3>{{ $coursecontent->material_title }}</h3>
                <hr>

                @if ($lastThreeLetters==".pdf")
                    <iframe src="/{{$coursecontent->file_path}}" width="100%" height="800px"></iframe>

                @endif
                
        
            
            <p class = "lead">{!! $coursecontent->description !!}</p>
        
            {{-- @if ($enroll == true && Auth::user()->role->first()->name == "Student") --}}
               
                <div class="course-button">
                    {{-- @if ($complete == false) --}}
                        <br></br>
                        <a href="{{ route('course.complete', [$coursecontent->id]) }}" type="button" class="btn btn-primary btn-lg" >Mark as Complete</a>
                        <br></br>
                    {{-- @endif --}}
                </div>
           
        </div>
    </div>
    
</div>
@endsection