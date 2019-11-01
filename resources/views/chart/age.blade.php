@extends('layouts.master')
@section('title')
{{$title}} - {{config('app.name')}}
@endsection
@section('container')
<div class="container-fluid">
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('failed'))
    <div class="alert alert-danger">
        {{ session('failed') }}
    </div>
    @endif

    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div id="grafik"></div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    Highcharts.chart('grafik', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafik Usia'
            },
            xAxis: {
                categories: {!! json_encode($categories) !!},
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Penduduk'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Jumlah Penduduk',
                data: {!! json_encode($data) !!}
            }]
        });
</script>
@endsection