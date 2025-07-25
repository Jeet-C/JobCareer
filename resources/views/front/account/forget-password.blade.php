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
                    <h1 class="h3">Forgot Password</h1>
                    <form action="{{ route('account.processforgotpassword') }}" method="post">
                        @csrf
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        <div class="mb-3">
                            <label for="email" class="mb-2">Email*</label>
                            <input type="text" name="email" id="email" value="{{ old('email') }}"  class="form-control @error('email') is-invalid @enderror" required placeholder="example@example.com">
                        </div>
                        @error('email')
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