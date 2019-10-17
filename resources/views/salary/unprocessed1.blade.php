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
        <a class="nav-link" href="{{ route('salary.verified1') }}">{{ __('salary.verified') }}</a>
        <a class="nav-link" href="{{ route('salary.declined1') }}">{{ __('salary.declined') }}</a>
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
                            <td>{{ $salary->user->nik }}</a></td>
                            <td>{{ 'Rp.'.number_format($salary->salary, 2, ',', '.') }}</td>
                            <td>{{ $salary->reason }}</td>
                            <td>{{ $salary->created_at->format('d M Y - H:i:s') }}</td>
                            <td>
                                <a href="{{ route('salary.edit-unprocessed1',$salary->id) }}" class="badge badge-warning">
                                    {{ __('salary.verify') }}
                                </a>
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
                                    <form action="{{ route('salary.verify1',$salary->id) }}" method="post">
                                        @csrf
                                        @method('put')
                                        <input type="hidden" name="update" value="0">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-form-label" for="">@lang('salary.salary')</label>
                                                <input id="penghasilan" type="text" class="form-control"
                                                    name="penghasilan" value="{{ $salary->salary }}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label" for="">@lang('salary.reason')</label>
                                                <textarea name="alasan_pengajuan" id="alasan_pengujian"
                                                    class="form-control" cols="30" rows="5"
                                                    disabled>{{ $salary->reason }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label"
                                                    for="verifikasi">@lang('salary.verify')</label><br>
                                                <div class="custom-control custom-radio">
                                                    @if (old('verifikasi') == 1)
                                                    <input checked="checked" type="radio" id="verifikas1"
                                                        name="verifikasi" class="custom-control-input" value="1">
                                                    @else
                                                    <input type="radio" id="verifikas1" name="verifikasi"
                                                        class="custom-control-input" value="1">
                                                    @endif
                                                    <label class="custom-control-label"
                                                        for="verifikas1">{{ __('salary.accept') }}</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    @if (old('verifikasi') == -1)
                                                    <input checked="checked" type="radio" id="verifikasi2"
                                                        name="verifikasi" class="custom-control-input" value="-1">
                                                    @else
                                                    <input type="radio" id="verifikasi2" name="verifikasi"
                                                        class="custom-control-input" value="-1">
                                                    @endif
                                                    <label class="custom-control-label"
                                                        for="verifikasi2">{{__('salary.decline')}}</label>
                                                </div>
                                                @error('verifikasi')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                @lang('salary.close')
                                            </button>
                                            <button type="Submit" class="btn btn-primary" id="submitMenu">
                                                @lang('salary.verify')
                                            </button>
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