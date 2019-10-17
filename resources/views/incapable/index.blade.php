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
            <form action="{{ route('incapable.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="">@lang('incapable.name')</label>
                            <div class="col-sm-9">
                                <input id="nama" type="text" class="form-control " name="nama"
                                    value="{{ old('nama') }}">
                                @error('nama')<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="">@lang('incapable.birth_place')</label>
                            <div class="col-sm-9">
                                <input id="tempat_lahir" type="text" class="form-control " name="tempat_lahir"
                                    value="{{ old('tempat_lahir') }}">
                                @error('tempat_lahir')<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="">@lang('incapable.birth_date')</label>
                            <div class="col-sm-9">
                                <input id="tanggal_lahir" type="date" class="form-control " name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir') }}">
                                @error('tanggal_lahir')<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="">@lang('incapable.job')</label>
                            <div class="col-sm-9">
                                <input id="pekerjaan" type="text" class="form-control " name="pekerjaan"
                                    value="{{ old('pekerjaan') }}">
                                @error('pekerjaan')<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="">@lang('incapable.address')</label>
                            <div class="col-sm-9">
                                <textarea name="alamat" id="alamat" class="form-control " cols="30"
                                    rows="2">{{ old('alamat') }}</textarea>
                                @error('alamat')<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="">@lang('incapable.reason')</label>
                            <div class="col-sm-9">
                                <textarea name="alasan_pengajuan" id="alasan_pengujian" class="form-control " cols="30"
                                    rows="2">{{ old('alasan_pengajuan') }}</textarea>
                                @error('alasan_pengajuan')<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
                                
                            </div>
                        </div>
                        <div class="form-group">
                            Adalah benar-benar merupakan
                            <select class="form-control-sm" name="merupakan" id="merupakan">
                                <option value="">{{ __('incapable.choose') }}</option>
                                <option value="1">{{ __('incapable.parents') }}</option>
                                <option value="2">{{ __('incapable.child') }}</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-2">
                            @lang('incapable.add')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow h-100">
        <div class="card-header">
            <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ __('incapable.data') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>{{ __('incapable.reason') }}</th>
                            <th>{{ __('incapable.created') }}</th>
                            <th>{{ __('incapable.updated_at') }}</th>
                            <th>{{ __('incapable.status') }}</th>
                            <th>{{ __('incapable.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach($incapables as $incapable)
                        <tr>
                            <td>{{ $incapable->reason }}</td>
                            <td>{{ $incapable->created_at->format('d M Y - H:i:s') }}</td>
                            @if ($incapable->letter_id == null)
                            <td>{{ __('~') }}</td>
                            <td>{{ __('incapable.status_null') }}</td>
                            @elseif($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == 0)
                            <td>{{ __('~') }}</td>
                            <td>{{ __('incapable.status_1') }}</td>
                            @elseif($incapable->letter->verify1 == -1 && $incapable->letter->verify2 == 0)
                            <td>{{ __('~') }}</td>
                            <td>{{ __('incapable.declined') }}</td>
                            @elseif($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == -1)
                            <td>{{ __('~') }}</td>
                            <td>{{ __('incapable.status_1') }}</td>
                            @elseif($incapable->letter->verify1 == -1 && $incapable->letter->verify2 == -1)
                            <td>{{ __('~') }}</td>
                            <td>{{ __('incapable.declined') }}</td>
                            @elseif($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == 1)
                            <td>{{ $incapable->letter->updated_at->format('d M Y - H:i:s') }}</td>
                            <td>{{ __('incapable.approved') }}</td>
                            @endif
                            <td>
                                @if ($incapable->letter_id == null)
                                <a class="editSubmission" href="" data-toggle="modal"
                                    data-target="{{'#editSubmissionModal'.$i}}" data-id="{{ $incapable->id }}"><span
                                        class="badge badge-warning">{{ __('incapable.edit') }}</span></a>
                                <form class="d-inline-block" action="{{ route('incapable.destroy',$incapable->id) }}"
                                    method="POST">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="badge badge-danger "
                                        onclick="return confirm('{{__('incapable.delete_confirm')}}');">
                                        {{ __('incapable.delete') }}
                                    </button>
                                </form>
                                @elseif($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == 0)
                                ~
                                @elseif($incapable->letter->verify1 == -1 && $incapable->letter->verify2 == 0)
                                ~
                                @elseif($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == -1)
                                ~
                                @elseif($incapable->letter->verify1 == -1 && $incapable->letter->verify2 == -1)
                                ~
                                @elseif($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == 1)
                                <a target="_blank" class="d-inline-block"
                                    href="{{ route('incapable.download',$incapable->id) }}">
                                    <span class="badge badge-success">{{ __('incapable.download') }}</span>
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
                                            {{ __('incapable.edit_salary') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('incapable.update',$incapable->id) }}" method="post">
                                        @csrf
                                        @method('patch')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-form-label" for="">@lang('incapable.name')</label>
                                                <input id="nama" type="text" class="form-control" name="nama"
                                                    value="{{ $incapable->name }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label"
                                                    for="">@lang('incapable.birth_place')</label>
                                                <input id="tempat_lahir" type="text" class="form-control"
                                                    name="tempat_lahir" value="{{ $incapable->birth_place }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label"
                                                    for="">@lang('incapable.birth_date')</label>
                                                <input id="tanggal_lahir" type="date" class="form-control"
                                                    name="tanggal_lahir" value="{{ $incapable->birth_date }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label"
                                                    for="">@lang('incapable.job')</label>
                                                <input id="pekerjaan" type="text" class="form-control"
                                                    name="pekerjaan" value="{{ $incapable->job }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label" for="">@lang('incapable.address')</label>
                                                <textarea name="alamat" id="alamat" class="form-control" cols="30"
                                                    rows="5">{{ $incapable->address }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label" for="">@lang('incapable.reason')</label>
                                                <textarea name="alasan_pengajuan" id="alasan_pengajuan"
                                                    class="form-control" cols="30" rows="5"
                                                >{{ $incapable->reason }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label" for="">@lang('incapable.as')</label>
                                                <select name="merupakan" id="merupakan">
                                                    <option value="">{{ __('incapable.choose') }}</option>
                                                    @if ($incapable->as == 1)
                                                    <option selected="selected" value="1">{{ __('incapable.parents') }}</option>
                                                    <option value="2">{{ __('incapable.child') }}</option>
                                                    @elseif($incapable->as == 2)
                                                    <option value="1">{{ __('incapable.parents') }}</option>
                                                    <option selected="selected" value="2">{{ __('incapable.child') }}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">@lang('incapable.close')</button>
                                            <button type="Submit" class="btn btn-primary"
                                                id="submitMenu">@lang('incapable.edit')</button>
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