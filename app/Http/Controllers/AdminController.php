<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }


// function real index
    public function user_list(){

     $users =User::orderBy('created_at','DESC')->paginate(5);

      return view('admin.user_list',[
    'users' => $users
    ]);
    }

    public function edit($id){

        $user =user::findOrFail($id);

        return view('admin.edit',[
        'user'=>$user
        ]);

    }


    public function update($id, Request $request){

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
            session()->flash('success', 'User information updated successfully.');
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


    public function destroy(Request $request){

        $id = $request->id;

        $user =User::find($id);
        if ($user == null){
            session()->flash('error','User not found');
            return response()->json([
                'status'=>false,
            ]);
        }

        $user->delete();
        session()->flash('success','user delete successfully');
        return response()->json([
            'status'=>true,
        ]);
    }
}
