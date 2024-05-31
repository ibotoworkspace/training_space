@extends('layouts.index')
@section('content')
    @php
    // $pagetype = "wyswyg";
    @endphp

    <style>
        /* Hide all questions by default */
        /* .question {
            display: none;
        } */
        /* Show the first question */
        /* .question:first-child {
            display: block;
        } */

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
        </div>
    <div class="container">       
        <form id="form" method="post" action="{{route("save-answers")}}"> 
            @csrf      
            <input type="hidden" name="quiz_id" value="{{$questions[0]->quiz_id}}">
            @foreach ($questions as $key => $qu)
                
                <div id="question{{ $qu->id }}" class="question"style="display: {{ $loop->first ? 'block' : 'none' }}">
                    <h5>Question {{$key+1}} of {{$questions->count()}} </h5>  
                    <hr>
                    <fieldset>
                        <legend><h2>{!!$qu->question!!}</h2></legend>
                        <small><em>Question Type: {{$qu->question_type}}</em></small>
                    
                        <div class="answer_container">
                            <input type="radio" id="answer1_{{$qu->id}}" name="answer_{{$qu->id}}" value="answer1" />
                            <label for="answer1_{{$qu->id}}">{{$qu->answer1}}</label>
                        </div>

                        <div class="answer_container">
                            <input type="radio" id="answer2_{{$qu->id}}" name="answer_{{$qu->id}}" value="answer2" />
                            <label for="answer2_{{$qu->id}}">{{$qu->answer2}}</label>
                        </div>
                        
                        <div class="answer_container">
                            <input type="radio" id="answer3_{{$qu->id}}" name="answer_{{$qu->id}}" value="answer3" />
                            <label for="answer3_{{$qu->id}}">{{$qu->answer3}}</label>
                        </div>

                        <div class="answer_container">
                            <input type="radio" id="answer4_{{$qu->id}}" name="answer_{{$qu->id}}" value="answer4" />
                            <label for="answer4_{{$qu->id}}">{{$qu->answer4}}</label>
                        </div>
                        
                        <div class="answer_container">
                            <input type="radio" id="answer5_{{$qu->id}}" name="answer_{{$qu->id}}" value="answer5" />
                            <label for="answer5_{{$qu->id}}">{{$qu->answer5}}</label>
                        </div>

                        
                    </fieldset>

                    @if($loop->last)                            
                        <!-- Display submit button on the last question -->
                        <button type="submit" class="btn btn-primary btn-lg float-right">Submit Answers</button>
                    @endif
            

                    @if(!$loop->last)
                        <!-- Display next button for all questions except the last one -->
                        <a href="#" class="btn btn-primary btn-lg right float-right" onclick="nextQuestion({{ $qu->id }})">Next</a>
                    @endif
                </div>
            @endforeach
        </form>
        

    </div>
@endsection

<script>
    // Define JavaScript function to handle the submission and navigation
    function nextQuestion(currentQuestionId) {

        // Get the selected answer for the current question
        const selectedAnswer = document.querySelector(`#form input[name=answer_${currentQuestionId}]:checked`);
        
        if (!selectedAnswer) {
            alert('Please select an answer.');
            return;
        }
        
        // Hide all questions
        const questions = document.querySelectorAll('.question');
        questions.forEach((question) => {
            question.style.display = 'none';
        });

        // Unhide the next question
        const nextQuestionId = currentQuestionId + 1;
        const nextQuestion = document.getElementById(`question${nextQuestionId}`);
        if (nextQuestion) {
            nextQuestion.style.display = 'block';
        } else {
            // If there is no next question, display a message or perform other actions
            alert('End of questionnaire. Thank you for participating!');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Countdown timer
        const duration = {{$duration}}; // Duration in minutes
        const countdownElement = document.getElementById('countdown');
        let timeRemaining = duration * 60; // Convert minutes to seconds

        function updateCountdown() {
            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            countdownElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            timeRemaining--;

            if (timeRemaining < 0) {
                clearInterval(timer);
                countdownElement.textContent = 'Time Up!';
                // Optionally, you can submit the form automatically here
                // document.querySelector('form').submit();
            }
        }

        const timer = setInterval(updateCountdown, 1000);
    });

     // Function to store selected answers in local storage
     function storeAnswer(questionId, answer) {
        localStorage.setItem(`answer_${questionId}`, answer);
    }

    // Function to retrieve stored answers from local storage
    function retrieveAnswer(questionId) {
        return localStorage.getItem(`answer_${questionId}`);
    }

    // Function to handle radio button selection
    function handleSelection(questionId, answer) {
        // Store the selected answer in local storage
        storeAnswer(questionId, answer);
    }

    // Function to initialize radio buttons with stored answers
    function initializeRadioButtons() {
        // Get all radio buttons
        const radioButtons = document.querySelectorAll('input[type="radio"]');
        radioButtons.forEach((radioButton) => {
            const questionId = radioButton.getAttribute('data-question-id');
            const storedAnswer = retrieveAnswer(questionId);
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
        event.returnValue = '';
    });
</script>