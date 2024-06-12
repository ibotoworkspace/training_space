@extends('layouts.index')
@section('content')

@if (Auth::check() && (Auth::user()->role->first()->name == 'Instructor' or Auth::user()->role->first()->name == "Admin"))
    @php $pagetype = "report"; @endphp
    <div class="container mt-5">
      
        <h3>Quiz Bank | All Course Quizes</h3>
       <div class="col-md-12">
            @if($quizzes->isEmpty())
            <p>No quizzes available at the moment.</p>
        @else
            <table class="table table-striped table-responsive" style="width: 100%" id="products">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Description</th>
                        <th>Course ID</th>
                        <th>Category ID</th>
                        <th>Duration</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Author</th>
                        <th>Remarks</th>
                        <th>Attempts Allowed</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizzes as $quiz)
                        <tr>
                            <td>{{ $quiz->id }}</td>
                            <td>{{ $quiz->title }}</td>
                            <td>{{ $quiz->subtitle }}</td>
                            <td>{{ $quiz->description }}</td>
                            <td>{{ $quiz->course_id }}</td>
                            <td>{{ $quiz->category_id }}</td>
                            <td>{{ $quiz->duration }}</td>
                            <td>{{ $quiz->start_date }}</td>
                            <td>{{ $quiz->end_date }}</td>
                            <td>{{ $quiz->status }}</td>
                            <td>{{ $quiz->author }}</td>
                            <td>{{ $quiz->remarks }}</td>
                            <td>{{ $quiz->attempts_allowed }}</td>
                            <td>{{ $quiz->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
       </div>
    </div>
@else
<div class="alert alert-warning alert-dismissible fade show" role="alert">
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