@extends('front.layout.parent')

@section('main')

<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Job Details</li>
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
               {{-- @include('front.layout.alert') --}}
                    <form action="" method="post" id="editJobeForm" name="editJobeForm">
                        <div class="card border-0 shadow mb-4">
                            <div class="card-body card-form p-4">
                                <h3 class="fs-4 mb-1">Edit Job Details</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Title<span class="req">*</span></label>
                                        <input type="text" value="{{ $job->title }}" placeholder="Job Title" id="title" name="title" class="form-control">
                                        <p></p>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Category<span class="req">*</span></label>
                                        <select name="category" id="category" class="form-control">
                                            <option value="">Select a Category</option>
                                            @if ($category->isNotEmpty())
                                                @foreach ($category as $jobtype )
                                                    <option {{ ($job->category_id == $jobtype->id) ? 'selected' : '' }} value="{{ $jobtype->id }}">{{ $jobtype->category_name }}</option> 
                                                @endforeach     
                                            @endif
                                           
                                        </select>
                                         <p></p>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Job Nature<span class="req">*</span></label>
                                        <select class="form-select" name="jobtype" id="jobtype">
                                             <option value="">Select a Job Nature</option>
                                             @if ($jobType->isNotEmpty())
                                                @foreach ($jobType as $job_type )
                                                    <option {{ ($job->job_type_id == $job_type->id) ? 'selected' : '' }} value="{{ $job_type->id }}">{{ $job_type->job_type }}</option> 
                                                @endforeach     
                                            @endif
                                        </select>
                                         <p></p>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                        <input type="number" value="{{ $job->vacancy }}" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control">
                                         <p></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Salary</label>
                                        <input type="text" value="{{ $job->salary }}" placeholder="Salary" id="salary" name="salary" class="form-control">
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Location<span class="req">*</span></label>
                                        <input type="text" value="{{ $job->location }}" placeholder="location" id="location" name="location" class="form-control">
                                         <p></p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Description<span class="req">*</span></label>
                                    <textarea class="textarea" name="description" id="description" cols="5" rows="5" placeholder="Description">{{ $job->description  }}</textarea>
                                     <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Benefits</label>
                                    <textarea class="textarea" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits">{{ $job->benefits  }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Responsibility</label>
                                    <textarea class="textarea" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility">{{ $job->responsibility  }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Qualifications</label>
                                    <textarea class="textarea" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications">{{ $job->qualifications  }}</textarea>
                                </div>
                                 <div class="mb-4">
                                    <label for="" class="mb-2">Experience<span class="req">*</span></label>
                                    <select name="experience" id="experience" class="form-control">
                                        <option value="">Select Experience</option>
                                        <option {{ ($job->experience == 0) ? 'selected' : '' }} value="0">Fresher</option>
                                        <option {{ ($job->experience == 1) ? 'selected' : '' }} value="1">1 Year</option>
                                        <option {{ ($job->experience == 2) ? 'selected' : '' }} value="2">2 Years</option>
                                        <option {{ ($job->experience == 3) ? 'selected' : '' }} value="3">3 Years</option>
                                        <option {{ ($job->experience == 4) ? 'selected' : '' }} value="4">4 Years</option>
                                        <option {{ ($job->experience == 5) ? 'selected' : '' }} value="5">5 Years</option>
                                        <option {{ ($job->experience == 6) ? 'selected' : '' }} value="6">6 Years</option>
                                        <option {{ ($job->experience == 7) ? 'selected' : '' }} value="7">7 Years</option>
                                        <option {{ ($job->experience == 8) ? 'selected' : '' }} value="8">8 Years</option>
                                        <option {{ ($job->experience == 9) ? 'selected' : '' }} value="9">9 Years</option>
                                        <option {{ ($job->experience == 10) ? 'selected' : '' }} value="10">10 Years</option>
                                        <option {{ ($job->experience == '10_plus') ? 'selected' : '' }} value="10_plus">10+ Years</option>
                                    </select>
                                    <p></p>
                                 </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Keywords</label>
                                    <input type="text" value="{{ $job->keywords }}" placeholder="keywords" id="keywords" name="keywords" class="form-control">
                                </div>
                                <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>
                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Name<span class="req">*</span></label>
                                        <input type="text" value="{{ $job->company_name }}" placeholder="Company Name" id="company_name" name="company_name" class="form-control">
                                         <p></p>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Location</label>
                                        <input type="text" value="{{ $job->company_location }}" placeholder="Location" id="company_location" name="company_location" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="" class="mb-2">Website</label>
                                    <input type="text" value="{{ $job->company_website }}" placeholder="Website" id="website" name="website" class="form-control">
                                </div>
                            </div> 
                            <div class="card-footer  p-4">
                                <button type="sub" class="btn btn-primary">Update Job</button>
                            </div>  
                        </div>        
                    </form>          
            </div>
        </div>
    </div>
</section>

@endsection

@section('customjs')
<script type="text/javascript">
$(document).ready(function(){
    $('#editJobeForm').submit(function(e){
        e.preventDefault();
        $("button[type='submit']").prop('disabled',true);
        $.ajax({
            url : '{{ route("account.updateMyjobs", $job->id) }}',
            type : 'post',
            dataType : 'json',
            data :   $('#editJobeForm').serializeArray(),
            success : function(response){
                   $("button[type='submit']").prop('disabled',false);
                if(response.status == true){
                       $("#title").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                       $("#category").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                       $("#jobtype").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                       $("#vacancy").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                       $("#location").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                       $("#description").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');   
                       $("#experience").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                       $("#company_name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                      
                        window.location.href="{{ route('account.showMyjobs') }}";
                }else{
                    var errors = response.errors;
                    if(errors.title){
                        $("#title").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.title);
                    }else{
                        $("#title").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if(errors.category){
                        $("#category").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.category);
                    }else{
                        $("#category").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                     if(errors.jobtype){
                        $("#jobtype").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.jobtype);
                    }else{
                        $("#jobtype").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                      if(errors.vacancy){
                        $("#vacancy").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.vacancy);
                    }else{
                        $("#vacancy").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                        if(errors.location){
                        $("#location").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.location);
                    }else{
                        $("#location").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                         if(errors.description){
                        $("#description").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.description);
                    }else{
                        $("#description").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                      if(errors.experience){
                        $("#experience").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.experience);
                    }else{
                        $("#experience").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                        if(errors.company_name){
                        $("#company_name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.company_name);
                    }else{
                        $("#company_name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                }
            }
        });
    });
});
</script>
@endsection
