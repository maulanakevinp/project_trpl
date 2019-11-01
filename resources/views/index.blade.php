@extends('layouts.master')
@section('title')
{{ $title }} - {{ config('app.name') }}
@endsection
@section('container')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Jumlah Penduduk Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Penduduk</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jumlah Penduduk Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Surat Disetujui</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $letters_approved }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jumlah Penduduk Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Surat Tidak Disetujui</div>
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $letters_declined }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Jumlah Surat Belum Diproses</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $unprocessed }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-mail-bulk fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 ">
            <h5 class="m-0 pt-1 font-weight-bold text-primary">Data Penduduk</h5>
        </div>

        <!-- Content Row -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>{{__('user.nik')}}</th>
                            <th>{{__('user.name')}}</th>
                            <th>{{__('user.gender')}}</th>
                            <th>{{__('user.age')}}</th>
                            <th>{{__('user.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
        $('#dataTable').DataTable({
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
            processing: true,
            serverside: true,
            ajax: "{{ route('ajax.get.users') }}",
            columns: [
                { data: 'nik', name: 'nik' },
                { data: 'name', name: 'name' },
                { data: 'gender.gender', name: 'gender.gender' },
                { data: 'usia', name: 'usia' },
                { data: 'action', name: 'action' },
            ],
        });
    });
</script>
@endsection