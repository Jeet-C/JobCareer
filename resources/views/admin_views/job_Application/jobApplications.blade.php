@extends('front.layout.parent')

@section('main')

<section class="section-5 bg-2 mb-4">
    <div class="container py-4">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Job Applications</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('admin_views.common.admin_sidebar')
            </div>
            <div class="col-lg-9">
                {{-- <div id="message"></div> --}}
                @include('front.layout.alert')
                <div class="card border-0 shadow mb-4">
                      <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">Job Applications</h3>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Job Title</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Job creator</th>
                                        <th scope="col">Applied Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if ($applications->isNotEmpty())
                                    @foreach ($applications as $application)
                                    <tr class="active">
                                        <td>
                                            <div class="job-name fw-500">{{ $application->job->title }}</div>
                                        </td>
                                        <td>{{ $application->user->name }}</td>
                                       <td>{{ $application->job_owner->name }}</td>
                                        <td> {{ \Carbon\Carbon::parse($application->applied_date)->format('d M, Y') }}</td>
                                        <td>
                                            <div class="action-dots">
                                                <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><button class="dropdown-item" onclick="deleteJobApplication({{ $application->id }})"><i class="fa fa-trash"
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
                            {{ $applications->links() }}
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
    function deleteJobApplication(id){
        if(confirm("Are you sure you want to delete job application?")){
            $.ajax({
                url : '{{ route("admin.job-application.delete") }}',
                type : 'post',
                data : {id:id},
                dataType : 'json',
                success : function(response){
                    window.location.href = "{{ route('admin.jobapplication') }}";
                }
        });
        }
    }
</script>
@endsection