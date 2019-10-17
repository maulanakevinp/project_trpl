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
        <a class="nav-link" href="{{ route('salary.unprocessed1') }}">{{ __('salary.unprocessed') }}</a>
        <a class="nav-link active" href="">{{ __('salary.verified') }}</a>
        <a class="nav-link" href="{{ route('salary.declined1') }}">{{ __('salary.declined') }}</a>
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
    <div class="card shadow h-100">
        <div class="card-header">
            <h5 class="m-0 pt-1 font-weight-bold text-primary float-left">{{ __('salary.data') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>{{ __('salary.nik') }}</th>
                            <th>{{ __('salary.salary') }}</th>
                            <th>{{ __('salary.reason') }}</th>
                            <th>{{ __('salary.created') }}</th>
                            <th>{{ __('salary.updated_at') }}</th>
                            <th>{{ __('salary.status') }}</th>
                            <th>{{ __('salary.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach($salaries as $salary)
                        <tr>
                            <td><a href="" data-toggle="modal"
                                    data-target="{{'#showUserModal'.$i}}">{{ $salary->user->nik }}</a></td>
                            <td>{{ 'Rp.'.number_format($salary->salary, 2, ',', '.') }}</td>
                            <td>{{ $salary->reason }}</td>
                            <td>{{ $salary->created_at->format('d M Y - H:i:s') }}</td>
                            @if ($salary->letter->verify2 == 1)
                            <td>{{ $salary->letter->updated_at->format('d M Y - H:i:s') }}</td>
                            <td>{{ __('salary.approved') }}</td>
                            @elseif($salary->letter->verify2 == -1)
                            <td>~</td>
                            <td>{{ __('salary.declined') }}</td>
                            @else
                            <td>~</td>
                            <td>{{ __('salary.unprocessed') }}</td>
                            @endif
                            <td>
                                @if ($salary->letter->verify1 == 1 && $salary->letter->verify2 == null || $salary->letter->verify2 == -1)
                                <a href="{{ route('salary.edit-verified1',$salary->id) }}" class="badge badge-warning">{{ __('salary.edit') }}</a>
                                @else
                                <a href="{{ route('salary.download',$salary->id) }}" target="_blank">
                                    <span class="badge badge-success">{{ __('salary.download') }}</span>
                                </a>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="{{'showUserModal'.$i}}" tabindex="-1" role="dialog"
                            aria-labelledby="{{'showUserModalLabel'.$i}}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="{{'showUserModalLabel'.$i}}">
                                            {{ __('salary.detail_user') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="{{ asset('img/profile/' . $salary->user->image) }}"
                                            class="img-thumbnail mb-3" alt="{{ $salary->user->image }}">
                                        <div class="row">
                                            <div class="col-md-4"><label
                                                    class="col-form-label">{{ __('user.name') }}</label></div>
                                            <div class="col-md-8 mb-2"><input class="form-control" type="text" disabled
                                                    value="{{ $salary->user->name }}"></div>
                                            <div class="col-md-4"><label
                                                    class="col-form-label">{{ __('user.email') }}</label></div>
                                            <div class="col-md-8 mb-2"><input class="form-control" type="text" disabled
                                                    value="{{ $salary->user->email }}"></div>
                                            <div class="col-md-4"><label
                                                    class="col-form-label">{{ __('user.nik') }}</label></div>
                                            <div class="col-md-8 mb-2"><input class="form-control" type="text" disabled
                                                    value="{{ $salary->user->nik }}"></div>
                                            <div class="col-md-4"><label
                                                    class="col-form-label">{{ __('user.gender') }}</label></div>
                                            <div class="col-md-8 mb-2"><input class="form-control" type="text" disabled
                                                    value="{{ $salary->user->gender->gender }}"></div>
                                            <div class="col-md-4"><label
                                                    class="col-form-label">{{ __('user.religion') }}</label></div>
                                            <div class="col-md-8 mb-2"><input class="form-control" type="text" disabled
                                                    value="{{ $salary->user->religion->religion }}"></div>
                                            <div class="col-md-4"><label
                                                    class="col-form-label">{{ __('user.marital') }}</label></div>
                                            <div class="col-md-8 mb-2"><input class="form-control" type="text" disabled
                                                    value="{{ $salary->user->marital->marital }}"></div>
                                            <div class="col-md-4"><label
                                                    class="col-form-label">{{ __('user.birth') }}</label></div>
                                            <div class="col-md-8 mb-2"><input class="form-control" type="text" disabled
                                                    value="{{ $salary->user->birth_place .__(', ').date('d-m-Y', strtotime($salary->user->birth_date)) }}">
                                            </div>
                                            <div class="col-md-4"><label
                                                    class="col-form-label">{{ __('user.job') }}</label></div>
                                            <div class="col-md-8 mb-2"><input class="form-control" type="text" disabled
                                                    value="{{ $salary->user->job }}"></div>
                                            <div class="col-md-4"><label
                                                    class="col-form-label">{{ __('user.phone_number') }}</label></div>
                                            <div class="col-md-8 mb-2"><input class="form-control" type="text" disabled
                                                    value="{{ $salary->user->phone_number }}"></div>
                                            <div class="col-md-4"><label
                                                    class="col-form-label">{{ __('user.address') }}</label></div>
                                            <div class="col-md-8 mb-2"><textarea class="form-control" disabled
                                                    rows="3">{{ $salary->user->address }}</textarea></div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">@lang('salary.close')</button>
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