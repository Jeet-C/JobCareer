@extends('front.layout.parent')

@section('main')

<section class="section-5 bg-2 mb-4">
    <div class="container py-4">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
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
                                <h3 class="fs-4 mb-1">Users</h3>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if ($users->isNotEmpty())
                                    @foreach ($users as $user)
                                    <tr class="active">
                                        <td>
                                            <div class="job-name fw-500">{{ $user->name }}</div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td> {{ $user->mobile }}</td>
                                        <td>
                                            <div class="action-dots">
                                                <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @if ($user->role != 'admin')
                                                        <li><a class="dropdown-item" href="{{ route('admin.users.edit',$user->id) }}"><i class="fa fa-edit"
                                                                aria-hidden="true"></i> Edit</a></li>
                                                    @endif
                                                    <li><button class="dropdown-item" onclick="deleteAccount({{ $user->id }})"><i class="fa fa-trash"
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
                            {{ $users->links() }}
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
    function deleteAccount(id){
        if(confirm("Are you sure you want to delete account?")){
            $.ajax({
                url : '{{ route("admin.users.delete") }}',
                type : 'post',
                data : {id:id},
                dataType : 'json',
                success : function(response){
                    window.location.href = "{{ route('admin.users') }}";
                }
        });
        }
    }
</script>
@endsection