@extends('layouts.index')
@section('content')
@if (Auth::check() && (Auth::user()->role->first()->name == 'Instructor' or Auth::user()->role->first()->name == "Admin"))
    @php $pagetype = "report"; @endphp
    <div class="container mt-5">
      
        <h3>Course Students | Enrollees</h3>
       <div class="col-md-12">
            @if($students->isEmpty())
            <p>No Course enrollee available at the moment.</p>
        @else
            <table class="table table-striped table-responsive" style="width: 100%" id="products">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Student ID</th>
                        <th>Modules Completed</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $stu)
                        <tr>
                            <td>{{ $stu->User->name }}</td>
                            <td>HRSCC24-00{{$stu->id}}</td>
                            <td>{{$stu->CompletedContent->where('content_completed',1)->where('user_id',$stu->user_id)->count() ?? ""}}/{{$stu->course->contents->count()>0 ? $stu->course->contents->count() : 1}}</td>
                           
                            <td class="btn-group">
                                <a href="{{route('user-dashboard',[$stu->user_id])}}" class="btn btn-primary btn-xs">View Dashboard</a>
                                @if (Auth::user()->role->first()->name == 'Instructor' || Auth::user()->role->first()->name == "Admin")
                                    <a href="{{url('issue-certificate/'.$stu->course_id.'/'.$stu->user_id)}}" class="btn btn-warning" onclick="confirm('Are you sure want to issue this student a certificate?')">Issue Certificate</a>
                                @endif
                                <a href="{{url('unenroll/'.$stu->course_id.'/'.$stu->user_id)}}" class="btn btn-danger btn-xs">Unenroll</a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
       </div>
    </div>
@else
<div class="alert alert-warning  alert-dismissible fade show" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>You don't ave permission to visit this page</strong> 
</div>

<script>
  $(".alert").alert();
</script>
@endif


@endsection