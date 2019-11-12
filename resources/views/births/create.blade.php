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
            <form action="{{ route('births.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('letter.file') }}</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="surat_pengantar">
                            </div>
                        </div>
                        <h3>Data Anak</h3>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="">@lang('birth.name')</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control " name="nama" value="{{ old('nama') }}">
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
                                <input type="text" class="form-control " name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="">@lang('birth.birth_date')</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control " name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="">@lang('birth.religion')</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="agama">
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
                                <textarea name="alamat" class="form-control " cols="30" rows="2">{{ old('alamat') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="">@lang('birth.order')</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control " name="anak_ke" value="{{ old('anak_ke') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        @if (auth()->user()->gender->gender == "Laki-laki")
                            <h3>Data Orangtua (Istri)</h3>
                        @elseif(auth()->user()->gender->gender == "Perempuan")
                            <h3>Data Orangtua (Suami)</h3>
                        @endif
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="">@lang('birth.name')</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control " name="nama_orangtua" value="{{ old('nama_orangtua') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="">@lang('birth.age')</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control " name="usia_orangtua" value="{{ old('usia_orangtua') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="">@lang('birth.job')</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control " name="pekerjaan_orangtua" value="{{ old('pekerjaan_orangtua') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="">@lang('birth.address')</label>
                            <div class="col-sm-9">
                                <textarea name="alamat_orangtua" class="form-control " cols="30" rows="2">{{ old('alamat_orangtua') }}</textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-2">@lang('letter.add')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow h-100">
        <div class="card-header">
            <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ __('letter.birth') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>{{ __('birth.name') }}</th>
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
<div class="modal fade" id="modalEditBirth" tabindex="-1" role="dialog" aria-labelledby="editMenuModalLabel" aria-hidden="true">
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
                        <div class="col-lg-6 mb-3">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ __('letter.file') }}</label> 
                                <div class="col-sm-8">
                                    <input type="file" class="form-control" name="surat_pengantar">
                                </div>
                                <a href="#" class="btn btn-primary btn-sm btn-circle mt-1" data-toggle="modal" data-target="#DetailSuratPengantar" data-toggle="tooltip" title="Lihat surat"><i class="fas fa-eye"></i></a>
                            </div>
                            <h3>Data Anak</h3>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="">@lang('birth.name')</label>
                                <div class="col-sm-9">
                                    <input id="name" type="text" class="form-control " name="nama" value="{{ old('nama') }}">
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
                                    <select id="religion" class="form-control" name="agama">
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
                                    <textarea id="address" name="alamat" class="form-control " cols="30" rows="2">{{ old('alamat') }}</textarea>
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
                            @if (auth()->user()->gender->gender == "Laki-laki")
                            <h3>Data Orangtua (Istri)</h3>
                            @elseif(auth()->user()->gender->gender == "Perempuan")
                            <h3>Data Orangtua (Suami)</h3>
                            @endif
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
            url: "{{ route('ajax.get.edit.births') }}",
            method: 'post',
            dataType: 'json',
            data: {
                _token: CSRF_TOKEN,
                id: id
            },
            success: function (data) {
                $('#name').val(data.name);
                $("input[name=jenis_kelamin][value="+ data.gender +"]").attr('checked','checked');
                $('#birth_place').val(data.birth_place);
                $('#birth_date').val(data.birth_date);
                $('#religion').val(data.religion);
                $('#address').val(data.address);
                $('#order').val(data.order);
                $('#name_parent').val(data.name_parent);
                $('#age').val(data.age);
                $('#job').val(data.job);
                $('#address_parent').val(data.address_parent);
                $('#postModal').attr('action',"{{url('/births')}}"+"/"+data.id);
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
            ajax: "{{ route('ajax.get.births') }}",
            columns: [
                {data:null},
                {data:'name', name:'name'},
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