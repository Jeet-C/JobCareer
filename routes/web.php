<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\admin\AdminProfileController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\JobApplicationController;
use App\Http\Controllers\admin\JobController as AdminJobController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\guest;
use App\Http\Middleware\IfAuthenticated;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobController::class, 'findJob'])->name('jobs');
Route::get('/job/details/{id}', [JobController::class, 'detail'])->name('job.details');
Route::post('/apply-job', [JobController::class, 'applyJob'])->name('apply.job');
Route::post('/save-job', [JobController::class, 'saveJobs'])->name('apply.Savejob');

Route::get('/forgot-password', [AccountController::class, 'forgotpassword'])->name('account.forgotpassword');
Route::post('/process-forgot-password', [AccountController::class, 'processForgotPassword'])->name('account.processforgotpassword');
Route::get('/reset-password/{token}', [AccountController::class, 'resetPassword'])->name('account.resetPassword');
Route::post('/process-reset-password', [AccountController::class, 'prcessResetPassword'])->name('account.processresetpassword');





Route::prefix('account')->group(function () {

    // guest route..
    Route::middleware(guest::class)->group(function () {
        //register page show and new account routes...
        Route::get('/register', [AccountController::class, 'registration'])->name('account.register');
        Route::post('/newUser', [AccountController::class, 'newregistration'])->name('account.newUser');

        //login page show and user login routes...
        Route::get('/login', [AccountController::class, 'login'])->name('account.login');
        Route::post('/userLogin', [AccountController::class, 'newlogin'])->name('account.userLogin');
    });
    //Authenticated route..
    Route::middleware(IfAuthenticated::class)->group(function () {
        //login successfully then redirect profile page...
        Route::get('/profile', [AccountController::class, 'showProfile'])->name('account.profile');
        //profile details update route..
        Route::post('/update-profile', [AccountController::class, 'profileUpdate'])->name('account.update');
        //update password route..
        Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('account.updatePassword');
        //profile picture update route..
        Route::post('/update-profile-pic', [AccountController::class, 'updateProfilePic'])->name('account.updatePic');
        //this route is used logout...
        Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
        //this route get the create job page...
        Route::get('/create-job', [JobController::class, 'createJob'])->name('account.createjob');
        //this route post job db...
        Route::post('/job-post', [JobController::class, 'postJob'])->name('account.jobPost');
        //this route show my post job ...
        Route::get('/show-myjobs', [JobController::class, 'myJobs'])->name('account.showMyjobs');
        //this route show edit job ...
        Route::get('/show-myjobs/edit/{edit_id}', [JobController::class, 'editView'])->name('account.editMyjobs');
        //this route update job ...
        Route::post('/show-myjobs/update/{job_id}', [JobController::class, 'updateJob'])->name('account.updateMyjobs');
        //this route delete job ...
        Route::post('/show-myjobs/delete-job', [JobController::class, 'deleteJob'])->name('account.deleteMyjobs');
        //this route show applied job application...
        Route::get('/my-job-applications', [JobController::class, 'myJobApplication'])->name('account.myjobapplication');
        //this route remove applied job application...
        Route::post('/remove-job-application', [JobController::class, 'removeJob'])->name('account.removejobapplication');
        //this route show saved jobs ...
        Route::get('/show-savejobs', [JobController::class, 'showSaveJobs'])->name('account.showSaveJobs');
        //this route remove saved jobs ...
        Route::post('/remove-saveJob', [JobController::class, 'removeSaveJobs'])->name('account.removeSavedJob');
    });
});

//-------------------------------------------------------Admin all routs---------------------------------------------------------------------------
Route::prefix('admin')->group(function () {
    Route::middleware(CheckAdmin::class)->group(function () {
        //this routs show admin profile...
        Route::get('/admin-profile', [AdminProfileController::class, 'showAdmin'])->name('admin.adminProfile');
        //this routs update admin profile...
        Route::post('/update-admin-profile', [AdminProfileController::class, 'updateAdminProfile'])->name('admin.updateAdminProfile');
        //this routs update admin password...
        Route::post('/update-admin-password', [AdminProfileController::class, 'updateAdminPassword'])->name('admin.updateAdminPassword');
        //this route is used logoutAdmin...
        Route::get('/logout-admin', [AdminProfileController::class, 'logoutAdmin'])->name('admin.logoutAdmin');
        // //this route is used update admin profile pic...
        // Route::post('/update-profilePic-admin', [AdminProfileController::class, 'updateAdminProfilePic'])->name('admin.update ProfilePicAdmin');

        
        //this routs show admin dashboard...
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        //this routs show admin users...
        Route::get('/users', [UserController::class, 'fetchUser'])->name('admin.users');
        //this routs show edit users...
        Route::get('/users/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
        //this routs update users...
        Route::post('/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
        //this routs delete users...
        Route::post('/delete', [UserController::class, 'deleteUserAccount'])->name('admin.users.delete');
        //this routs show all jobs...
        Route::get('/jobs', [AdminJobController::class, 'showJobs'])->name('admin.jobs');
        //this routs show  Editjob page...
        Route::get('/jobs/edit/{id}', [AdminJobController::class, 'edit'])->name('admin.jobs.edit');
        //this routs update  job...
        Route::post('/jobs/update/{id}', [AdminJobController::class, 'update'])->name('admin.jobs.updatejob');
        //this routs delete  job...
        Route::post('/jobs/delete', [AdminJobController::class, 'deleteJobs'])->name('admin.jobs.deletejob');
        //this routs show all jobApplication...
        Route::get('/job-application', [JobApplicationController::class, 'showJobApplication'])->name('admin.jobapplication');
        //this routs delete  jobApplication...
        Route::post('/job-application/delete', [JobApplicationController::class, 'deleteJobApplication'])->name('admin.job-application.delete');
    });
});

//404 not found custon page show....
Route::fallback(function(){
    return view('404');
});
