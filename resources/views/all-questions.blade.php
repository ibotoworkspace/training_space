@extends('layouts.index')
@section('content')

@if (Auth::check() && (Auth::user()->role->first()->name == 'Instructor' or Auth::user()->role->first()->name == "Admin"))
    @php $pagetype = "report"; @endphp
    <div class="container mt-5">
      
        <h3>Quiz: {{$questions[0]->quiz->title}} | Questions</h3>
       <div class="col-md-12">
            @if($questions->isEmpty())
            <p>No Questions available at the moment.</p>
        @else
            <table class="table table-striped table-responsive" style="width: 100%" id="products">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Question</th>
                        <th>Type</th>
                        <th>1st Answer</th>
                        <th>2nd Answer</th>
                        <th>3rd Answer</th>
                        <th>4th Answer</th>
                        <th>5th Answer</th>
                        <th>Correct Answer</th>
                        <th>Score</th>
                        <th>Rationale</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($questions as $ques)
                        <tr>
                            <td>{{ $ques->id }}</td>
                            <td style="width: 50% !important;">{{ $ques->question }}</td>
                            <td>{{ $ques->question_type }}</td>
                            <td>{{ $ques->answer1 }}</td>
                            <td>{{ $ques->answer2 }}</td>
                            <td>{{ $ques->answer3 }}</td>
                            <td>{{ $ques->answer4 }}</td>
                            <td>{{ $ques->answer5 }}</td>
                            <td>{{ $ques->correct_answer }}</td>
                            <td>{{ $ques->score }}</td>
                            <td>{{ $ques->remarks }}</td>
                            <td class="btn-group">
                                @if (Auth::user()->role->first()->name == 'Instructor' || Auth::user()->role->first()->name == "Admin")
                                    <a href="{{route('edit-question',$ques->id)}}" class="btn btn-info">Edit</a>
                                    {{-- <a href="{{route('delete-question',$ques->id)}}" class="btn btn-info">Delete</a> --}}
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