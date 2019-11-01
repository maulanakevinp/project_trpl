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
        <a class="nav-link" href="{{ route('incapable.unprocessed2') }}">{{ __('incapable.unprocessed') }}</a>
        <a class="nav-link" href="{{ route('incapable.verified2') }}">{{ __('incapable.verified') }}</a>
        <a class="nav-link active" href="">{{ __('incapable.declined') }}</a>
    </nav>
    @if ($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close"
            data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>@endif
    @if (session('success'))<div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button></div>@endif
    @if (session('failed'))<div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('failed') }}<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button></div>@endif
    <div class="card shadow h-100">
        <div class="card-header">
            <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ __('incapable.data') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>{{ __('incapable.nik') }}</th>
                            <th>{{ __('incapable.reason') }}</th>
                            <th>{{ __('incapable.reason_decline') }}</th>
                            <th>{{ __('incapable.created') }}</th>
                            <th>{{ __('incapable.declined_at') }}</th>
                            <th>{{ __('incapable.action') }}</th>
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

@endsection
@section('script')
<script>
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
            "order": [[ 3, "desc" ]],
            processing: true,
            serverside: true,
            ajax: "{{ route('ajax.get.declined2.incapable') }}",
            columns: [
                {data:'user.nik', name:'user.nik'},
                {data:'reason', name:'reason'},
                {data:'letter.reason2', name:'letter.reason2'},
                {data:'tanggal_pengajuan', name:'tanggal_pengajuan'},
                {data:'tanggal_penolakan', name:'tanggal_penolakan'},
                {data:'action', name:'action'},
            ],
        });
    });
</script>
@endsection