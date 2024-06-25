@extends('layouts.index')
@section('content')

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
                        <td class="btn-group">
                            <a href="{{url('course/'.$co->course_id)}}" class="btn btn-primary">Open Course</a>
                            @if ($co->course_completed==2)
                                <a href="{{url('download-certificate/'.$co->course_id.'/'.$user->id)}}" class="btn btn-info">Download Certificate</a>
                            @endif
                        </td>
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