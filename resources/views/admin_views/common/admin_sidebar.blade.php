<div class="card border-0 shadow mb-4 p-3">
    <div class="s-body text-center mt-3">
        {{-- @if (auth()->user()->image != '')
        <img src="{{ asset('storage/'.auth()->user()->image) }}" alt="user-image" class="rounded-circle img-fluid"
            style="width: 150px; height:150px;">
        @else --}}
        <img src="{{ asset('assets/images/avatar7.avif') }}" alt="avatar" class="rounded-circle img-fluid"
            style="width: 150px;">
        {{-- @endif --}}
        <h5 class="mt-3 pb-0">{{ auth()->user()->name }}</h5>
        {{-- <p class="text-muted mb-1 fs-6">{{ auth()->user()->designation }}</p> --}}
        {{-- <div class="d-flex justify-content-center mb-2">
            <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn btn-primary">Change
                Profile Picture</button>
        </div> --}}
    </div>
</div>
<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush ">
            <li class="list-group-item d-flex justify-content-between p-3">
                <a href="{{ route('admin.adminProfile') }}">Admin Profile</a>
            </li>
            <li class="list-group-item d-flex justify-content-between p-3">
                <a href="{{ route('admin.users') }}">Users</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('admin.jobs') }}">Jobs</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('admin.jobapplication') }}">Job Applications</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('admin.logoutAdmin') }}">Logout</a>
            </li>
        </ul>
    </div>
</div>