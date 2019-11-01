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
            <form action="{{ route('salary.store') }}" method="post">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="">@lang('salary.salary')</label>
                    <div class="col-sm-4">
                        <input id="penghasilan" type="text" class="form-control " name="penghasilan"
                            value="{{ old('penghasilan') }}">
                        @error('penghasilan')<span class="invalid-feedback"
                            role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="">@lang('salary.reason')</label>
                    <div class="col-sm-10">
                        <textarea name="alasan_pengajuan" id="alasan_pengujian" class="form-control " cols="30"
                            rows="5">{{ old('alasan_pengajuan') }}</textarea>
                        @error('alasan_pengajuan')<span class="invalid-feedback"
                            role="alert"><strong>{{ $message }}</strong></span>@enderror
                        <button type="submit" class="btn btn-primary btn-block mt-2">
                            @lang('salary.add')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow h-100">
        <div class="card-header">
            <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ __('salary.data') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>{{ __('salary.salary') }}</th>
                            <th>{{ __('salary.reason') }}</th>
                            <th>{{ __('salary.created') }}</th>
                            <th>{{ __('salary.updated_at') }}</th>
                            <th>{{ __('salary.status') }}</th>
                            <th>{{ __('salary.action') }}</th>
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
<div class="modal fade" id="editSubmissionModal" tabindex="-1" role="dialog"
    aria-labelledby="editMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMenuModalLabel">
                    {{ __('salary.edit_salary') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="postModal" action="" method="post">
                @csrf
                @method('patch')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label" for="">@lang('salary.salary')</label>
                        <input id="penghasilanEdit" type="text" class="form-control" name="penghasilan" value="{{ old('penghasilan') }}">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="">@lang('salary.reason')</label>
                        <textarea name="alasan_pengajuan" id="alasan_pengajuan" class="form-control" cols="30" rows="5">{{ old('alasan_pengajuan') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('salary.close')</button>
                    <button type="Submit" class="btn btn-primary" id="submitMenu">@lang('salary.edit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    function editModal(id) {
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ route('ajax.get.edit.salary') }}",
            method: 'post',
            dataType: 'json',
            data: {
                _token: CSRF_TOKEN,
                id: id
            },
            success: function (data) {
                $('#penghasilanEdit').val(data.salary);
                $('#alasan_pengajuan').html(data.reason);
                $('#postModal').attr('action',"{{url('/salary')}}"+"/"+data.id);
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
            "order": [[ 2, "desc" ]],
            processing: true,
            serverside: true,
            ajax: "{{ route('ajax.get.salary') }}",
            columns: [
                {data:'salary', name:'salary'},
                {data:'reason', name:'reason'},
                {data:'tanggal_pengajuan', name:'tanggal_pengajuan'},
                {data:'tanggal_disetujui', name:'tanggal_disetujui'},
                {data:'status', name:'status'},
                {data:'action', name:'action'},
            ],
        });
    });
</script>
@endsection