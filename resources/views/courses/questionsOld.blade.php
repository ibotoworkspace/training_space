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
            display: block !important;
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
                        <small><em>Question Type: {{$qu->question_type}}</em></small>

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
                        
                        <small><i>Note: {{$qu->remarks}}</i></small><br>
                    </fieldset>

                    @if($loop->last)                            
                        <!-- Display submit button on the last question -->
                        <button type="submit" class="btn btn-primary btn-lg float-right">Submit Answers</button>
                    @endif
                
                    @if(!$loop->last)
                        <!-- Display next button for all questions except the last one -->
                        <a href="#" class="btn btn-primary btn-lg right float-right" data-ansnum="" id="next-question-button-{{$qu->id}}" onclick="nextQuestion({{$qu->id}})">Next</a>
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
                // Update the corresponding next button with the selected answer number
                const questionId = this.getAttribute('data-qid');
                const nextQuestionButton = document.getElementById(`next-question-button-${questionId}`);
                nextQuestionButton.setAttribute('data-ansnum', selectedAnsNum);
            });
        });
    });

    // function nextQuestion(currentQuestionId) {
    //     const ansNumber = document.getElementById(`next-question-button-${currentQuestionId}`).getAttribute('data-ansnum');

    //     // Get the selected answer for the current question
    //     const selectedAnswer = document.querySelector(`#answer${ansNumber}_${currentQuestionId}:checked`);
        
    //     if (!selectedAnswer) {
    //         alert('Please select an answer.');
    //         return;
    //     }
        
    //     // Hide all questions
    //     const questions = document.querySelectorAll('.question');
    //     questions.forEach((question) => {
    //         question.style.display = 'none';
    //     });

    //     // Unhide the next question
    //     const nextQuestionId = currentQuestionId + 1;
    //     const nextQuestion = document.getElementById(`question${nextQuestionId}`);
    //     if (nextQuestion) {
    //         nextQuestion.style.display = 'block';
    //     } else {
    //         // If there is no next question, display a message or perform other actions
    //         alert('You have come to the end of this quiz. Thank you for participating!');
    //     }
    // }

    function nextQuestion(currentQuestionId) {
        // Get the list of all questions
        const questions = document.querySelectorAll('.question');

        // Find the index of the current question
        let currentIndex = null;
        questions.forEach((question, index) => {
            if (question.id === `question${currentQuestionId}`) {
                currentIndex = index;
            }
        });

        // Ensure we found the current question
        if (currentIndex === null) {
            alert('An error occurred. Please try again.');
            return;
        }

        // Check if an answer is selected
        const ansNumber = document.getElementById(`next-question-button-${currentQuestionId}`).getAttribute('data-ansnum');
        const selectedAnswer = document.querySelector(`#answer${ansNumber}_${currentQuestionId}:checked`);
        if (!selectedAnswer) {
            alert('Please select an answer.');
            return;
        }

        // Hide the current question
        questions[currentIndex].style.display = 'none';

        // Show the next question if it exists
        const nextIndex = currentIndex + 1;
        if (nextIndex < questions.length) {
            questions[nextIndex].style.display = 'block';
        } else {
            // If no more questions, submit the form
            alert('You have come to the end of this quiz. Thank you for participating!');
            document.getElementById('form').submit();
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
        event.returnValue = 'Please, are you sure you want to save/leave the page.';
    });
</script>