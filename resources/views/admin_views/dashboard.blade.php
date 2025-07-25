@extends('front.layout.parent')

@section('main')

<section class="section-5 bg-2 mb-4">
    <div class="container py-4">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
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
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center" style="height: 50vh;">
                            <p class="h1 font-bold text-center">Welcome Admin</p>
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
    
</script>
@endsection