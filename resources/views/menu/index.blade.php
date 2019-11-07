@extends('layouts.master')
@section('title')
{{ $title }} - {{ config('app.name') }}
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
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ $title }}</h5>
                    <a href="" class="btn btn-primary btn-sm float-right addMenu" data-toggle="modal"
                        data-target="#newMenuModal">{{ __('menu.add') }}</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('#') }}</th>
                                <th scope="col">{{ __('menu.menu') }}</th>
                                <th scope="col">{{ __('menu.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user_menu as $menu)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $menu->menu }}</td>
                                <td>
                                    <button class="editMenu btn btn-warning btn-circle btn-sm" data-toggle="modal" data-target="#newMenuModal" data-id="{{ $menu->id }}"><i class="fas fa-edit"></i></button>
                                    <form class="d-inline-block" action="{{ route('menu.destroy',$menu->id) }}"
                                        method="POST">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-circle btn-sm " onclick="return confirm('{{__('menu.delete_confirm', ['menu' => $menu->menu])}}');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- Modal -->
<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">{{ __('menu.add') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('menu.store') }}" method="post" id="postMenu">
                @csrf
                <input id="method-menu" type="hidden" name="_method" value="post">

                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu"
                            autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('menu.close')</button>
                    <button type="Submit" class="btn btn-primary" id="submitMenu">@lang('menu.add')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('.editMenu').on('click', function () {
                const id = $(this).data('id');
                const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $('#newMenuModalLabel').html("{{__('menu.edit_menu')}}");
                $('#submitMenu').html("{{__('menu.edit')}}");
                $('#postMenu').attr('action', "{{ url('menu') }}/" + id);
                $('#method-menu').val('patch');
                $.ajax({
                    url: "{{ url('/getMenu') }}",
                    method: 'post',
                    dataType: 'json',
                    data: {
                        _token: CSRF_TOKEN,
                        id: id
                    },
                    success: function (data) {
                        $('#menu').val(data.menu);
                    }
                });
            });
            $('.addMenu').on('click', function () {
                $('#newMenuModalLabel').html("{{__('menu.add')}}");
                $('#submitMenu').html("{{__('menu.add')}}");
                $('#postMenu').attr('action', "{{ route('menu.store') }}");
                $('#method-menu').val('post');
                $('#menu').val('');
            });
        });
    </script>
@endsection