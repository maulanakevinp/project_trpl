@extends('layouts.master')
@section('title')
{{ $title }} - {{ config('app.name') }}
@endsection
@section('container')
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg">
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
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ $title }}</h5>
                    <a href="" class="btn btn-sm btn-primary float-right addSubmenu" data-toggle="modal" data-target="#newSubmenuModal">{{ __('submenu.add') }}</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('submenu.title') }}</th>
                                    <th>{{ __('submenu.menu') }}</th>
                                    <th>{{ __('submenu.url') }}</th>
                                    <th>{{ __('submenu.icon') }}</th>
                                    <th>{{ __('submenu.active') }}</th>
                                    <th>{{ __('submenu.action') }}</th>
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

</div>
<!-- /.container-fluid -->

<!-- Modal -->
<div class="modal fade" id="newSubmenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubmenuModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubmenuModalLabel">{{ __('submenu.add') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="postSubmenu" action="{{ route('submenu.store') }}" method="post">
                @csrf
                <input id="method-submenu" type="hidden" name="_method" value="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" name="submenu"
                            placeholder="@lang('submenu.title')" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <select name="menu" id="menu" class="form-control">
                            <option value="">{{ __('submenu.choose_menu') }}</option>
                            @foreach ($user_menu as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->menu }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="url" name="url" placeholder="@lang('submenu.url')">
                    </div>
                    <div class="form-group row">
                        <div class="col-11">
                            <input onkeyup="iconChange()" type="text" class="form-control" id="icon" name="icon" placeholder="@lang('submenu.icon')">
                        </div>
                        <div class="col-1 p-2">
                            <i id="icon-change"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active">
                            <label class="form-check-label" for="is_active">
                                {{ __('submenu.active') }}
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('submenu.close')</button>
                        <button type="Submit" class="btn btn-primary" id="submitSubmenu">@lang('submenu.add') </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    function iconChange() {
        $('#icon-change').attr('class',$('#icon').val());
    }
    function editSubmenu(id) {
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#newSubmenuModalLabel').html("{{__('submenu.edit_menu')}}");
        $('#submitSubmenu').html("{{__('submenu.edit')}}");
        $('#postSubmenu').attr('action', "{{ url('submenu') }}/" + id);
        $('#method-submenu').val('patch');
        $.ajax({
            url: "{{ route('ajax.get.edit.submenu') }}",
            method: 'post',
            dataType: 'json',
            data: {
                _token: CSRF_TOKEN,
                id: id
            },
            success: function (data) {
                $('#title').val(data.title);
                $('#menu').val(data.menu_id);
                $('#url').val(data.url);
                $('#icon').val(data.icon);
                if (data.is_active == 1) {
                    $('#is_active').attr('checked',true);
                } else {
                    $('#is_active').attr('checked',false);
                }
                $('#delete-submenu').show().attr('action',"{{ url('/submenu') }}" + "/" + data.id);
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
            ajax: "{{ route('ajax.get.submenu') }}",
            columns: [
                {data: 'title',name: 'title' },
                {data: 'menu.menu', name: 'menu.menu'},
                {data: 'url',name: 'url'},
                {data: 'icon', name: 'icon'},
                {data: 'is_active', name: 'is_active'},
                {data: 'action', name: 'action'},
            ],
        });
        $('.addSubmenu').on('click', function () {
            console.log('tes');
            $('#newSubmenuModalLabel').html("{{__('submenu.add')}}");
            $('#submitSubmenu').html("{{__('submenu.add')}}");
            $('#postSubmenu').attr('action', "{{ route('submenu.store') }}");
            $('#method-submenu').val('post');
            $('#title').val('');
            $('#menu').val('');
            $('#url').val('');
            $('#icon').val('');
            $('#is_active').attr('checked', false);
            $('#delete-submenu').hide();
        });
    });
</script>
@endsection