@extends('layouts.index')
@section('content')
<style>
    .questionBox{
        border: solid black 4px;
        padding: 20px;
        margin-bottom: 10px;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div class="container"> 
            <button onclick="printDiv('pagecontent')" class="btn btn-primary float-right"><i class="fas fa-print"></i> Print this Page</button>      
            <h2>Quiz Title: {{$quiz_result[0]->Quiz->title}}</h2>
            @php
                $num_attempts = $quiz_result->max('attempt');
            @endphp
            @for ($i = 1; $i <= $num_attempts; $i++)
                @php
                    $totalQuestions = 0;
                    $passed = 0;
                    $totalScore = 0;
                    $qnum = 1;
                @endphp
                <div class="questionBox">
                    <h6>Attempt: {{$i}}</h6>
                    @foreach ($quiz_result->where('attempt',$i) as $key => $qr)
                        @php
                            $totalQuestions = $qr->Quiz->questions->count();                        
                            if($qr->is_correct==1){
                                $passed++;
                                $totalScore+=$qr->score;
                            }
                        @endphp
                        
                            <hr>

                            <fieldset>
                                <legend><h5><small>Question {{$qnum++}}:</small> {!!$qr->Question->question!!}</h5></legend>
                                <small><em>Question Type: {{ucwords(str_replace('_', ' ', $qr->Question->question_type))}}</em></small> 
                                {{-- <small>Answer: </small> --}}
                                {{-- <h5>{{$qr->answer_text}} - </h5> --}}
                                <h5>{!!$qr->is_correct==1?"<span style='color: green'>Correct Answer</span>" : "<span style='color: red'>Wrong Answer</span>"!!}</h5>
                            </fieldset> 
                            
                    @endforeach
                    <h3>Performance: {{$passed}}/{{$totalQuestions}}</h3>
                    <h3>Total Score: {{$totalScore}}</h3>
                </div>
                
                
            @endfor
            
            

    </div>

    <script>
        function printDiv(divId) {
            var divContents = document.getElementById(divId).innerHTML;
            var a = window.open('', '', 'height=500, width=500');
            a.document.write('<html>');
            a.document.write('<head><title>Print</title>');
            a.document.write('<style>body{font-family: Arial, sans-serif;} @media print { .no-print { display: none; }}</style>');
            a.document.write('</head>');
            a.document.write('<body>');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();
        }
    </script>
@endsection