@extends('layouts.index')
@section('content')

<style>
    td{
        font-size: 0.8em;
    }
</style>
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
                        <th style="width: 50% !important;">Type/ Question</th>
                        <th>Answers</th>
                       
                        <th>Score</th>
                        <th>Rationale</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($questions as $ques)
                        <tr>
                            <td>{{ $ques->ordering }}</td>
                            <td style="width: 50% !important;">
                                <i>Type: {{ ucwords(str_replace("_"," ",$ques->question_type)) }}</i> <br>
                                {!! $ques->question !!}
                            </td>
                            <td style="white-space: nowrap;"> 
                                <ul>
                                    {!! $ques->answer1!="" ? "<li> Answer1: <b>".$ques->answer1."</b></li>" : ""!!}
                                    {!! $ques->answer2!="" ? "<li> Answer2: <b>".$ques->answer2."</b></li>" : ""!!}
                                    {!! $ques->answer3!="" ? "<li> Answer3: <b>".$ques->answer3."</b></li>" : ""!!}
                                    {!! $ques->answer4!="" ? "<li> Answer4: <b>".$ques->answer4."</b></li>" : ""!!}
                                    {!! $ques->answer5!="" ? "<li> Answer5: <b>".$ques->answer5."</b></li>" : ""!!}
                                </ul>
                                <i>Correct Answer: <b>{{ ucwords($ques->correct_answer) }}</b></i>
                            </td>
                            <td>{{ $ques->score }}</td>
                            <td>{{ $ques->remarks }}</td>
                            <td class="btn-group">
                                @if (Auth::user()->role->first()->name == 'Instructor' || Auth::user()->role->first()->name == "Admin")
                                    <a href="{{route('edit-question',$ques->id)}}" class="btn btn-info">Edit</a>
                                    {{-- <a href="{{route('delete-question',$ques->id)}}" class="btn btn-info">Delete</a> --}}
                                @endif
                                <a href="{{url('delete-question/'.$ques->id)}}" class="btn btn-danger" onclick="confirm('Are you sure want to delete this question?')">Delete</a>

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