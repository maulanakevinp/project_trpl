@extends('layouts.master')
@section('title')
{{ $subtitle }} - {{ config('app.name') }}
@endsection
@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ $title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $subtitle }}</li>
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
                    <h5 class="m-0 pt-1 font-weight-bold text-primary">{{ $subtitle }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update',$user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <div class="col-md-3">{{__('user.image')}}</div>
                                    <div class="col-md-9">
                                        <div class="text-center mb-3">
                                            <img id="image" src="{{ asset('img/profile/'.$user->image) }}" class="img-thumbnail">
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
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" autocomplete="off">
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nama_lengkap" class="col-md-3 col-form-label">{{__('user.name')}}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ $user->name }}" autocomplete="off">
                                        @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nik" class="col-md-3 col-form-label">{{__('user.nik')}}</label>
                                    <div class="col-md-9">
                                        <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ $user->nik }}" >
                                        @error('nik')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div><div class="form-group row">
                                    <label for="nik_file" class="col-md-3 col-form-label">{{__('user.nik_file')}}</label>
                                    <div class="col-md-9">
                                        <input type="file" id="nik_file" name="nik_file" value="{{ old('nik_file') }}">@if($user->nik_file)<a target="_blank" href="{{ route('detail-nik', $user->nik_file) }}" class="badge badge-info">lihat</a>@endif
                                        @error('kk')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kk" class="col-md-3 col-form-label">{{__('user.kk')}}</label>
                                    <div class="col-md-9">
                                        <input id="kk" type="text" class="form-control @error('kk') is-invalid @enderror" name="kk" value="{{ old('kk') ?? $user->kk }}">
                                        @error('kk')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kk_file" class="col-md-3 col-form-label">{{__('user.kk_file')}}</label>
                                    <div class="col-md-9">
                                        <input type="file" id="kk_file" name="kk_file" value="{{ old('kk_file') }}">@if($user->kk_file)<a target="_blank" href="{{ route('detail-kk', $user->kk_file) }}" class="badge badge-info">lihat</a>@endif
                                        @error('kk')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="nomor_telepon" class="col-md-3 col-form-label">{{__('user.phone_number')}}</label>
                                    <div class="col-md-9">
                                        <input id="nomor_telepon" type="text" class="form-control @error('nomor_telepon') is-invalid @enderror"
                                            name="nomor_telepon" value="{{ $user->phone_number }}">
                                        @error('nomor_telepon')<span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="peran" class="col-sm-3 col-form-label">{{__('user.role')}}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control @error('peran') is-invalid @enderror" name="peran" id="peran">
                                            <option value="">{{__('user.choose_role')}}</option>
                                            @foreach ($user_role as $role)
                                            @if($user->role_id == $role->id)
                                            <option selected="selected" value="{{$role->id}}">{{$role->role}}</option>                                            
                                            @elseif(old('peran') == $role->id)
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
                                    <label for="jenis_kelamin" class="col-md-3">{{__('user.gender')}}</label>
                                    <div class="col-md-9">
                                        @foreach ($genders as $gender)
                                        <div class="custom-control custom-radio custom-control-inline">
                                            @if ($gender->id == $user->gender_id)
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
                                            @if ($religion->id == $user->religion_id)
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
                                            @if ($marital->id == $user->marital_id)
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
                                        <input id="tempat_lahir" type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir" value="{{ $user->birth_place }}" >
                                        @error('tempat_lahir')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3" for="tanggal_lahir">{{__('user.birth_date')}}</label>
                                    <div class="col-md-9">
                                        <input id="tanggal_lahir" type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ $user->birth_date }}" >
                                        @error('tanggal_lahir')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3" for="pekerjaan">{{__('user.job')}}</label>
                                    <div class="col-md-9">
                                        <input id="pekerjaan" type="text" class="form-control @error('pekerjaan') is-invalid @enderror" name="pekerjaan" value="{{ $user->job }}" >
                                        @error('pekerjaan')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3" for="alamat">{{__('user.address')}}</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" name="alamat" cols="30" rows="3">{{ $user->address }}</textarea>
                                        @error('alamat')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="float-right">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">{{__('user.back')}}</a>
                            <button type="submit" class="btn btn-primary">{{__('user.edit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
@section('script')
<script>
    $(document).ready(function () {
        $(".custom-file-input").on("change", function () {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    });
</script>
@endsection