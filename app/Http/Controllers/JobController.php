<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\JobNotificationEmail;
use App\Mail\VerificationCodeMail;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobAplication;
use App\Models\JobType;
use App\Models\SavedJob;
use App\Models\SaveJob;
use App\Models\SelaryModel;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;










// use Illuminate\Support\Facades\File;
// use Intervention\Image\ImageManager;
// use Intervention\Image\Drivers\Gd\Driver;

class JobController extends Controller
{



    public function layout_script()
    {
        return view('layout.master_layout');
    }


    public function jobdetaild_script()
    {
        return view('job_detail');
    }


    public function registration()
    {
        return view('register');
    }

    public function processRistration(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|same:confirm_Password',
            'confirm_Password' => 'required',
        ]);
        if ($validator->passes()) {
            $user = new user();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash('success', 'you have registerd successfully');

            return response()->json([

                'status' => true,
                'errors' => $validator->errors()
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function login_script()
    {
        return view('login');
    }

    public function authentucation(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'

        ]);

        if ($validator->passes()) {

            if (Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])) {
                return redirect()->route('account');
            } else {

                return redirect()->route('login')->with('error', 'Either Email/Password is incorrect');
            }
        } else {

            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }

    public function account_script()
    {
        $id = Auth::user()->id;
        $user = user::where('id', $id)->first();

        return view('account', [
            'user' => $user
        ]);
    }

    public function update_Account(Request $request)
    {

        $id = Auth::user()->id;

        $validator = validator::make($request->all(), [
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,' . $id . ',id'
        ]);

        if ($validator->passes()) {
            $user = user::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;
            $user->save();
            session()->flash('success', 'Account updated successfuly');
            return response()->json([
                'status' => true,
                'errors' => []

            ]);
        } else {
            return response()->json([

                'status' => false,
                'errors' => $validator->errors()

            ]);
        }
    }



    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }




    public function update_profile(Request $request)
    {


        $id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'image' => 'required|image'
        ]);

        if ($validator->passes()) {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageNmae = $id . '-' . time() . '-' . $ext;
            $image->move(public_path('/profile_pic'), $imageNmae);


            // $sourcePath = public_path("/profile_pic".$imageNmae);
            // $manager = new ImageManager(Driver::class);
            // $image =$manager->read($sourcePath);

            // cropthe best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
            // $image->cover(150, 150);
            // $image->toPng()->save(public_path("/profile_pic/thumb/").$imageNmae);

            // File::delete(public_path("/profile_pic/thumb/".Auth::user()->image));
            // File::delete(public_path("/profile_pic/".Auth::user()->image));

            user::where('id', $id)->update(['image' => $imageNmae]);

            session()->flash('success', 'Profile picture updated succcessfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function postjob_script()
    {

        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();

        $jobType = JobType::orderBy('name', 'ASC')->where('status', 1)->get();

        $selary = SelaryModel::orderBy('name', 'ASC')->where('status', 1)->get();

        return view('post_job', [
            'categories' => $categories,
            'jobType' => $jobType,
            'selary' =>  $selary
        ]);
    }


// save Job mtl apply job
    public function save_Job(Request $request)
    {

        $rules = [
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'jobType' => 'required',
            'salary' => 'required',
            'salary_unit' => 'required|integer',
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'company_name' => 'required|min:3|max:75',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $job = new Job();

            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->selary_type_id = $request->salary_unit;
            $job->user_id = Auth::user()->id;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->website;
            $job->save();

            session()->flash('success', 'Job added successfully.');

            return response()->json([
                'status' => true,
                'errors' => []

            ]);
        } else {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function myjob_script()
    {

        $jobs = Job::where('user_id', Auth::user()->id)->with('jobType')->orderBy('created_at', 'DESC')->paginate(5);

        return view('my_job', [
            'jobs' => $jobs
        ]);
    }

    public function edit_scrept()
    {
        return view('edit_job');
    }

    public function editjob(Request $request, $id)
    {
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $jobType = JobType::orderBy('name', 'ASC')->where('status', 1)->get();
        $selary = SelaryModel::orderBy('name', 'ASC')->where('status', 1)->get();

        $job = job::where([
            'user_id' => Auth::user()->id,
            'id' => $id
        ])->first();

        return view('edit_job', [
            'categories' => $categories,
            'jobTypes' => $jobType,
            'job' => $job,
            'selary' => $selary,
        ]);
    }
    public function UpdateJob(Request $request, $id){

        $rules = [
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'company_name' => 'required|min:3|max:75',

        ];

        $validator = validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $job = Job::find($id);

            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->selary_type_id = $request->salary_unit;
            $job->user_id = Auth::user()->id;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->website;
            $job->save();

            session()->flash('success', 'Job Updated successfully.');

            return response()->json([
                'status' => true,
                'errors' => []

            ]);
        } else {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function delete_job(Request $request)
    {

        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $request->jobid
        ])->first();
        if ($job == null) {
            session()->flase('success', 'Either job delete or not found.');
            return response()->json([
                'status' => true
            ]);
        }

        Job::where('id', $request->jobid)->delete();
        session()->Flase('success', 'JOb delete successfully.');
        return response()->json([
            'status' => true
        ]);
    }



    public function index(){
        $categories = Category::where('status', 1)
            ->orderBy('name', 'ASC')
            ->take(8)
            ->get();



            $newCategories = Category::where('status', 1)
            ->orderBy('name', 'ASC')
            ->get();


        $featuredJobs = Job::where('status', 1)
            ->where('isFeatured', 1)
            ->with('jobType')
            ->orderBy('created_at', 'DESC')
            ->take(4)
            ->get();

        $latestJobs = Job::where('status', 1)
            ->with('jobType')
            ->orderBy('created_at', 'DESC')
            ->take(6)
            ->get();

        return view('index', [
            'categories' => $categories,
            'featuredJobs' => $featuredJobs,
            'latestJobs' => $latestJobs,
           'newcategories' => $newCategories
        ]);
    }

    public function job_script(Request $request){

        $categories = Category::where('status', 1)->get();
        $jobType = JobType::where('status', 1)->get();

        $jobs = Job::where('status', 1);

        // Keyword se search
        if (!empty($request->Keyword)) {
            $jobs = $jobs->where(function ($query) use ($request) {
                $query->orWhere('title', 'like', '%' . $request->Keyword . '%');
                $query->orWhere('keywords', 'like', '%' . $request->Keyword . '%');
            });
        }

        // Location se search
        if (!empty($request->location)) {
            $jobs = $jobs->where('location', $request->location);
        }

        // Category se search
        if (!empty($request->category)) {
            $jobs = $jobs->where('category_id', $request->category);
        }

        // Job Type se search
        $jobTypeArray = [];
        if (!empty($request->jobType)) {
            // Ensure $request->jobType is a string
            $jobTypeString = (string) $request->jobType;

            // Convert string to array
            $jobTypeArray = explode(',', $jobTypeString);

            // Debugging: Check if $jobTypeArray has correct values
            Log::info('Job Type Array:', $jobTypeArray);

            $jobs = $jobs->whereIn('job_type_id', $jobTypeArray);
        }

        // Experience se search
        if (!empty($request->experience)) {
            $jobs = $jobs->where('experience', $request->experience);
        }



             $jobs = $jobs->with(['jobType', 'category']);

             if( $request->sort == '0'){
                 $jobs =$jobs->orderBy('created_at', 'ASC');
            }else{
              $jobs =$jobs->orderBy('created_at', 'DESC');
        }
             $jobs =$jobs->paginate(9);

             return view('jobs', [
            'categories' => $categories,
            'jobType' => $jobType,
            'jobs' => $jobs,
            'jobTypeArray' => $jobTypeArray,
        ]);
    }
    // location search
    public function autocompleteLocation(Request $request){
             $term = $request->get('term');

            // Location field se matching locations find karein
             $locations = Job::where('location', 'like', '%' . $term . '%')
                    ->distinct()
                    ->pluck('location')
                    ->toArray();

             // JSON response bhejein
             return response()->json($locations);
}


      // This method will show job detail page

      public function detail($id){
          $job = Job::where([
              'id' => $id,
              'status' => 1
          ])->with(['jobType', 'category','selary'])->first();

          if ($job === null) {
              abort(404);
          }

          $count = 0;
          if (Auth::check()) {
              $count = SavedJob::where([
                  'user_id' => Auth::user()->id,
                  'job_id' => $id
              ])->count();
          }

          // Fetch applications
          $applications = JobAplication::where('job_id', $id)->with('user')->get();

          return view('job_detail', [
              'job' => $job,
              'count' => $count,
              'applications' => $applications
          ]);
      }



        public function applyJob(Request $request){
             $id =$request->id;
             $job = Job::where('id',$id)->first();

              //If job not found in db

            if($job == null){
            session()->flash('error','Job does not exist');
            return response()->json([
               'status'=>false,
                 'message'=> 'Job does not exist'
             ]);
            }
           //you can not apply on your own job

            // $employer_id =$id->user_id;
            $employer_id = $job->user_id;

            if( $employer_id == Auth::user()->id) {
                session()->flash('error','You can not apply on you own job');
                return response()->json([
                    'status'=>false,
                    'message'=>'you can not apply on own job'
                ]);

            }

            //you can not apply on a job twise
            $jobAplicationCount = JobAplication::where([
                'user_id'=> Auth::user()->id,
                'job_id'=> $id
            ])->count();

            if( $jobAplicationCount > 0){
                session()->flash( 'error','You already applied on this job');
                return response()->json([
                    'status'=>false,
                    'message'=>'you can not apply on own job'
                ]);
            }

            $aplication = new JobAplication();
            $aplication->job_id = $id;
            $aplication->user_id = Auth::user()->id;
            $aplication->employer_id = $employer_id;
            $aplication->applied_date = now();
            $aplication->save();

            // Send Notification Email to Employer
            // $employer = user::where('id',$employer_id)->first();
            // $mailData =[
            // 'employer'=>$employer,
            // 'user'=> Auth::user(),
            // 'job'=> $job,
            // ];

            // Mail::to($employer->email)->send( new JobNotificationEmail( $mailData));


            session()->flash('success','You have successfully applied.');
            return response()->json([
                'status'=>true,
                'message'=>'You have successfully applied.'
            ]);
        }

            public function myjobApplication(){


               $jobApplications = JobAplication::where('user_id',Auth::user()->id)->with('job','job.jobType','job.applications')
               ->orderBy('created_at','DESC')->paginate(10);

             return view('job_applied',[
                'jobApplications'=> $jobApplications
             ]);

        }

        public function removejobs (Request $request){


            $jobApplication = JobAplication::where([
                'id' => $request->id,
                'user_id' => Auth::user()->id
                ])->first();

                if ($jobApplication == null){
                    session()->flash('error','Job application not found');
                    return response()->json([
                        'status'=> false,
                    ]);
                }

                JobAplication::find($request->id)->delete();

                session()->flash('success','Job application remove successfully');
                    return response()->json([
                        'status'=> true,
                    ]);

        }



        public function saveJob(Request $request){


             $id = $request->id;

             $job = Job::find($id);

             if($id == null){
              session()->flash('error','Job not found.');
              return response()->json([
               'status'=>false,
              ]);}

             //check  if user alredy save the job
             $count =SavedJob::where([
            'user_id'=> Auth::user()->id,
            'job_id'=> $id
             ])->count();
                 if($count > 0){
              session()->flash('error','You already saved on this job.');
              return response()->json([
               'status'=>false,
              ]);
             }


             $savedJob = new savedJob;
             $savedJob-> job_id = $id;
             $savedJob-> user_id =Auth::user()->id;
             $savedJob->save();

             session()->flash('success','You have successfully saved the job.');

              return response()->json([
               'status'=>false,
              ]);

    }



    public function savedjob_script()
    {
        $savedJob = SavedJob::where('user_id', Auth::user()->id)
            ->with('job', 'job.jobType', 'job.applications')
            ->orderBy('created_at','DESC')
            ->paginate(10);

        return view('saved_jobs', [
            'savedJobs' => $savedJob
        ]);
    }

    public function removeSavedjob(Request $request){


        $savedJob = SavedJob::where([
            'id' => $request->id,
            'user_id' => Auth::user()->id
            ])->first();

            if ($savedJob == null){
                session()->flash('error','Job application not found');
                return response()->json([
                    'status'=> false,
                ]);
            }

           SavedJob::find($request->id)->delete();

            session()->flash('success','Job  remove successfully');
                return response()->json([
                    'status'=> true,
                ]);

    }


    public function updatePassword(Request $request) {
        // Validate the input fields
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:8|different:old_password', // Ensure new password is different from old password
            'confirm_password' => 'required|same:new_password', // Ensure confirm password matches new password
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        // Check if old password matches the current password
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return response()->json([
                'status' => false,
                'errors' => [
                    'old_password' => 'Your old password is incorrect.'
                ],
            ]);
        }

        // Find the authenticated user
        $user = user::find(Auth::user()->id);
        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Flash success message and return response
        session()->flash('success', 'Password updated successfully.');
        return response()->json([
            'status' => true
        ]);
    }

    public function forgotPassword(){

        return view('forgot-password');
    }






}





