@extends('layouts.index')
@section('content')
    @php
    // $pagetype = "wyswyg";
    @endphp

    <style>
        /* Hide all questions by default */
        .question {
            display: none;
        }          

        /* Show the first question */
        .question:first-of-type {
            display: block;
        }

         /* Style for the radio button */
        input[type="radio"] {
            /* Increase the size of the radio button */
            width: 20px;
            height: 20px;
        }

        /* Style for the label */
        label {
            /* Increase the font size of the label */
            font-size: 18px;
            /* Add some margin to the label to provide spacing */
            margin-left: 5px;
        }

        /* Style for the container div */
        .answer_container{
            /* Add some margin to the container to provide spacing */
            margin-bottom: 10px;
        }
    </style>
    
    <!-- questions.blade.php -->
    <!-- Display countdown timer on the last question -->
    <div style="text-align: right; clear: both;">
        <span style="color: red; font-size: 18px; font-weight: bold;">Time Remaining: 
        <div id="countdown" style="display: inline"></div></span>
        <h4>Quiz Attempts: {{$attempts}} of {{$questions[0]->quiz->allowed_attempts}}</h4>
    </div>

    <div class="container">       
        <form id="form" method="post" action="{{route('save-answers')}}"> 
            @csrf      
            <input type="hidden" name="quiz_id" value="{{$questions[0]->quiz_id}}">
            <input type="hidden" name="attempts" value="{{$attempts}}">

            @foreach ($questions as $key => $qu)
                <div id="question{{ $qu->id }}" class="question">
                    <h5>Question {{$key + 1}} of {{$questions->count()}}</h5>  
                    <hr>
                    <fieldset>
                        <legend><h2>{!! $qu->question !!}</h2></legend>
                        <small><em>Question Type: <b>{{ucwords(str_replace('_', ' ', $qu->question_type))}}</b></em></small>
                        <div  style="margin-bottom: 20px !important;"></div>

                        @switch($qu->question_type)
                            @case('single_choice')
                                @for ($i = 1; $i <= 5; $i++)
                                    @php
                                        $answer = "answer{$i}";
                                    @endphp
                                    @if ($qu->$answer != "")
                                        <div class="answer_container">
                                            <input type="radio" id="{{$answer}}_{{$qu->id}}" name="answer_{{$qu->id}}" value="{{$answer}}" class="answer-radio" data-ansnum="{{$i}}" data-qid="{{$qu->id}}"/>
                                            <label for="{{$answer}}_{{$qu->id}}">{{$qu->$answer}}</label>
                                        </div>
                                    @endif
                                @endfor
                                @break
                            
                            @case('multiple_choice')
                                @for ($i = 1; $i <= 5; $i++)
                                    @php
                                        $answer = "answer{$i}";
                                    @endphp
                                    @if ($qu->$answer != "")
                                        <div class="answer_container">
                                            <input type="radio" id="{{$answer}}_{{$qu->id}}" name="{{$answer}}_{{$qu->id}}" value="{{$answer}}" class="answer-radio" data-ansnum="{{$i}}" data-qid="{{$qu->id}}"/>
                                            <label for="{{$answer}}_{{$qu->id}}">{{$qu->$answer}}</label>
                                        </div>
                                    @endif
                                @endfor
                                @break
                            
                            @case('true_false')
                                @if ($qu->answer1 != "")
                                    <div class="answer_container">
                                        <input type="radio" id="answer1_{{$qu->id}}" name="answer_{{$qu->id}}" value="answer1" class="answer-radio" data-ansnum="1" data-qid="{{$qu->id}}"/>
                                        <label for="answer1_{{$qu->id}}">{{$qu->answer1}}</label>
                                    </div>
                                @endif
                                
                                @if ($qu->answer2 != "")
                                    <div class="answer_container">
                                        <input type="radio" id="answer2_{{$qu->id}}" name="answer_{{$qu->id}}" value="answer2" class="answer-radio" data-ansnum="2" data-qid="{{$qu->id}}"/>
                                        <label for="answer2_{{$qu->id}}">{{$qu->answer2}}</label>
                                    </div>
                                @endif
                                @break
                            
                            @default
                                @if ($qu->answer1 != "")
                                    <div class="answer_container">
                                        <input type="text" id="answer1_{{$qu->id}}" name="answer1_{{$qu->id}}" value="answer1" data-ansnum="1" data-qid="{{$qu->id}}"/>
                                        <label for="answer1_{{$qu->id}}">{{$qu->answer1}}</label>
                                    </div>
                                @endif
                        @endswitch
                        
                        {{-- <small><i>Rationale: {{$qu->remarks}}</i></small><br> --}}
                    </fieldset>

                    @if($loop->last)                            
                        <!-- Display submit button on the last question -->
                        <button type="submit" class="btn btn-primary btn-lg float-right">Submit Answers</button>
                    @endif
                
                    @if(!$loop->last)
                        <!-- Display next button for all questions except the last one -->
                        <a href="#" class="btn btn-primary btn-lg right float-right" data-ansnum="" id="next-question-button-{{$qu->id}}" onclick="nextQuestion({{$qu->id}})" style="margin-top: -30px;">Next 	<b>&rarr;</b></a>
                    @endif
                </div>
            @endforeach
        </form>
    </div>
