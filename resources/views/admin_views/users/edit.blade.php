@extends('front.layout.parent')

@section('main')

<section class="section-5 bg-2 mb-4">
    <div class="container py-4">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users</a></li>
                        <li class="breadcrumb-item active">Edit Users</li>
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
                         <form id="userForm">
                        <div class="card-body  p-4">
                        <h3 class="fs-4 mb-1">User / Edit</h3>
                        <div class="mb-4">
                            <label for="name" class="mb-2">Name*</label>
                            <input type="text" name="name" id="name"  placeholder="Enter Name" class="form-control" value="{{ $user->name }}">
                             <p></p>
                        </div>
                       
                        <div class="mb-4">
                            <label for="email" class="mb-2">Email*</label>
                            <input type="text" name="email" id="email" placeholder="Enter Email" class="form-control" value="{{ $user->email }}" readonly>
                        </div>
                        <div class="mb-4">
                            <label for="Designation" class="mb-2">Designation*</label>
                            <input type="text" name="Designation" id="Designation" placeholder="Designation" class="form-control" value="{{ $user->designation }}">
                          <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="mobile" class="mb-2">Mobile</label>
                            <input type="text" name="mobile" id="mobile" placeholder="Mobile" class="form-control" value="{{ $user->mobile }}">
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
    </div>
</section>


@endsection

@section('customjs')
<script type="text/javascript">
    $(document).ready(function(){
                $('#userForm').submit(function(e){
                e.preventDefault();
                $.ajax({
                    url : '{{ route("admin.users.update",$user->id) }}',
                    type : 'post',
                    dataType : 'json',
                    data :   $('#userForm').serializeArray(),
                    success : function(response){
                        if(response.status == true){
                            $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                            $("#Designation").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                                window.location.href="{{ route('admin.users') }}";
                        }else{
                            var errors = response.errors;
                            if(errors.name){
                                $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.name);
                            }else{
                                $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                            }
                            if(errors.Designation){
                                $("#Designation").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.Designation);
                            }else{
                                $("#Designation").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                            }
                        }
                    }
                });
            });
    });
</script>
@endsection