@extends('layouts.index')
@section('content')
    
    <div class="container">     
        
        <h1>Quiz Completed</h1>

        <p>Thank you for Attempting the Quiz: {{$quiz}}. Find below your performance</p>

        <p>Total Score: <b>{{$totalScore}}</b></p>

        <p>Correct Answers: {{$passed}} </p>
        <p>Wrong Answers: {{$failed}} </p>
        <p>Thank you.</p>
    </div>
@endsection