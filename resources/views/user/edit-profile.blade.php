@extends('layouts.master')
@section('title')
@lang('user.edit_profile') - {{ config('app.name') }}
@endsection
@section('container')
    @if ($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    @if (session('success'))<div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>@endif
    @if (session('failed'))<div class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('failed') }}<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>@endif
    <div class="row">
        <div class="col-lg">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold text-primary">@lang('user.edit_profile')</h5>
                </div>
                <div class="card-body">
                    <form action=" {{ route('update-profile', ['id' => Auth::user()->id]) }} " method="post" enctype="multipart/form-data">
                        @method('patch')
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="image" class="col-md-3">{{__('user.image')}}</label>
                                    <div class="col-md-9">
                                        <div class="text-center mb-3">
                                            <img id="image" src="{{ asset('img/profile/'.Auth::user()->image) }}" class="img-thumbnail">
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="foto" name="foto">
                                            <label class="custom-file-label" for="foto">{{__('user.choose_image')}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-md-3 col-form-label">{{__('user.email')}}</label>
                                    <div class="col-md-9">
                                        <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" autocomplete="off">
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nama_lengkap" class="col-md-3 col-form-label">{{__('user.name')}}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ Auth::user()->name }}" autocomplete="off">
                                        @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nik" class="col-md-3 col-form-label">{{__('user.nik')}}</label>
                                    <div class="col-md-9">
                                        <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ Auth::user()->nik }}" >
                                        @error('nik')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nomor_telepon" class="col-md-3 col-form-label">{{__('user.phone_number')}}</label>
                                    <div class="col-md-9">
                                        <input id="nomor_telepon" type="text" class="form-control @error('nomor_telepon') is-invalid @enderror" name="nomor_telepon" value="{{ Auth::user()->phone_number }}" >
                                        @error('nomor_telepon')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="jenis_kelamin" class="col-md-3">{{__('user.gender')}}</label>
                                    <div class="col-md-9">
                                        @foreach ($genders as $gender)
                                        <div class="custom-control custom-radio custom-control-inline">
                                            @if ($gender->id == Auth::user()->gender_id)
                                            <input checked="chekced" id="jenis_kelamin{{ $loop->iteration }}" type="radio" class="custom-control-input @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" value="{{$gender->id}}" >
                                            <label class="custom-control-label" for="jenis_kelamin{{ $loop->iteration }}">
                                                {{$gender->gender}}
                                            </label>
                                            @else
                                            <input id="jenis_kelamin{{ $loop->iteration }}" type="radio" class="custom-control-input @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" value="{{$gender->id}}" >
                                            <label class="custom-control-label" for="jenis_kelamin{{ $loop->iteration }}">
                                                {{$gender->gender}}
                                            </label>
                                            @endif
                                        </div>
                                        @endforeach
                                        @error('jenis_kelamin')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3" for="agama">{{__('user.religion')}}</label>
                                    <div class="col-md-9">
                                        <select name="agama" id="agama" class="form-control @error('agama') is-invalid @enderror">
                                            <option value="">{{__('Pilih agama')}}</option>
                                            @foreach ($religions as $religion)
                                            @if ($religion->id == Auth::user()->religion_id)
                                            <option selected="selected" value="{{$religion->id}}">{{$religion->religion}}</option>
                                            @else
                                            <option value="{{$religion->id}}">{{$religion->religion}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @error('agama')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3" for="status_pernikahan">{{__('user.marital')}}</label>
                                    <div class="col-md-9">
                                        <select name="status_pernikahan" id="status_pernikahan" class="form-control @error('status_pernikahan') is-invalid @enderror">
                                            <option value="">{{__('Pilih status_pernikahan')}}</option>
                                            @foreach ($maritals as $marital)
                                            @if ($marital->id == Auth::user()->marital_id)
                                            <option selected="selected" value="{{$marital->id}}">{{$marital->marital}}</option>
                                            @else
                                            <option value="{{$marital->id}}">{{$marital->marital}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @error('status_pernikahan')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3" for="tempat_lahir">{{__('user.birth_place')}}</label>
                                    <div class="col-md-9">
                                        <input id="tempat_lahir" type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir" value="{{ Auth::user()->birth_place }}" >
                                        @error('tempat_lahir')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3" for="tanggal_lahir">{{__('user.birth_date')}}</label>
                                    <div class="col-md-9">
                                        <input id="tanggal_lahir" type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ Auth::user()->birth_date }}" >
                                        @error('tanggal_lahir')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3" for="pekerjaan">{{__('user.job')}}</label>
                                    <div class="col-md-9">
                                        <input id="pekerjaan" type="text" class="form-control @error('pekerjaan') is-invalid @enderror" name="pekerjaan" value="{{ Auth::user()->job }}" >
                                        @error('pekerjaan')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3" for="alamat">{{__('user.address')}}</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" name="alamat" cols="30" rows="3">{{ Auth::user()->address }}</textarea>
                                        @error('alamat')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="float-right">
                            <a href="{{ url('/my-profile') }}" class="btn btn-secondary">{{__('user.cancel')}}</a>
                            <button type="submit" class="btn btn-primary">{{__('user.edit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
