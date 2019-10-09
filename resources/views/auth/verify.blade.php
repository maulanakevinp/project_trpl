@extends('layouts.app')
@section('title')
@lang('auth.verify') | {{ config('app.name') }}
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
                                    <h2 class="h4 text-gray-900 mb-4">{{ __('auth.verify_title') }}</h2>
                                </div>
                                @if (session('resent'))
                                    <div class="alert alert-success" role="alert">
                                        {{ __('auth.verify_resent') }}
                                    </div>
                                @endif
                                {{ __('auth.verify_email_check') }}
                                {{ __('auth.verify_not_receive_email') }}, <a href="{{ route('verification.resend') }}">{{ __('auth.verify_resent_email') }}</a>.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
