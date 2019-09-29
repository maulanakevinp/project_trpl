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
            <a href="{{route('users.create')}}" class="btn btn-sm btn-primary addRole float-right">{{ __('Add New User') }}</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>{{__('NIK')}}</th>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Gender')}}</th>
                            <th>{{__('Religion')}}</th>
                            <th>{{__('Marital')}}</th>
                            <th>{{__('Address')}}</th>
                            <th>{{__('Age')}}</th>
                            <th>{{__('Job')}}</th>
                            <th>{{__('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->nik }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->gender->gender }}</td>
                            <td>{{ $user->religion->religion }}</td>
                            <td>{{ $user->marital->marital }}</td>
                            <td>{{ $user->address }}</td>
                            <td>{{ \Carbon\Carbon::parse($user->birth_date)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days') }}</td>
                            <td>{{ $user->job }}</td>
                            <td>
                                <a href="{{route('users.edit',$user->id)}}" class="badge badge-warning">{{__('edit')}}</a>
                                @if($user->id != Auth::user()->id)
                                <form class="d-inline-block" action="{{ route('users.destroy',$user->id) }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="badge badge-danger " onclick="return confirm('Are you sure want to DELETE this user ?');">
                                        {{ __('delete') }}
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
<!-- /.container-fluid -->
@endsection