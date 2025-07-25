@extends('front.layout.parent')

@section('main')

<section class="section-5 bg-2">
    <div class="container py-2">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-2">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">My Jobs</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                {{-- <div id="message"></div> --}}
                @include('front.layout.alert')
                <div class="card border-0 shadow mb-4">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">My Jobs</h3>
                            </div>
                            <div style="margin-top: -10px;">
                                <a href="{{ route('account.createjob') }}" class="btn btn-primary">Post a Job</a>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Job Created</th>
                                        <th scope="col">Applicants</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if ($jobs->isNotEmpty())
                                    @foreach ($jobs as $job)
                                    <tr class="active">
                                        <td>
                                            <div class="job-name fw-500">{{ $job->title }}</div>
                                            <div class="info1">{{ $job->jobType->job_type  }}. {{ $job->location }}</div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}</td>
                                        <td> {{ $job->applications->count() }} Applications</td>
                                        <td>
                                            @if ($job->status == 1)
                                                <div class="job-status text-capitalize btn btn-success">Active</div>
                                            @else
                                                <div class="job-status text-capitalize btn btn-danger">Block</div>
                                            @endif
                                            
                                        </td>
                                        <td>
                                            <div class="action-dots">
                                                <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="{{ route('job.details',$job->id) }}"> <i
                                                                class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                    <li><a class="dropdown-item" href="{{ route('account.editMyjobs', $job->id) }}"><i class="fa fa-edit"
                                                                aria-hidden="true"></i> Edit</a></li>
                                                    <li><button class="dropdown-item" onclick="deleteJob({{ $job->id }})"><i class="fa fa-trash"
                                                                aria-hidden="true"></i> Delete</button></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif

                                </tbody>

                            </table>
                        </div>
                        <div class="">
                            {{ $jobs->links() }}
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
    function deleteJob(jobId){
        if(confirm("Are you sure you want to delete?")){
            $.ajax({
                url : '{{ route("account.deleteMyjobs") }}',
                type : 'post',
                data : {jobId:jobId},
                dataType : 'json',
                success : function(response){
                        window.location.href="{{ route('account.showMyjobs') }}";
                }
            });
        }
    }
</script>
@endsection