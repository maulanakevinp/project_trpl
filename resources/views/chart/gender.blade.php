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

@section('chart')
<script>
    Highcharts.chart('grafik', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Grafik Jenis Kelamin'
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.y:f} Jiwa'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:f}</b> Jiwa<br/>'
        },

        series: [
            {
                name: "Jenis Kelamin",
                colorByPoint: true,
                data: [
                    {
                        name: "Laki-laki",
                        y: {{ $data_laki }},
                    },
                    {
                        name: "Perempuan",
                        y: {{ $data_perempuan }},
                    }
                ]
            }
        ]        
    });
</script>
@endsection