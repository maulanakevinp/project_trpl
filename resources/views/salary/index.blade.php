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
    @if ($errors->any())<div class="alert alert-danger"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if (session('failed'))<div class="alert alert-danger">{{ session('failed') }}</div>@endif
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-unprocessed-tab" data-toggle="pill" href="#pills-unprocessed" role="tab" aria-controls="pills-unprocessed" aria-selected="true">{{ __('salary.unprocessed') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-processed-tab" data-toggle="pill" href="#pills-processed" role="tab" aria-controls="pills-processed" aria-selected="false">{{ __('salary.verified') }}</a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-unprocessed" role="tabpanel" aria-labelledby="pills-unprocessed-tab">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ __('salary.data') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('user.nik') }}</th>
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
                                        @if ($salary->verify1 == 0)
                                            <td>{{ __('~') }}</td>
                                            <td>{{ __('salary.status_null') }}</td>
                                        @elseif($salary->verify1 == 1 && $salary->verify2 == 0)
                                            <td>{{ __('~') }}</td>
                                            <td>{{ __('salary.status_1') }}</td>
                                        @elseif($salary->verify1 == -1 && $salary->verify2 == 0)
                                            <td>{{ __('~') }}</td>
                                            <td>{{ __('Ditolak') }}</td>
                                        @elseif($salary->verify1 == 1 && $salary->verify2 == -1)
                                            <td>{{ __('~') }}</td>
                                            <td>{{ __('salary.status_1') }}</td>
                                        @elseif($salary->verify1 == -1 && $salary->verify2 == -1)
                                            <td>{{ __('~') }}</td>
                                            <td>{{ __('Ditolak') }}</td>
                                        @elseif($salary->verify1 == 1 && $salary->verify2 == 1)
                                            <td>{{ $salary->created_at->format('d M Y - H:i:s') }}</td>
                                            <td>{{ __('Terverifikasi') }}</td>
                                        @endif
                                        <td>
                                            @if ($salary->verify1 == 0)
                                                <a class="editSubmission" href="" data-toggle="modal" data-target="{{'#editSubmissionModal'.$i}}" data-id="{{ $salary->id }}"><span class="badge badge-warning">{{ __('salary.edit') }}</span></a>
                                                <form class="d-inline-block" action="{{ route('salary.destroy',$salary->id) }}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="badge badge-danger " onclick="return confirm('{{__('salary.delete_confirm')}}');">
                                                        {{ __('salary.delete') }}
                                                    </button>
                                                </form>
                                            @elseif($salary->verify1 == 1 && $salary->verify2 == 0)
                                                ~
                                            @elseif($salary->verify1 == -1 && $salary->verify2 == 0)
                                                <a class="editSubmission" href="" data-toggle="modal" data-target="{{'#editSubmissionModal'.$i}}" data-id="{{ $salary->id }}"><span class="badge badge-warning">{{ __('salary.edit') }}</span></a>
                                                <form class="d-inline-block" action="{{ route('salary.destroy',$salary->id) }}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="badge badge-danger " onclick="return confirm('{{__('salary.delete_confirm')}}');">
                                                        {{ __('salary.delete') }}
                                                    </button>
                                                </form>
                                            @elseif($salary->verify1 == 1 && $salary->verify2 == -1)
                                                ~
                                            @elseif($salary->verify1 == -1 && $salary->verify2 == -1)
                                                <a class="editSubmission" href="" data-toggle="modal" data-target="{{'#editSubmissionModal'.$i}}" data-id="{{ $salary->id }}"><span class="badge badge-warning">{{ __('salary.edit') }}</span></a>
                                                <form class="d-inline-block" action="{{ route('salary.destroy',$salary->id) }}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="badge badge-danger " onclick="return confirm('{{__('salary.delete_confirm')}}');">
                                                        {{ __('salary.delete') }}
                                                    </button>
                                                </form>
                                            @elseif($salary->verify1 == 1 && $salary->verify2 == 1)
                                                <a class="d-inline-block" href=""><span class="badge badge-success">{{ __('salary.download') }}</span></a>
                                            @endif
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="{{'editSubmissionModal'.$i}}" tabindex="-1" role="dialog" aria-labelledby="{{'editMenuModalLabel'.$i}}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="{{'editMenuModalLabel'.$i}}">{{ __('salary.edit_salary') }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('salary.update',$salary->id) }}" method="post">
                                                    @csrf
                                                    @method('patch')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="">@lang('salary.salary')</label>
                                                            <input id="penghasilan" type="text" class="form-control" name="penghasilan" value="{{ $salary->salary }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="">@lang('salary.reason')</label>
                                                            <textarea name="alasan_pengajuan" id="alasan_pengujian" class="form-control" cols="30" rows="5">{{ $salary->reason }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('salary.close')</button>
                                                        <button type="Submit" class="btn btn-primary" id="submitMenu">@lang('salary.edit')</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
        <div class="tab-pane fade" id="pills-processed" role="tabpanel" aria-labelledby="pills-processed-tab">
            
        </div>
    </div>
    
</div>
<!-- /.container-fluid -->

@endsection
