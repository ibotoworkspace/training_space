<style>
    hr{
        border: 3px solid black !important;
    }
</style>
<h3>Publish Questions for a Quiz</h3>

<form method="POST" action="{{ route('publish-question') }}">
    @csrf

    <div id="questions-container">
        <div class="col-md-10">
            <label for="quiz_id">Select Quiz</label>
            <select name="quiz_id" class="form-control">
                @foreach ($quizes as $qz)
                    <option value="{{$qz->id}}" @if ($qz->id==$quiz_id)
                        selected
                    @endif >{{$qz->title}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="question">
            <div class="col-md-12">
                <label for="question_type1">Question Type:</label>
                <select name="question_type[]" id="question_type1" class="form-control" onchange="reloadChoices(1)">
                    <option value="single_choice" selected>Select Question Type</option>
                    <option value="single_choice">Single Choice</option>
                    <option value="multiple_choice">Multiple Choice</option>
                    <option value="true_false">True/False</option>
                    <option value="short_answer">Short Answer</option>
                </select>
            </div>

            <div class="col-md-12">
                <label>Question <span class="qnum">1</span></label>
                
                <textarea name="question[]" class="wyswyg"></textarea>
            </div>
            
            <div id="dynamicChoices1" class="row">
                <div class="col-md-4">
                    <label for="answer1">A</label>
                    <input type="text" name="answer1[]" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="answer2">B</label>
                    <input type="text" name="answer2[]" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="answer3">C</label>
                    <input type="text" name="answer3[]" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="answer4">D</label>
                    <input type="text" name="answer4[]" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="answer5">E</label>
                    <input type="text" name="answer5[]" class="form-control">
                </div>
                <!-- Add inputs for answer2, answer3, answer4, answer5 -->
                <div class="col-md-4">
                    <label for="correct_answer">Correct Answer</label>
                    <select name="correct_answer[]" class="form-control">
                        <option value="answer1">Answer A</option>
                        <option value="answer2">Answer B</option>
                        <option value="answer3">Answer C</option>
                        <option value="answer4">Answer D</option>
                        <option value="answer5">Answer E</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <label for="score">Question Score</label>
                    <input type="number" name="score[]" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="ordering">Ordering</label>
                    <input type="number" name="ordering[]" class="form-control">
                </div>
                <div class="col-md-8">
                    <label for="remarks">Instructions/Rationale</label>
                    <textarea name="remarks[]" class="form-control"></textarea>
                    {{-- <input type="text" name="remarks[]" class="form-control"> --}}
                </div>
            </div>
            <hr>
        </div>
    </div>

    <div style="text-align: center;">
        <button type="button" id="add-question" class="btn btn-primary center">Add More Question</button>
    </div>
    <div style="margin-bottom: 30px;">
        <button type="submit" class="btn btn-success" style="float: right;">Submit Quiz Questions</button>
    </div>
</form>

<script>

    document.getElementById('add-question').addEventListener('click', function() {
        const container = document.getElementById('questions-container');
        const question = container.querySelector('.question');

        // Detach Summernote from the original textarea
        $(question).find('textarea.wyswyg').each(function() {
                    $(this).summernote('destroy');
        });

        const clone = question.cloneNode(true);
        
        // Update id and onchange attributes for the cloned question_type element
        const questionType = clone.querySelector('#question_type1'); // Assuming the original id is question_type1
        const dynamicChoices = clone.querySelector('#dynamicChoices1');
        const questionTypeNumber = container.querySelectorAll('.question').length; // Get the number of existing questions
        questionType.id = `question_type${questionTypeNumber + 1}`; // Update id
        dynamicChoices.id = `dynamicChoices${questionTypeNumber + 1}`; // Update id
        questionType.setAttribute('onchange', `reloadChoices(${questionTypeNumber + 1})`); // Update onchange attribute

        // Update content of qnum span
        const qnumSpan = clone.querySelector('.qnum');
        const questionNumber = container.querySelectorAll('.question').length + 1; // Get the number of existing questions
        qnumSpan.textContent = questionNumber; // Update content of qnum span

        // Add delete button
        const deleteButton = document.createElement('button');
        deleteButton.textContent = `Delete Question ${questionNumber}`;
        deleteButton.addEventListener('click', function() {
            container.removeChild(clone);
        });
        clone.appendChild(deleteButton);
        
        container.appendChild(clone);

        // Reinitialize Summernote for the newly added textarea
        $(clone).find('textarea.wyswyg').each(function() {
            $(this).summernote({
                height: 300, // Set the height of the editor    
                toolbar: [
                    ['style', ['undo','redo','style']], // Style dropdown (e.g., paragraph, code)
                    ['font', ['bold', 'italic', 'underline', 'clear','strikethrough', 'superscript', 'subscript']], // Font style (bold, italic, underline)
                    ['fontname', ['fontname']], // Font family
                    ['fontsize', ['fontsize']], // Font size
                    ['fontsizeunit', ['fontsizeunit']], // Font size
                    ['color', ['forecolor', 'backcolor']], // Text color and background color
                    ['para', ['ul', 'ol', 'paragraph']], // Lists (unordered, ordered), paragraph formatting
                    ['height', ['height']], // Line height
                    ['table', ['table']], // Insert table
                    ['insert', ['link', 'picture', 'video', 'hr']], // Insert links, images, videos, horizontal rule
                    ['view', ['fullscreen', 'codeview','help']], // Fullscreen mode, code view, help
                ],
                popover: {
                    image: [
                        ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                        ['float', ['floatLeft', 'floatRight', 'floatNone']],
                        ['remove', ['removeMedia']]
                    ],
                    link: [
                        ['link', ['linkDialogShow', 'unlink']]
                    ],
                    table: [
                        ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                        ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
                    ],
                    air: [
                        ['color', ['color']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['para', ['ul', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']]
                    ]
                }
            });
        });

        // Reinitialize Summernote for the original textarea
        $(question).find('textarea.wyswyg').each(function() {
            $(this).summernote({
                height: 300, // Set the height of the editor    
                toolbar: [
                    ['style', ['undo','redo','style']], // Style dropdown (e.g., paragraph, code)
                    ['font', ['bold', 'italic', 'underline', 'clear','strikethrough', 'superscript', 'subscript']], // Font style (bold, italic, underline)
                    ['fontname', ['fontname']], // Font family
                    ['fontsize', ['fontsize']], // Font size
                    ['fontsizeunit', ['fontsizeunit']], // Font size
                    ['color', ['forecolor', 'backcolor']], // Text color and background color
                    ['para', ['ul', 'ol', 'paragraph']], // Lists (unordered, ordered), paragraph formatting
                    ['height', ['height']], // Line height
                    ['table', ['table']], // Insert table
                    ['insert', ['link', 'picture', 'video', 'hr']], // Insert links, images, videos, horizontal rule
                    ['view', ['fullscreen', 'codeview','help']], // Fullscreen mode, code view, help
                ],
                popover: {
                    image: [
                        ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                        ['float', ['floatLeft', 'floatRight', 'floatNone']],
                        ['remove', ['removeMedia']]
                    ],
                    link: [
                        ['link', ['linkDialogShow', 'unlink']]
                    ],
                    table: [
                        ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                        ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
                    ],
                    air: [
                        ['color', ['color']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['para', ['ul', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']]
                    ]
                }
            });
        });
    });

    

    // Event listener for select element change
    function reloadChoices(num){
        // Get the selected value
        var selectedValue = $("#question_type"+num).val();

        if(selectedValue=="short_answer"){
            alert("Note: This type of Question demands that the student writes an answer, however their answers may be correct but varying in how they enter it. Therefore, provide all the acceptable variations of the question that will be accepted as correct answer.")
        }
        
        
        var singleChoiceContent = `<div class="col-md-4">
                <label for="answer1">A</label>
                <input type="text" name="answer1[]" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="answer2">B</label>
                <input type="text" name="answer2[]" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="answer3">C</label>
                <input type="text" name="answer3[]" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="answer4">D</label>
                <input type="text" name="answer4[]" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="answer5">E</label>
                <input type="text" name="answer5[]" class="form-control">
            </div>
            <!-- Add inputs for answer2, answer3, answer4, answer5 -->
            <div class="col-md-4">
                <label for="correct_answer">Correct Answer</label>
                <select name="correct_answer[]" class="form-control">
                    <option value="answer1">Answer A</option>
                    <option value="answer2">Answer B</option>
                    <option value="answer3">Answer C</option>
                    <option value="answer4">Answer D</option>
                    <option value="answer5">Answer E</option>
                </select>
            </div>`;

        // MULTIPLE CHOICE ANSWERS
        var multipleChoiceContent = `<div class="col-md-4">
                <label for="answer1">A</label>
                <input type="text" name="answer1[]" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="answer2">B</label>
                <input type="text" name="answer2[]" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="answer3">C</label>
                <input type="text" name="answer3[]" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="answer4">D</label>
                <input type="text" name="answer4[]" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="answer5">E</label>
                <input type="text" name="answer5[]" class="form-control">
            </div>
            <!-- Add inputs for answer2, answer3, answer4, answer5 -->
            <div class="col-md-4">
                <label for="correct_answer">Correct Answer</label>
                <select name="correct_answer[`+num+`][]" class="form-control" multiple>
                    <option value="answer1">Answer A</option>
                    <option value="answer2">Answer B</option>
                    <option value="answer3">Answer C</option>
                    <option value="answer4">Answer D</option>
                    <option value="answer5">Answer E</option>
                </select>
            </div>`;

        // True or False
        var trueFalseContent = `<div class="col-md-4">
                <label for="answer1">A</label>
                <input type="text" name="answer1[]" class="form-control" value="TRUE" readonly>
            </div>
            <div class="col-md-4">
                <label for="answer2">B</label>
                <input type="text" name="answer2[]" class="form-control" value="FALSE" readonly>
            </div>
           
            <!-- Add inputs for answer2, answer3, answer4, answer5 -->
            <div class="col-md-4">
                <label for="correct_answer">Correct Answer</label>
                <select name="correct_answer[]" class="form-control">
                    <option value="answer1">TRUE</option>
                    <option value="answer2">FALSE</option>
                </select>
            </div>`;

            // True or False
        var shortAnswerContent = `<div class="col-md-12">
                <label for="correct_answer">Correct Answer, use variations seperated by comma</label>
                <input type="text" name="correct_answer[]" class="form-control">                
            </div>`;

        // Update the content of the div based on the selected value
        switch(selectedValue) {
            case 'single_choice':
                $('#dynamicChoices'+num).html(singleChoiceContent);
                break;
            case 'multiple_choice':
                $('#dynamicChoices'+num).html(multipleChoiceContent);
                break;
            case 'true_false':
                $('#dynamicChoices'+num).html(trueFalseContent);
                break;
            case 'short_answer':
                $('#dynamicChoices'+num).html(shortAnswerContent);
                break;
            default:
                // Handle default case
                $('#dynamicChoices'+num).html('<p>No content available</p>');
                break;
        }
    };
    
</script>
