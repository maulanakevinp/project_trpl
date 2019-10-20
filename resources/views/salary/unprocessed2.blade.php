@extends('layouts.master')
@section('title')
{{ $subtitle }} - {{ config('app.name') }}
@endsection
@section('container')
<!-- Begin Page Content -->
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('pengajuan-surat') }}">{{ $title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $subtitle }}</li>
        </ol>
    </nav>
    <nav class="nav nav-pills nav-fill mb-3">
        <a class="nav-link active" href="">{{ __('salary.unprocessed') }}</a>
        <a class="nav-link" href="{{ route('salary.verified2') }}">{{ __('salary.verified') }}</a>
        <a class="nav-link" href="{{ route('salary.declined2') }}">{{ __('salary.declined') }}</a>
    </nav>
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if (session('success'))<div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button></div>@endif
    @if (session('failed'))<div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('failed') }}<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button></div>@endif
    <div class="card shadow h-100">
        <div class="card-header">
            <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ __('salary.data') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>{{ __('salary.nik') }}</th>
                            <th>{{ __('salary.salary') }}</th>
                            <th>{{ __('salary.reason') }}</th>
                            <th>{{ __('salary.created') }}</th>
                            <th>{{ __('salary.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach($salaries as $salary)
                        <tr>
                            <td>{{ $salary->user->nik }}</td>
                            <td>{{ 'Rp.'.number_format($salary->salary, 2, ',', '.') }}</td>
                            <td>{{ $salary->reason }}</td>
                            <td>{{ $salary->created_at->format('d M Y - H:i:s') }}</td>
                            <td>
                                <a href="{{ route('salary.edit-unprocessed2',$salary->id) }}" class="badge badge-warning">{{ __('salary.verify') }}</a>
                            </td>
                        </tr>
                        @php
                        $i++;
                        @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

@endsection
@section('orderBy')
"order": [[ 3, "desc" ]]
@endsection