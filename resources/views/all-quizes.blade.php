@extends('layouts.index')
@section('content')
<style>
    table{
        font-size: 0.8em;
    }
</style>
@if (Auth::check() && (Auth::user()->role->first()->name == 'Instructor' or Auth::user()->role->first()->name == "Admin"))
    @php $pagetype = "report"; @endphp
    <div class="container mt-5">
        <div class="row btn-group">
            <a href="{{url('quiz-form')}}" class="btn btn-primary">Create New Quiz</a>
            <a href="{{url('upload-quiz-form')}}" class="btn btn-success float-right" style="float: right !important">Upload Quiz From File</a>
        </div>
        <h3>Quiz Bank | All Course Quizes</h3>
       <div class="col-md-12">
            @if($quizzes->isEmpty())
            <p>No quizzes available at the moment.</p>
        @else
            <table class="table table-striped table-responsive" style="width: 100%" id="products">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Course ID</th>
                        <th>Category ID</th>
                        <th>Duration (Minutes)</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Author</th>
                        <th>Attempts Allowed</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizzes as $quiz)
                        <tr>
                            <td>{{ $quiz->id }}</td>
                            <td>{{ $quiz->title }}</td>
                            <td>{{ $quiz->subtitle }}</td>
                            <td>{{ $quiz->course->title ?? '' }}</td>
                            <td>{{ $quiz->Category->category_name ?? '' }}</td>
                            <td>{{ $quiz->duration }}</td>
                            <td>{{ $quiz->start_date }}</td>
                            <td>{{ $quiz->end_date }}</td>
                            <td>{{ $quiz->status }}</td>
                            <td>{{ $quiz->Author->name }}</td>
                            <td>{{ $quiz->attempts_allowed }}</td>
                            <td>{{ $quiz->created_at }}</td>
                            <td class="btn-group">
                                <a href="{{route('course-quiz',[$quiz->id])}}" class="btn btn-primary btn-xs">View</a>
                                @if (Auth::user()->role->first()->name == 'Instructor' || Auth::user()->role->first()->name == "Admin")
                                    <a href="{{route('edit-quiz',$quiz->id)}}" class="btn btn-secondary btn-xs">Edit</a>
                                    <a href="{{route('edit-questions',$quiz->id)}}" class="btn btn-info btn-xs">Manage Questions</a>
                                    <a href="{{route('question-form',$quiz->id)}}" class="btn btn-warning btn-xs">Add Question</a>
                                    <a href="{{url('delete-quiz/'.$quiz->id)}}" class="btn btn-danger" onclick="confirm('Are you sure want to delete this quiz?')">Delete</a>

                                @endif
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