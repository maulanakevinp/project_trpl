@extends('layouts.master')
@section('title')
{{ $subtitle }} - {{ config('app.name') }}
@endsection
@section('container')
<!-- Begin Page Content -->
<div class="container-fluid">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('role.index') }}">{{ $title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $subtitle }}</li>
        </ol>
    </nav>
    @if ($message = Session::get('success'))<div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>@endif
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 id="judul" class="m-0 pt-1 font-weight-bold text-primary">
                        {{ __('role.role')}} {{ $role->role }}
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('#') }}</th>
                                <th scope="col">{{ __('role.menu') }}</th>
                                <th scope="col">{{ __('role.access') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menu as $m)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $m->menu }}</td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input accessMenu" type="checkbox" {{ \App\UserAccessMenu::checkAccess($role->id, $m->id) }} data-role="{{ $role->id }}" data-menu="{{ $m->id }}">
                                        </div>
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

@endsection
