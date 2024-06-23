<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\UserCourse;
use App\Enrollments;
use App\User;
use App\quiz_attempts;
use App\posts;
use Auth;

class EnrollmentController extends Controller
{
    public function approve(User $user, Course $course)
    {
        $usercourse = UserCourse::create(
            [
                'user_id' => $user->id,
                'course_id' => $course->id,
                'course_enrolled' => 1,
                'course_completed' => 0
            ]
        );
        $usercourse->save();
        Enrollments::where('user_id', '=', $user->id)
                    ->where('course_id', '=', $course->id)
                    ->delete();
        \Session::flash('flash_message', 'The enrollment request has been approved');
        return redirect(route('dashboard'));
    }

    public function disapprove(User $user, Course $course)
    {
        $enrollment = Enrollments::where('user_id', '=', $user->id)
                    ->where('course_id', '=', $course->id)
                    ->delete();
        \Session::flash('flash_message', 'The enrollment request has been disapproved!');
        return redirect(route('dashboard'));
    }

    public function dashboard()
    {
        $user = Auth::user();
        $category_ids = [];
        $posts = posts::all();
        $allcourses = null;
        $students = null;

        if($user->user_role=="Admin"){
            $enrollments = Enrollments::all();
            $courses = UserCourse::all();
            $quizAttempts = quiz_attempts::all();
            $allcourses = Course::all();
            $students = User::where('user_role','Student')->get();
        }else{
            $courses = UserCourse::where('user_id', '=', $user->id)->get();
            $enrollments = Enrollments::where('user_id', '=', $user->id)->get();
            $quizAttempts = quiz_attempts::where('user_id', '=', $user->id)->get();

            foreach($courses as $co){
                $category_ids[] = $co->course->category_id; 
            }
        }
        
        return view('dashboard', compact('enrollments','courses','quizAttempts','posts','category_ids','allcourses','students'));
    }

    public function userDashboard($userid)
    {
        $user = User::find($userid);
        $category_ids = [];
        $posts = posts::all();
        $allcourses = null;
        $students = null;

        
            $courses = UserCourse::where('user_id', '=', $user->id)->get();
            $enrollments = Enrollments::where('user_id', '=', $user->id)->get();
            $quizAttempts = quiz_attempts::where('user_id', '=', $user->id)->get();

            foreach($courses as $co){
                $category_ids[] = $co->course->category_id; 
            }
        
        
        return view('user-dashboard', compact('enrollments','courses','quizAttempts','posts','category_ids','allcourses','students','user'));
    }
}
