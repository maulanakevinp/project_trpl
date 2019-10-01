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
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
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
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="role" class="col-sm-4 col-form-label">{{__('Role :')}}</label>
                                    <div class="col-sm-8">
                                        <select class="form-control @error('role') is-invalid @enderror" name="role" id="role">
                                            <option value="">{{__('Choose Role')}}</option>
                                            @foreach ($user_role as $role)
                                            @if ($role->id == $user->role->id)
                                            <option selected="selected" value="{{$role->id}}">{{$role->role}}</option>                                            
                                            @elseif(old('role') == $role->id)
                                            <option selected="selected" value="{{$role->id}}">{{$role->role}}</option>                                            
                                            @else
                                            <option value="{{$role->id}}">{{$role->role}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @error('role')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-4 col-form-label">{{__('Email :')}}</label>
                                    <div class="col-sm-8">
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" autocomplete="off">
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-sm-4 col-form-label">{{__('Full name :')}}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $user->name }}" autocomplete="off">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nik" class="col-sm-4 col-form-label">{{__('NIK :')}}</label>
                                    <div class="col-sm-8">
                                        <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ $user->nik }}" placeholder="Enter nik...">
                                        @error('nik')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="gender" class="col-sm-4">{{__('Gender :')}}</label>
                                    <div class="col-sm-8">
                                        @foreach ($genders as $gender)
                                        <div class="custom-control custom-radio custom-control-inline">
                                            @if ($gender->id == $user->gender_id)
                                            <input checked="chekced" id="gender{{ $loop->iteration }}" type="radio" class="custom-control-input @error('gender') is-invalid @enderror" name="gender" value="{{$gender->id}}" >
                                            <label class="custom-control-label" for="gender{{ $loop->iteration }}">
                                                {{$gender->gender}}
                                            </label>
                                            @else
                                            <input id="gender{{ $loop->iteration }}" type="radio" class="custom-control-input @error('gender') is-invalid @enderror" name="gender" value="{{$gender->id}}" >
                                            <label class="custom-control-label" for="gender{{ $loop->iteration }}">
                                                {{$gender->gender}}
                                            </label>
                                            @endif
                                        </div>
                                        @endforeach
                                        @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4" for="religion">{{__('Religion :')}}</label>
                                    <div class="col-sm-8">
                                        <select name="religion" id="religion" class="form-control @error('religion') is-invalid @enderror">
                                            <option value="">{{__('Choose religion')}}</option>
                                            @foreach ($religions as $religion)
                                            @if ($religion->id == $user->religion_id)
                                            <option selected="selected" value="{{$religion->id}}">{{$religion->religion}}</option>
                                            @else
                                            <option value="{{$religion->id}}">{{$religion->religion}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @error('religion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4" for="marital">{{__('Marital Status :')}}</label>
                                    <div class="col-sm-8">
                                        <select name="marital" id="marital" class="form-control @error('marital') is-invalid @enderror">
                                            <option value="">{{__('Choose marital')}}</option>
                                            @foreach ($maritals as $marital)
                                            @if ($marital->id == $user->marital_id)
                                            <option selected="selected" value="{{$marital->id}}">{{$marital->marital}}</option>
                                            @else
                                            <option value="{{$marital->id}}">{{$marital->marital}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @error('marital')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                            <label class="col-sm-4" for="birth_place">{{__('Birth Place :')}}</label>
                                        <div class="col-sm-8">
                                            <input id="birth_place" type="text" class="form-control @error('birth_place') is-invalid @enderror" name="birth_place" value="{{ $user->birth_place }}" placeholder="Enter birth place...">
                                            @error('birth_place')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                </div>
                                <div class="form-group row">
                                            <label class="col-sm-4" for="birth_date">{{__('Birthdate :')}}</label>
                                        <div class="col-sm-8">
                                            <input id="birth_date" type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ $user->birth_date }}" placeholder="Enter birth date...">
                                            @error('birth_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                </div>
                                <div class="form-group row">
                                            <label class="col-sm-4" for="job">{{__('Job :')}}</label>
                                        <div class="col-sm-8">
                                            <input id="job" type="text" class="form-control @error('job') is-invalid @enderror" name="job" value="{{ $user->job }}" placeholder="Enter job...">
                                            @error('job')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                </div>
                                <div class="form-group row">
                                            <label class="col-sm-4" for="address">{{__('Address :')}}</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" name="address" cols="30" rows="3">{{ $user->address }}</textarea>
                                            @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-4">{{__('Image')}}</div>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <img src="{{ asset('img/profile/'.$user->image) }}" class="img-thumbnail">
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="image" name="image">
                                                    <label class="custom-file-label" for="image">{{__('Choose file')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        @error('image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            {{__('Edit user')}}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->


@endsection
