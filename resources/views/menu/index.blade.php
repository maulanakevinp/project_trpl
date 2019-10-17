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
    <div class="row">
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
                                    <a class="editMenu" href="" data-toggle="modal" data-target="#newMenuModal"
                                        data-id="{{ $menu->id }}"><span
                                            class="badge badge-success">{{ __('menu.edit') }}</span></a>
                                    <form class="d-inline-block" action="{{ route('menu.destroy',$menu->id) }}"
                                        method="POST">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="badge badge-danger "
                                            onclick="return confirm('{{__('menu.delete_confirm')}}');">
                                            {{ __('menu.delete') }}
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