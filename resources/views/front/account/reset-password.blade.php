@extends('front.layout.parent')

@section('main')

<section class="section-5">
    @if(session('error'))
<div class="alert alert-danger">
    <span>{{ session('error') }}</span>  
    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Reset Password</h1>
                    <form action="{{ route('account.processresetpassword') }}" method="post">
                        @csrf
                        <input type="hidden" name="token" value="{{ $tokenstring }}">
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        <div class="mb-3">
                            <label for="new_password" class="mb-2">New Password*</label>
                            <input type="password" name="new_password" id="new_password" value="{{ old('new_password') }}" class="form-control @error('new_password') is-invalid @enderror" required placeholder="New Password..">
                        </div>
                        @error('new_password')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                        
                         <div class="mb-3">
                            <label for="confirm_password" class="mb-2">Confirm Password*</label>
                            <input type="password" name="confirm_password" id="confirm_password"  class="form-control @error('confirm_password') is-invalid @enderror" required placeholder="Confirm Password..">
                        </div>
                        @error('confirm_password')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror

                        <div class="justify-content-between d-flex">
                            <button class="btn btn-primary mt-2">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="mt-4 text-center">
                    <p>Do not have an account? <a href="{{ route('account.login') }}">Back to login</a></p>
                </div>
            </div>
        </div>
        <div class="py-lg-5">&nbsp;</div>
    </div>
</section>

@endsection