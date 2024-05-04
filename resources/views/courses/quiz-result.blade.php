@extends('layouts.index')
@section('content')
 
    <div class="container">       
            <h2>Quiz Title: {{$quiz_result[0]->Quiz->title}}</h2>
            @php
                $totalQuestions = $quiz_result->count();
                $passed = 0;
                $totalScore = 0;
            @endphp
            @foreach ($quiz_result as $key => $qr)
                @php
                    if($qr->is_correct==1){
                        $passed++;
                        $totalScore+=$qr->score;
                    }
                @endphp
                    <hr>
                    <fieldset>
                        <legend><h2><small>Question {{$key+1}}:</small> {!!$qr->Question->question!!}</h2></legend>
                        <small><em>Question Type: {{$qr->Question->question_type}}</em></small> <br>
                        <small>Answer: </small>
                        <h5>{{$qr->answer_text}} - <h5>{!!$qr->is_correct==1?"<span style='color: green'>Correct Answer</span>" : "<span style='color: red'>Wrong Answer</span>"!!}</h5></h5>
                    </fieldset>    
            @endforeach
            <h3>Performance: {{$passed}}/{{$totalQuestions}}</h3>
            <h3>Total Score: {{$totalScore}}</h3>

    </div>
@endsection