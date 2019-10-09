@extends('layouts.master')
@section('title')
{{ $subtitle }} - {{ config('app.name') }}
@endsection
@section('container')
<!-- Begin Page Content -->
<div class="container-fluid">
    @if ($errors->any())<div class="alert alert-danger"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if (session('failed'))<div class="alert alert-danger">{{ session('failed') }}</div>@endif
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ $subtitle }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('salary.store') }}">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="">@lang('salary.salary')</label>
                            <div class="col-sm-8">
                                <input id="gaji" type="text" class="form-control @error('gaji') is-invalid @enderror" name="gaji" value="{{ old('gaji') }}">
                                @error('gaji')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="">@lang('salary.reason')</label>
                            <div class="col-sm-8">
                                <textarea name="alasan_pengajuan" id="alasan_pengujian" class="form-control @error('alasan_pengajuan') is-invalid @enderror" cols="30" rows="5">{{ old('alasan_pengajuan') }}</textarea>
                                @error('alasan_pengajuan')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            @lang('salary.add')
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ __('salary.data') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('salary.title') }}</th>
                                    <th>{{ __('salary.menu') }}</th>
                                    <th>{{ __('salary.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_submenu as $salary)
                                <tr>
                                    <td>{{ $salary->title }}</td>
                                    <td>{{ $salary->menu->menu }}</td>
                                    <td>{{ $salary->is_active }}</td>
                                    <td>
                                        <a class="editSubMenu" href="" data-toggle="modal" data-target="#newSubMenuModal" data-id="{{ $salary->id }}"><span class="badge badge-success">{{ __('salary.edit') }}</span></a>
                                        <form class="d-inline-block" action="{{ route('salary.destroy',$salary->id) }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            @if ($salary->menu->menu != 'Menu')
                                                <button type="submit" class="badge badge-danger " onclick="return confirm('{{__('salary.delete_confirm')}}');">
                                                    {{ __('salary.delete') }}
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

@endsection
