@extends('layouts.master')
@section('title')
{{ $title }} - {{ config('app.name') }}
@endsection
@section('container')
<!-- Begin Page Content -->
<div class="container-fluid">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('failed'))
    <div class="alert alert-danger">
        {{ session('failed') }}
    </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 ">
            <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ $title }}</h5>
            <div class="btn-group float-right">
                <a href="{{route('users.trash')}}" class="btn btn-sm btn-warning">{{ __('user.trash') }}</a>
                <a href="{{route('users.create')}}" class="btn btn-sm btn-primary">{{ __('user.add') }}</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>{{__('user.nik')}}</th>
                            <th>{{__('user.name')}}</th>
                            <th>{{__('user.role')}}</th>
                            <th>{{__('user.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->nik }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->role->role }}</td>
                            <td>
                                <a href="{{route('users.edit',$user->id)}}" class="badge badge-warning">{{__('user.edit')}}</a>
                                @if($user->id != Auth::user()->id)
                                <a href="{{ route('softdelete',$user->id) }}" class="badge badge-danger d-inline-block" onclick="return confirm('{{__('user.delete_confirm')}}');">
                                    {{ __('user.delete') }}
                                </a>
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
<!-- /.container-fluid -->
@endsection