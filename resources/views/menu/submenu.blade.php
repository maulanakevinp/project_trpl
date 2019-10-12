@extends('layouts.master')
@section('title')
{{ $title }} - {{ config('app.name') }}
@endsection
@section('container')
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg">
            @if ($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            @if (session('success'))<div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>@endif
            @if (session('failed'))<div class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('failed') }}<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>@endif
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ $title }}</h5>
                    <a href="" class="btn btn-sm btn-primary float-right addSubMenu" data-toggle="modal" data-target="#newSubMenuModal">{{ __('submenu.add') }}</a>
                    <!-- Modal -->
                    <div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="newSubMenuModalLabel">{{ __('submenu.add') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="postSubMenu" action="{{ route('submenu.store') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="title" name="title" placeholder="@lang('submenu.title')" autocomplete="off">
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
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="icon" name="icon" placeholder="@lang('submenu.icon')">
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
                                            <button type="Submit" class="btn btn-primary" id="submitSubMenu">@lang('submenu.add') </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
                                @php
                                    $i = 1;
                                @endphp
                                @foreach($user_submenu as $submenu)
                                <tr>
                                    <td>{{ $submenu->title }}</td>
                                    <td>{{ $submenu->menu->menu }}</td>
                                    <td>{{ $submenu->url }}</td>
                                    <td>{{ $submenu->icon }}</td>
                                    <td>{{ $submenu->is_active }}</td>
                                    <td>
                                        <a href="" data-toggle="modal" data-target="{{'#editSubMenuModal'.$i}}" ><span class="badge badge-warning">{{ __('submenu.edit') }}</span></a>
                                        <form class="d-inline-block" action="{{ route('submenu.destroy',$submenu->id) }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            @if ($submenu->menu->menu != 'Menu')
                                                <button type="submit" class="badge badge-danger " onclick="return confirm('{{__('submenu.delete_confirm',['submenu' => $submenu->title])}}');">
                                                    {{ __('submenu.delete') }}
                                                </button>
                                            @endif
                                        </form>
                                    </td>

                                    <!-- Modal -->
                                    <div class="modal fade" id="{{'editSubMenuModal'.$i}}" tabindex="-1" role="dialog" aria-labelledby="{{'editSubMenuModalLabel'.$i}}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="{{'editSubMenuModalLabel'.$i}}">{{ __('submenu.edit') }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="postSubMenu" action="{{ route('submenu.update',$submenu->id) }}" method="post">
                                                    @csrf
                                                    @method('patch')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="title">{{ __('submenu.title') }}</label>
                                                            <input type="text" class="form-control" id="title" name="title" value="{{ $submenu->title }}" autocomplete="off">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="menu">{{ __('submenu.menu') }}</label>
                                                            <select name="menu" id="menu" class="form-control">
                                                                <option value="">{{ __('submenu.choose_menu') }}</option>
                                                                @foreach ($user_menu as $menu)
                                                                @if ($submenu->menu_id == $menu->id)
                                                                    <option selected="selected" value="{{ $menu->id }}">{{ $menu->menu }}</option>
                                                                @else
                                                                    <option value="{{ $menu->id }}">{{ $menu->menu }}</option>
                                                                @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="url">{{ __('submenu.url') }}</label>
                                                            <input type="text" class="form-control" id="url" name="url" value="{{ $submenu->url }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="icon">{{ __('submenu.icon') }}</label>
                                                            <input type="text" class="form-control" id="icon" name="icon" value="{{ $submenu->icon }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                @if ($submenu->is_active == 1)
                                                                    <input checked="checked" class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active">
                                                                @else
                                                                    <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active">
                                                                @endif
                                                                <label class="form-check-label" for="is_active">
                                                                    {{ __('submenu.active') }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('submenu.close')</button>
                                                            <button type="Submit" class="btn btn-primary" id="submitSubMenu">@lang('submenu.edit') </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->


@endsection
