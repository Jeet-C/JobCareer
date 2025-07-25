<?php

namespace App\Http\Controllers;

use App\Mail\JobNotificationEmail;
use App\Models\Job;
use App\Models\JobType;
use App\Models\Category;
use App\Models\JobApplication;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    //job post page get...
    public function createJob()
    {
        $category = Category::orderBy('category_name', 'ASC')->where('status', 1)->get();
        $jobType = JobType::orderBy('job_type', 'ASC')->where('status', 1)->get();
        return view('front.account.job.create', compact('category', 'jobType'));
    }

    //job post in database...
    public function postJob(Request $request)
    {
        $rulse = [
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'jobtype' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'experience' => 'required',
            'company_name' => 'required|min:3|max:75',
        ];

        $validator = Validator::make($request->all(), $rulse);

        if ($validator->passes()) {
            Job::create([
                'title' => $request->title,
                'category_id' => $request->category,
                'job_type_id' => $request->jobtype,
                'user_id' => Auth::id(),
                'vacancy' => $request->vacancy,
                'salary' => $request->salary,
                'location' => $request->location,
                'description' => $request->description,
                'benefits' => $request->benefits,
                'responsibility' => $request->responsibility,
                'qualifications' => $request->qualifications,
                'experience' => $request->experience,
                'keywords'  => $request->keywords,
                'company_name' => $request->company_name,
                'company_location' => $request->company_location,
                'company_website' => $request->website,
            ]);
            Session()->flash('success', 'Job post successfully');
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

    //show this myjob page...
    public function myJobs()
    {
        $jobs = Job::where('user_id', Auth::id())->with(['jobType', 'applications'])->orderBy('created_at', 'DESC')->paginate(5);
        return view('front.account.job.my-jobs', compact('jobs'));
    }

    //show this edit job page...
    public function editView(Request $request, $id)
    {
        $category = Category::orderBy('category_name', 'ASC')->where('status', 1)->get();
        $jobType = JobType::orderBy('job_type', 'ASC')->where('status', 1)->get();

        $job = Job::where([
            'user_id' => Auth::id(),
            'id' => $id
        ])->first();

        if ($job == null) {
            abort(404);
        }

        return view('front.account.job.edit', compact('category', 'jobType', 'job'));
    }

    //edit form update method...
    public function updateJob(Request $request, $id)
    {
        $rulse = [
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'jobtype' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'experience' => 'required',
            'company_name' => 'required|min:3|max:75',
        ];

        $validator = Validator::make($request->all(), $rulse);

        if ($validator->passes()) {
            Job::find($id)->update([
                'title' => $request->title,
                'category_id' => $request->category,
                'job_type_id' => $request->jobtype,
                'user_id' => Auth::id(),
                'vacancy' => $request->vacancy,
                'salary' => $request->salary,
                'location' => $request->location,
                'description' => $request->description,
                'benefits' => $request->benefits,
                'responsibility' => $request->responsibility,
                'qualifications' => $request->qualifications,
                'experience' => $request->experience,
                'keywords'  => $request->keywords,
                'company_name' => $request->company_name,
                'company_location' => $request->company_location,
                'company_website' => $request->website,
            ]);
            Session()->flash('success', 'Job updated successfully');
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

    //this method use delete job....
    public function deleteJob(Request $request)
    {
        $job = Job::where([
            'user_id' => Auth::id(),
            'id' => $request->jobId,
        ])->first();
        if ($job == null) {
            Session()->flash('error', 'Job not found...');
            return response()->json([
                'status' => true,
            ]);
        }

        $job->delete();
        Session()->flash('success', 'Job deleted successfully.');
        return response()->json([
            'status' => true,
        ]);
    }

    //this method will show job page...
    public function findJob(Request $request)
    {

        $categories = Category::orderBy('category_name', 'ASC')->where('status', 1)->get();
        $jobTypes = JobType::orderBy('job_type', 'ASC')->where('status', 1)->get();

        $jobs = Job::where('status', 1);

        // search using keywords..
        if (!empty($request->keywords)) {
            $jobs = $jobs->where(function ($query) use ($request) {
                $query->orWhere('title', 'like', '%' . $request->keywords . '%');
                $query->orWhere('keywords', 'like', '%' . $request->keywords . '%');
            });
            // $jobs = $jobs->where('title', 'like', '%' . $request->keywords . '%')->orWhere('keywords', 'like', '%' . $request->keywords . '%');
        }

        //search using location...
        if (!empty($request->location)) {
            $jobs = $jobs->where('location', $request->location);
        }

        //search using category...
        if (!empty($request->category)) {
            $jobs = $jobs->where('category_id', $request->category);
        }

        //search using job_type...
        $jobs_type = [];
        if (!empty($request->job_type)) {
            $jobs_type = explode(',', $request->job_type);
            $jobs = $jobs->whereIn('job_type_id', $jobs_type);
        }

        //search using experience...
        if (!empty($request->experience)) {
            $jobs = $jobs->where('experience', $request->experience);
        }

        $jobs = $jobs->with('jobType');

        if ($request->sort != null && $request->sort == 0) {
            $jobs = $jobs->orderBy('created_at', 'ASC');
        } else {
            $jobs = $jobs->orderBy('created_at', 'DESC');
        }

        // dd($request->sort);

        $jobs = $jobs->paginate(6);

        return view('front.jobs', compact('categories', 'jobTypes', 'jobs', 'jobs_type'));
    }

    //this method show job details page....
    public function detail($id)
    {
        $job_detail = Job::where(['id' => $id, 'status' => 1])->with('jobType')->first();

        if ($job_detail == null) {
            abort(404);
        }

        $count = SavedJob::where(['user_id' => Auth::id(), 'job_id' => $id])->count();

        //fetch applicants..
        $applications = JobApplication::where('job_id', $id)->with('user')->get();

        return view('front.jobDetails', compact('job_detail', 'count', 'applications'));
    }

    //job apply method...
    public function applyJob(Request $request)
    {
        $id = $request->id;

        $job = Job::where('id', $id)->first();

        //if job not found db...
        if ($job == null) {
            Session()->flash('error', 'Job does not exist');
            return response()->json([
                'status' => false,
                'message' => 'Job does not exist'
            ]);
        }

        //you can not apply on your won job ...
        $job_creater_id = $job->user_id;

        if ($job_creater_id == Auth::id()) {
            Session()->flash('error', 'You can not apply on your won job');
            return response()->json([
                'status' => false,
                'message' => 'You can not apply on your won job'
            ]);
        }

        //you can not on a job twise..
        $jobapplicationCount = JobApplication::where([
            'user_id' => Auth::id(),
            'job_id' => $id
        ])->count();

        if ($jobapplicationCount > 0) {
            Session()->flash('error', 'You already applied on this job');
            return response()->json([
                'status' => false,
                'message' => 'You already applied on this job'
            ]);
        }

        JobApplication::create([
            'job_id' => $id,
            'user_id' => Auth::id(),
            'job_owner_id' => $job_creater_id,
            'applied_date' => now()
        ]);

        //send notification email job creator ...
        $job_owner = User::where('id', $job_creater_id)->first();
        $mailData = [
            'job_owner' => $job_owner,
            'user' => Auth::user(),
            'job' => $job
        ];
        Mail::to($job_owner->email)->send(new JobNotificationEmail($mailData));

        Session()->flash('success', 'You have successfully applied.');
        return response()->json([
            'status' => true,
            'message' => 'You have successfully applied.'
        ]);
    }

    //this method show applied job page...
    public function myJobApplication()
    {
        $jobApplications = JobApplication::where('user_id', Auth::id())->with(['job', 'job.jobType', 'job.applications'])->orderBy('applied_date', 'DESC')->paginate(5);
        return view('front.account.job.my-job-applications', compact('jobApplications'));
    }

    //this method remove applied job...
    public function removeJob(Request $request)
    {
        $jobApplication = JobApplication::where(['id' => $request->id, 'user_id' => Auth::id()])->first();
        if ($jobApplication == null) {
            session()->flash('error', 'Job application not found');
            return response()->json([
                'status' => false,
            ]);
        }

        $jobApplication->delete();
        session()->flash('success', 'Job application removed successfully');
        return response()->json([
            'status' => true,
        ]);
    }

    //this method save jobs in db...
    public function saveJobs(Request $request)
    {
        $id = $request->id;

        $job = Job::find($id);

        if ($job == null) {
            session()->flash('error', 'Job not found');
            return response()->json([
                'status' => false,
            ]);
        }

        //check if user already saved the job...
        $count = SavedJob::where(['user_id' => Auth::id(), 'job_id' => $id])->count();
        if ($count > 0) {
            session()->flash('error', 'You already saved this job.');
            return response()->json([
                'status' => false,
            ]);
        }

        //user not a saved your own job..
        if ($job->user_id == Auth::id()) {
            session()->flash('error', 'You can not saved on your won job.');
            return response()->json([
                'status' => false,
            ]);
        }

        SavedJob::create([
            'job_id' => $id,
            'user_id' => Auth::id(),
        ]);

        session()->flash('success', 'You have successfully saved job.');
        return response()->json([
            'status' => true,
        ]);
    }

    //this method show saved jobs in the page...
    public function showSaveJobs()
    {
        $saveJobs = SavedJob::where('user_id', Auth::id())->with(['job', 'job.jobType', 'job.applications'])->orderBy('created_at', 'DESC')->paginate(5);
        return view('front.account.job.saved-jobs', compact('saveJobs'));
    }

    //this method remove saved jobs...
    public function removeSaveJobs(Request $request)
    {
        $jobApplication = SavedJob::where(['id' => $request->id, 'user_id' => Auth::id()])->first();
        if ($jobApplication == null) {
            session()->flash('error', 'Job not found');
            return response()->json([
                'status' => false,
            ]);
        }

        $jobApplication->delete();
        session()->flash('success', 'Saved job removed successfully');
        return response()->json([
            'status' => true,
        ]);
    }
}
