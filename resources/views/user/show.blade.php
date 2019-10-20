@extends('layouts.master')
@section('title')
{{ $title }} - {{ config('app.name') }}
@endsection
@section('container')

    @if ($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    @if (session('success'))<div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>@endif
    @if (session('failed'))<div class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('failed') }}<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>@endif
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold float-left text-primary">{{ $title }}</h5>
                    <a href="{{route('edit-profile')}}" class="btn btn-primary btn-sm float-right">{{__('user.edit_profile')}} </a>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('img/profile/' . Auth::user()->image) }}" class="img-thumbnail mb-3" alt="{{ Auth::user()->image }}">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <tr><td>{{ __('user.name') }}</td>          <td>:</td><td>{{ Auth::user()->name }}</td></tr>
                                <tr><td>{{ __('user.email') }}</td>         <td>:</td><td>{{ Auth::user()->email }}</td></tr>
                                <tr><td>{{ __('user.nik') }}</td>           <td>:</td><td><a target="_blank" @if(Auth::user()->nik_file) data-toggle="tooltip" data-placement="top" title="Lihat detail NIK" href="{{ route('detail-nik', ['nik' => Auth::user()->nik_file]) }} @endif">{{ Auth::user()->nik }}</a></td></tr>
                                <tr><td>{{ __('user.kk') }}</td>            <td>:</td><td><a target="_blank" @if(Auth::user()->kk_file) data-toggle="tooltip" data-placement="top" title="Lihat detail KK" href="{{ route('detail-kk', ['kk' => Auth::user()->kk_file]) }} @endif">{{ Auth::user()->kk }}</a></td></tr>
                                <tr><td>{{ __('user.gender') }}</td>        <td>:</td><td>{{ Auth::user()->gender->gender }}</td></tr>
                                <tr><td>{{ __('user.religion') }}</td>      <td>:</td><td>{{ Auth::user()->religion->religion }}</td></tr>
                                <tr><td>{{ __('user.marital') }}</td>       <td>:</td><td>{{ Auth::user()->marital->marital }}</td></tr>
                                <tr><td>{{ __('user.birth') }}</td>         <td>:</td><td>{{ Auth::user()->birth_place .__(', ').date('d-m-Y', strtotime(Auth::user()->birth_date)) }}</td></tr>
                                <tr><td>{{ __('user.phone_number') }}</td>  <td>:</td><td>{{ Auth::user()->phone_number }}</td></tr>
                                <tr><td>{{ __('user.address') }}</td>       <td>:</td><td>{{ Auth::user()->address }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
