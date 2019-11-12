<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Keterangan Usaha</title>
    <meta http-equiv=Content-Type content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="icon" href="{{ asset('img/logo/logo-pemkab-jember1.png') }}">
    <script type="text/javascript" src="wz_jsgraphics.js"></script>
</head>

<body>
    <div style="margin-top:60px;margin-left:60px;margin-bottom:30px;margin-right:60px">
        <div style="height:100px;width:100%">
            <div style="height:100px;width:90px;float:left" class="">
                <img height="100%" width="100%" src="{{ asset('img/logo/logo-pemkab-jember1.png') }}" alt="">
            </div>
            <div style="position: relative; top: -25px">
                <p class="fs-14 bold text-center">
                    PEMERINTAH KABUPATEN JEMBER <br>
                    KECAMATAN ARJASA <br>
                    DESA ARJASA <br>
                    <span class="fs-11 italic normal">JL. Rengganis Nomor 01 Arjasa Kode Pos : 68191</span>
                </p>
            </div>
            <hr style="position: relative; top:-25px; border-top: 5px double #000000;">
        </div>
        <div style="margin-top:50px">
            <p class="text-center">
                <span class="fs-12 bold underline">SURAT KETERANGAN USAHA</span>
                <br>
                <span class="fs-11">
                    Nomor : 503 / {{ $enterprise->letter->number }} / Ds.2005 /
                    {{ Terbilang::roman(date('m', strtotime($enterprise->letter->updated_at))) }} /
                    {{ date('Y', strtotime($enterprise->letter->updated_at)) }}
                </span>
            </p>
        </div>
        <div style="margin-top:-10px" class="">
            <p class="text-justify text-indent">
                Yang bertanda tangan dibawah ini Kepala Desa Arjasa
                Kecamatan Arjasa Kabupaten Jember, menerangakan bahwa :
            </p>
        </div>
        
        <div>
            <table style="border-style: none; line-height: unset">
                <tbody>
                    <tr><td valign="top">Nama</td>              <td valign="top">:</td><td valign="top">{{ $enterprise->user->name }}</td></tr>
                    <tr><td valign="top">NIK</td>               <td valign="top">:</td><td valign="top">{{ $enterprise->user->nik }}</td></tr>
                    <tr><td valign="top">Tempat/Tgl,lahir</td>  <td valign="top">:</td><td valign="top">{{ $enterprise->user->birth_place .__(', ').date('d-m-Y', strtotime($enterprise->user->birth_date)) }}</td></tr>
                    <tr><td valign="top">Jenis Kelamin</td>     <td valign="top">:</td><td valign="top">{{ $enterprise->user->gender->gender }}</td></tr>
                    <tr><td valign="top">Pekerjaan</td>         <td valign="top">:</td><td valign="top">{{ $enterprise->user->job }}</td></tr>
                    <tr><td valign="top">Alamat</td>            <td valign="top">:</td><td valign="top">{{ $enterprise->user->address.' Kecamatan Arjasa Kabupaten Jember' }}</td></tr>
                </tbody>
            </table>
        </div>
        
        <div style="" class="">
            <p class="text-justify text-indent">
                Adapun nama tersebut diatas, mempunyai usaha <b>"{{ $enterprise->name }}"</b>
                yang terletak di <b>{{ $enterprise->address }}</b>.
                Surat ini dipergunakan untuk persyaratan <b>{{ $enterprise->purpose }}</b>
            </p>
            <p class="text-justify text-indent">
                Demikian surat keterangan ini kami buat dengan
                sebenarnya untuk dipergunakan sebagaimana mestinya.
            </p>
        </div>
        <div style="margin-left:50%; margin-top:-25px" class="text-center">
            <p style="line-height: 1; margin-bottom: 55px">
                Arjasa, {{ date('d M Y', strtotime($enterprise->letter->updated_at)) }} <br>
                Kepala Desa Arjasa
            </p>
            <p style="" class="bold underline">
                {{ $kepala->name }}
            </p>
        </div>
        <img style="position: absolute; top: 600px; right:150px;height: 120px; width:120px" src="{{ asset('img/logo/tanda-tangan.png') }}" alt="">
        <img style="position: absolute; top: 600px; right:220px;height: 120px; width:120px;-ms-transform: rotate(20deg);-webkit-transform: rotate(20deg);transform: rotate(20deg);" src="{{ asset('img/logo/stempel.png') }}" alt="">
    </div>
</body>

</html>