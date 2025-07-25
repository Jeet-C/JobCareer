@extends('front.layout.parent')

@section('main')
    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3">Register</h1>
                        <form action="{{ route('account.newUser') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="mb-2">Name*</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required placeholder="Enter Name">
                            </div> 
                             @error('name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                            <div class="mb-3">
                                <label for="email" class="mb-2">Email*</label>
                                <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required  placeholder="Enter Email">
                            </div> 
                            @error('email')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                            <div class="mb-3">
                                <label for="password" class="mb-2">Password*</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Enter Password">
                            </div> 
                             @error('password')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                            <div class="mb-3">
                                <label for="password_confirmation" class="mb-2">Confirm Password*</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password') is-invalid @enderror" required placeholder="Confirm Password">
                            </div> 
                            <button class="btn btn-primary mt-2">Register</button>
                        </form>             
                    </div>
                    <div class="mt-4 text-center">
                        <p>Have an account? <a  href="{{ route('account.login') }}">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection