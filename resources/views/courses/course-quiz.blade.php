@extends('layouts.index')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div>
            <div class="course-title">
                <h1 class = "display-4">{{ $quiz->title }}</h4>
                <h3>{{ $quiz->subtitle }}</h3>
                <h6>Course: {{ $quiz->course->title }} | <em><small>Category: {{$quiz->Category->category_name}}</small></em></h3>
            </div>           
               

                <div class="published">
                    <h6>Duration: <b>{{ $quiz->duration }} minutes</b></h6>
                    <h4>No of Attempts: {{$quiz->attempts_allowed}}</h4>
                    <p>Opens On: {{$quiz->start_date}}, Closes On: {{$quiz->end_date}}</p>
                </div>
                <div class="author">
                    <h6>Published By: <b>{{ $quiz->Author->name }}</b></h6>
                </div>
                <hr>
                <h3>About this Quiz</h3>
            
            <p class = "lead">{!! $quiz->description !!}</p>
            <p><h3>Information</h3>
                {{$quiz->remarks}}</p>
        
            {{-- @if ($enroll == true && Auth::user()->role->first()->name == "Student") --}}
               
                <div class="course-button">
                    {{-- @if ($complete == false) --}}
                        <br></br>
                        <a href="{{ route('quiz-questions', [$quiz->id]) }}" type="button" class="btn btn-primary btn-lg" >Take this Quiz</a>
                        <br></br>
                    {{-- @endif --}}
                </div>
           
        </div>
    </div>
    
</div>
@endsection