<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminProfileController extends Controller
{
    //this method is show admin details page..
    public function showAdmin()
    {
        $admin_profile = User::where('role', 'admin')->first();
        return view('admin_views.admin_profile.admin-details', compact('admin_profile'));
    }

    //this method update profile details...
    public function updateAdminProfile(Request $request)
    {
        $user_id = Auth::id();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required'
        ]);

        if ($validator->passes()) {
            $user = User::find($user_id)->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            Session::flash('success', 'Profile Details Updated Successfully..');

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

    //this method used to update password....
    public function updateAdminPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        //old password check..
        if (Hash::check($request->old_password, Auth::user()->password) == false) {
            session()->flash('error', 'Your old password is incorrect');
            return response()->json([
                'status' => true,
            ]);
        }

        User::find(Auth::id())->update([
            'password' => $request->new_password,
        ]);

        session()->flash('success', 'Your password is updated successfully');
        return response()->json([
            'status' => true,
        ]);
    }

    //this method update admin profile pic...
    // public function updateAdminProfilePic(Request $request)
    // {
    //     $user_id = Auth::id();
    //     $validator = Validator::make($request->all(), [
    //         'image' => 'required|image',
    //     ]);

    //     $user = User::find($user_id);
    //     $image_path = public_path('storage/') . $user->image;

    //     if ($validator->passes()) {
    //         $path = $request->image->store('profile_pic', 'public');

    //         //delete folder image....
    //         if (file_exists($image_path)) {
    //             File::delete($image_path);
    //         }
    //         //delete database...
    //         // File::delete($path);

    //         User::find($user_id)->update([
    //             'image' => $path
    //         ]);
    //         return response()->json([
    //             'status' => true,
    //             'errors' => []
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => false,
    //             'errors' => $validator->errors()
    //         ]);
    //     }
    // }

    //this method used to admin logout...
    public function logoutAdmin()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }
}
