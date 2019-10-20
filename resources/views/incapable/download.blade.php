<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Keterangan Tidak Mampu</title>
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
                <span class="fs-12 bold underline">SURAT KETERANGAN TIDAK MAMPU</span>
                <br>
                <span class="fs-11">
                    Nomor : 140 / {{ $incapable->letter->number }} / 22.2003 /
                    {{ Terbilang::roman(date('m', strtotime($incapable->letter->updated_at))) }} /
                    {{ date('Y', strtotime($incapable->letter->updated_at)) }}
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
                    <tr><td valign="top">Nama</td>              <td valign="top">:</td><td valign="top" class="bold">{{ $incapable->user->name }}</td></tr>
                    <tr><td valign="top">Tempat/Tgl,lahir</td>  <td valign="top">:</td><td valign="top">{{ $incapable->user->birth_place .__(', ').date('d-m-Y', strtotime($incapable->user->birth_date)) }}</td></tr>
                    <tr><td valign="top">Pekerjaan</td>         <td valign="top">:</td><td valign="top">{{ $incapable->user->job }}</td></tr>
                    <tr><td valign="top">Alamat</td>            <td valign="top">:</td><td valign="top">{{ $incapable->user->address.' Kecamatan Arjasa Kabupaten Jember' }}</td></tr>
                </tbody>
            </table>
            @if ($incapable->as == 2)
                <p>
                    Adalah benar-benar Orangtua/Wali dari :
                </p>
            @else
                <p>
                    Adalah benar-benar Anak dari :
                </p>
            @endif
            <table style="border-style: none; line-height: unset">
                <tbody>
                    <tr>
                        <td valign="top">Nama</td>
                        <td valign="top">:</td>
                        <td valign="top" class="bold">{{ $incapable->name }}</td>
                    </tr>
                    <tr>
                        <td valign="top">Tempat/Tgl,lahir</td>
                        <td valign="top">:</td>
                        <td valign="top">
                            {{ $incapable->birth_place .__(', ').date('d-m-Y', strtotime($incapable->birth_date)) }}</td>
                    </tr>
                    <tr>
                        <td valign="top">Pekerjaan</td>
                        <td valign="top">:</td>
                        <td valign="top">{{ $incapable->job }}</td>
                    </tr>
                    <tr>
                        <td valign="top">Alamat</td>
                        <td valign="top">:</td>
                        <td valign="top">{{ $incapable->address.' Kecamatan Arjasa Kabupaten Jember' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div style="" class="">
            <p class="text-justify text-indent">
                Adalah benar-benar penduduk Desa Arjasa Kecamatan Arjasa Kabupaten Jember yang berdomisili dialamat tersebut diatas dan
                orang tersebut diatas benar-benar tergolong masyarakat Kurang/Tidak mampu. Selanjutnya kami terangkan bahwa surat
                keterangan ini dipergunakan {{ $incapable->reason }}
            </p>
            <p class="text-justify text-indent">
                Demikian surat keterangan ini kami buat dengan
                sebenarnya untuk dipergunakan sebagaimana mestinya.
            </p>
        </div>
        <div style="margin-left:50%; margin-top:-25px" class="text-center">
            <p style="line-height: 1; margin-bottom: 55px">
                Arjasa, {{ date('d M Y', strtotime($incapable->letter->updated_at)) }} <br>
                Kepala Desa Arjasa
            </p>
            <p style="" class="bold underline">
                {{ $kepala->name }}
            </p>
            <img style="position: absolute; top: 795px; right:150px;height: 120px; width:120px" src="{{ asset('img/logo/tanda-tangan.png') }}" alt="">
            <img style="position: absolute; top: 760px; right:220px;height: 120px; width:120px;-ms-transform: rotate(20deg);-webkit-transform: rotate(20deg);transform: rotate(20deg);" src="{{ asset('img/logo/stempel.png') }}" alt="">
        </div>
    </div>
</body>

</html>