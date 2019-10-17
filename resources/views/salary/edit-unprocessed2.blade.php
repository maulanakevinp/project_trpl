@extends('layouts.master')
@section('title')
{{ __('salary.verify') }} - {{ config('app.name') }}
@endsection
@section('container')
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold float-left text-primary">{{ __('salary.detail_user') }}</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('img/profile/' . $salary->user->image) }}" class="img-thumbnail mb-3"
                            alt="{{ $salary->user->image }}">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td>{{ __('user.name') }}</td>
                                    <td>:</td>
                                    <td>{{ $salary->user->name }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.email') }}</td>
                                    <td>:</td>
                                    <td>{{ $salary->user->email }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.nik') }}</td>
                                    <td>:</td>
                                    <td>{{ $salary->user->nik }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.gender') }}</td>
                                    <td>:</td>
                                    <td>{{ $salary->user->gender->gender }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.religion') }}</td>
                                    <td>:</td>
                                    <td>{{ $salary->user->religion->religion }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.marital') }}</td>
                                    <td>:</td>
                                    <td>{{ $salary->user->marital->marital }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.birth') }}</td>
                                    <td>:</td>
                                    <td>{{ $salary->user->birth_place .__(', ').date('d-m-Y', strtotime($salary->user->birth_date)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.phone_number') }}</td>
                                    <td>:</td>
                                    <td>{{ $salary->user->phone_number }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.address') }}</td>
                                    <td>:</td>
                                    <td>{{ $salary->user->address }}</td>
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
                    <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ __('salary.verify') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('salary.verify2',$salary->id) }}" method="post">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label class="col-form-label" for="">@lang('salary.salary')</label>
                            <input id="penghasilan" type="text" class="form-control" name="penghasilan"
                                value="{{ $salary->salary }}" disabled>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="">@lang('salary.reason')</label>
                            <textarea name="alasan_pengajuan" id="alasan_pengujian" class="form-control" cols="30"
                                rows="5" disabled>{{ $salary->reason }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="verifikasi">@lang('salary.verify')</label><br>
                            <div class="custom-control custom-radio">
                                @if (old('verifikasi') == 1)
                                <input checked="checked" type="radio" id="verifikas1" name="verifikasi"
                                    class="custom-control-input" value="1">
                                @else
                                <input type="radio" id="verifikas1" name="verifikasi" class="custom-control-input"
                                    value="1">
                                @endif
                                <label class="custom-control-label" for="verifikas1">{{ __('salary.accept') }}</label>
                            </div>
                            <div class="custom-control custom-radio">
                                @if (old('verifikasi') == -1)
                                <input checked="checked" type="radio" id="verifikasi2" name="verifikasi"
                                    class="custom-control-input" value="-1">
                                @else
                                <input type="radio" id="verifikasi2" name="verifikasi" class="custom-control-input"
                                    value="-1">
                                @endif
                                <label class="custom-control-label" for="verifikasi2">{{__('salary.decline')}}</label>
                            </div>
                            @error('verifikasi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="float-right">
                            <a href="{{ route('salary.unprocessed2') }}" class="btn btn-secondary">
                                @lang('salary.back')
                            </a>
                            <button type="Submit" class="btn btn-primary" id="submitMenu">
                                @lang('salary.verify')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection