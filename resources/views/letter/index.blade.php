@extends('layouts.master')
@section('title')
    {{$title}} - {{config('app.name')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
@endsection
@section('container')
<div class="container-fluid">
    @if ($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    @if (session('success'))<div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>@endif
    @if (session('failed'))<div class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('failed') }}<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>@endif
    <section id="features" class="features p-0">
        <div class="container p-0">
                <h3>{{ $title }}</h3>
            <div class="row justify-content-center">
                @if (Auth::user()->role->role == 'Penduduk')
                    <div class="col-lg-4">
                        <div class="feature-item">
                            <a class="card-link text-dark" href="{{ route('salary.index') }}">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <h5>Surat Keterangan Penghasilan</h5>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="feature-item">
                            <a class="card-link text-dark" href="{{ route('incapable.index') }}">
                                <i class="fas fa-file-signature"></i>
                                <h5>Surat Keterangan Tidak Mampu</h5>
                            </a>
                        </div>
                    </div>
                @elseif(Auth::user()->role->role == 'Administrasi')
                    <div class="col-lg-4">
                        <div class="feature-item">
                            <a class="card-link text-dark" href="{{ route('salary.unprocessed1') }}">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <h5>Surat Keterangan Penghasilan</h5>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="feature-item">
                            <a class="card-link text-dark" href="{{ route('incapable.unprocessed1') }}">
                                <i class="fas fa-file-signature"></i>
                                <h5>Surat Keterangan Tidak Mampu</h5>
                            </a>
                        </div>
                    </div>
                @elseif(Auth::user()->role->role == 'Kepala Desa')
                    <div class="col-lg-4">
                        <div class="feature-item">
                            <a class="card-link text-dark" href="{{ route('salary.unprocessed2') }}">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <h5>Surat Keterangan Penghasilan</h5>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="feature-item">
                            <a class="card-link text-dark" href="{{ route('incapable.unprocessed2') }}">
                                <i class="fas fa-file-signature"></i>
                                <h5>Surat Keterangan Tidak Mampu</h5>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection