@extends('layouts.master')
@section('title')
{{ $title }} - {{ config('app.name') }}
@endsection
@section('container')
<!-- Begin Page Content -->
<div class="container-fluid">
    @if ($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <div class="card shadow mb-4">
        <div class="card-header py-3 ">
            <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ $title }}</h5>
            <div class="btn-group float-right">
                <a href="{{route('users.trash')}}" class="btn btn-sm btn-warning">{{ __('user.trash') }}</a>
                <a href="{{route('users.create')}}" class="btn btn-sm btn-primary">{{ __('user.add') }}</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>{{__('user.nik')}}</th>
                            <th>{{__('user.name')}}</th>
                            <th>{{__('user.role')}}</th>
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
            processing: true,
            serverside: true,
            ajax: "{{ route('ajax.get.user') }}",
            columns: [
                { data: 'nik', name: 'nik' },
                { data: 'name', name: 'name' },
                { data: 'role.role', name: 'role.role' },
                { data: 'action', name: 'action' },
            ],
        });
    });
</script>
@endsection