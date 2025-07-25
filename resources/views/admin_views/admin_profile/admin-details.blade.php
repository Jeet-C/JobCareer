@extends('front.layout.parent')

@section('main')

<section class="section-5 bg-2">
    <div class="container py-2">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-2">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Admin Profile</li>
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
                    <form id="adminForm" >
                        <div class="card-body  p-4">
                        <h3 class="fs-4 mb-1">Admin profile</h3>
                        <div class="mb-4">
                            <label for="name" class="mb-2">Name*</label>
                            <input type="text" name="name" id="name"  placeholder="Enter Name" class="form-control" value="{{ $admin_profile->name }}">
                             <p></p>
                        </div>
                       
                        <div class="mb-4">
                            <label for="email" class="mb-2">Email*</label>
                            <input type="text" name="email" id="email" placeholder="Enter Email" class="form-control" value="{{ $admin_profile->email }}" >
                            <p></p>
                        </div>                        
                    </div>
                    <div class="card-footer  p-4">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    </form>
                </div>

                <div class="card border-0 shadow mb-4">
                    <form action="" id="changePasswordFormAdmin" name="changePasswordFormAdmin">
                        <div class="card-body p-4">
                            <h3 class="fs-4 mb-1">Change Password</h3>
                            <div class="mb-4">
                                <label for="" class="mb-2">Old Password*</label>
                                <input type="password" name="old_password" id="old_password" placeholder="Old Password" class="form-control">
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">New Password*</label>
                                <input type="password" name="new_password" id="new_password"  placeholder="New Password" class="form-control">
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Confirm Password*</label>
                                <input type="password" name="confirm_password" id="confirm_password"  placeholder="Confirm Password" class="form-control">
                               <p></p>
                            </div>                        
                        </div>
                        <div class="card-footer  p-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>  

            </div>
        </div>
    </div>
</section>

@endsection

@section('customjs')
<script type="text/javascript">
$(document).ready(function(){
    $('#adminForm').submit(function(e){
        e.preventDefault();
        $.ajax({
            url : '{{ route("admin.updateAdminProfile") }}',
            type : 'post',
            dataType : 'json',
            data :   $('#adminForm').serializeArray(),
            success : function(response){
                if(response.status == true){
                       $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                       $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    //    $('#message').fadeIn().delay(2500).fadeOut();
                    //     $('#message').addClass('alert alert-success text-center').text('Profile Upated successfull');
                        window.location.href="{{ route('admin.adminProfile') }}";
                }else{
                    var errors = response.errors;
                    if(errors.name){
                        $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.name);
                    }else{
                        $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if(errors.email){
                        $("#email").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.email);
                    }else{
                        $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                }
            }
        });
    });

    // update old password
      $('#changePasswordFormAdmin').submit(function(e){
        e.preventDefault();
        $.ajax({
            url : '{{ route("admin.updateAdminPassword") }}',
            type : 'post',
            dataType : 'json',
            data :   $('#changePasswordFormAdmin').serializeArray(),
            success : function(response){
                if(response.status == true){
                        $("#old_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $("#new_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $("#confirm_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                        window.location.href="{{ route('admin.adminProfile') }}";
                }else{
                    var errors = response.errors;
                    if(errors.old_password){
                        $("#old_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.old_password);
                    }else{
                        $("#old_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if(errors.new_password){
                        $("#new_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.new_password);
                    }else{
                        $("#new_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if(errors.confirm_password){
                        $("#confirm_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.confirm_password);
                    }else{
                        $("#confirm_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                }
            }
        });
    });
});
</script>
@endsection