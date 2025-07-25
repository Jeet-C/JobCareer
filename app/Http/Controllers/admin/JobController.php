<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    //this method show job page and all jobs...
    public function showJobs()
    {
        $jobs = Job::orderBy('created_at', 'DESC')->with('user', 'applications')->paginate(5);
        return view('admin_views.jobs.jobs', compact('jobs'));
    }

    //this method show edit page...
    public function edit($id)
    {
        $category = Category::orderBy('category_name', 'ASC')->get();
        $jobType = JobType::orderBy('job_type', 'ASC')->get();
        $job = Job::findOrFail($id);
        return view('admin_views.jobs.edit', compact('job', 'category', 'jobType'));
    }

    //this method update jobs...
    public function update(Request $request, $id)
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

                'status' => $request->status,
                'isFeatured' => (!empty($request->isFeatured)) ? $request->isFeatured  : 0,


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

    //this method delete jobs...
    public function deleteJobs(Request $request)
    {
        $id = $request->id;
        $job = Job::find($id);

        if ($job == null) {
            session()->flash('error', 'Either job deleted or not found.');
            return response()->json([
                'status' => false,
            ]);
        }

        $job->delete();
        session()->flash('success', 'Job deleted successfully.');
        return response()->json([
            'status' => false,
        ]);
    }
}
