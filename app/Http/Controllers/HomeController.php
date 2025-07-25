<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  //this method is show home page
  public function index()
  {
    $categories = Category::where('status', 1)->orderBy('category_name', 'ASC')->take(8)->get();

    $allCategory = Category::where('status', 1)->orderBy('category_name', 'ASC')->get();

    $featured_job = Job::where('status', 1)->orderBy('created_at', 'DESC')->with('jobType')->where('isFeatured', 1)->take(6)->get();

    $latest_job = Job::where('status', 1)->with('jobType')->orderBy('created_at', 'DESC')->take(6)->get();

    return view('front.home', compact('categories', 'featured_job', 'latest_job', 'allCategory'));
  }
}
