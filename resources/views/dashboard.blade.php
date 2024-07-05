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

    .btn2 {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        color: #ffffff;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: rgba(158, 190, 171, 0.5);
    }


</style>
@if (Auth::check() && (Auth::user()->role->first()->name == 'Instructor' or Auth::user()->role->first()->name == "Admin"))

<div class="container mt-5">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card card-1">
                <div class="card-content">
                    <div class="number">{{$allcourses->count()}}</div>
                    <div class="text">Courses</div>
                    <a class="btn btn-primary" href="{{url('course-list')}}">View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card card-2">
                <div class="card-content">
                    <div class="number">{{$students->count()}}</div>
                    <div class="text">Students</div>
                    <a class="btn btn-danger" href="{{url('user')}}">View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card card-3">
                <div class="card-content">
                    <div class="number">{{$enrollments->count()}}</div>
                    <div class="text">New Enrollments</div>
                    <a class="btn btn-success" href="{{url('dashboard')}}">View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card card-4">
                <div class="card-content">
                    <div class="number">{{$posts->count()}}</div>
                    <div class="text">Announcements</div>
                    <a class="btn btn-info" href="{{url('post-list')}}">View All</a>
                </div>
            </div>
        </div>
    </div>
</div>
    @if (!isset($enrollments) && $enrollments->isEmpty())
        <div class="card-body">
            <h2 class="alert alert-info">No New Enrollments</h2>
        </div>
    @else
        <div class="card-body">
            <h2 class="alert alert-info">All Enrollment Requests</h2>
        </div>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Course</th>
                <th scope="col">Payment Info</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($enrollments as $enrollment)
                    <tr>
                        <td>{{ $enrollment->user->name ?? "" }}</td>
                        <td>{{ $enrollment->user->email ?? "" }}</td>
                        <td>{{ $enrollment->course->title ?? "" }}</td>
                        <td>{{$enrollment->payment->reference_no ?? ""}} <br> {{$enrollment->payment->payment_method ?? ""}}  <br> <small><em>{{$enrollment->payment->amount ?? ""}} {{$enrollment->payment->currency ?? ""}} / {{$enrollment->payment->payment_status ?? ""}}</em></small></td>
                        <td>
                            <a class="btn btn-success" href = "{{route('enrollment.approve', [$enrollment->user_id ?? "", $enrollment->course_id ?? ""])}}">Approve</a>
                            <a class="btn btn-danger" href = "{{ route('enrollment.disapprove', [$enrollment->user_id ?? "", $enrollment->course_id ?? ""]) }}">Disapprove</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@elseif(Auth::check() && (Auth::user()->role->first()->name == 'Student'))
    
<div class="row">
    <div class="col-md-12"><h3 style="text-align: center;">Student ID: <b>HRSCC24-00{{Auth::id()}}</b></h3></div>
 </div>
        
    <div class="row">
        
        <div class="col-md-7">
            <h3>My Courses</h3>

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
                        <td>{{$co->CompletedContent->where('content_completed',1)->where('user_id',Auth::id())->count() ?? ""}}/{{$co->Course->contents->count()>0 ? $co->Course->contents->count() : 1}}</td>
                        <td>{{number_format((($co->CompletedContent->where('content_completed',1)->where('user_id',Auth::id())->count() ?? 1)/(($co->Course->contents->count()>0 ? $co->Course->contents->count() : 1))*100),2)}}%</td>
                        <td class="btn-group">
                            <a href="{{url('course/'.$co->course_id)}}" class="btn btn-primary">Open Course</a>
                            @if ($co->userCourse->where('course_completed',2)->where('user_id',Auth::id())->first())
                                <a href="{{url('download-certificate/'.$co->id.'/'.Auth::id())}}" class="btn btn-primary">Download Certificate</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-5">
            <h3>My Grades/Scores</h3>
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
                        <td>{{$qza->total_score}}/{{$qza->Quiz->questions->sum('score')>0 ? $qza->Quiz->questions->sum('score') : 1}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">

            <h3>My Inbox</h3>

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
                @foreach ($posts->where('user_id',Auth::id()) as $pos)
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
                        <td>{{$post->title}}</td>
                        <td>{{$post->Author->name}}</td>
                        <td>{{$post->created_at}}</td>
                        <td> <a href="{{ route('post', $post->id) }}" class="btn btn-primary">Read</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endif


@endsection