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
    <div class="card shadow h-100 mb-3">
        <div class="card-header">
            <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ $subtitle }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('incapables.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('letter.file') }}</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="surat_pengantar">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="">@lang('incapable.name')</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control " name="nama" value="{{ old('nama') }}">
                                @error('nama')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="">@lang('incapable.birth_place')</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control " name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                                @error('tempat_lahir')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="">@lang('incapable.birth_date')</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control " name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                @error('tanggal_lahir')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="">@lang('incapable.job')</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control " name="pekerjaan" value="{{ old('pekerjaan') }}">
                                @error('pekerjaan')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="">@lang('incapable.address')</label>
                            <div class="col-sm-9">
                                <textarea name="alamat" class="form-control " cols="30" rows="2">{{ old('alamat') }}</textarea>
                                @error('alamat')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="">{{ __('letter.purpose') }}</label>
                            <div class="col-sm-9">
                                <textarea id="tujuan" type="text" class="form-control " name="tujuan" rows="2">{{ old('tujuan') }}</textarea>
                                @error('tujuan')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                        <div class="form-group">
                            Adalah benar-benar merupakan
                            <select class="form-control-sm" name="merupakan" >
                                <option value="">Pilih</option>
                                <option value="1">Orangtua/Wali saya</option>
                                <option value="2">Anak saya</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-2">@lang('letter.add')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow h-100">
        <div class="card-header">
            <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ __('letter.incapable') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>{{ __('letter.purpose') }}</th>
                            <th>{{ __('letter.created') }}</th>
                            <th>{{ __('letter.updated_at') }}</th>
                            <th>{{ __('letter.status') }}</th>
                            <th>{{ __('letter.action') }}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- Modal -->
<div class="modal fade" id="modalEditIncapable" tabindex="-1" role="dialog" aria-labelledby="editMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMenuModalLabel">
                    {{ __('letter.edit_letter') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="postModal" action="" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ __('letter.file') }}</label> 
                                <div class="col-sm-8">
                                    <input type="file" class="form-control" name="surat_pengantar">
                                </div>
                                <a href="#" class="btn btn-primary btn-sm btn-circle mt-1" data-toggle="modal" data-target="#DetailSuratPengantar" data-toggle="tooltip" title="Lihat surat"><i class="fas fa-eye"></i></a>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="">@lang('incapable.name')</label>
                                <div class="col-sm-9">
                                    <input id="nameEdit" type="text" class="form-control " name="nama" value="{{ old('nama') }}">
                                    @error('nama')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="">@lang('incapable.birth_place')</label>
                                <div class="col-sm-9">
                                    <input id="birth_placeEdit" type="text" class="form-control " name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                                    @error('tempat_lahir')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="">@lang('incapable.birth_date')</label>
                                <div class="col-sm-9">
                                    <input id="birth_dateEdit" type="date" class="form-control " name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                    @error('tanggal_lahir')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="">@lang('incapable.job')</label>
                                <div class="col-sm-9">
                                    <input id="jobEdit" type="text" class="form-control " name="pekerjaan" value="{{ old('pekerjaan') }}">
                                    @error('pekerjaan')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="">@lang('incapable.address')</label>
                                <div class="col-sm-9">
                                    <textarea id="addressEdit"  name="alamat" class="form-control " cols="30" rows="2">{{ old('alamat') }}</textarea>
                                    @error('alamat')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="">{{ __('letter.purpose') }}</label>
                                <div class="col-sm-9">
                                    <textarea id="purposeEdit" type="text" class="form-control " name="tujuan" rows="2">{{ old('tujuan') }}</textarea>
                                    @error('tujuan')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>
                            <div class="form-group">
                                Adalah benar-benar merupakan
                                <select id="asEdit" class="form-control-sm" name="merupakan" >
                                    <option value="">Pilih</option>
                                    <option value="1" {{ old('merupakan') == 1 ? 'selected="selected"' : '' }}>Orangtua/Wali saya</option>
                                    <option value="2" {{ old('merupakan') == 2 ? 'selected="selected"' : '' }}>Anak saya</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('letter.close')</button>
                    <button type="Submit" class="btn btn-primary" id="submitMenu">@lang('letter.edit')</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="DetailSuratPengantar" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
@endsection
@section('script')
<script>
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
    function editModal(id) {
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ route('ajax.get.edit.incapables') }}",
            method: 'post',
            dataType: 'json',
            data: {
                _token: CSRF_TOKEN,
                id: id
            },
            success: function (data) {
                $('#nameEdit').val(data.name);
                $('#birth_placeEdit').val(data.birth_place);
                $('#birth_dateEdit').val(data.birth_date);
                $('#jobEdit').val(data.job);
                $('#addressEdit').val(data.address);
                $('#asEdit').val(data.as);
                $('#purposeEdit').val(data.purpose);
                $('#postModal').attr('action',"{{url('/incapables')}}"+"/"+data.id);
                $('#sp_image').attr('src',"{{ url('img/surat_pengantar') }}" + "/" + data.file);
            }
        });
    }
    $(document).ready(function () {
        var t = $('#dataTable').DataTable({
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
            "order": [[ 2, "desc" ]],
            processing: true,
            serverside: true,
            ajax: "{{ route('ajax.get.incapables') }}",
            columns: [
                {data:null},
                {data:'purpose', name:'purpose'},
                {data:'tanggal_pengajuan', name:'tanggal_pengajuan'},
                {data:'tanggal_disetujui', name:'tanggal_disetujui'},
                {data:'status', name:'status'},
                {data:'action', name:'action'},
            ],
        });
        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            });
        }).draw();
    });
</script>
@endsection