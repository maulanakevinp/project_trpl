@extends('layouts.master')
@section('title')
{{ __('incapable.edit_verify') }} - {{ config('app.name') }}
@endsection
@section('container')
<!-- Begin Page Content -->
<div class="container-fluid">
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
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold float-left text-primary">{{ __('incapable.detail_user') }}</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('img/profile/' . $incapable->user->image) }}" class="img-thumbnail mb-3"
                            alt="{{ $incapable->user->image }}">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td>{{ __('user.name') }}</td>
                                    <td>:</td>
                                    <td>{{ $incapable->user->name }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.email') }}</td>
                                    <td>:</td>
                                    <td>{{ $incapable->user->email }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.nik') }}</td>
                                    <td>:</td>
                                    <td><a target="_blank" @if($incapable->user->nik_file) data-toggle="modal" data-target="#detailNIKModal" data-toggle="tooltip" data-placement="top" title="Lihat detail NIK" href="" @endif>{{ $incapable->user->nik }}</a></td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.kk') }}</td>
                                    <td>:</td>
                                    <td><a target="_blank" @if($incapable->user->kk_file)data-toggle="modal" data-target="#detailKKModal" data-toggle="tooltip" data-placement="top" title="Lihat detail KK" href="" @endif>{{ $incapable->user->kk }}</a></td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.gender') }}</td>
                                    <td>:</td>
                                    <td>{{ $incapable->user->gender->gender }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.religion') }}</td>
                                    <td>:</td>
                                    <td>{{ $incapable->user->religion->religion }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.marital') }}</td>
                                    <td>:</td>
                                    <td>{{ $incapable->user->marital->marital }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.birth') }}</td>
                                    <td>:</td>
                                    <td>{{ $incapable->user->birth_place .__(', ').date('d-m-Y', strtotime($incapable->user->birth_date)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.phone_number') }}</td>
                                    <td>:</td>
                                    <td>{{ $incapable->user->phone_number }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('user.address') }}</td>
                                    <td>:</td>
                                    <td>{{ $incapable->user->address }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ __('incapable.edit_verify') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('incapable.verify1',$incapable->id) }}" method="post">
                        @csrf
                        @method('put')
                        <input type="hidden" name="update" value="1">
                        <div class="form-group">
                            <label class="col-form-label" for="">@lang('incapable.name')</label>
                            <input id="nama" type="text" class="form-control" name="nama" value="{{ $incapable->name }}" disabled>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="">@lang('incapable.birth_place')</label>
                            <input id="tempat_lahir" type="text" class="form-control" name="tempat_lahir" value="{{ $incapable->birth_place }}"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="">@lang('incapable.birth_date')</label>
                            <input id="tanggal_lahir" type="date" class="form-control" name="tanggal_lahir" value="{{ $incapable->birth_date }}"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="">@lang('incapable.address')</label>
                            <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="5"
                                disabled>{{ $incapable->address }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="">@lang('incapable.reason')</label>
                            <textarea name="alasan_pengajuan" id="alasan_pengajuan" class="form-control" cols="30" rows="5">{{ $incapable->reason }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="">@lang('incapable.as')</label>
                            <select name="merupakan" id="merupakan">
                                @if ($incapable->as == 1)
                                <option selected="selected" value="1">{{ __('incapable.parents') }}</option>
                                @elseif($incapable->as == 2)
                                <option selected="selected" value="2">{{ __('incapable.child') }}</option>
                                @else
                                <option value="">{{ __('incapable.choose') }}</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="verifikasi">@lang('incapable.verify')</label><br>
                            <div class="custom-control custom-radio">
                                @if ($incapable->letter->verify1 == 1)
                                <input checked="checked" type="radio" id="verifikasi1" name="verifikasi" class="custom-control-input" value="1">
                                @else
                                <input type="radio" id="verifikasi1" name="verifikasi" class="custom-control-input" value="1">
                                @endif
                                <label class="custom-control-label" for="verifikasi1">{{ __('incapable.accept') }}</label>
                            </div>
                            <div class="custom-control custom-radio">
                                @if ($incapable->letter->verify1 == -1)
                                <input checked="checked" type="radio" id="verifikasi2" name="verifikasi" class="custom-control-input"
                                    value="-1">
                                @else
                                <input type="radio" id="verifikasi2" name="verifikasi" class="custom-control-input" value="-1">
                                @endif
                                <label class="custom-control-label" for="verifikasi2">{{__('incapable.decline')}}</label>
                            </div>
                            @error('verifikasi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div id="alasan_penolakan" class="form-group">
                            <label class="col-form-label" for="">@lang('incapable.reason_decline')</label>
                            <textarea name="alasan_penolakan" class="form-control" cols="30" rows="5">{{ old('alasan_penolakan') }}</textarea>
                        </div>
                        <div class="float-right">
                            <a href="{{ route('incapable.verified1') }}" class="btn btn-secondary">@lang('incapable.back')</a>
                            <button type="Submit" class="btn btn-primary" id="submitMenu">@lang('incapable.edit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="detailNIKModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="detailNIK" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailNIK">Detail NIK</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="text-left">
                    <select onchange="rotateImage('#nik_image',this.value)">
                        <option value="">Putar</option>
                        <option value="90">90</option>
                        <option value="180">180</option>
                        <option value="270">270</option>
                        <option value="360">360</option>
                    </select>
                </div>
                <img id="nik_image" class="mw-100" src="{{url('img/nik/'.$incapable->user->nik_file) }}"
                    alt="{{ $incapable->user->nik_file }}">
            </div>
        </div>
    </div>
</div>
<div id="detailKKModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="detailKK" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailKK">Detail KK</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="text-left">
                    <select onchange="rotateImage('#kk_image',this.value)">
                        <option value="">Putar</option>
                        <option value="90">90</option>
                        <option value="180">180</option>
                        <option value="270">270</option>
                        <option value="360">360</option>
                    </select>
                </div>
                <img id="kk_image" class="mw-100" src="{{url('img/kk/'.$incapable->user->kk_file) }}"
                    alt="{{ $incapable->user->kk_file }}">
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    function rotateImage(image,degree) {
            $(image).animate({
                transform: degree
            }, {
                step: function (now, fx) {
                    $(this).css({
                        '-webkit-transform': 'rotate(' + now + 'deg)',
                        '-moz-transform': 'rotate(' + now + 'deg)',
                        'transform': 'rotate(' + now + 'deg)',
                        'margin': '0',
                    });
                }
            });
        }
    $(document).ready(function () {
        $('#alasan_penolakan').hide();
        $('#verifikasi2').on('change', function () {
            $('#alasan_penolakan').show();
        });
        $('#verifikasi1').on('change', function () {
            $('#alasan_penolakan').hide();
        });
    });
</script>
@endsection