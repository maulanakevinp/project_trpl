@extends('layouts.master')
@section('title')
    {{$title}} - {{config('app.name')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
@endsection
@section('container')
<div class="container-fluid">
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('failed'))
    <div class="alert alert-danger">
        {{ session('failed') }}
    </div>
    @endif
    <section id="features" class="features p-0">
        <div class="container p-0">
                <h3>{{ $title }}</h3>
            <div class="row">
                <div class="col-lg-4">
                    <div class="feature-item">
                        <a class="card-link text-dark" href="{{ route('salary.create') }}">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <h5>Surat Keterangan Penghasilan</h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection