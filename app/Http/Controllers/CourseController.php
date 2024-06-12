<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Course;
use Auth;
use PDF;
use App\UserCourse;
use App\Enrollments;
use App\categories;
use App\coursecontents;
use App\quizes;
use App\questions;
use App\answers;
use App\quiz_attempts;
use App\media;
use App\user_contents;

use Carbon\Carbon;

class CourseController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $usercourse = UserCourse::where('user_id', '=', Auth::id())
                                    ->get();
            $courses = [];
            foreach ($usercourse as $row) {
                $courses[] = $row->course;
            }
            $courses = collect($courses);
        } else {
            $courses = Course::all();
        }
        if ($courses->isEmpty()) {
            return redirect()->route('home')->with(['flash_message'=>'Not enrolled to any courses. Select one of the courses below to enroll.']);
        } else {
            foreach ($courses as $course) {
                $course->author = User::find($course->user_id);
            }
            return view('courses', compact('courses'));
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $submitbuttontext = "Create Course";
        $categories = categories::all();
        return view('courses.create', compact('submitbuttontext','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        // $input['thumbnail'] = $request->file('thumbnail')->store('public/images');
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $filename = $image->getClientOriginalName();
            $image->move(public_path('images'), $filename);
            $input['thumbnail'] = 'images/' . $filename;
        }else{
            $input['thumbnail'] = 'images/placeholder.png';
        }
        $input['user_id'] = Auth::id();
        $course = Course::create($input);
        \Session::flash('flash_message', 'A new course has been created!');
        $author = User::find($course->user_id);
        return redirect(route('home'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\r  $r
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $text = UserCourse::where('user_id', '=', $user->id)->where('course_id', '=', $course->id)->get()->first();
            $enroll = (isset($text))?$text->course_enrolled:'';
            // $comp = UserCourse::where('user_id', '=', $user->id)->where('course_id', '=', $course->id)->get()->first();
            $complete = (isset($text) && $text->course_completed == 1)?$text->course_completed:false;
        } else {
            $enroll = false;
            $complete = false;
        }
        $author = User::find($course->user_id);
        $now = Carbon::now();
        return view('courses.singlecourse', compact('course', 'author', 'enroll', 'complete', 'now'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\r  $r
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $submitbuttontext = "Update Course";
        $categories = categories::all();
        return view('courses.edit', compact('course', 'submitbuttontext','categories'));
    }

    public function enroll(Course $course)
    {
        if (Auth::guest()) {
            return redirect(route('login'));
        }

        $checkEnroll = Enrollments::where('user_id',Auth::id())->where('course_id',$course->id)->get();
        if($checkEnroll->isEmpty()){
            //add enroll request to admin dashboard
            $enrollment = Enrollments::create([
                'user_id' => Auth::id(),
                'course_id' => $course->id,
                'status' => 0,
            ]);
            $enrollment->save();

            $message = "Your request has been submitted, You will be able to see the course content after you have made payment, and the Admin approves your request!";
        }else{
            $message = "You have enrolled before on this course";
        }   

        $course = Course::where('id',$course->id)->select('id','title','fee')->first();
        \Session::flash('flash_message', $message);
        return view('make-payment', compact('course'));
    }

    public function unenroll(Course $course)
    {
        //detach record from user-course.
        UserCourse::where('user_id', '=', Auth::id())
                    ->where('course_id', '=', $course->id)
                    ->delete();
        \Session::flash('flash_message', 'You have been unenrolled from the course!');
        return redirect(route('home'));
    }

    public function complete(Course $course)
    {
        UserCourse::where('user_id', '=', Auth::id())
                    ->where('course_id', '=', $course->id)
                    ->update(['course_completed' => 1]);
        \Session::flash('flash_message', 'Course marked as completed!');
        return redirect(route('course.show', [$course->id]));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\r  $r
     * @return \Illuminate\Http\Response
     */
    public function update(Course $course, Request $request)
    {
        $input = $request->all();
        if ($request->hasFile('thumbnail')) {
        // $input['thumbnail'] = $request->file('thumbnail')->storeAs('images', $request->file('thumbnail')->getClientOriginalName());
        $image = $request->file('thumbnail');
        $filename = $image->getClientOriginalName();
        $image->move(public_path('images'), $filename);
        $input['thumbnail'] = 'images/' . $filename;
        }else{
            $input['thumbnail'] = $input['oldthumbnail'];
        }
        $course->update($input);
        \Session::flash('flash_message', 'The course has been updated!');
        return redirect(route('course.edit',[$course['id']]));

    }

    public function contentForm(){
        $categories = categories::all();
        $courses = Course::select('id','title')->get();
        $students = User::select('id','name','user_role')->get();
        $directory = public_path('media');
        return view('courses.create-content', compact('courses','categories','students'));
    }


    public function contentComplete($contentId)
    {
        $courseinfo = coursecontents::where('id',$contentId)->first();
        user_contents::updateOrCreate(['user_id'=>Auth::id(),'content_id'=>$contentId],[
            'user_id'=>Auth::id(),
            'course_id'=>$courseinfo->course_id,
            'content_id'=>$contentId,
            'content_enrolled'=>1,
            'content_completed'=>1,            
        ]);
        \Session::flash('flash_message', 'Course content marked as completed!');
        return redirect()->back();
    }

    public function editContent($courseid)
    {
        $course = coursecontents::find($courseid);
        $courses = courses::selec();

        $submitbuttontext = "Save Course Content";
        $categories = categories::all();
        return view('courses.edit-content', compact('course', 'submitbuttontext','categories'));
    }


    public function publishContent(Request $request){
        $input = $request->all();
        if ($request->hasFile('file_path')) {
            $image = $request->file('file_path');
            $filename = $image->getClientOriginalName();
            $image->move(public_path('images'), $filename);
            $input['file_path'] = 'images/' . $filename;
        }else{
            $input['file_path'] = '';
        }

        coursecontents::create($input);
        \Session::flash('flash_message', 'A new course content has been created!');
        return redirect(route('content-form'));
    }

    public function updateContent(coursecontents $coursecontents, Request $request)
    {
        $input = $request->all();
        if ($request->hasFile('file_path')) {
            $image = $request->file('file_path');
            $filename = $image->getClientOriginalName();
            $image->move(public_path('images'), $filename);
            $input['file_path'] = 'images/' . $filename;
        }else{
            $input['file_path'] = '';
        }

        $coursecontents->update($input);
        \Session::flash('flash_message', 'The course content has been updated!');
        return redirect(route('course.edit-content',[$coursecontents['id']]));

    }

    public function courseContent($courseid){
        $coursecontent = coursecontents::find($courseid);
        $complete_check = user_contents::where('user_id',Auth::id())->where('content_id',$courseid)->where('content_completed',1)->get();
        $completed = "No";
        if(!$complete_check->isEmpty()){
            $completed = "Yes";
        }

        return view('courses.course-content', compact('coursecontent','completed'));
    }

    public function quizForm(){
        $categories = categories::all();
        $courses = Course::select('id','title')->get();
        $students = User::select('id','name','user_role')->get();
        return view('courses.create-quiz', compact('courses','categories','students'));
    }

    public function publishQuiz(Request $request){
        $input = $request->except('files');
    //    dd($input);
        quizes::create($input);
        \Session::flash('flash_message', 'A new quiz has been created!');
        return redirect(route('quiz-form'));
    }

    public function courseQuiz($quizid){
        $quiz = quizes::where('id',$quizid)->first();
        return view('courses.course-quiz', compact('quiz'));
    }

    // FOR QUIZ QUESTIONS
    public function questionForm($quiz_id){
        $quizes = quizes::select('id','title','subtitle')->get();
        
        return view('courses.create-question', compact('quizes','quiz_id'));
    }

    public function publishQuestion(Request $request){
        // dd($request);
        
        foreach ($request->question as $key => $question) {
            
            $quizQuestion = new questions();
            $quizQuestion->quiz_id = $request->quiz_id;
            $quizQuestion->question = $question;
            $quizQuestion->question_type = $request->question_type[$key];
            $quizQuestion->answer1 = $request->answer1[$key] ?? "";
            $quizQuestion->answer2 = $request->answer2[$key] ?? "";
            $quizQuestion->answer3 = $request->answer3[$key] ?? "";
            $quizQuestion->answer4 = $request->answer4[$key] ?? "";
            $quizQuestion->answer5 = $request->answer5[$key] ?? "";
            switch ($request->question_type[$key]) {
                case 'single_choice':                    
                    $quizQuestion->correct_answer = $request->correct_answer[$key];
                    break;
                case 'multiple_choice':  
                    // dd($request->correct_answer[$key+1]);                  
                    $quizQuestion->correct_answer = implode("|",$request->correct_answer[$key+1]) ?? "";
                    break;
                case 'true_false':                    
                    $quizQuestion->correct_answer = $request->correct_answer[$key] ?? "";
                    break;
                case 'short_answer':                    
                    $quizQuestion->correct_answer = $request->correct_answer[$key] ?? "";
                    break;
                
                default:
                    $quizQuestion->correct_answer = $request->correct_answer[$key];
                    break;
            }
            
            $quizQuestion->score = $request->score[$key];
            $quizQuestion->remarks = $request->remarks[$key];
            $quizQuestion->save();
        }
        \Session::flash('flash_message', 'Quiz questions added successfully!');

        return redirect()->back();
    
    }

    public function courseQuestions($quiz_id){
        $questions = questions::where('quiz_id',$quiz_id)->get();
        $duration = $questions->first()->quiz->duration;

        $attempted = quiz_attempts::select('attempts')->where('quiz_id',$quiz_id)->where('user_id',Auth::id())->get();
        if(!$attempted->isEmpty()){
            if($attempted->count()>=$questions[0]->quiz->attempts_allowed){

                \Session::flash('flash_message', 'You have reached the maximum number of attempts for this quiz');

                return redirect()->back();
            }else{
                $attempts = $attempted->max('attempts')+1;

                return view('courses.questions', compact('questions', 'duration','attempts'));
            }
        }else{
            $attempts = 1;

            return view('courses.questions', compact('questions', 'duration','attempts'));
        }
        // dd($questions);
    }


    public function saveAnswers(Request $request){
        // dd($request);
        $questions = questions::where('quiz_id',$request->quiz_id)->get();
        $totalScore = 0;
        $passed = 0;
        $checkAnswer = false;
        $score = 0;
        
        $failed = $questions->count();
        $quiz = $questions->first()->quiz->title;

        foreach($questions as $key =>$qu){
            
            $correct_ans = $qu->correct_answer;
            
            switch ($qu->question_type) {
                case 'multiple_choice':
                    $acceptableAns = explode('|',str_replace(' ', '', $correct_ans));
                    $check_corrects = [];
                    for($ans_num = 1; $ans_num<=5; $ans_num++){
                        $answerKey = "answer" . $ans_num . "_" . $qu->id;
    
                        // dd($request->answer2_13);
                        if(isset($request->{$answerKey}) && $request->{$answerKey}!=""){
    
                            // dd($request->{$answerKey}." Actually is the answer given");
    
                            $answer = $request->{$answerKey};
                           
                            if (in_array($answer, $acceptableAns)) {
                                $check_corrects[] = true;
                            }else{
                                $check_corrects[] = false;
                            }               
                        }                       
                    }
                    if (in_array(!false, $check_corrects, true)) {
                        $checkAnswer = true;
                        $score = $qu->score;
                        $totalScore+=$score;
                        $failed--;
                        $passed++;
                    }

                    answers::create([
                        'user_id'=>Auth::id(),
                        'quiz_id'=>$qu->quiz_id,
                        'question_id'=>$qu->id,
                        'answer'=>$answer,
                        'is_correct'=>$checkAnswer,
                        'score'=>$score
                    ]);
                    break;
                case 'single_choice':
                    for($ans_num = 1; $ans_num<=5; $ans_num++){
                        $answerKey = "answer_" . $qu->id;

                        // dd($request->answer2_13);
                        if(isset($request->{$answerKey}) && $request->{$answerKey}!=""){

                            // dd($request->{$answerKey}." Actually is the answer given");

                            $answer = $request->{$answerKey};     
                        }                        
                    }
                    if($correct_ans==$answer){
                        $checkAnswer = true;
                        $score = $qu->score;
                        $totalScore+=$score;
                        $failed--;
                        $passed++;
                    }   
                    answers::create([
                        'user_id'=>Auth::id(),
                        'quiz_id'=>$qu->quiz_id,
                        'question_id'=>$qu->id,
                        'answer'=>$answer,
                        'is_correct'=>$checkAnswer,
                        'score'=>$score
                    ]);  
                    break;
                case 'true_false':
                    for($ans_num = 1; $ans_num<=2; $ans_num++){
                        $answerKey = "answer_" . $qu->id;

                        // dd($request->answer2_13);
                        if(isset($request->{$answerKey})){
                            $answer = $request->{$answerKey};
                        }
                    }
                    if($correct_ans==$answer){
                        $checkAnswer = true;
                        $score = $qu->score;
                        $totalScore+=$score;
                        $failed--;
                        $passed++;
                    }
                    answers::create([
                        'user_id'=>Auth::id(),
                        'quiz_id'=>$qu->quiz_id,
                        'question_id'=>$qu->id,
                        'answer'=>$answer,
                        'is_correct'=>$checkAnswer,
                        'score'=>$score,
                        'attempt'=>$attempts->attempts
                    ]);  
                    break;
                
                case 'short_answer':
                    $acceptableAns = explode(',',str_replace(' ', '', $correct_ans));
                    $answerKey = "answer1_" . $qu->id;                        
                    $answer = $request->{$answerKey};                                   
                    
                    if (in_array($answer, $acceptableAns)) {
                        $checkAnswer = true;
                        $score = $qu->score;
                        $totalScore+=$score;
                        $failed--;
                        $passed++;
                    }
                    answers::create([
                        'user_id'=>Auth::id(),
                        'quiz_id'=>$qu->quiz_id,
                        'question_id'=>$qu->id,
                        'answer'=>$answer,
                        'is_correct'=>$checkAnswer,
                        'score'=>$score
                    ]);                        
                   
                    break;
                default:
                    break;
            }
                
        }

        quiz_attempts::create([
                'user_id'=>Auth::id(),
                'quiz_id'=>$qu->quiz_id,
                'total_score'=>$totalScore,
                'attempts'=>$request->attempts
        ]);
        // dd($questions);
        return view('courses.quiz-complete', compact('totalScore', 'passed', 'failed', 'quiz'));
    }

    public function quizResult($quiz_id,$user_id){
        $quiz_result = answers::where('quiz_id',$quiz_id)
        ->where('user_id',$user_id)
        ->get();
        // dd($quiz_result);
        return view('courses.quiz-result', compact('quiz_result'));
    }

    public function downloadCertificate($courseid)
    {
        $course = Course::where('id',$courseid)->first();
        $data = [
            'studentName' => Auth::user()->name,
            'courseName' => $course->title,
            'category' => $course->category->category_name,
            'studentId' => "HRSCC24-00".Auth::id(),
        ];

        $pdf = PDF::loadView('courses.certificate', $data)
        ->setPaper('a4', 'landscape');

        $fileName = $courseId . '_' . $studentName . '.pdf';
        $filePath = public_path('certificates/' . $fileName);

        // Ensure the certificates directory exists
        if (!File::exists(public_path('certificates'))) {
        File::makeDirectory(public_path('certificates'), 0755, true);
        }

        // Save the PDF to the specified path
        $pdf->save($filePath);

        return view('courses.certificates', ['fileName' => $fileName]);
    }

    public function allQuizzes()
    {
        // Fetch all quizzes from the database
        $quizzes = quizes::all();

        // Pass the quizzes to the view
        return view('all-quizes', compact('quizzes'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\r  $r
     * @return \Illuminate\Http\Response
     */
    public function destroy($r)
    {
        $course = Course::find($r);
        $course->delete();
        \Session::flash('flash_message', 'Course Deleted!');
        // dd($course);
        return redirect(route('course.index'));
    }
}
