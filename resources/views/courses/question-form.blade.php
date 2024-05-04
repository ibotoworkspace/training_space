<h3>Publish Quiz for a Course</h3>
<hr>
<form method="POST" action="{{ route('publish-question') }}">
    @csrf

    <div id="questions-container">
        <div class="col-md-12">
            <label for="correct_answer">Quiz</label>
            <select name="quiz_id" class="form-control">
                @foreach ($quizes as $qz)
                    <option value="{{$qz->id}}" @if ($qz->id==$quiz_id)
                        selected
                    @endif >{{$qz->title}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="row question">
            
            <div class="col-md-12">
                <label for="question">Question</label>
                
                <textarea name="question[]" class="form-control" id="wyswyg" required></textarea>
            </div>
           
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

            <div class="col-md-2">
                <label for="score">Question Score</label>
                <input type="number" name="score[]" class="form-control">
            </div>
            <div class="col-md-2">
                <label for="question_type">Question Type:</label>
                <select name="question_type" id="question_type" class="form-control">
                    <option value="single_choice">Single Choice</option>
                    <option value="multiple_choice">Multiple Choice</option>
                    <option value="true_false">True/False</option>
                    <option value="short_answer">Short Answer</option>
                </select>
            </div>
        
            <div class="col-md-8">
                <label for="remarks">Instructions</label>
                <input type="text" name="remarks[]" class="form-control">
            </div>

        </div>
        <hr>
    </div>

    <hr>

    <div style="text-align: center;">
        <button type="button" id="add-question" class="btn btn-primary center">Add More Question</button>
    </div>
    <div>
        <button type="submit" class="btn btn-success" style="float: right;">Submit Quiz Questions</button>
    </div>
</form>

<script>
    document.getElementById('add-question').addEventListener('click', function() {
        const container = document.getElementById('questions-container');
        const question = container.querySelector('.question');
        const clone = question.cloneNode(true);
        container.appendChild(clone);
    });
</script>
