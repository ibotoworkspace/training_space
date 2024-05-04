<?php

use App\Http\Controllers\PaymentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('home'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/publish-post', 'HomeController@publishPost')->name('publish-post');
Route::post('/save-post', 'HomeController@savePost')->name('save-post');
Route::get('/post/{postid}', 'HomeController@Post')->name('post');

Route::get('/course', 'CourseController@index')->name('course.index');

Route::resource('/course', 'CourseController')->except('index', 'show')->middleware('auth');

Route::get('/course/{course}/enroll', 'CourseController@enroll')->name('course.enroll');

Route::get('/course/{course}/unenroll', 'CourseController@unenroll')->name('course.unenroll');

// For Courses
Route::get('/course/{course}/complete', 'CourseController@complete')->name('course.complete');
Route::get('/course/{course}', 'CourseController@show')->name('course.show');
Route::get('/course-content/{courseid}', 'CourseController@courseContent')->name('course-content');

// For Course Contents
Route::get('/course-content/{courseid}', 'CourseController@courseContent')->name('course-content');
Route::get('/content-form', 'CourseController@contentForm')->name('content-form');
Route::post('/publish-content', 'CourseController@publishContent')->name('publish-content');


// For Categories
Route::get('/create-category', 'HomeController@createCategory')->name('create-category');
Route::post('/publish-category', 'HomeController@publishCategory')->name('publish-category');
Route::get('/delete-category/{catid}', 'HomeController@deleteCategory')->name('delete-category');

// For Quizes
Route::get('/course-quiz/{quizid}', 'CourseController@courseQuiz')->name('course-quiz');
Route::get('/quiz-form', 'CourseController@quizForm')->name('quiz-form');
Route::post('/publish-quiz', 'CourseController@publishQuiz')->name('publish-quiz');


// For Quiz Questions
// Route::get('/quiz-question/{questionid}', 'CourseController@quizQuestion')->name('quiz-question');
Route::get('/question-form/{quiz_id}', 'CourseController@questionForm')->name('question-form');
Route::post('/publish-question', 'CourseController@publishQuestion')->name('publish-question');
Route::get('/quiz-questions/{quiz_id}', 'CourseController@courseQuestions')->name('quiz-questions');
Route::post('/save-answers', 'CourseController@saveAnswers')->name('save-answers');
Route::get('/quiz-result/{quiz_id}/{user_id}', 'CourseController@quizResult')->name('quiz-result');


Route::resource('/user', 'UserController')->except('show')->middleware('auth');

Route::get('/user/{user}/account', 'UserController@account')->name('user.account');

Route::get('/dashboard', 'EnrollmentController@dashboard')->name('dashboard')->middleware('auth');

Route::get('/dashboard/{user}/{course}/approve', 'EnrollmentController@approve')->name('enrollment.approve');

Route::get('/dashboard/{user}/{course}/disapprove', 'EnrollmentController@disapprove')->name('enrollment.disapprove');

Route::post('/paystack/payment', [PaymentController::class, 'payWithPaystack'])->name('paystack.payment');
Route::get('/paystack/callback', [PaymentController::class, 'handlePaymentCallback']);

Route::post('/paypal/create-payment', [PaymentController::class, 'createPaypalPayment'])->name('paypal.payment');
Route::get('/paypal/confirm-payment', [PaymentController::class, 'confirmPaypalPayment'])->name('paypal.confirm');
Route::get('/paypal/cancel-payment', [PaymentController::class, 'cancelPaypalPayment'])->name('paypal.cancel');
