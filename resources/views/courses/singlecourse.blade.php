@extends('layouts.index')
@section('content')
<script id="dsq-count-scr" src="//iboto-empire-lms.disqus.com/count.js" async></script>

<div class="row">
    <div class="col-md-8">
        <div class="jumbotron">
            <div class="course-title">
                <h1 class = "display-4">{{ $course->title }}</h4>
                    <hr>
                    
            </div>
        
            <div class="course-image">
                <img src="/{{$course->thumbnail}}" alt="{{$course->title}}" width="100%" height="auto">
            </div>
        
            <div class="published">
                <h6>Published on: <b>{{ $course->created_at->toFormattedDateString() }}</b></h6>
            </div>
            <div class="author">
                <h6>Instructor: <b>{{ $course->Author->name ?? "" }}</b> | <small>{{$course->Author->about}}</small></h6>
            </div>
            <div class="author">
                <h6>Course Fee: <b>{{ $course->fee ?? "" }}USD</b></h6>
            </div>
            <hr>
            <h3>Course Description</h3>
            <hr>
            <p class = "lead">{!! $course->description !!}</p>
        
                @if ($enroll == true)
                    <div class="course-content">
                        <p class = "lead">{!! $course->description !!}</p>
                    </div>
                    <div class="course-button">
                        <a href="{{ route('course.unenroll', [$course->id,Auth::user()->id]) }}" type="button" class="btn btn-primary btn-lg">Unenroll</a>
                        @if ($complete == false)
                            <br></br>
                            <a href="{{ route('course.complete', [$course->id]) }}" type="button" class="btn btn-primary btn-lg" >Mark as Complete</a>
                            <br></br>
                        @endif
                    </div>
                @else
                    @if ($complete == false)
                        <a href="{{ route('course.enroll', [$course->id]) }}" type="button" class="btn btn-primary btn-lg" >Enroll</a>
                    @endif
                @endif
        </div>
    </div>
    <div class="col-md-4">

        <h3>Course Contents</h3>
        <small><em>Materials/Resources</em></small>
        <hr>
        @if(($enroll == true) || (Auth::user() && Auth::user()->user_role=="Admin"))
            @if(isset($course->contents))
                <ul>
                    @foreach ($course->contents as $content)
                        <li><a href="{{route('course-content',[$content->id])}}">{{$content->material_title}}</a> - <small style="color: green; font-weight: bold;"><em>({{$content->material_type}})</em> - 
                        @if (Auth::user()->role->first()->name == 'Instructor' || Auth::user()->role->first()->name == "Admin")
                            <a href="{{url('edit-content/'.$content->id)}}">edit</a>
                        @endif
                        </small></li>
                    @endforeach
                </ul>

                @if(isset($course->quizes)  && $course->quizes->isNotEmpty())
                    <h3>Course Assessment/Quizes</h3>
                    <ul>
                        @foreach ($course->quizes->where('start_date', '<=', $now)
                        ->where('end_date', '>=', $now) as $quiz)

                            {{-- Check if the user has attempted the quiz --}}
                        @php
                            $attempts = $quiz->attempts()->where('user_id', Auth::id())->get();
                        @endphp

                        @if ($attempts && $attempts->count()==$quiz->attempts_allowed)
                                <li>
                                    <a href="{{url('quiz-result', ['quiz_id' => $quiz->id, 'user_id' => Auth::id()])}}">Quiz Attempted, View your Score</a>
                                </li>
                           
                        @else
                            <li><a href="{{route('course-quiz',[$quiz->id])}}">{{$quiz->title}}</a> - <small style="color: green; font-weight: bold;"><em>({{$quiz->status}})</em>
                                @if (Auth::user()->role->first()->name == 'Instructor' || Auth::user()->role->first()->name == "Admin")
                                <a href="edit-content">edit</a>
                                <a href="{{route('question-form',$quiz->id)}}">Add Question</a>
                            @endif
                            </small></li>
                        @endif

                            
                        @endforeach
                    </ul>
                @endif

                @if(isset($course->userCourse)  && $course->userCourse->isNotEmpty())
                    <h3>Coursemates / Members</h3>
                    <ul>
                        @foreach ($course->userCourse as $enr)
                                <li>
                                    <a href="#">{{$enr->user->name}} - <small>Joined: {{$enr->created_at}}</small></a>
                                </li>
                        @endforeach
                    </ul>
                @endif

                {{-- @if ($complete==2)
                    <a href="{{url('download-certificate/'.$course->id)}}" class="btn btn-primary">Download Certificate</a>
                @endif --}}
            @else           
        
                <div class="alert alert-info">
                    No course contents published yet, please check back later.
                </div>
            @endif
        @else
            <div class="alert alert-info">
                The contents will be loaded after enrollment is confirmed
            </div>
        @endif

        <div class="row">

            @if (Auth::check() && Auth::id() == $author->id)
                <div class="btn-group">
                    <a href="{{ route('course.edit', [$course->id]) }}" class="btn btn-secondary" id= "course_button" style="margin-right: 10px">Edit Course</a>
                    {!! Form::open(['method' => 'delete', 'route' => ['course.destroy', $course->id]]) !!}
                    <input type="submit" value="Delete Course" class="btn btn-danger" id= "course_button">
                    {!! Form::close() !!}
                </div>
            @endif
        </div>

    </div>
</div>
@if(($enroll == true))
    <div class="row">
        <h3>Course Discussion Board</h3>
        <div class="col-md-12">
            <div id="disqus_thread"></div>
            <script>
                /**
                *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
                /*
                var disqus_config = function () {
                this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
                this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                };
                */
                (function() { // DON'T EDIT BELOW THIS LINE
                var d = document, s = d.createElement('script');
                s.src = 'https://iboto-empire-lms.disqus.com/embed.js';
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
                })();
            </script>
            <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        </div>
    </div>
@endif
@endsection