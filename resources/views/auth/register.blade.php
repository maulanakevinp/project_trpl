@extends('layouts.app')
@section('title')
@lang('auth.register') | {{ config('app.name') }}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg">
            <div class="card o-hidden border-0 shadow-lg my-5" style="background: rgba(255,255,255,0.7)">
                <div class="card-body p-0">
                    <div class="p-4">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">@lang('auth.register') {{ config('app.name') }}</h1>
                        </div>
                        <form class="user" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4 col-form-label" for="">@lang('auth.name')</label>
                                            <div class="col-sm-8">
                                                <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}">
                                                @error('nama')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4 col-form-label" for="">@lang('auth.nik')</label>
                                            <div class="col-sm-8">
                                                <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik') }}">
                                                @error('nik')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4 col-form-label" for="gender">@lang('auth.gender')</label>
                                            <div class="col-sm-8">
                                                @foreach ($genders as $gender)
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        @if (old('jenis_kelamin') == $gender->id)
                                                        <input checked="checked" id="jenis_kelamin{{ $gender->id }}" type="radio" class="custom-control-input @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" value="{{$gender->id}}" >
                                                        <label class="custom-control-label" for="jenis_kelamin{{ $gender->id }}">
                                                            {{$gender->gender}}
                                                        </label>
                                                        @else
                                                        <input id="jenis_kelamin{{ $gender->id }}" type="radio" class="custom-control-input @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" value="{{$gender->id}}" >
                                                        <label class="custom-control-label" for="jenis_kelamin{{ $gender->id }}">
                                                            {{$gender->gender}}
                                                        </label>                                                            
                                                        @endif
                                                    </div>
                                                @endforeach
                                                @error('jenis_kelamin')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4 col-form-label" for="agama">@lang('auth.religion')</label>
                                            <div class="col-sm-8">
                                                <select name="agama" id="agama" class="form-control @error('agama') is-invalid @enderror">
                                                    <option value="">@lang('auth.choose_religion')</option>
                                                    @foreach ($religions as $religion)
                                                        @if (old('agama') == $religion->id)
                                                        <option selected="selected" value="{{$religion->id}}">{{$religion->religion}}</option>
                                                        @else
                                                        <option value="{{$religion->id}}">{{$religion->religion}}</option>                                                            
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('agama')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4 col-form-label" for="status_pernikahan">@lang('auth.marital')</label>
                                            <div class="col-sm-8">
                                                <select name="status_pernikahan" id="status_pernikahan" class="form-control @error('status_pernikahan') is-invalid @enderror">
                                                    <option value="">@lang('auth.choose_marital')</option>
                                                    @foreach ($maritals as $marital)
                                                        @if (old('status_pernikahan') == $marital->id)
                                                        <option selected="selected" value="{{$marital->id}}">{{$marital->marital}}</option>
                                                        @else
                                                        <option value="{{$marital->id}}">{{$marital->marital}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('status_pernikahan')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4 col-form-label" for="alamat">@lang('auth.address')</label>
                                            <div class="col-sm-8">
                                                <input id="alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat') }}">
                                                @error('alamat')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4 col-form-label" for="tempat_lahir">@lang('auth.birth_place')</label>
                                            <div class="col-sm-8">
                                                <input id="tempat_lahir" type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                                                @error('tempat_lahir')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4 col-form-label" for="tanggal_lahir">@lang('auth.birth_date')</label>
                                            <div class="col-sm-8">
                                                <input id="tanggal_lahir" type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" >
                                                @error('tanggal_lahir')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4 col-form-label" for="pekerjaan">@lang('auth.job')</label>
                                            <div class="col-sm-8">
                                                <input id="pekerjaan" type="text" class="form-control @error('pekerjaan') is-invalid @enderror" name="pekerjaan" value="{{ old('pekerjaan') }}">
                                                @error('pekerjaan')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4 col-form-label" for="email">@lang('auth.email')</label>
                                            <div class="col-sm-8">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4 col-form-label" for="password">@lang('auth.password')</label>
                                            <div class="col-sm-8">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4 col-form-label" for="password_confirmation">@lang('auth.confirm_password')</label>
                                            <div class="col-sm-8">
                                                <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation">
                                                @error('password_confirmation')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                @lang('auth.register')
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="{{ route('login')}}">@lang('auth.to_login')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
