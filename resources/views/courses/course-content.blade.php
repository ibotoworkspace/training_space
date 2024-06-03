@extends('layouts.index')
@section('content')
<style>
    #delayed-link {
        display: none; /* Initially hidden */
    }
</style>
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
                    <h6>Author: <b>{{ $coursecontent->Author->name }}</b></h6>
                </div>
                <hr>
                <h3>{{ $coursecontent->material_title }}</h3>
                <hr>

                @if ($lastThreeLetters==".pdf")
                    <iframe src="/{{$coursecontent->file_path}}" width="100%" height="800px"></iframe>

                @endif
                
        
            
            <p class = "lead">{!! $coursecontent->description !!}</p>
        
            @if ($completed=="No")

                <div class="course-button">
                        <br></br>
                        <a href="{{ route('content-complete', [$coursecontent->id]) }}" type="button" class="btn btn-primary btn-lg delayed-link" id="delayed-link">Mark as Complete</a>   
                </div>
                
            @endif
               
                
           
        </div>
    </div>
    
</div>
<script>
    // Set a timeout to show the link after 10 minutes (600,000 milliseconds)
    setTimeout(function() {
        document.getElementById('delayed-link').style.display = 'inline';
    }, {{$coursecontent->duration ?? 1}}0000); // 600000 milliseconds = 10 minutes
</script>
@endsection