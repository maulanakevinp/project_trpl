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
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                                                @error('name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
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
                                                        <input id="gender{{ $loop->iteration }}" type="radio" class="custom-control-input @error('gender') is-invalid @enderror" name="gender" value="{{$gender->id}}" >
                                                        <label class="custom-control-label" for="gender{{ $loop->iteration }}">
                                                            {{$gender->gender}}
                                                        </label>
                                                    </div>
                                                @endforeach
                                                @error('gender')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4 col-form-label" for="religion">@lang('auth.religion')</label>
                                            <div class="col-sm-8">
                                                <select name="religion" id="religion" class="form-control @error('religion') is-invalid @enderror">
                                                    <option value="">@lang('auth.choose_religion')</option>
                                                    @foreach ($religions as $religion)
                                                        <option value="{{$religion->id}}">{{$religion->religion}}</option>
                                                    @endforeach
                                                </select>
                                                @error('religion')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4 col-form-label" for="marital">@lang('auth.marital')</label>
                                            <div class="col-sm-8">
                                                <select name="marital" id="marital" class="form-control @error('marital') is-invalid @enderror">
                                                    <option value="">@lang('auth.choose_marital')</option>
                                                    @foreach ($maritals as $marital)
                                                        <option value="{{$marital->id}}">{{$marital->marital}}</option>
                                                    @endforeach
                                                </select>
                                                @error('marital')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4 col-form-label" for="address">@lang('auth.address')</label>
                                            <div class="col-sm-8">
                                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}">
                                                @error('address')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4 col-form-label" for="birth_place">@lang('auth.birth_place')</label>
                                            <div class="col-sm-8">
                                                <input id="birth_place" type="text" class="form-control @error('birth_place') is-invalid @enderror" name="birth_place" value="{{ old('birth_place') }}">
                                                @error('birth_place')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4 col-form-label" for="birth_date">@lang('auth.birth_date')</label>
                                            <div class="col-sm-8">
                                                <input id="birth_date" type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" >
                                                @error('birth_date')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4 col-form-label" for="job">@lang('auth.job')</label>
                                            <div class="col-sm-8">
                                                <input id="job" type="text" class="form-control @error('job') is-invalid @enderror" name="job" value="{{ old('job') }}">
                                                @error('job')
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
