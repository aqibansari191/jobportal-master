<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\JobAplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index(){

         $applications = JobAplication::orderBy('created_at','DESC')
                    ->with('job','user','employer')
                    ->paginate(10);
         return view('admin.job_list_application',[
        'applications'=>$applications
         ]);
    }

    public function ApplicatioDestroy(Request $request){


        $id = $request->id;

        $jobApplication = JobAplication::find($id);
        if($jobApplication  == null){
            session()->flash('error','Either Jobapplication deleted or not found');
            return response()->json([
                'status'=>false

            ]);
        }

        $jobApplication ->delete();
        session()->flash('success','Job application deleteted successfully.');
        return response()->json([
            'status'=>true

        ]);
    }

}
