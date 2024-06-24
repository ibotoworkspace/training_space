<style>
    hr{
        border: 3px solid black !important;
    }
</style>
<h3>Update Question {{$question->ordering}} for Quiz: {{$question->quiz->title}}</h3>

<form method="POST" action="{{ route('update-question') }}">
    @csrf

    <input type="hidden" name="qid" value="{{$question->id}}">
    <input type="hidden" name="question_type" value="{{$question->question_type}}">

    <div class="row"><div class="col-md-12">
        <label for="question">Question {{$question->ordering}}</label>
        
        <textarea name="question" class="wyswyg">{!!$question->question!!}</textarea>
    </div></div>

    <div class="row">
        @switch($question->question_type)
            @case("single_choice")
                <div class="col-md-4">
                    <label for="answer1">A</label>
                    <input type="text" name="answer1" class="form-control" value="{{$question->answer1}}">
                </div>
                <div class="col-md-4">
                    <label for="answer2">B</label>
                    <input type="text" name="answer2" class="form-control" value="{{$question->answer2}}">
                </div>
                <div class="col-md-4">
                    <label for="answer3">C</label>
                    <input type="text" name="answer3" class="form-control" value="{{$question->answer3}}">
                </div>
                <div class="col-md-4">
                    <label for="answer4">D</label>
                    <input type="text" name="answer4" class="form-control" value="{{$question->answer4}}">
                </div>
                <div class="col-md-4">
                    <label for="answer5">E</label>
                    <input type="text" name="answer5" class="form-control" value="{{$question->answer5}}">
                </div>
                <!-- Add inputs for answer2, answer3, answer4, answer5 -->
                <div class="col-md-4">
                    <label for="correct_answer">Correct Answer</label>
                    <select name="correct_answer" class="form-control">
                        @switch($question->correct_answer)
                            @case("answer1")
                                <option value="answer1" selected>Answer A</option>
                                @break
                            @case("answer2")
                                <option value="answer2" selected>Answer B</option>
                                @break
                            @case("answer3")
                                <option value="answer3" selected>Answer C</option>
                                @break
                            @case("answer4")
                                <option value="answer4" selected>Answer D</option>
                                @break
                            @case("answer5")
                                <option value="answer5" selected>Answer E</option>
                                @break
                            @default
                        @endswitch
                        <option value="answer1">Answer A</option>
                        <option value="answer2">Answer B</option>
                        <option value="answer3">Answer C</option>
                        <option value="answer4">Answer D</option>
                        <option value="answer5">Answer E</option>
                    </select>
                </div>
                @break
            @case("multiple_choice")
                <div class="col-md-4">
                    <label for="answer1">A</label>
                    <input type="text" name="answer1" class="form-control" value="{{$question->answer1}}">
                </div>
                <div class="col-md-4">
                    <label for="answer2">B</label>
                    <input type="text" name="answer2" class="form-control" value="{{$question->answer2}}">
                </div>
                <div class="col-md-4">
                    <label for="answer3">C</label>
                    <input type="text" name="answer3" class="form-control" value="{{$question->answer3}}">
                </div>
                <div class="col-md-4">
                    <label for="answer4">D</label>
                    <input type="text" name="answer4" class="form-control" value="{{$question->answer4}}">
                </div>
                <div class="col-md-4">
                    <label for="answer5">E</label>
                    <input type="text" name="answer5" class="form-control" value="{{$question->answer5}}">
                </div>
                <!-- Add inputs for answer2, answer3, answer4, answer5 -->
                <div class="col-md-4">

                    <label for="correct_answer">Correct Answer</label>
                    <select name="correct_answer" class="form-control" multiple>
                        @php
                            $correct_answers = explode("|",$question->correct_answer);
                        @endphp
                        @foreach ($correct_answers as $cor_ans)
                            @switch($cor_ans)
                                @case("answer1")
                                    <option value="answer1" selected>Answer A</option>
                                    @break
                                @case("answer2")
                                    <option value="answer2" selected>Answer B</option>
                                    @break
                                @case("answer3")
                                    <option value="answer3" selected>Answer C</option>
                                    @break
                                @case("answer4")
                                    <option value="answer4" selected>Answer D</option>
                                    @break
                                @case("answer5")
                                    <option value="answer5" selected>Answer E</option>
                                    @break
                                @default
                            @endswitch
                        @endforeach
                        <option value="answer1">Answer A</option>
                        <option value="answer2">Answer B</option>
                        <option value="answer3">Answer C</option>
                        <option value="answer4">Answer D</option>
                        <option value="answer5">Answer E</option>                        
                    </select>
                </div>
                @break    
            @case("true_false")
                <div class="col-md-4">
                    <label for="answer1">A</label>
                    <input type="text" name="answer1" class="form-control" value="TRUE" readonly>
                </div>
                <div class="col-md-4">
                    <label for="answer2">B</label>
                    <input type="text" name="answer2" class="form-control" value="FALSE" readonly>
                </div>
            
                <!-- Add inputs for answer2, answer3, answer4, answer5 -->
                <div class="col-md-4">
                    <label for="correct_answer">Correct Answer</label>
                    <select name="correct_answer" class="form-control">
                        <option value="{{$question->correct_answer}}" selected>{{$question->correct_answer=="answer1" ? "TRUE" : "FALSE"}}</option>
                        <option value="answer1">TRUE</option>
                        <option value="answer2">FALSE</option>
                    </select>
                </div>
                @break
            @case("short_answer")
                <div class="col-md-12">
                    <label for="correct_answer">Correct Answer, use variations seperated by comma</label>
                    <input type="text" name="correct_answer" class="form-control" value="{{$question->correct_answer}}">                
                </div>           
                @break
            @default                
        @endswitch
    </div>

    <div class="row">
        <div class="col-md-2">
            <label for="score">Question Score</label>
            <input type="number" name="score" class="form-control" value="{{$question->score}}">
        </div>
        <div class="col-md-2">
            <label for="ordering">Ordering</label>
            <input type="number" name="ordering" class="form-control" value="{{$question->ordering}}">
        </div>
        <div class="col-md-8">
            <label for="remarks">Instructions/Rationale</label>
            <textarea name="remarks" class="form-control">{{$question->remarks}}</textarea>
        </div>
    </div>

    <div style="margin-bottom: 30px;">
        <button type="submit" class="btn btn-success" style="float: right;">Update this Question</button>
    </div>
</form>