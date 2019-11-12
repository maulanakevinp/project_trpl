@extends('layouts.master')
@section('title')
{{ $subtitle }} - {{ config('app.name') }}
@endsection
@section('container')
<!-- Begin Page Content -->
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('pengajuan-surat') }}">{{ $title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $subtitle }}</li>
        </ol>
    </nav>
    <nav class="nav nav-pills nav-fill mb-3">
        <a id="btnUnprocessed" class="nav-link active" href="#">{{ __('letter.unprocessed') }}</a>
        <a id="btnVerified" class="nav-link" href="#">{{ __('letter.verified') }}</a>
        <a id="btnDeclined" class="nav-link" href="#">{{ __('letter.declined') }}</a>
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
    <div id="unprocessed">
        <div class="card shadow h-100">
            <div class="card-header">
                <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ __('letter.birth') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="unprocessedTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>No.</th>
                                <th>{{ __('letter.nik') }}</th>
                                <th>{{ __('birth.name') }}</th>
                                <th>{{ __('letter.created') }}</th>
                                <th>{{ __('letter.action') }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="verified">
        <div class="card shadow h-100">
            <div class="card-header">
                <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ __('letter.birth') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="verifiedTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>No.</th>
                                <th>{{ __('letter.nik') }}</th>
                                <th>{{ __('birth.name') }}</th>
                                <th>{{ __('letter.created') }}</th>
                                <th>{{ __('letter.updated_at') }}</th>
                                <th>{{ __('letter.status') }}</th>
                                <th>{{ __('letter.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="declined">
        <div class="card shadow h-100">
            <div class="card-header">
                <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ __('letter.birth') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="declinedTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>No.</th>
                                <th>{{ __('letter.nik') }}</th>
                                <th>{{ __('birth.name') }}</th>
                                <th>{{ __('letter.reason_decline') }}</th>
                                <th>{{ __('letter.created') }}</th>
                                <th>{{ __('letter.declined_at') }}</th>
                                @if (auth()->user()->role_id == 2)
                                <th>{{ __('letter.action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- Modal -->
<div class="modal fade" id="userDetailModal" tabindex="-1" role="dialog" aria-labelledby="userDetailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userDetailModalLabel">Detail Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img id="image-profile" src="" class="img-thumbnail mb-3">
                </div>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tbody>
                            <tr><td>{{ __('user.name') }}</td>          <td>:</td><td id="name"></td><td></td></tr>
                            <tr><td>{{ __('user.email') }}</td>         <td>:</td><td id="email"></td><td></td></tr>
                            <tr><td>{{ __('user.nik') }}</td>           <td>:</td><td id="nik"></td><td><a href="" data-toggle="modal" data-target="#detailNIKModal" class="btn btn-sm btn-circle btn-info" data-toggle="tooltip" data-placement="top" title="Lihat detail NIK"><i class="fas fa-eye"></i></a></td></tr>
                            <tr><td>{{ __('user.kk') }}</td>            <td>:</td><td id="kk"></td><td><a href="" data-toggle="modal" data-target="#detailKKModal" class="btn btn-sm btn-circle btn-info" data-toggle="tooltip" data-placement="top" title="Lihat detail KK"><i class="fas fa-eye"></i></a></td></tr>
                            <tr><td>{{ __('user.gender') }}</td>        <td>:</td><td id="gender"></td><td></td></tr>
                            <tr><td>{{ __('user.religion') }}</td>      <td>:</td><td id="religion"></td><td></td></tr>
                            <tr><td>{{ __('user.marital') }}</td>       <td>:</td><td id="marital"></td><td></td></tr>
                            <tr><td>{{ __('user.birth') }}</td>         <td>:</td><td id="birth"></td><td></td></tr>
                            <tr><td>{{ __('user.phone_number') }}</td>  <td>:</td><td id="phone_number"></td><td></td></tr>
                            <tr><td>{{ __('user.address') }}</td>       <td>:</td><td id="address"></td><td></td></tr>
                        </tbody>
                    </table>
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
                <img id="nik_image" class="mw-100" src="" alt="">
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
            <div class="modal-body">
                <div class="text-left">
                    <select onchange="rotateImage('#kk_image',this.value)">
                        <option value="">Putar</option>
                        <option value="90">90</option>
                        <option value="180">180</option>
                        <option value="270">270</option>
                        <option value="360">360</option>
                    </select>
                </div>
                <div class="text-center">
                    <img id="kk_image" class="mw-100" src="" alt="">
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalDetailSP" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Detail Surat Pengantar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-left">
                        <select onchange="rotateImage('#sp_image',this.value)">
                            <option value="">Putar</option>
                            <option value="90">90</option>
                            <option value="180">180</option>
                            <option value="270">270</option>
                            <option value="360">360</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <img id="sp_image" class="mw-100" src="" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

<div id="modalVerification" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('letter.verify') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formVerification" action="" method="post">
                <div class="modal-body">
                    @csrf @method('put')
                    <input id="update" type="hidden" name="update" value="">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <h3>Data Anak</h3>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="">@lang('birth.name')</label>
                                <div class="col-sm-9">
                                    <input id="nama" type="text" class="form-control " name="nama" value="{{ old('nama') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3" for="jenis_kelamin">@lang('birth.gender')</label><br>
                                <div class="col-sm-9">
                                    <div class="custom-control custom-control-inline custom-radio">
                                        <input type="radio" id="jenis_kelamin1" name="jenis_kelamin" class="custom-control-input" value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked="checked"' : '' }}>
                                        <label class="custom-control-label" for="jenis_kelamin1">Laki-laki</label>
                                    </div>
                                    <div class="custom-control custom-control-inline custom-radio">
                                        <input type="radio" id="jenis_kelamin2" name="jenis_kelamin" class="custom-control-input" value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked="checked"' : '' }}>
                                        <label class="custom-control-label" for="jenis_kelamin2">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="">@lang('birth.birth_place')</label>
                                <div class="col-sm-9">
                                    <input id="birth_place" type="text" class="form-control " name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="">@lang('birth.birth_date')</label>
                                <div class="col-sm-9">
                                    <input id="birth_date" type="date" class="form-control " name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="">@lang('birth.religion')</label>
                                <div class="col-sm-9">
                                    <select id="agama" class="form-control" name="agama">
                                        <option value="">Pilih</option>
                                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected="selected"' : '' }}>Islam</option>
                                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected="selected"' : '' }}>Kristen</option>
                                        <option value="Kristen" {{ old('agama') == 'Katolik' ? 'selected="selected"' : '' }}>Katolik</option>
                                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected="selected"' : '' }}>Hindu</option>
                                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected="selected"' : '' }}>Buddha</option>
                                        <option value="Kong Hu Cu" {{ old('agama') == 'Kong Hu Cu' ? 'selected="selected"' : '' }}>Kong Hu Cu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="">@lang('birth.address')</label>
                                <div class="col-sm-9">
                                    <textarea id="alamat" name="alamat" class="form-control " cols="30" rows="2">{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="">@lang('birth.order')</label>
                                <div class="col-sm-9">
                                    <input id="order" type="number" class="form-control " name="anak_ke" value="{{ old('anak_ke') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <h3 id="dataOrtu">Data Orangtua</h3>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="">@lang('birth.name')</label>
                                <div class="col-sm-9">
                                    <input id="name_parent" type="text" class="form-control " name="nama_orangtua" value="{{ old('nama_orangtua') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="">@lang('birth.age')</label>
                                <div class="col-sm-9">
                                    <input id="age" type="number" class="form-control " name="usia_orangtua" value="{{ old('usia_orangtua') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="">@lang('birth.job')</label>
                                <div class="col-sm-9">
                                    <input id="job" type="text" class="form-control " name="pekerjaan_orangtua" value="{{ old('pekerjaan_orangtua') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="">@lang('birth.address')</label>
                                <div class="col-sm-9">
                                    <textarea id="address_parent" name="alamat_orangtua" class="form-control " cols="30" rows="2">{{ old('alamat_orangtua') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="verifikasi">@lang('letter.verify')</label><br>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="verifikasi1" name="verifikasi" class="custom-control-input" value="1">
                                        <label class="custom-control-label" for="verifikasi1">{{ __('letter.accept') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="verifikasi2" name="verifikasi" class="custom-control-input" value="-1">
                                        <label class="custom-control-label" for="verifikasi2">{{__('letter.decline')}}</label>
                                    </div>
                                    @error('verifikasi') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="col-sm-9">
                                    <div id="alasan_penolakan" class="form-group">
                                        <label class="col-form-label">{{ __('letter.reason_decline') }}</label>
                                        <textarea class="form-control" name="alasan_penolakan" rows="2">{{ old('alasan_penolakan') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">{{ __('letter.verify') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $('#unprocessed').show();
    $('#verified').hide();
    $('#declined').hide();
    function rotateImage(image, degree) {
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
    function modalVerification(id, update = false) {
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ route('ajax.get.edit.births') }}",
            method: 'post',
            dataType: 'json',
            data: {
                _token: CSRF_TOKEN,
                id: id
            },
            success: function (data) {
                if (data.gender_parent == 'Perempuan') {
                    $('#dataOrtu').html('Data Orangtua (Istri)');
                } else if (data.gender == 'Laki-laki') {
                    $('#dataOrtu').html('Data Orangtua (Suami)');
                }
                $('#nama').val(data.name);
                $('#nama').attr('disabled','disabled');
                $("input[name=jenis_kelamin][value="+ data.gender +"]").attr('checked','checked');
                $("input[name=jenis_kelamin]").attr('disabled','disabled');
                $('#birth_place').val(data.birth_place);
                $('#birth_place').attr('disabled','disabled');
                $('#birth_date').val(data.birth_date);
                $('#birth_date').attr('disabled','disabled');
                $('#agama').val(data.religion);
                $('#agama').attr('disabled','disabled');
                $('#alamat').val(data.address);
                $('#alamat').attr('disabled','disabled');
                $('#order').val(data.order);
                $('#order').attr('disabled','disabled');
                $('#name_parent').val(data.name_parent);
                $('#name_parent').attr('disabled','disabled');
                $('#age').val(data.age);
                $('#age').attr('disabled','disabled');
                $('#job').val(data.job);
                $('#job').attr('disabled','disabled');
                $('#address_parent').val(data.address_parent);
                $('#address_parent').attr('disabled','disabled');

                @if (auth()->user()->role_id == 3)
                    if (update) {
                        $('#update').val('1');
                    }
                    $('#formVerification').attr('action', "{{ url('/births')}}" + "/" + data.id + "/verify1" );
                @elseif(auth()->user()->role_id == 2)
                    $('#formVerification').attr('action', "{{ url('/births')}}" + "/" + data.id + "/verify2" );
                @endif
                $('#sp_image').attr('src',"{{ url('img/surat_pengantar') }}" + "/" + data.file);
            }
        });
    }

    function viewDetail(id) {
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ route('ajax.get.detail.user') }}",
            method: 'post',
            dataType: 'json',
            data: {
                _token: CSRF_TOKEN,
                id: id
            },
            success: function (data) {
                $('#name').html(data.name);
                $('#email').html(data.email);
                $('#nik').html(data.nik);
                $('#kk').html(data.kk);
                $('#gender').html(data.gender.gender);
                $('#religion').html(data.religion.religion);
                $('#marital').html(data.marital.marital);
                $('#birth').html(data.birth_place+', '+data.birth_date);
                $('#phone_number').html(data.phone_number);
                $('#address').html(data.address);
                $('#image-profile').attr('src',"{{ asset('img/profile') }}"+"/"+data.image);
                $('#image-profile').attr('alt',data.image);
                if (data.kk_file != null && data.kk != null ) {
                    $('#kk_image').attr('src',"{{ asset('img/kk') }}" + "/" + data.kk_file);
                    $('#kk_image').attr('alt',data.kk_file);
                } else{
                    $('#kk_image').attr('src',"{{ asset('img/noimage.jpg') }}");
                }
                if(data.nik_file != null){
                    $('#nik_image').attr('src',"{{ asset('img/nik') }}" + "/" + data.nik_file);
                    $('#nik_image').attr('alt',data.nik_file);
                } else {
                    $('#nik_image').attr('src',"{{ asset('img/noimage.jpg') }}");
                }
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
        $('#btnUnprocessed').on('click',function () {
            $('#btnUnprocessed').attr('class','nav-link active');
            $('#btnVerified').attr('class','nav-link');
            $('#btnDeclined').attr('class','nav-link');
            $('#unprocessed').show();
            $('#verified').hide();
            $('#declined').hide();
        });
        $('#btnVerified').on('click',function () {
            $('#btnUnprocessed').attr('class','nav-link');
            $('#btnVerified').attr('class','nav-link active');
            $('#btnDeclined').attr('class','nav-link');
            $('#unprocessed').hide();
            $('#verified').show();
            $('#declined').hide();
        });
        $('#btnDeclined').on('click',function () {
            $('#btnUnprocessed').attr('class','nav-link');
            $('#btnVerified').attr('class','nav-link');
            $('#btnDeclined').attr('class','nav-link active');
            $('#unprocessed').hide();
            $('#verified').hide();
            $('#declined').show();
        });
        var unprocessedTable = $('#unprocessedTable').DataTable({
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Maaf - Tidak ada yang ditemukan",
                "info": "Tampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data yang tersedia",
                "infoFiltered": "(difilter dari _MAX_ total kolom)",
                "emptyTable": "Tidak ada data di dalam tabel",
                "search": "Cari",
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya"
                }
            },
            "order": [[ 3, "desc" ]],
            processing: true,
            serverside: true,
            @if(auth()->user()->role_id == 3)
            ajax: "{{ route('ajax.get.unprocessed1.births') }}",
            @elseif(auth()->user()->role_id == 2)
            ajax: "{{ route('ajax.get.unprocessed2.births') }}",
            @endif
            columns: [
                {data:null},
                {data:'nik', name:'nik'},
                {data:'name', name:'name'},
                {data:'tanggal_pengajuan', name:'tanggal_pengajuan'},
                {data:'action', name:'action'},
            ],
        });
        unprocessedTable.on( 'order.dt search.dt', function () {
            unprocessedTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            });
        }).draw();
        var verifiedTable = $('#verifiedTable').DataTable({
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Maaf - Tidak ada yang ditemukan",
                "info": "Tampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data yang tersedia",
                "infoFiltered": "(difilter dari _MAX_ total kolom)",
                "emptyTable": "Tidak ada data di dalam tabel",
                "search": "Cari",
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya"
                }
            },
            "order": [[ 3, "desc" ]],
            processing: true,
            serverside: true,
            @if(auth()->user()->role_id == 3)
            ajax: "{{ route('ajax.get.verified1.births') }}",
            @elseif(auth()->user()->role_id == 2)
            ajax: "{{ route('ajax.get.verified2.births') }}",
            @endif
            columns: [
                {data:null},
                {data:'nik', name:'nik'},
                {data:'name', name:'name'},
                {data:'tanggal_pengajuan', name:'tanggal_pengajuan'},
                {data:'tanggal_disetujui', name:'tanggal_disetujui'},
                {data:'status', name:'status'},
                {data:'action', name:'action'},
            ],
        });
        verifiedTable.on( 'order.dt search.dt', function () {
            verifiedTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            });
        }).draw();
        var declinedTable = $('#declinedTable').DataTable({
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Maaf - Tidak ada yang ditemukan",
                "info": "Tampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data yang tersedia",
                "infoFiltered": "(difilter dari _MAX_ total kolom)",
                "emptyTable": "Tidak ada data di dalam tabel",
                "search": "Cari",
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya"
                }
            },
            "order": [[ 3, "desc" ]],
            processing: true,
            serverside: true,
            @if(auth()->user()->role_id == 3)
            ajax: "{{ route('ajax.get.declined1.births') }}",
            @elseif(auth()->user()->role_id == 2)
            ajax: "{{ route('ajax.get.declined2.births') }}",
            @endif
            columns: [
                {data:null},
                {data:'nik', name:'nik'},
                {data:'name', name:'name'},
                @if(auth()->user()->role_id == 3)
                {data:'letter.reason1', name:'letter.reason1'},
                @elseif(auth()->user()->role_id == 2)
                {data:'letter.reason2', name:'letter.reason2'},
                @endif
                {data:'tanggal_pengajuan', name:'tanggal_pengajuan'},
                {data:'tanggal_penolakan', name:'tanggal_penolakan'},
                @if(auth()->user()->role_id == 2)
                {data:'action', name:'action'},
                @endif
            ],
        });
        declinedTable.on( 'order.dt search.dt', function () {
            declinedTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            });
        }).draw();
    });
</script>
@endsection