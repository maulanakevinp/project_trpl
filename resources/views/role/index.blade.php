@extends('layouts.master')
@section('title')
{{ $title }} - {{ config('app.name') }}
@endsection
@section('container')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row">
        <div class="col-lg-6">
            @if ($errors->any())<div class="alert alert-danger"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if (session('failed'))<div class="alert alert-danger">{{ session('failed') }}</div>@endif

            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ $title }}</h5>
                    <a href="" class="btn btn-sm btn-primary addRole float-right" data-toggle="modal" data-target="#newRoleModal">{{ __('role.add') }}</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('#') }}</th>
                                <th scope="col">{{ __('role.role') }}</th>
                                <th scope="col">{{ __('role.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user_role as $role)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $role->role }}</td>
                                    <td>
                                        <a href="{{ route('role.edit', $role->id)  }}"><span class="badge badge-warning">{{ __('role.access') }}</span></a>
                                        <a class="editRole" href="" data-toggle="modal" data-target="#newRoleModal" data-id="{{ $role->id }}"><span class="badge badge-success">{{ __('role.edit') }}</span></a>
                                        @if($role->id != 1)
                                            <form class="d-inline-block" action="{{ route('role.destroy',$role->id) }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="badge badge-danger " onclick="return confirm('{{__('role.delete_confirm')}}');">
                                                    {{ __('role.delete') }}
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal -->
<div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">{{ __('role.add') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="postRole" action="{{ route('role.store') }}" method="post">
                @csrf
                <input id="method-role" type="hidden" name="_method" value="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="role" name="peran" placeholder="Role Name" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('role.close') }}</button>
                    <button type="Submit" class="btn btn-primary" id="submitRole">{{ __('role.add') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}" />

@endsection
