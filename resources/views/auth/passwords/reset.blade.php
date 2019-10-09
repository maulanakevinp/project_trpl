@extends('layouts.app')
@section('title')
@lang('auth.reset_password') | {{ config('app.name') }}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card o-hidden border-0 shadow-lg my-5" style="background: rgba(255,255,255,0.7)">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">@lang('auth.reset_password') {{ config('app.name') }}</h1>
                                </div>
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">@lang('auth.email')</label>
                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}"autofocus>
                                            @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">@lang('auth.password')</label>
                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                            @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">@lang('auth.confirm_password')</label>
                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                            @error('password_confirmation')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                @lang('auth.reset_password')
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
