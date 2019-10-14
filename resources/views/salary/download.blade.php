<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Keterangan Penghasilan</title>
    <meta http-equiv=Content-Type content="text/html; charset=UTF-8">
    <style type="text/css">
    <!--
    span.cls_004{font-family:Times,serif;font-size:14;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
    div.cls_004{font-family:Times,serif;font-size:14;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
    span.cls_005{font-family:Times,serif;font-size:11;color:rgb(0,0,0);font-weight:normal;font-style:italic;text-decoration: none}
    div.cls_005{font-family:Times,serif;font-size:11;color:rgb(0,0,0);font-weight:normal;font-style:italic;text-decoration: none}
    span.cls_006{font-family:Times,serif;font-size:14;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: underline}
    div.cls_006{font-family:Times,serif;font-size:14;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
    span.cls_007{font-family:Times,serif;font-size:11;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
    div.cls_007{font-family:Times,serif;font-size:11;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
    span.cls_008{font-family:Times,serif;font-size:11;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
    div.cls_008{font-family:Times,serif;font-size:11;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
    span.cls_009{font-family:Times,serif;font-size:12;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
    div.cls_009{font-family:Times,serif;font-size:12;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
    span.cls_010{font-family:Times,serif;font-size:11;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: underline}
    div.cls_010{font-family:Times,serif;font-size:11;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
    span.cls_011{font-family:Times,serif;font-size:9;color:rgb(0,0,0);font-weight:normal;font-style:italic;text-decoration: none}
    div.cls_011{font-family:Times,serif;font-size:9;color:rgb(0,0,0);font-weight:normal;font-style:italic;text-decoration: none}
    span.cls_012{font-family:Times,serif;font-size:12;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: underline}
    div.cls_012{font-family:Times,serif;font-size:12;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
    span.cls_013{font-family:Times,serif;font-size:9;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
    div.cls_013{font-family:Times,serif;font-size:9;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
    -->
    </style>
    <link rel="icon" href="{{ asset('img/logo/logo-pemkab-jember1.png') }}">

    <script type="text/javascript" src="wz_jsgraphics.js"></script>
</head>
<body>
    <div style="position:absolute;left:50%;margin-left:-320px;top:0px;width:793.7107869076px;height:1122.533827198px;overflow:hidden">
    <div style="position:absolute;left:60px;top:63px" class="cls_004"><img style="height: 78px; width:75px" src="{{ asset('img/logo/logo-pemkab-jember1.png') }}" alt=""></div>
    <div style="position:absolute;left:180.24px;top:58.32px" class="cls_004"><span class="cls_004">PEMERINTAH KABUPATEN JEMBER</span></div>
    <div style="position:absolute;left:253.68px;top:80.80px" class="cls_004"><span class="cls_004">KECAMATAN ARJASA</span></div>
    <div style="position:absolute;left:282.00px;top:103.52px" class="cls_004"><span class="cls_004">DESA ARJASA</span></div>
    <div style="position:absolute;left:190.20px;top:127.64px" class="cls_005"><span class="cls_005">JL. Rengganis Nomor 01 Arjasa Kode Pos : 68191</span></div>
    <div style="position:absolute;left:-140px;top:150.64px;"><hr width="540px"></div>
    <div style="position:absolute;left:213.60px;top:181.12px" class="cls_006"><span class="cls_006">SURAT KETERANGAN</span></div>
    <div style="position:absolute;left:205.36px;top:201.92px" class="cls_007"><span class="cls_007">Nomor : 140 / {{ $salary->id }} / 22.2003 / {{ Terbilang::roman(date('m', strtotime($salary->updated_at))) }} / {{ date('Y', strtotime($salary->updated_at)) }}</span></div>
    <div style="position:absolute;left:136.80px;top:240.32px" class="cls_008"><span class="cls_008">Yang bertanda tangan dibawah ini Kepala Desa Arjasa Kecamatan Arjasa</span></div>
    <div style="position:absolute;left:67.68px;top:260.92px" class="cls_008"><span class="cls_008">Kabupaten Jember,menerangakan bahwa :</span></div>
    <div style="position:absolute;left:67.20px;top:292.84px" class="cls_008"><span class="cls_008">Nama</span></div>
    <div style="position:absolute;left:200.40px;top:292.84px" class="cls_009"><span class="cls_009">: {{ $salary->user->name }}</span></div>
    <div style="position:absolute;left:67.68px;top:318.92px" class="cls_008"><span class="cls_008">Jenis Kelamin</span></div>
    <div style="position:absolute;left:200.40px;top:318.92px" class="cls_008"><span class="cls_008">: {{ $salary->user->gender->gender }}</span></div>
    <div style="position:absolute;left:67.68px;top:344.52px" class="cls_008"><span class="cls_008">Tempat/Tgl,lahir</span></div>
    <div style="position:absolute;left:200.40px;top:344.52px" class="cls_008"><span class="cls_008">: {{ $salary->user->birth_place .__(', ').date('d-m-Y', strtotime($salary->user->birth_date)) }}</span></div>
    <div style="position:absolute;left:67.68px;top:370.60px" class="cls_008"><span class="cls_008">Agama</span></div>
    <div style="position:absolute;left:200.40px;top:370.60px" class="cls_008"><span class="cls_008">: {{ $salary->user->religion->religion }}</span></div>
    <div style="position:absolute;left:67.92px;top:400.20px" class="cls_008"><span class="cls_008">Status Perkawinan</span></div>
    <div style="position:absolute;left:200.40px;top:400.20px" class="cls_008"><span class="cls_008">: {{ $salary->user->marital->marital }}</span></div>
    <div style="position:absolute;left:67.20px;top:430.28px" class="cls_008"><span class="cls_008">Pekerjaan</span></div>
    <div style="position:absolute;left:200.40px;top:430.28px" class="cls_008"><span class="cls_008">: {{ $salary->user->job }}</span></div>
    <div style="position:absolute;left:67.92px;top:460.88px" class="cls_008"><span class="cls_008">Alamat</span></div>
    <div style="position:absolute;left:200.40px;top:460.88px" class="cls_008"><span class="cls_008">: {{ $salary->user->address }}</span></div>
    <div style="position:absolute;left:208.40px;top:480.04px" class="cls_008"><span class="cls_008">Kecamatan Arjasa Kabupaten Jember.</span></div>
    <div style="position:absolute;left:136.32px;top:527.88px" class="cls_008"><span class="cls_008">Adalah benar-benar penduduk Desa Arjasa Kecamatan Arjasa Kabupaten Jember</span></div>
    <div style="position:absolute;left:67.68px;top:548.72px" class="cls_008"><span class="cls_008">yang berdomisili dialamat tersebut diatas.</span></div>
    <div style="position:absolute;left:67.92px;top:569.32px" class="cls_008"><span class="cls_008">Selanjutnya kami terangkan bahwa orang tersebut benar-benar mempunyai penghasilan</span></div>
    <div style="position:absolute;left:67.20px;top:590.40px" class="cls_010"><span class="cls_010">Rp. {{ number_format($salary->salary, 2, ',', '.') }} / Bulan ( {{ ucwords(Terbilang::make($salary->salary)) }} Rupiah perBulan ). </span></div>
    <div style="position:absolute;left:136.08px;top:627.08px" class="cls_008"><span class="cls_008">Demikian surat keterangan ini kami buat dengan sebenarnya untuk dipergunakan</span></div>
    <div style="position:absolute;left:67.68px;top:649.16px" class="cls_008"><span class="cls_008">sebagaimana mestinya.</span></div>
    <div style="position:absolute;left:398.88px;top:690.92px" class="cls_008"><span class="cls_008">Arjasa, {{ date('d M Y', strtotime(now())) }}</span></div>
    <div style="position:absolute;left:398.88px;top:710.60px" class="cls_008"><span class="cls_008">Kepala Desa Arjasa</span></div>
    <div style="position:absolute;left:398.88px;top:720.60px" class="cls_004"><img style="height: 100px; width:120px" src="{{ asset('img/logo/tanda-tangan.png') }}" alt=""></div>
    <div style="position:absolute;left:398.88px;top:780.60px;" class="cls_006"><span class="cls_006">{{ $kepala->name }}</span></div>
    <div style="position:absolute;left:320.88px;top:680.60px;-ms-transform: rotate(20deg);-webkit-transform: rotate(20deg);transform: rotate(20deg);" class="cls_004"><img style="height: 120px; width:120px" src="{{ asset('img/logo/stempel.png') }}" alt=""></div>
</body>
</html>