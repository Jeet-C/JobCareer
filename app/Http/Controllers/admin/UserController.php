<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //this method show all users account or details
    public function fetchUser()
    {
        $users = User::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin_views.users.user', compact('users'));
    }

    //this method show edit page...
    public function edit($id){
        $user =  User::findOrFail($id);
        return view('admin_views.users.edit',compact('user'));
    }

    //this method update user account...
    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'Designation' => 'required'
        ]);

        if ($validator->passes()) {
            $user = User::find($id)->update([
                'name' => $request->name,
                'designation' => $request->Designation,
                'mobile' => $request->mobile,
            ]);

            Session::flash('success', 'User information Updated Successfully..');

            return response()->json([
                'status' => true,
                'errors' => [],
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    //this method use to delete user account..
    public function deleteUserAccount(Request $request){
        $id = $request->id;
        $user = User::find($id);
        if ($user == null){
            session()->flash('error','User account not found.');
            return response()->json([
                'status' => false,
            ]);
        }

        $user->delete();
        Session::flash('success', 'User information/account deleted Successfully..');
        return response()->json([
            'status' => true,
        ]);
    }
}
