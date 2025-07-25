{{-- parent layout extends this line --}}
@extends('front.layout.parent')

@section('main')
{{-- @if(session('success'))
<div class="alert alert-success">
    <span>{{ session('success') }}</span>  
    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif --}}
<section class="section-0 lazy d-flex bg-image-style dark align-items-center" class="" data-bg="{{ asset('assets/images/banner5.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-12 col-xl-8">
                <h1>Find your dream job</h1>
                <p>Thounsands of jobs available.</p>
            </div>
        </div>
    </div>
</section>

<section class="section-1 py-5 "> 
    <div class="container">
        <div class="card border-0 shadow p-5">
            <form  id="submitSeach">
                <div class="row">
                    <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                        <input type="text" class="form-control" name="keywords" id="keywords" placeholder="Keywords">
                    </div>
                    <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                        <input type="text" class="form-control" name="location" id="location" placeholder="Location">
                    </div>
                    <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                        <select name="category" id="category" class="form-control">
                            <option value="">Select a Category</option>
                            @if ($allCategory->isNotEmpty())
                                @foreach ($allCategory as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            @endif)
                        </select>
                    </div>
                    
                    <div class=" col-md-3 mb-xs-3 mb-sm-3 mb-lg-0">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-block">Search</button>
                        </div>
                        
                    </div>
                </div> 
            </form>           
        </div>
    </div>
</section>

<section class="section-2 bg-2 py-5">
    <div class="container">
        <h2>Popular Categories</h2>
        <div class="row pt-5">
            @if ($categories->isNotEmpty())

                @foreach ($categories as $category )
                    <div class="col-lg-4 col-xl-3 col-md-6">
                        <div class="single_catagory">
                            <a href="{{ route('jobs').'?category='.$category->id }}"><h4 class="pb-2">{{ $category->category_name }}</h4></a>
                        </div>
                    </div>
                @endforeach
            
            @endif
            
        </div>
    </div>
</section>

<section class="section-3  py-5">
    <div class="container">
        <h2>Featured Jobs</h2>
        <div class="row pt-5">
            <div class="job_listing_area">                    
                <div class="job_lists">
                    <div class="row">
                        @if ($featured_job->isNotEmpty())
                            
                            @foreach ($featured_job as $featured)
                                <div class="col-md-4">
                                    <div class="card border-0 p-3 shadow mb-4">
                                        <div class="card-body">
                                            <h3 class="border-0 fs-5 pb-2 mb-0">{{ $featured->title }}</h3>
                                            <p>{{ Str::words(strip_tags($featured->description), 5) }}</p>
                                            <div class="bg-light p-3 border">
                                                <p class="mb-0">
                                                    <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                    <span class="ps-1">{{ $featured->location }}</span>
                                                </p>
                                                <p class="mb-0">
                                                    <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                    <span class="ps-1">{{ $featured->jobType->job_type }}</span>
                                                </p>
                                                @if (!is_null($featured->salary))
                                                    <p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                        <span class="ps-1">{{ $featured->salary }}</span>
                                                    </p>
                                                @endif 
                                            </div>

                                            <div class="d-grid mt-3">
                                                <a href="{{ route('job.details',$featured->id) }}" class="btn btn-primary btn-lg">Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @endif
                           
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-3 bg-2 py-5">
    <div class="container">
        <h2>Latest Jobs</h2>
        <div class="row pt-5">
            <div class="job_listing_area">                    
                <div class="job_lists">
                    <div class="row">
                        @if ($latest_job->isNotEmpty())
                            
                            @foreach ($latest_job as $latest)
                                <div class="col-md-4">
                                    <div class="card border-0 p-3 shadow mb-4">
                                        <div class="card-body">
                                            <h3 class="border-0 fs-5 pb-2 mb-0">{{ $latest->title }}</h3>
                                            <p>{{ Str::words(strip_tags($latest->description), 5) }}</p>
                                            <div class="bg-light p-3 border">
                                                <p class="mb-0">
                                                    <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                    <span class="ps-1">{{ $latest->location }}</span>
                                                </p>
                                                <p class="mb-0">
                                                    <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                    <span class="ps-1">{{ $latest->jobType->job_type }}</span>
                                                </p>
                                                @if (!is_null($latest->salary))
                                                    <p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                        <span class="ps-1">{{ $latest->salary }}</span>
                                                    </p>
                                                @endif 
                                            </div>

                                            <div class="d-grid mt-3">
                                                <a href="{{ route('job.details',$latest->id) }}" class="btn btn-primary btn-lg">Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @endif                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('customjs')
      <script type="text/javascript">
          $("#submitSeach").submit(function(e){
            e.preventDefault();

            var url = '{{ route("jobs") }}?';

            var keywords = $('#keywords').val();
            var location = $('#location').val();
            var category = $('#category').val();

            //if keword has a value
            if (keywords != ""){
                url += '&keywords='+keywords;
            }
             //if location has a value
            if (location != ""){
                url += '&location='+location;
            }
             //if category has a value
            if (category != ""){
                url += '&category='+category;
            }
            
            if (keywords != "" || location != "" || category != ""){
                $("#submitSeach").trigger('reset');
                 window.location.href=url;
            }
         
        });
      </script>
@endsection