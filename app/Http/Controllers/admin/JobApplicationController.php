<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    //this method show all application..
    public function showJobApplication()
    {
        $applications = JobApplication::orderBy('applied_date', 'DESC')->with('user', 'job', 'job_owner')->paginate(5);
        return view('admin_views.job_Application.jobApplications', compact('applications'));
    }

    //this method delete jobApplication...
    public function deleteJobApplication(Request $request)
    {
        $id = $request->id;
        $jobApplication = JobApplication::find($id);

        if ($jobApplication == null) {
            session()->flash('error', 'Either Job Application deleted or not found.');
            return response()->json([
                'status' => false,
            ]);
        }

        $jobApplication->delete();
        session()->flash('success', 'Job Application deleted successfully.');
        return response()->json([
            'status' => false,
        ]);
    }
}
