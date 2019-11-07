@extends('layouts.master')
@section('title')
@lang('user.change_password') | {{ config('app.name') }}
@endsection
@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold text-primary">@lang('user.change_password')</h5>
                </div>
                <div class="card-body">
                    <form action=" {{ route('update-password', [ 'id' => Auth::user()->id ]) }} " method="post">
                        @method('patch')
                        @csrf
                        <div class="form-group">
                            <label for="kata_sandi">@lang('user.password')</label>
                            <input type="password" class="form-control  @error('kata_sandi') is-invalid @enderror" id="kata_sandi" name="kata_sandi">
                            @error('kata_sandi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="kata_sandi_baru">@lang('user.new_password')</label>
                            <input type="password" class="form-control  @error('kata_sandi_baru') is-invalid @enderror" id="kata_sandi_baru" name="kata_sandi_baru">
                            @error('kata_sandi_baru')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="konfirmasi_kata_sandi">@lang('user.confirm_password')</label>
                            <input type="password" class="form-control  @error('konfirmasi_kata_sandi') is-invalid @enderror" id="konfirmasi_kata_sandi" name="konfirmasi_kata_sandi">
                            @error('konfirmasi_kata_sandi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">@lang('user.change_password')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

@endsection
