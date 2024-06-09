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

                        @switch($qu->question_type)
                            @case("single_choice")
                            @if ($qu->answer1!="")
                                <div class="answer_container">
                                        <input type="radio" id="answer1_{{$qu->id}}" name="answer_{{$qu->id}}" value="answer1" class="answer-radio" data-ansnum="1" data-qid="{{$qu->id}}"/>
                                        <label for="answer1_{{$qu->id}}">{{$qu->answer1}}</label>
                                    </div>
                                @endif
                                
                                @if ($qu->answer2!="")
                                    <div class="answer_container">
                                        <input type="radio" id="answer2_{{$qu->id}}" name="answer_{{$qu->id}}" value="answer2" class="answer-radio" data-ansnum="2" data-qid="{{$qu->id}}"/>
                                        <label for="answer2_{{$qu->id}}">{{$qu->answer2}}</label>
                                    </div>
                                @endif
                                
                                @if ($qu->answer3!="")
                                    <div class="answer_container">
                                        <input type="radio" id="answer3_{{$qu->id}}" name="answer_{{$qu->id}}" value="answer3" class="answer-radio" data-ansnum="3" data-qid="{{$qu->id}}"/>
                                        <label for="answer3_{{$qu->id}}">{{$qu->answer3}}</label>
                                    </div>
                                @endif
                                
                                @if ($qu->answer4!="")
                                    <div class="answer_container">
                                        <input type="radio" id="answer4_{{$qu->id}}" name="answer_{{$qu->id}}" value="answer4" class="answer-radio" data-ansnum="4" data-qid="{{$qu->id}}"/>
                                        <label for="answer4_{{$qu->id}}">{{$qu->answer4}}</label>
                                    </div>
                                @endif
                                
                                @if ($qu->answer5!="")
                                    <div class="answer_container">
                                        <input type="radio" id="answer5_{{$qu->id}}" name="answer_{{$qu->id}}" value="answer5" class="answer-radio" data-ansnum="5" data-qid="{{$qu->id}}"/>
                                        <label for="answer5_{{$qu->id}}">{{$qu->answer5}}</label>
                                    </div>
                                @endif
                                
                                @break
                            @case("multiple_choice")
                                @if ($qu->answer1!="")
                                    <div class="answer_container">
                                        <input type="radio" id="answer1_{{$qu->id}}" name="answer1_{{$qu->id}}" value="answer1" class="answer-radio" data-ansnum="1" data-qid="{{$qu->id}}"/>
                                        <label for="answer1_{{$qu->id}}">{{$qu->answer1}}</label>
                                    </div>
                                @endif
                                
                                @if ($qu->answer2!="")
                                    <div class="answer_container">
                                        <input type="radio" id="answer2_{{$qu->id}}" name="answer2_{{$qu->id}}" value="answer2" class="answer-radio" data-ansnum="2" data-qid="{{$qu->id}}"/>
                                        <label for="answer2_{{$qu->id}}">{{$qu->answer2}}</label>
                                    </div>
                                @endif
                                
                                @if ($qu->answer3!="")
                                    <div class="answer_container">
                                        <input type="radio" id="answer3_{{$qu->id}}" name="answer3_{{$qu->id}}" value="answer3" class="answer-radio" data-ansnum="3" data-qid="{{$qu->id}}"/>
                                        <label for="answer3_{{$qu->id}}">{{$qu->answer3}}</label>
                                    </div>
                                @endif
                                
                                @if ($qu->answer4!="")
                                    <div class="answer_container">
                                        <input type="radio" id="answer4_{{$qu->id}}" name="answer4_{{$qu->id}}" value="answer4" class="answer-radio" data-ansnum="4" data-qid="{{$qu->id}}"/>
                                        <label for="answer4_{{$qu->id}}">{{$qu->answer4}}</label>
                                    </div>
                                @endif
                                
                                @if ($qu->answer5!="")
                                    <div class="answer_container">
                                        <input type="radio" id="answer5_{{$qu->id}}" name="answer5_{{$qu->id}}" value="answer5" class="answer-radio" data-ansnum="5" data-qid="{{$qu->id}}"/>
                                        <label for="answer5_{{$qu->id}}">{{$qu->answer5}}</label>
                                    </div>
                                @endif
                                @break
                            @case("true_false")
                                @if ($qu->answer1!="")
                                    <div class="answer_container">
                                        <input type="radio" id="answer1_{{$qu->id}}" name="answer_{{$qu->id}}" value="answer1" class="answer-radio" data-ansnum="1" data-qid="{{$qu->id}}"/>
                                        <label for="answer1_{{$qu->id}}">{{$qu->answer1}}</label>
                                    </div>
                                @endif
                                
                                @if ($qu->answer2!="")
                                    <div class="answer_container">
                                        <input type="radio" id="answer2_{{$qu->id}}" name="answer_{{$qu->id}}" value="answer2" class="answer-radio" data-ansnum="2" data-qid="{{$qu->id}}"/>
                                        <label for="answer2_{{$qu->id}}">{{$qu->answer2}}</label>
                                    </div>
                                @endif
                                @break
                            @default
                            @if ($qu->answer1!="")
                                <div class="answer_container">
                                    <input type="text" id="answer1_{{$qu->id}}" name="answer1_{{$qu->id}}" value="answer1" class="form-control" data-ansnum="1" data-qid="{{$qu->id}}"/>
                                    <label for="answer1_{{$qu->id}}">{{$qu->answer1}}</label>
                                </div>
                        @endif
                                
                        @endswitch                       

                        
                    </fieldset>

                    @if($loop->last)                            
                        <!-- Display submit button on the last question -->
                        <button type="submit" class="btn btn-primary btn-lg float-right">Submit Answers</button>
                    @endif
            

                    @if(!$loop->last)
                        <!-- Display next button for all questions except the last one -->
                        <a href="#" class="btn btn-primary btn-lg right float-right" id="next-question-button">Next</a>
                    @endif
                </div>
            @endforeach
        </form>
        

    </div>
