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
            <h1 class="mb-3">{{ $title }}</h1>
            <div class="row justify-content-center">
                @if (Auth::user()->role->role == 'Penduduk')
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="feature-item p-0">
                                    <a class="card-link text-dark" href="{{ route('salaries.create') }}">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                        <h5>Surat Keterangan Penghasilan</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="feature-item p-0">
                                    <a class="card-link text-dark" href="{{ route('incapables.create') }}">
                                        <i class="fas fa-file-signature"></i>
                                        <h5>Surat Keterangan Tidak Mampu</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="feature-item p-0">
                                    <a class="card-link text-dark" href="{{ route('domiciles.create') }}">
                                        <i class="fas fa-file-signature"></i>
                                        <h5>Surat Keterangan Domisili</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="feature-item p-0">
                                    <a class="card-link text-dark" href="{{ route('disappearances.create') }}">
                                        <i class="fas fa-file-signature"></i>
                                        <h5>Surat Keterangan Kehilangan</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="feature-item p-0">
                                    <a class="card-link text-dark" href="{{ route('enterprises.create') }}">
                                        <i class="fas fa-file-signature"></i>
                                        <h5>Surat Keterangan Usaha</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="feature-item p-0">
                                    <a class="card-link text-dark" href="{{ route('births.create') }}">
                                        <i class="fas fa-file-signature"></i>
                                        <h5>Surat Keterangan Kelahiran</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif(Auth::user()->role->role == 'Administrasi')
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="feature-item p-0">
                                    <a class="card-link text-dark" href="{{ route('salaries.index1') }}">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                        <h5>Surat Keterangan Penghasilan</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="feature-item p-0">
                                    <a class="card-link text-dark" href="{{ route('incapables.index1') }}">
                                        <i class="fas fa-file-signature"></i>
                                        <h5>Surat Keterangan Tidak Mampu</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="feature-item p-0">
                                    <a class="card-link text-dark" href="{{ route('domiciles.index1') }}">
                                        <i class="fas fa-file-signature"></i>
                                        <h5>Surat Keterangan Domisili</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="feature-item p-0">
                                    <a class="card-link text-dark" href="{{ route('disappearances.index1') }}">
                                        <i class="fas fa-file-signature"></i>
                                        <h5>Surat Keterangan Kehilangan</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="feature-item p-0">
                                    <a class="card-link text-dark" href="{{ route('enterprises.index1') }}">
                                        <i class="fas fa-file-signature"></i>
                                        <h5>Surat Keterangan Usaha</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="feature-item p-0">
                                    <a class="card-link text-dark" href="{{ route('births.index1') }}">
                                        <i class="fas fa-file-signature"></i>
                                        <h5>Surat Keterangan Kelahiran</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif(Auth::user()->role->role == 'Kepala Desa')
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="feature-item p-0">
                                    <a class="card-link text-dark" href="{{ route('salaries.index2') }}">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                        <h5>Surat Keterangan Penghasilan</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="feature-item p-0">
                                    <a class="card-link text-dark" href="{{ route('incapables.index2') }}">
                                        <i class="fas fa-file-signature"></i>
                                        <h5>Surat Keterangan Tidak Mampu</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="feature-item p-0">
                                    <a class="card-link text-dark" href="{{ route('domiciles.index2') }}">
                                        <i class="fas fa-file-signature"></i>
                                        <h5>Surat Keterangan Domisili</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="feature-item p-0">
                                    <a class="card-link text-dark" href="{{ route('disappearances.index2') }}">
                                        <i class="fas fa-file-signature"></i>
                                        <h5>Surat Keterangan Kehilangan</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="feature-item p-0">
                                    <a class="card-link text-dark" href="{{ route('enterprises.index2') }}">
                                        <i class="fas fa-file-signature"></i>
                                        <h5>Surat Keterangan Usaha</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="feature-item p-0">
                                    <a class="card-link text-dark" href="{{ route('births.index2') }}">
                                        <i class="fas fa-file-signature"></i>
                                        <h5>Surat Keterangan Kelahiran</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection