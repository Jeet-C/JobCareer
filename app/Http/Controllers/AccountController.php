<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordEmail;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    //this method show registration page
    public function registration()
    {
        return view('front.account.registration');
    }
    //this methos create account
    public function newregistration(Request $request)
    {
        $valid_reg = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);
        //create new user database
        $reg = User::create($valid_reg);

        if ($reg) {
            return redirect()->route('account.login')->with('success', 'Registration successful ! Please login.');
        }
    }

    //this method show login page
    public function login()
    {
        return view('front.account.login');
    }

    //this method login user
    public function newlogin(Request $request)
    {
        $valid_login = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        //check user email and password
        if (Auth::attempt($valid_login)) {
            //if user login successfully then redirect to home page...
            if (Auth::user()->role != 'admin') {
                return redirect()->route('account.profile')->with('success', 'Login successful !');
            }
            return redirect()->route('admin.dashboard')->with('success', 'Login successful !');
        } else {
            //if user login failed then redirect to login page with error message...
            return redirect()->back()->with('error', 'Login failed ! Please check your email and password.')->withInput($request->only('email'));
        }
    }

    //this method is used to logout...
    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }

    //this method show profile page...
    public function showProfile()
    {
        $user_id = Auth::id();
        $user_data = User::whereId($user_id)->first();
        return view('front.account.profile', compact('user_data'));
    }

    //update user profile...
    public function profileUpdate(Request $request)
    {

        $user_id = Auth::id();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'Designation' => 'required'
        ]);

        if ($validator->passes()) {
            $user = User::find($user_id)->update([
                'name' => $request->name,
                'designation' => $request->Designation,
                'mobile' => $request->mobile,
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

    //upload profile picture...
    public function updateProfilePic(Request $request)
    {
        $user_id = Auth::id();
        $validator = Validator::make($request->all(), [
            'image' => 'required|image',
        ]);

        $user = User::find($user_id);
        $image_path = public_path('storage/') . $user->image;

        if ($validator->passes()) {
            $path = $request->image->store('profile_pic', 'public');

            //delete folder image....
            if (file_exists($image_path)) {
                File::delete($image_path);
            }
            //delete database...
            // File::delete($path);

            User::find($user_id)->update([
                'image' => $path
            ]);
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

    //update password method...
    public function updatePassword(Request $request)
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

    //this method show forgot password...
    public function forgotpassword()
    {
        return view('front.account.forget-password');
    }

    //this method find email and send mail...
    public function processForgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.forgotpassword')->withErrors($validator);
        }

        $token = Str::random(60);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        $user = User::where('email', $request->email)->first();
        $mailData = [
            'token' => $token,
            'user' => $user,
            'subject' => 'You have requested to change your password.',
        ];
        Mail::to($request->email)->send(new ResetPasswordEmail($mailData));

        return redirect()->route('account.forgotpassword')->with('success', 'Reset password email has been send to your inbox.');
    }

    //this method show reset password page...
    public function resetPassword($tokenstring)
    {
        $token =  DB::table('password_reset_tokens')->where('token', $tokenstring)->first();

        if ($token == null) {
            return redirect()->route('account.forgotpassword')->with('error', 'Invalid token.');
        }

        return view('front.account.reset-password', compact('tokenstring'));
    }

    //this method update forgot password...
    public function prcessResetPassword(Request $request)
    {
        $token =  DB::table('password_reset_tokens')->where('token', $request->token)->first();

        if ($token == null) {
            return redirect()->route('account.forgotpassword')->with('error', 'Invalid token.');
        }

        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password'
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.resetPassword', $request->token)->withInput($request->only('new_password'))->withErrors($validator);
        }

        User::where('email', $token->email)->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('account.login')->with('success', 'You have successfully change your password.');
    }
}