@endsection

<script>
    // Define JavaScript function to handle the submission and navigation

    document.addEventListener('DOMContentLoaded', function() {
        // Variable to store the selected answer number
        let selectedAnsNum = null;

        // Select all radio buttons with the class 'answer-radio'
        const radioButtons = document.querySelectorAll('.answer-radio');

        // Add a click event listener to each radio button
        radioButtons.forEach(function(radio) {
            radio.addEventListener('click', function() {
                // Retrieve the value of the data-ansnum attribute
                selectedAnsNum = this.getAttribute('data-ansnum');
                questionId = this.getAttribute('data-qid');
            });
        });

        // Select the button that will trigger the nextQuestion function
        const nextQuestionButton = document.getElementById('next-question-button');

        // Add a click event listener to the button
        nextQuestionButton.addEventListener('click', function() {
            // Ensure a radio button has been selected
            if (selectedAnsNum !== null) {
                // Call the nextQuestion function with the stored ansnumber
                // Assuming you have a question variable defined, replace 'questionVariable' with the actual variable
                nextQuestion(selectedAnsNum, questionId);
            } else {
                alert('Please select an answer first.');
            }
        });
    });
    function nextQuestion(ansNumber, currentQuestionId) {

        // Get the selected answer for the current question
        const selectedAnswer = document.querySelector(`#form input[name=answer${ansNumber}_${currentQuestionId}]:checked`);
        
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
        const nextQuestionId = parseInt(currentQuestionId) + 1;
        alert("Next Question Number: "+nextQuestionId);
        const nextQuestion = document.getElementById(`question${nextQuestionId}`);
        if (nextQuestion) {
            nextQuestion.style.display = 'block';
        } else {
            // If there is no next question, display a message or perform other actions
            alert('You have come to the end of this quiz. Thank you for participating!');
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
     function storeAnswer(questionId, answer, ansNumber) {
        localStorage.setItem(`answer${ansNumber}_${questionId}`, answer);
    }

    // Function to retrieve stored answers from local storage
    function retrieveAnswer(questionId,ansNumber) {
        return localStorage.getItem(`answer${ansNumber}_${questionId}`);
    }

    // Function to handle radio button selection
    function handleSelection(questionId, answer, ansNumber) {
        // Store the selected answer in local storage
        storeAnswer(questionId, answer, ansNumber);
    }

    // Function to initialize radio buttons with stored answers
    // function initializeRadioButtons() {
    //     // Get all radio buttons
    //     const radioButtons = document.querySelectorAll('input[type="radio"]');
    //     radioButtons.forEach((radioButton) => {
    //         const questionId = radioButton.getAttribute('data-question-id');
    //         const storedAnswer = retrieveAnswer(questionId, ansNumber);
    //         if (storedAnswer === radioButton.value) {
    //             radioButton.checked = true;
    //         }
    //     });
    // }

    // Add event listener for DOMContentLoaded event to initialize radio buttons
    // document.addEventListener('DOMContentLoaded', initializeRadioButtons);


    // Function to disable page refresh
    window.addEventListener('beforeunload', function(event) {
        // Cancel the event to prevent the default action
        event.preventDefault();
        // Prompt the user with a custom message
        event.returnValue = 'Please, are you sure you want to save/leave the page.';
    });
</script>