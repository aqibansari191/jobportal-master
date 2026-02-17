<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\admin\AdminJobController;
use App\Http\Controllers\admin\JobApplicationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobsController;
use App\Models\JobAplication;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });



Route::get('/',[JobController::class,'index']);
Route::get('/layout',[JobController::class,'layout_script']);




// Route::get('/jobdetaild',[JobController::class,'jobdetaild_script']);


Route::get('/login',[JobController::class,'login_script']);



Route::get('/forgot-password',[JobController::class,'forgotPassword'])->name('forgotPassword');


Route::get('/register', [JobController::class, 'registration'])->middleware('chacklogout');
Route::post('/process_register', [JobController::class, 'processRistration'])->name('process_register');

Route::get('/login',[JobController::class,'login_script'])->name('login')->middleware('chacklogout');
Route::post('/authenticate',[JobController::class,'authentucation'])->name('authenticate');

Route::get('/account',[JobController::class,'account_script'])->name('account')->middleware('chacklogin');
Route::get('/logout',[JobController::class,'logout'])->name('logout');

Route::put('/updateaccount',[JobController::class,'update_Account'])->name('updateaccount');
Route::post('/updateprofile',[JobController::class,'update_profile'])->name('updateprofile');

Route::get('/postjob',[JobController::class,'postjob_script'])->name('postjob')->middleware('chacklogin');

Route::post('/saveJob',[JobController::class,'save_Job'])->name('save_Job');

Route::get('/myjob',[JobController::class,'myjob_script'])->name('myjob')->middleware('chacklogin');

Route::get('/editpage',[JobController::class,'edit_scrept'])->name('editpage');
Route::get('/editjob/{id}',[JobController::class,'editjob'])->name('editjob');


Route::post('/updateJob/{id}',[JobController::class,'UpdateJob'])->name('updateJob');
Route::post('/deletejob',[JobController::class,'delete_job'])->name('deletejob');


Route::get('/job',[JobController::class,'job_script'])->name('job');

//location search route
Route::get('/autocomplete-location', [JobController::class, 'autocompleteLocation'])->name('autocompleteLocation');


Route::get('/job/detail/{id}',[JobController::class,'detail'])->name('jobDetail');
Route::post('/apply-job',[JobController::class,'applyJob'])->name('applyJob');

Route::get('/jobapplied',[JobController::class,'myjobApplication'])->name('mjobApplication')->middleware('chacklogin');
Route::post('/remove-job-application',[JobController::class,'removejobs'])->name('removejobs');


//this route jobDetails page se saved job
Route::post('/save-job',[JobController::class,'saveJob'])->name('saveJob');


//this route page open
Route::get('/savedjob',[JobController::class,'savedjob_script'])->name('savedJobs')->middleware('chacklogin');
Route::post('/remove-saved-job',[JobController::class,'removeSavedjob'])->name('removeSavedjob');


Route::post('/update-password', [JobController::class, 'updatePassword'])->name('updatePassword');

// Route::group([''],function(){

//     // Guest Route

//     // Authenticated Routes

// });


Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/users', [AdminController::class, 'user_list'])->name('admin.users');
Route::get('/users/{id}', [AdminController::class, 'edit'])->name('admin.edit');
Route::put('/users/{id}', [AdminController::class, 'update'])->name('admin.update');
Route::delete('/users', [AdminController::class,'destroy'])->name('admin.destroy');

Route::get('/jobs', [AdminJobController::class,'Jobs'])->name('admin.jobs');
Route::get('/jobs-edit/{id}', [AdminJobController::class,'edit'])->name('admin.edit');
Route::put('/jobs/{id}', [AdminJobController::class, 'Job_update'])->name('admin.Jobupdate');
Route::delete('/jobs-delete', [AdminJobController::class, 'JobDestroy'])->name('admin.JobDestroy');

Route::get('/job-applications',[JobApplicationController::class,'index'])->name('admin.jobApplications');
Route::delete('/jobs-applicatio-delete', [JobApplicationController::class, 'ApplicatioDestroy'])->name('admin.applicationDestroy');



