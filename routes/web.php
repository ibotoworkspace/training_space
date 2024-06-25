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
Route::post('/save-post-update', 'HomeController@savePostUpdate')->name('save-post-update');
Route::get('/update-post/{postid}', 'HomeController@updatePost')->name('update-post');

Route::get('/post/{postid}', 'HomeController@Post')->name('post');
Route::get('/delete-post/{postid}', 'HomeController@deletePost')->name('delete-post');

Route::get('/course', 'CourseController@index')->name('course.index');

Route::resource('/course', 'CourseController')->except('index', 'show')->middleware('auth');

Route::get('/course/{course}/enroll', 'CourseController@enroll')->name('course.enroll');
Route::get('/unenroll/{course_id}/{user_id}', 'CourseController@adminUnenroll')->name('unenroll');
Route::get('/issue-certificate/{course_id}/{user_id}', 'CourseController@issueCertificate')->name('issue-certificate');

// For Courses
Route::get('/course/{course}/complete', 'CourseController@complete')->name('course.complete');
Route::get('/course/{course}', 'CourseController@show')->name('course.show');
Route::get('/course-content/{courseid}', 'CourseController@courseContent')->name('course-content');
Route::get('/complete-content/{contentId}', 'CourseController@contentComplete')->name('content-complete');

// For Course Contents
Route::get('/course-content/{courseid}', 'CourseController@courseContent')->name('course-content');
Route::get('/content-form', 'CourseController@contentForm')->name('content-form');
Route::post('/publish-content', 'CourseController@publishContent')->name('publish-content');
Route::get('/edit-content/{courseid}', 'CourseController@editContent')->name('edit-content');
Route::post('/save-update', 'CourseController@updateContent')->name('save-update');
Route::get('/course-students/{course_id}', 'CourseController@courseStudents')->name('course-students');
Route::get('/download-certificate/{courseid}/{user_id}', 'CourseController@downloadCertificate');
Route::get('/delete-content/{quiz_id}', 'CourseController@deleteContent')->name('delete-content');



// For Categories
Route::get('/create-category', 'HomeController@createCategory')->name('create-category');
Route::post('/publish-category', 'HomeController@publishCategory')->name('publish-category');
Route::get('/delete-category/{catid}', 'HomeController@deleteCategory')->name('delete-category');

// For Quizes
Route::get('/course-quiz/{quizid}', 'CourseController@courseQuiz')->name('course-quiz');
Route::get('/quiz-form', 'CourseController@quizForm')->name('quiz-form');
Route::get('/edit-quiz/{quiz_id}', 'CourseController@editQuiz')->name('edit-quiz');

Route::post('/publish-quiz', 'CourseController@publishQuiz')->name('publish-quiz');
Route::post('/update-quiz', 'CourseController@updateQuiz')->name('update-quiz');

Route::get('/all-quizzes', 'CourseController@allQuizzes')->name('all-quizzes');
Route::get('/delete-quiz/{quiz_id}', 'CourseController@deleteQuiz')->name('delete-quiz');

// For Quiz Questions
// Route::get('/quiz-question/{questionid}', 'CourseController@quizQuestion')->name('quiz-question');
Route::get('/question-form/{quiz_id}', 'CourseController@questionForm')->name('question-form');
Route::post('/publish-question', 'CourseController@publishQuestion')->name('publish-question');
Route::get('/quiz-questions/{quiz_id}', 'CourseController@courseQuestions')->name('quiz-questions');
Route::post('/save-answers', 'CourseController@saveAnswers')->name('save-answers');
Route::get('/quiz-result/{quiz_id}/{user_id}', 'CourseController@quizResult')->name('quiz-result');
Route::get('/create-media', 'HomeController@createMedia')->name('create-media');
Route::post('/saveMedia', 'HomeController@saveMedia')->name('saveMedia');
Route::get('/edit-questions/{quiz_id}', 'CourseController@editQuestions')->name('edit-questions');
Route::get('/edit-question/{question_id}', 'CourseController@editQuestion')->name('edit-question');
Route::post('/update-question', 'CourseController@updateQuestion')->name('update-question');
Route::get('/delete-question/{qid}', 'CourseController@deleteQuestion')->name('delete-question');

// Summernote Upload
Route::post('/upload-image', 'HomeController@uploadSImage')->name('upload.image');


Route::resource('/user', 'UserController')->except('show')->middleware('auth');

Route::get('/user/{user}/account', 'UserController@account')->name('user.account');

Route::get('/dashboard', 'EnrollmentController@dashboard')->name('dashboard')->middleware('auth');
Route::get('/user-dashboard/{userid}', 'EnrollmentController@userDashboard')->name('user-dashboard')->middleware('auth');

Route::get('/dashboard/{user}/{course}/approve', 'EnrollmentController@approve')->name('enrollment.approve');

Route::get('/dashboard/{user}/{course}/disapprove', 'EnrollmentController@disapprove')->name('enrollment.disapprove');

Route::post('/paystack/payment', [PaymentController::class, 'payWithPaystack'])->name('paystack.payment');
Route::get('/paystack/callback', [PaymentController::class, 'handlePaymentCallback']);

Route::post('/paypal/create-payment', [PaymentController::class, 'createPaypalPayment'])->name('paypal.payment');
Route::get('/paypal/confirm-payment', [PaymentController::class, 'confirmPaypalPayment'])->name('paypal.confirm');
Route::get('/paypal/cancel-payment', [PaymentController::class, 'cancelPaypalPayment'])->name('paypal.cancel');

Route::post('/save-payment', [PaymentController::class, 'savePayment'])->name('save-payment');

/// listings
Route::get('/post-list', 'HomeController@postList')->name('post-list');
Route::get('/course-list', 'HomeController@courseList')->name('course-list');
Route::get('/payment-list', 'HomeController@paymentList')->name('payment-list');
Route::get('/content-list', 'CourseController@contentList')->name('content-list');

// ARTISAN COMMANDS
Route::get('/artisan1/{command}', 'HomeController@Artisan1');
Route::get('/artisan2/{command}/{param}', 'HomeController@Artisan2');
