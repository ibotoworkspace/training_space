@extends('layouts.index')
@section('content')

@if (Auth::check() && (Auth::user()->role->first()->name == 'Instructor' or Auth::user()->role->first()->name == "Admin"))

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
                        <td>{{$enrollment->payment->reference_no ?? ""}} <br> <small><em>{{$enrollment->payment->amount ?? ""}} {{$enrollment->payment->currency ?? ""}} / {{$enrollment->payment->payment_status ?? ""}}</em></small></td>
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
                    <td>{{$co->CompletedContent->where('content_completed',1)->where('user_id',Auth::id())->count() ?? ""}}/{{$co->Course->contents->count() ?? ""}}</td>
                    <td>{{(($co->CompletedContent->where('content_completed',1)->where('user_id',Auth::id())->count() ?? 1)/(($co->Course->contents->count() ?? 0))*100)}}%</td>
                    <td><a href="{{url('course/'.$co->course_id)}}" class="btn btn-primary">Continue</a></td>
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
                    <td>{{$qza->total_score}}/{{$qza->Quiz->questions->sum('score')}}</td>
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


@endif


@endsection