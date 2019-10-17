@extends('layouts.master')
@section('title')
@lang('user.add') - {{ config('app.name') }}
@endsection
@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ $title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">@lang('user.add')</li>
        </ol>
    </nav>
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="row">
        <div class="col-lg">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold text-primary">@lang('user.add')</h5>
                </div>
                <div class="card-body">
                    <form action=" {{ route('users.store') }} " method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="image" class="col-md-4">{{__('user.image')}}</label>
                                    <div class="col-md-8">
                                        <div class="text-center mb-3">
                                            <img id="image" src="{{ asset('img/profile/default.jpg') }}" class="img-thumbnail">
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="foto" name="foto">
                                            <label class="custom-file-label" for="foto">{{__('user.choose_image')}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="peran" class="col-sm-4 col-form-label">{{__('Peran :')}}</label>
                                    <div class="col-sm-8">
                                        <select class="form-control @error('peran') is-invalid @enderror" name="peran" id="peran">
                                            <option value="">{{__('user.choose_role')}}</option>
                                            @foreach ($user_role as $role)
                                            @if(old('peran') == $role->id)
                                            <option selected="selected" value="{{$role->id}}">{{$role->role}}</option>                                            
                                            @else
                                            <option value="{{$role->id}}">{{$role->role}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @error('peran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="">@lang('user.name')</label>
                                    <div class="col-sm-8">
                                        <input id="nama_lengkap" type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" value="{{ old('nama_lengkap') }}">
                                        @error('nama_lengkap')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-form-label" for="">@lang('user.nik')</label>
                                        <div class="col-sm-8">
                                            <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik') }}">
                                            @error('nik')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-form-label" for="jenis_kelamin">@lang('user.gender')</label>
                                        <div class="col-sm-8">
                                            @foreach ($genders as $gender)
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    @if (old('jenis_kelamin') == $gender->id)
                                                        <input checked="checked" id="jenis_kelamin{{ $loop->iteration }}" type="radio" class="custom-control-input @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" value="{{$gender->id}}" >
                                                    @else
                                                        <input id="jenis_kelamin{{ $loop->iteration }}" type="radio" class="custom-control-input @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" value="{{$gender->id}}" >
                                                    @endif
                                                    <label class="custom-control-label" for="jenis_kelamin{{ $loop->iteration }}">
                                                        {{$gender->gender}}
                                                    </label>
                                                </div>
                                            @endforeach
                                            @error('jenis_kelamin')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nomor_telepon" class="col-md-4 col-form-label">{{__('user.phone_number')}}</label>
                                    <div class="col-md-8">
                                        <input id="nomor_telepon" type="text" class="form-control @error('nomor_telepon') is-invalid @enderror" name="nomor_telepon" value="{{ Auth::user()->phone_number }}" >
                                        @error('nomor_telepon')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-form-label" for="agama">@lang('user.religion')</label>
                                        <div class="col-sm-8">
                                            <select name="agama" id="agama" class="form-control @error('agama') is-invalid @enderror">
                                                <option value="">@lang('user.choose_religion')</option>
                                                @foreach ($religions as $religion)
                                                    @if(old('agama') == $religion->id)
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
                                        <label class="col-sm-4 col-form-label" for="status_pernikahan">@lang('user.marital')</label>
                                        <div class="col-sm-8">
                                            <select name="status_pernikahan" id="status_pernikahan" class="form-control @error('status_pernikahan') is-invalid @enderror">
                                                <option value="">@lang('user.choose_marital')</option>
                                                @foreach ($maritals as $marital)
                                                    @if(old('status_pernikahan') == $marital->id)
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
                                        <label class="col-sm-4 col-form-label" for="tempat_lahir">@lang('user.birth_place')</label>
                                        <div class="col-sm-8">
                                            <input id="tempat_lahir" type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                                            @error('tempat_lahir')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-form-label" for="tanggal_lahir">@lang('user.birth_date')</label>
                                        <div class="col-sm-8">
                                            <input id="tanggal_lahir" type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" >
                                            @error('tanggal_lahir')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-form-label" for="pekerjaan">@lang('user.job')</label>
                                        <div class="col-sm-8">
                                            <input id="pekerjaan" type="text" class="form-control @error('pekerjaan') is-invalid @enderror" name="pekerjaan" value="{{ old('pekerjaan') }}">
                                            @error('pekerjaan')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4" for="alamat">{{__('user.address')}}</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" name="alamat" cols="30" rows="3">{{ old('alamat') }}</textarea>
                                        @error('alamat')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-form-label" for="email">@lang('user.email')</label>
                                        <div class="col-sm-8">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-form-label" for="kata_sandi">@lang('user.password')</label>
                                        <div class="col-sm-8">
                                            <input id="kata_sandi" type="password" class="form-control @error('kata_sandi') is-invalid @enderror" name="kata_sandi">
                                            @error('kata_sandi')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-form-label" for="konfirmasi_kata_sandi">@lang('user.confirm_password')</label>
                                        <div class="col-sm-8">
                                            <input id="konfirmasi_kata_sandi" type="password" class="form-control @error('konfirmasi_kata_sandi') is-invalid @enderror" name="konfirmasi_kata_sandi">
                                            @error('konfirmasi_kata_sandi')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="float-right">
                            <a href="{{ url('/users') }}" class="btn btn-secondary">{{__('user.back')}}</a>
                            <button type="submit" class="btn btn-primary">{{__('user.add')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.container-fluid -->


@endsection
