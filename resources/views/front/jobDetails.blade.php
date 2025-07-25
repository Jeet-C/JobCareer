@extends('front.layout.parent')

@section('main')
    <section class="section-4 bg-2">    
    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('jobs') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to jobs page</a></li>
                    </ol>
                </nav>
            </div>
        </div> 
    </div>
    <div class="container job_details_area">
        <div class="row pb-5">
            <div class="col-md-8">
                @include('front.layout.alert')
                <div class="card shadow border-0">
                    <div class="job_details_header">
                        <div class="single_jobs white-bg d-flex justify-content-between">
                            <div class="jobs_left d-flex align-items-center">
                                
                                <div class="jobs_conetent">
                                    <a href="#">
                                        <h4>{{ $job_detail->title }}</h4>
                                    </a>
                                    <div class="links_locat d-flex align-items-center">
                                        <div class="location">
                                            <p> <i class="fa fa-map-marker"></i> {{$job_detail->location}}</p>
                                        </div>
                                        <div class="location">
                                            <p> <i class="fa fa-clock-o"></i> {{ $job_detail->jobType->job_type }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="jobs_right">
                                <div class="apply_now">
                                    @if (auth()->check())
                                        <a class="heart_mark {{ ($count == 1)? 'saved-job' : '' }}" href="javascript:void(0);" onclick="savedJob({{ $job_detail->id }})"> <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                    @else
                                        <a class="heart_mark" href="{{ route('account.login') }}"> <i class="fa fa-heart-o" aria-hidden="true"></i></a>    
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="descript_wrap white-bg">
                        <div class="single_wrap">
                            <h4>Job description</h4>
                            <p>{!! nl2br($job_detail->description) !!}</p>
                        </div>
                        <div class="single_wrap">
                            @if (!empty($job_detail->responsibility))
                             <h4>Responsibility</h4>
                                <p>{!! nl2br($job_detail->responsibility) !!}</p>
                            @endif
                        </div>
                        <div class="single_wrap">
                            @if (!empty($job_detail->qualifications))
                             <h4>Qualifications</h4>
                                <p>{!! nl2br($job_detail->qualifications) !!}</p>
                            @endif
                        </div>
                        <div class="single_wrap">
                            @if (!empty($job_detail->benefits))
                             <h4>Benefits</h4>
                                <p>{!! nl2br($job_detail->benefits) !!}</p>
                            @endif
                        </div>
                        <div class="border-bottom"></div>
                        <div class="pt-3 text-end">
                              @if (auth()->check())
                                 <a onclick="savedJob({{ $job_detail->id }})" class="btn btn-secondary">Save</a>
                            @else
                                 {{--  <a  href="" class="btn btn-secondary disabled">Save</a> --}}
                                  <a href="{{ route('account.login') }}" class="btn btn-secondary">Save</a>
                            @endif

                            @if (auth()->check())
                                 <a  onclick="applyJob({{ $job_detail->id }})" class="btn btn-primary">Apply</a>
                            @else
                                 {{-- <a href="javascript:void(0);" class="btn btn-primary disabled">Login to Apply</a> --}}
                                  <a href="{{ route('account.login') }}" class="btn btn-primary">Apply</a>
                            @endif
                           
                        </div>
                    </div>
                </div>

                @if (auth()->check() && auth()->id() == $job_detail->user_id)
                        <div class="card shadow border-0 mt-4">
                            <div class="job_details_header">
                                <div class="single_jobs white-bg d-flex justify-content-between">
                                    <div class="jobs_left d-flex align-items-center">
                                        <div class="jobs_conetent">
                                                <h4>Applicants</h4>
                                        </div>
                                    </div>
                                    <div class="jobs_right"></div>
                                </div>
                            </div>
                            <div class="descript_wrap white-bg">
                            <table class="table table-striped">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Applied Date</th>
                                    </tr>
                                    @if ($applications->isNotEmpty())
                                        @foreach ($applications as $application)
                                            <tr>
                                                <td>{{ $application->user->name }}</td>
                                                <td>{{ $application->user->email }}</td>
                                                <td>{{ $application->user->mobile }}</td>
                                                <td>{{ \Carbon\Carbon::parse($application->applied_date)->format('d M, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                            <tr>
                                                <td colspan="4" class="text-center">Applicants not found</td>
                                            </tr>
                                    @endif
                            </table>
                            </div>
                        </div>
                 @endif
            </div>
            <div class="col-md-4">
                <div class="card shadow border-0">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Job Summery</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Published on: <span> {{ \Carbon\Carbon::parse($job_detail->created_at)->format('d M, Y') }}</span></li>
                                <li>Vacancy: <span> {{ $job_detail->vacancy }}</span></li>
                             @if (!empty($job_detail->salary))
                                <li>Salary: <span> {{ $job_detail->salary }}</span></li>
                             @endif 
                                <li>Location: <span> {{ $job_detail->location }}</span></li>
                                <li>Job Nature: <span> {{ $job_detail->jobType->job_type }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card shadow border-0 my-4">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Company Details</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Name: <span> {{ $job_detail->company_name }}</span></li>

                                 @if (!empty($job_detail->company_location))
                                  <li>Locaion: <span> {{ $job_detail->company_location }}</span></li>
                                 @endif 
                              
                                 @if (!empty($job_detail->company_website))
                                 <li>Webite: <span> <a href="{{ $job_detail->company_website }}">{{ $job_detail->company_website }}</a></span></li>
                                 @endif 
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
@endsection

@section('customjs')
    <script type="text/javascript">
        function applyJob(id){
           if (confirm("Are you sure you want to apply on this job?")){
            $.ajax({
                url : '{{ route("apply.job") }}',
                type : 'post',
                data : {id:id},
                dataType : 'json',
                success : function(response){
                   window.location.href="{{ url()->current() }}";
                }
            });
           }
        }

        function savedJob(id){
            $.ajax({
                url : '{{ route("apply.Savejob") }}',
                type : 'post',
                data : {id:id},
                dataType : 'json',
                success : function(response){
                   window.location.href="{{ url()->current() }}";
                }
            });
        }
    </script>
@endsection
