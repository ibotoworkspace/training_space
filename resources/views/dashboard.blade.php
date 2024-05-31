@extends('layouts.index')
@section('content')

@if ($enrollments->isEmpty())
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
                    <td>{{ $enrollment->user->name }}</td>
                    <td>{{ $enrollment->user->email }}</td>
                    <td>{{ $enrollment->course->title }}</td>
                    <td>{{$enrollment->payment->reference_no}} <br> <small><em>{{$enrollment->payment->amount}} {{$enrollment->payment->currency}} / {{$enrollment->payment->payment_status}}</em></small></td>
                    <td>
                        <a class="btn btn-success" href = "{{route('enrollment.approve', [$enrollment->user_id, $enrollment->course_id])}}">Approve</a>
                        <a class="btn btn-danger" href = "{{ route('enrollment.disapprove', [$enrollment->user_id, $enrollment->course_id]) }}">Disapprove</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@if($courses)
    
@endif

@endsection