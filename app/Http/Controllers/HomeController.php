<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\User;
use App\categories;
use App\posts;
use App\media;
use App\payments;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;


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
        $posts = posts::where('user_id',null)->get();
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
        $categories = categories::select('id','category_name')->get();
        $students = User::select('id','name')->get();

        return view('publish-post',compact('categories','students'));
    }

    public function Post($postid){
        $post = posts::find($postid);
        return view('post', compact('post'));
    }

    public function updatePost($postid){
        $categories = categories::select('id','category_name')->get();
        $students = User::select('id','name')->get();
        $post = posts::find($postid);
        return view('update-post', compact('post','categories','students'));
    }

    // DELETE POST
    public function deletePost($postid){

        if(Auth::user()->user_role=="Admin"){
            $post = posts::find($postid);
            $post->delete();
            \Session::flash('flash_message', 'The post has beeen deleted!');
        }else{
            \Session::flash('flash_message', 'You don\'t have the permission to delete a post !');
        }
        return redirect()->route('post-list');
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
            $input['featured'] = '';
        }
       
        posts::create($input);
        \Session::flash('flash_message', 'A new post has been created!');
        return redirect(route('publish-post'));
    }

    public function savePostUpdate(Request $request){
        $post = posts::where('id',$request->post_id)->first();

        $input = $request->except(['post_id', 'old_featured']);

        // $input['thumbnail'] = $request->file('thumbnail')->store('public/images');
        if ($request->hasFile('featured')) {
            $image = $request->file('featured');
            $filename = $image->getClientOriginalName();
            $image->move(public_path('slides'), $filename);
            $input['featured'] = 'slides/' . $filename;
        }else{
            $input['featured'] = $request->old_featured;
        }
       
        posts::updateOrCreate(['id'=>$request->post_id],$input);
        \Session::flash('flash_message', 'The post has been created!');
        return redirect()->back();
    }

    public function deleteCategory($catid){
        categories::find($catid)->delete();
        \Session::flash('flash_message', 'The course category has been deleted successfully!');
        return redirect(route('create-category'));
    }

    public function createMedia()
    {
                
        return view('create-media');
    }
    public function saveMedia(Request $request){

        foreach ($request->file('media') as $file) {
            $fileType = $file->getClientOriginalExtension();
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('media'), $fileName);
            Media::create([
                'file_type' => $fileType,
                'file_name' => $fileName
            ]);
        }
        return redirect()->back()->with('success', 'Media uploaded successfully.');
    }

    public function uploadSImage(Request $request){
          
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileType = $file->getClientOriginalExtension();
                $filename = $file->getClientOriginalName();
                $path = public_path('media');
    
                // Ensure the directory exists
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
    
                // Move the file to the public/media directory
                $file->move($path, $filename);

                
                Media::create([
                    'file_type' => $fileType,
                    'file_name' => $filename
                ]);
    
                $url = asset('media/' . $filename);
    
                return response()->json(['url' => $url]);
            }else{
                return response()->json(['error' => 'File not found.'], 400);
            }
    }

    public function postList(){
        $posts = posts::all();
        return view('post-list', compact('posts'));
    }

    public function courseList(){
        $courses = Course::all();
        return view('course-list', compact('courses'));
    }

    public function paymentList(){
        $payments = payments::all();
        return view('payment-list', compact('payments'));
    }

    // ARTISAN CONTROLLERS
    public function Artisan1($command) {
        $artisan = Artisan::call($command);
        $output = Artisan::output();
        return dd($output);
    }

    public function Artisan2($command, $param) {
        $output = Artisan::call($command.":".$param);
        return dd($output);
    }
}
