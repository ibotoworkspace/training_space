@extends('layouts.index')
@section('content')
<style>
    /* Custom CSS for dashboard cards */

    .card {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        padding: 20px;
        text-align: center;
        transition: transform 0.2s;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .card-1 {
        background-color: #ff6b6b; /* Red */
        color: #ffffff;
    }

    .card-2 {
        background-color: #4ecdc4; /* Teal */
        color: #ffffff;
    }

    .card-3 {
        background-color: burlywood; /* Yellow */
        color: #ffffff;
    }

    .card-4 {
        background-color: #1a535c; /* Dark Blue */
        color: #ffffff;
    }

    .card-content {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .number {
        font-size: 2em;
        margin-bottom: 10px;
    }

    .text {
        font-size: 1.2em;
        margin-bottom: 20px;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        background-color: rgba(255, 255, 255, 0.3);
        color: #ffffff;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: rgba(255, 255, 255, 0.5);
    }


</style>
<div class="row">
   <div class="col-md-12"><h3 style="text-align: center;">Student ID: <b>HRSCC24-00{{$user->id}}</b></h3></div>
</div>
    <div class="row">

        <div class="col-md-7">
            <h3>Courses</h3>
            <table class="table table-striped table-responsive" id="products">
                <thead>
                <tr>
                    <th>Couse Name</th>
                    <th>Modules Completed</th>
                    <th>Progress</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                
            @foreach ($courses as $co)
                    <tr>
                        <td>{{$co->Course->title}}</td>
                        <td>{{$co->CompletedContent->where('content_completed',1)->where('user_id',$user->id)->count() ?? ""}}/{{$co->Course->contents->count()>0 ? $co->Course->contents->count() : 1}}</td>
                        <td>{{number_format((($co->CompletedContent->where('content_completed',1)->where('user_id',$user->id)->count() ?? 1)/(($co->Course->contents->count()>0 ? $co->Course->contents->count() : 1))*100),2)}}%</td>
                        <td><a href="{{url('course/'.$co->course_id)}}" class="btn btn-primary">Continue</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-5">
            <h3>Grades/Scores</h3>
            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th>Course Name/Quiz</th>
                        <th>Scores</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($quizAttempts as $qza)
                    <tr>
                        <td>{{$qza->Quiz->course->title}} <br> <b>{{$qza->Quiz->title}}</b></td>
                        <td>{{$qza->total_score}}/{{$qza->Quiz->questions->sum('score') ?? 1}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">

            <h3>Inbox</h3>

            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Sender</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($posts->where('user_id',$user->id) as $pos)
                    <tr>
                        <td>{{$pos->title}}</td>
                        <td>{{$pos->Author->name}}</td>
                        <td>{{$pos->created_at}}</td>
                        <td> <a href="{{ route('post', $pos->id) }}" class="btn btn-primary">Read</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>

        <div class="col-md-5">

            <h3>Announcements</h3>

            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>From</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts->filter(function($post) use ($category_ids) {
                        return in_array($post->category_id, $category_ids);
                    }) as $post)
                    <tr>
                        <td>{{$pos->title}}</td>
                        <td>{{$pos->Author->name}}</td>
                        <td>{{$pos->created_at}}</td>
                        <td> <a href="{{ route('post', $post->id) }}" class="btn btn-primary">Read</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>


@endsection