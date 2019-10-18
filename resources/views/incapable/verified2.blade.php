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
        <a class="nav-link active" href="">{{ __('incapable.verified') }}</a>
        <a class="nav-link" href="{{ route('incapable.declined2') }}">{{ __('incapable.declined') }}</a>
    </nav>
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
                            <th>{{ __('incapable.created') }}</th>
                            <th>{{ __('incapable.updated_at') }}</th>
                            <th>{{ __('incapable.status') }}</th>
                            <th>{{ __('incapable.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach($incapables as $incapable)
                        <tr>
                            <td>
                                <a href="" data-toggle="modal" data-target="{{'#showUserModal'.$i}}">
                                    {{ $incapable->user->nik }}
                                </a>
                            </td>
                            <td>{{ $incapable->reason }}</td>
                            <td>{{ $incapable->created_at->format('d M Y - H:i:s') }}</td>
                            @if ($incapable->letter->verify2 == 1)
                            <td>{{ $incapable->letter->updated_at->format('d M Y - H:i:s') }}</td>
                            <td>{{ __('incapable.approved') }}</td>
                            @elseif($incapable->letter->verify2 == -1)
                            <td>~</td>
                            <td>{{ __('incapable.declined') }}</td>
                            @else
                            <td>~</td>
                            <td>~</td>
                            @endif
                            <td>
                                <a href="{{ route('incapable.download',$incapable->id) }}" target="_blank">
                                    <span class="badge badge-success">{{ __('incapable.download') }}</span>
                                </a>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="{{'showUserModal'.$i}}" tabindex="-1" role="dialog"
                            aria-labelledby="{{'showUserModalLabel'.$i}}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="{{'showUserModalLabel'.$i}}">
                                            {{ __('incapable.detail_user') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="{{ asset('img/profile/' . $incapable->user->image) }}"
                                            class="img-thumbnail mb-3" alt="{{ $incapable->user->image }}">
                                        <div class="row">
                                            <div class="col-md-4"><label
                                                    class="col-form-label">{{ __('user.name') }}</label></div>
                                            <div class="col-md-8 mb-2"><input class="form-control" type="text" disabled
                                                    value="{{ $incapable->user->name }}"></div>
                                            <div class="col-md-4"><label
                                                    class="col-form-label">{{ __('user.email') }}</label></div>
                                            <div class="col-md-8 mb-2"><input class="form-control" type="text" disabled
                                                    value="{{ $incapable->user->email }}"></div>
                                            <div class="col-md-4"><label
                                                    class="col-form-label">{{ __('user.nik') }}</label></div>
                                            <div class="col-md-8 mb-2"><input class="form-control" type="text" disabled
                                                    value="{{ $incapable->user->nik }}"></div>
                                            <div class="col-md-4"><label
                                                    class="col-form-label">{{ __('user.gender') }}</label></div>
                                            <div class="col-md-8 mb-2"><input class="form-control" type="text" disabled
                                                    value="{{ $incapable->user->gender->gender }}"></div>
                                            <div class="col-md-4"><label
                                                    class="col-form-label">{{ __('user.religion') }}</label></div>
                                            <div class="col-md-8 mb-2"><input class="form-control" type="text" disabled
                                                    value="{{ $incapable->user->religion->religion }}"></div>
                                            <div class="col-md-4"><label
                                                    class="col-form-label">{{ __('user.marital') }}</label></div>
                                            <div class="col-md-8 mb-2"><input class="form-control" type="text" disabled
                                                    value="{{ $incapable->user->marital->marital }}"></div>
                                            <div class="col-md-4"><label
                                                    class="col-form-label">{{ __('user.birth') }}</label></div>
                                            <div class="col-md-8 mb-2"><input class="form-control" type="text" disabled
                                                    value="{{ $incapable->user->birth_place .__(', ').date('d-m-Y', strtotime($incapable->user->birth_date)) }}">
                                            </div>
                                            <div class="col-md-4"><label
                                                    class="col-form-label">{{ __('user.job') }}</label></div>
                                            <div class="col-md-8 mb-2"><input class="form-control" type="text" disabled
                                                    value="{{ $incapable->user->job }}"></div>
                                            <div class="col-md-4"><label
                                                    class="col-form-label">{{ __('user.phone_number') }}</label></div>
                                            <div class="col-md-8 mb-2"><input class="form-control" type="text" disabled
                                                    value="{{ $incapable->user->phone_number }}"></div>
                                            <div class="col-md-4"><label
                                                    class="col-form-label">{{ __('user.address') }}</label></div>
                                            <div class="col-md-8 mb-2"><textarea class="form-control" disabled
                                                    rows="3">{{ $incapable->user->address }}</textarea></div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">@lang('incapable.close')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
<!-- /.container-fluid -->

@endsection