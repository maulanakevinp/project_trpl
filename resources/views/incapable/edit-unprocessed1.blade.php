@extends('layouts.master')
@section('title')
{{ __('incapable.verify') }} - {{ config('app.name') }}
@endsection
@section('container')
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold float-left text-primary">{{ __('incapable.detail_user') }}</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('img/profile/' . $incapable->user->image) }}" class="img-thumbnail mb-3"
                            alt="{{ $incapable->user->image }}">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td>{{ __('user.name') }}</td>
                                    <td>:</td>
                                    <td>{{ $incapable->user->name }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.email') }}</td>
                                    <td>:</td>
                                    <td>{{ $incapable->user->email }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.nik') }}</td>
                                    <td>:</td>
                                    <td>{{ $incapable->user->nik }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.gender') }}</td>
                                    <td>:</td>
                                    <td>{{ $incapable->user->gender->gender }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.religion') }}</td>
                                    <td>:</td>
                                    <td>{{ $incapable->user->religion->religion }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.marital') }}</td>
                                    <td>:</td>
                                    <td>{{ $incapable->user->marital->marital }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.birth') }}</td>
                                    <td>:</td>
                                    <td>{{ $incapable->user->birth_place .__(', ').date('d-m-Y', strtotime($incapable->user->birth_date)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.phone_number') }}</td>
                                    <td>:</td>
                                    <td>{{ $incapable->user->phone_number }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.address') }}</td>
                                    <td>:</td>
                                    <td>{{ $incapable->user->address }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ __('incapable.verify') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('incapable.verify1',$incapable->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label class="col-form-label" for="">@lang('incapable.name')</label>
                            <input id="nama" type="text" class="form-control" name="nama" value="{{ $incapable->name }}" disabled>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="">@lang('incapable.birth_place')</label>
                            <input id="tempat_lahir" type="text" class="form-control" name="tempat_lahir" value="{{ $incapable->birth_place }}"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="">@lang('incapable.birth_date')</label>
                            <input id="tanggal_lahir" type="date" class="form-control" name="tanggal_lahir" value="{{ $incapable->birth_date }}"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="">@lang('incapable.address')</label>
                            <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="5"
                                disabled>{{ $incapable->address }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="">@lang('incapable.reason')</label>
                            <textarea name="alasan_pengajuan" id="alasan_pengajuan" class="form-control" cols="30" rows="5">{{ $incapable->reason }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="">@lang('incapable.as')</label>
                            <select name="merupakan" id="merupakan">
                                @if ($incapable->as == 1)
                                <option selected="selected" value="1">{{ __('incapable.parents') }}</option>
                                @elseif($incapable->as == 2)
                                <option selected="selected" value="2">{{ __('incapable.child') }}</option>
                                @else
                                <option value="">{{ __('incapable.choose') }}</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="verifikasi">@lang('incapable.verify')</label><br>
                            <div class="custom-control custom-radio">
                                @if (old('verifikasi') == 1)
                                <input checked="checked" type="radio" id="verifikas1" name="verifikasi" class="custom-control-input" value="1">
                                @else
                                <input type="radio" id="verifikas1" name="verifikasi" class="custom-control-input" value="1">
                                @endif
                                <label class="custom-control-label" for="verifikas1">{{ __('incapable.accept') }}</label>
                            </div>
                            <div class="custom-control custom-radio">
                                @if (old('verifikasi') == -1)
                                <input checked="checked" type="radio" id="verifikasi2" name="verifikasi" class="custom-control-input"
                                    value="-1">
                                @else
                                <input type="radio" id="verifikasi2" name="verifikasi" class="custom-control-input" value="-1">
                                @endif
                                <label class="custom-control-label" for="verifikasi2">{{__('incapable.decline')}}</label>
                            </div>
                            @error('verifikasi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="float-right">
                            <a href="{{ route('incapable.unprocessed1') }}"
                                class="btn btn-secondary">@lang('incapable.back')</a>
                            <button type="Submit" class="btn btn-primary" id="submitMenu">@lang('incapable.verify')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection