@extends('layouts.app')
@section('title')
@lang('auth.login') | {{ config('app.name') }}
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
                                    <h1 class="h4 text-gray-900 mb-4">@lang('auth.login') {{ config('app.name') }}</h1>
                                </div>
                                <form class="user" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input id="email" type="text" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autofocus placeholder="@lang('auth.email')">
                                        @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="password" type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" placeholder="@lang('auth.password')">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        @lang('auth.login')
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route('password.request')}}">@lang('auth.to_forgot_password')</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="{{ route('register') }}">@lang('auth.to_register')</a>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