@endsection

<script>
  
    function nextQuestion(currentQuestionId) {
        // Find the current question by its ID
        let currentQuestion = document.getElementById(`question${currentQuestionId}`);

        // Ensure the current question is found
        if (!currentQuestion) {
            alert('An error occurred. Please try again.');
            return;
        }

        // Hide the current question if it exists
        currentQuestion.style.display = 'none';

        // Find and show the next question
        let nextQuestion = currentQuestion.nextElementSibling;
        while (nextQuestion && !nextQuestion.classList.contains('question')) {
            nextQuestion = nextQuestion.nextElementSibling;
        }

        // Display the next question if it exists, otherwise submit the form
        if (nextQuestion) {
            nextQuestion.style.display = 'block';
        } else {
            alert('You have come to the end of this quiz. Thank you for participating!');
            document.getElementById('form').submit();
        }
    }


    document.addEventListener('DOMContentLoaded', function() {
        const duration = {{$duration}};
        const countdownElement = document.getElementById('countdown');
        let timeRemaining = duration * 60;

        function updateCountdown() {
            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            countdownElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            timeRemaining--;

            if (timeRemaining < 0) {
                clearInterval(timer);
                countdownElement.textContent = 'Time Up!';
                document.getElementById('form').submit();  // Automatically submit the form
            }
        }

        const timer = setInterval(updateCountdown, 1000);
    });


    // Function to store selected answers in local storage
    function storeAnswer(questionId, answer, ansNumber) {
        localStorage.setItem(`answer${ansNumber}_${questionId}`, answer);
    }

    // Function to retrieve stored answers from local storage
    function retrieveAnswer(questionId, ansNumber) {
        return localStorage.getItem(`answer${ansNumber}_${questionId}`);
    }

    // Function to handle radio button selection
    function handleSelection(questionId, answer, ansNumber) {
        // Store the selected answer in local storage
        storeAnswer(questionId, answer, ansNumber);
    }

    // Function to initialize radio buttons with stored answers
    function initializeRadioButtons() {
        // Get all radio buttons
        const radioButtons = document.querySelectorAll('input[type="radio"]');
        radioButtons.forEach((radioButton) => {
            const questionId = radioButton.getAttribute('data-qid');
            const ansNumber = radioButton.getAttribute('data-ansnum');
            const storedAnswer = retrieveAnswer(questionId, ansNumber);
            if (storedAnswer === radioButton.value) {
                radioButton.checked = true;
            }
        });
    }

    // Add event listener for DOMContentLoaded event to initialize radio buttons
    document.addEventListener('DOMContentLoaded', initializeRadioButtons);

    // Function to disable page refresh
    window.addEventListener('beforeunload', function(event) {
        // Cancel the event to prevent the default action
        event.preventDefault();
        // Prompt the user with a custom message
        event.returnValue = 'Please, are you sure you want to save/leave the page. This current Quiz Attempt will be closed. Do you want to proceed?';
    });

</script>