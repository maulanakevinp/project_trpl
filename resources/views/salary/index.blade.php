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
    <div class="card shadow h-100 mb-3">
        <div class="card-header">
            <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ $subtitle }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('salary.store') }}" method="post">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="">@lang('salary.salary')</label>
                    <div class="col-sm-4">
                        <input id="penghasilan" type="text" class="form-control " name="penghasilan"
                            value="{{ old('penghasilan') }}">
                        @error('penghasilan')<span class="invalid-feedback"
                            role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="">@lang('salary.reason')</label>
                    <div class="col-sm-10">
                        <textarea name="alasan_pengajuan" id="alasan_pengujian" class="form-control " cols="30"
                            rows="5">{{ old('alasan_pengajuan') }}</textarea>
                        @error('alasan_pengajuan')<span class="invalid-feedback"
                            role="alert"><strong>{{ $message }}</strong></span>@enderror
                        <button type="submit" class="btn btn-primary btn-block mt-2">
                            @lang('salary.add')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow h-100">
        <div class="card-header">
            <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ __('salary.data') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>{{ __('salary.salary') }}</th>
                            <th>{{ __('salary.reason') }}</th>
                            <th>{{ __('salary.created') }}</th>
                            <th>{{ __('salary.updated_at') }}</th>
                            <th>{{ __('salary.status') }}</th>
                            <th>{{ __('salary.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach($salaries as $salary)
                        <tr>
                            <td>{{ 'Rp.'.number_format($salary->salary, 2, ',', '.') }}</td>
                            <td>{{ $salary->reason }}</td>
                            <td>{{ $salary->created_at->format('d M Y - H:i:s') }}</td>
                            @if ($salary->letter_id == null)
                            <td>{{ __('~') }}</td>
                            <td>{{ __('salary.status_null') }}</td>
                            @elseif($salary->letter->verify1 == 1 && $salary->letter->verify2 == 0)
                            <td>{{ __('~') }}</td>
                            <td>{{ __('salary.status_1') }}</td>
                            @elseif($salary->letter->verify1 == -1 && $salary->letter->verify2 == 0)
                            <td>{{ __('~') }}</td>
                            <td>{{ __('salary.declined') }}</td>
                            @elseif($salary->letter->verify1 == 1 && $salary->letter->verify2 == -1)
                            <td>{{ __('~') }}</td>
                            <td>{{ __('salary.status_1') }}</td>
                            @elseif($salary->letter->verify1 == -1 && $salary->letter->verify2 == -1)
                            <td>{{ __('~') }}</td>
                            <td>{{ __('salary.declined') }}</td>
                            @elseif($salary->letter->verify1 == 1 && $salary->letter->verify2 == 1)
                            <td>{{ $salary->letter->updated_at->format('d M Y - H:i:s') }}</td>
                            <td>{{ __('salary.approved') }}</td>
                            @endif
                            <td>
                                @if ($salary->letter_id == null)
                                <a class="editSubmission" href="" data-toggle="modal"
                                    data-target="{{'#editSubmissionModal'.$i}}" data-id="{{ $salary->id }}"><span
                                        class="badge badge-warning">{{ __('salary.edit') }}</span></a>
                                <form class="d-inline-block" action="{{ route('salary.destroy',$salary->id) }}"
                                    method="POST">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="badge badge-danger "
                                        onclick="return confirm('{{__('salary.delete_confirm')}}');">
                                        {{ __('salary.delete') }}
                                    </button>
                                </form>
                                @elseif($salary->letter->verify1 == 1 && $salary->letter->verify2 == 0)
                                ~
                                @elseif($salary->letter->verify1 == -1 && $salary->letter->verify2 == 0)
                                ~
                                @elseif($salary->letter->verify1 == 1 && $salary->letter->verify2 == -1)
                                ~
                                @elseif($salary->letter->verify1 == -1 && $salary->letter->verify2 == -1)
                                ~
                                @elseif($salary->letter->verify1 == 1 && $salary->letter->verify2 == 1)
                                <a target="_blank" class="d-inline-block" href="{{ route('salary.download',$salary->id) }}">
                                    <span class="badge badge-success">{{ __('salary.download') }}</span>
                                </a>
                                @endif
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="{{'editSubmissionModal'.$i}}" tabindex="-1" role="dialog"
                            aria-labelledby="{{'editMenuModalLabel'.$i}}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="{{'editMenuModalLabel'.$i}}">
                                            {{ __('salary.edit_salary') }}</h5>
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
                                                <input id="penghasilan" type="text" class="form-control"
                                                    name="penghasilan" value="{{ $salary->salary }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label" for="">@lang('salary.reason')</label>
                                                <textarea name="alasan_pengajuan" id="alasan_pengujian"
                                                    class="form-control" cols="30"
                                                    rows="5">{{ $salary->reason }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">@lang('salary.close')</button>
                                            <button type="Submit" class="btn btn-primary"
                                                id="submitMenu">@lang('salary.edit')</button>
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
<!-- /.container-fluid -->

@endsection