@extends('layouts.master')
@section('title')
{{ $title }} - {{ config('app.name') }}
@endsection
@section('container')

    @if ($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold float-left text-primary">{{ $title }}</h5>
                    <a href="{{route('edit-profile')}}" class="btn btn-primary btn-sm float-right">{{__('user.edit_profile')}} </a>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('img/profile/' . Auth::user()->image) }}" class="img-thumbnail mb-3" alt="{{ Auth::user()->image }}">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <tr><td>{{ __('user.name') }}</td>          <td>:</td><td>{{ Auth::user()->name }}</td></tr>
                                <tr><td>{{ __('user.email') }}</td>         <td>:</td><td>{{ Auth::user()->email }}</td></tr>
                                <tr><td>{{ __('user.nik') }}</td>           <td>:</td><td><a @if(Auth::user()->nik_file) data-toggle="modal" data-target="#detailNIKModal" data-toggle="tooltip" data-placement="top" title="Lihat detail NIK" href=""@endif>{{ Auth::user()->nik }}</a></td></tr>
                                <tr><td>{{ __('user.kk') }}</td>            <td>:</td><td><a @if(Auth::user()->kk_file) data-toggle="modal" data-target="#detailKKModal" data-toggle="tooltip" data-placement="top" title="Lihat detail KK" href=""@endif>{{ Auth::user()->kk }}</a></td></tr>
                                <tr><td>{{ __('user.gender') }}</td>        <td>:</td><td>{{ Auth::user()->gender->gender }}</td></tr>
                                <tr><td>{{ __('user.religion') }}</td>      <td>:</td><td>{{ Auth::user()->religion->religion }}</td></tr>
                                <tr><td>{{ __('user.marital') }}</td>       <td>:</td><td>{{ Auth::user()->marital->marital }}</td></tr>
                                <tr><td>{{ __('user.birth') }}</td>         <td>:</td><td>{{ Auth::user()->birth_place .__(', ').date('d-m-Y', strtotime(Auth::user()->birth_date)) }}</td></tr>
                                <tr><td>{{ __('user.phone_number') }}</td>  <td>:</td><td>{{ Auth::user()->phone_number }}</td></tr>
                                <tr><td>{{ __('user.address') }}</td>       <td>:</td><td>{{ Auth::user()->address }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="detailNIKModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="detailNIK"
        aria-hidden="true">
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
                    <img id="nik_image" class="mw-100" src="{{url('img/nik/'.Auth::user()->nik_file) }}" alt="{{ Auth::user()->nik_file }}">
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
                    <img id="kk_image" class="mw-100" src="{{url('img/kk/'.Auth::user()->kk_file) }}" alt="{{ Auth::user()->kk_file }}">
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
    </script>
@endsection