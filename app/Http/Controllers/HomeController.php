<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\User;
use App\categories;
use App\posts;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::all();
        $posts = posts::all();
        foreach ($courses as $course) {
            $course->author = User::find($course->user_id);
        }
        if ($courses->isEmpty()) {
            \Session::flash('course', 'No Courses Created.');
        }
        return view('courses', compact('courses','posts'));
    }

    public function createCategory(){
        $categories = categories::all();
        return view('courses.create-category', compact('categories'));
    }


    public function publishCategory(Request $request){
        $input = $request->all();
       
        categories::create($input);
        \Session::flash('flash_message', 'A new course category has been created!');
        return redirect(route('create-category'));
    }

    public function publishPost(){
        return view('publish-post');
    }

    public function Post($postid){
        $post = posts::find($postid);
        return view('post', compact('post'));
    }

    public function savePost(Request $request){
        $input = $request->all();

        // $input['thumbnail'] = $request->file('thumbnail')->store('public/images');
        if ($request->hasFile('featured')) {
            $image = $request->file('featured');
            $filename = $image->getClientOriginalName();
            $image->move(public_path('slides'), $filename);
            $input['featured'] = 'slides/' . $filename;
        }else{
            $input['featured'] = 'images/placeholder.png';
        }
       
        posts::create($input);
        \Session::flash('flash_message', 'A new post has been created!');
        return redirect(route('publish-post'));
    }

    public function deleteCategory($catid){
        categories::find($catid)->delete();
        \Session::flash('flash_message', 'The course category has been deleted successfully!');
        return redirect(route('create-category'));
    }
}
