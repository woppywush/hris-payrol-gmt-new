<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Slip Gaji - {{ $rekapslip[0]["tanggal_proses_akhir"] }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/bootstrap/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/bootstrap/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/dist/css/AdminLTE.min.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body onload="window.print();">
    <div class="wrapper">
      @foreach ($rekapslip as $slip)
      <section class="invoice">
        <table sytle="border-collapse: collapse; border: 1px solid black; text-align:right;float:right;" width="100%">
          <tr>
            <td style="text-align:right;color: #000000;font-size: 12px;">PT. GANDA MADY INDOTAMA</td>
          </tr>
          <tr>
            <td style="text-align:right;color: #000000;font-size: 9px;">Royal Palace A - 6, Jalan DR. Soepomo</td>
          </tr>
          <tr>
            <td style="text-align:right;color: #000000;font-size: 9px;">Tebet Barat, Tebet, Kota Jakarta Selatan</td>
          </tr>
        </table>
        <table style="text-align:left" width="100%">
          <tr>
            <td style="text-align:left;color: #000000;font-size: 11px;">SLIP GAJI</td>
          </tr>
          <tr>
            <td style="border-collapse: collapse; border-bottom: 1px solid black; font-size:10px;">Perhitungan Gaji Tanggal {{ $slip["tanggal_proses"] }} s/d {{ $slip["tanggal_proses_akhir"] }}</td>
          </tr>
        </table>
        <table width="100%">
          <tr>
            <td>
              <table width="50%">
                <tr>
                  <td style="font-size:10px;">Nama</td>
                  <td style="font-size:10px;">: {{ $slip["nama_pegawai"] }}</td>
                </tr>
                <tr>
                  <td style="font-size:10px;">Jabatan</td>
                  <td style="font-size:10px;">: {{ $slip["jabatan"] }}</td>
                </tr>
              </table>
            </td>
            <td></td>
            <td>
              <table width="50%">
                <tr>
                  <td style="font-size:10px;">Client</td>
                  <td style="font-size:10px;">: {{ $slip["client"] }}</td>
                </tr>
                <tr>
                  <td style="font-size:10px;">Cabang</td>
                  <td style="font-size:10px;">: {{ $slip["cabang"] }}</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <table width="100%">
          <tr>
            <td style="border-collapse: collapse; border-bottom: 2px solid black; border-top: 2px solid black; text-align:center;font-size:11px;" >PENERIMAAN</td>
            <td></td>
            <td style="border-collapse: collapse; border-bottom: 2px solid black; border-top: 2px solid black; text-align:center;font-size:11px;" >POTONGAN</td>
          </tr>
          <tr>
            <td>
              <table width="100%">
                <tr style="font-size:10px;">
                  <td style="text-align:left">HARI KERJA</td>
                  <td style="text-align:right" width="20px"></td>
                  <td style="text-align:right" width="60px">{{ $slip["hari_kerja"] }} Hari</td>
                </tr>
                @php
                $total_terima = 0;
                @endphp
                @foreach ($slip["penerimaan"] as $terima => $terima_value)
                @if ($terima_value != 0)
                <tr style="font-size:10px;">
                  <td style="text-align:left">{{ str_replace('_', ' ', strtoupper($terima)) }}</td>
                  <td style="text-align:right" width="20px">Rp.</td>
                  <td style="text-align:right" width="60px">{{ number_format($terima_value,0,',','.') }}</td>
                </tr>
                @php
                  $total_terima += $terima_value;
                @endphp
                @endif
                @endforeach
              </table>
            </td>
            <td width="10%"></td>
            <td>
              <table width="100%">
                @php
                  $total_potong = 0;
                @endphp
                @foreach ($slip["potongan"] as $potong => $potong_value)
                @if ($potong_value != 0)
                <tr style="font-size:10px;">
                  <td style="text-align:left">{{ str_replace('_', ' ', strtoupper($potong)) }}</td>
                  <td style="text-align:right" width="20px">Rp. </td>
                  <td style="text-align:right" width="60px">{{ number_format($potong_value,0,',','.') }}</td>
                </tr>
                @endif
                @php
                  $total_potong += $potong_value;
                @endphp
                @endforeach
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <table width="100%">
                <tr style="font-size:11px;">
                  <td style="text-align:left; border-collapse: collapse; border-bottom: 2px solid black; border-top: 2px solid black;">Total Penerimaan</td>
                  <td style="text-align:right; border-collapse: collapse; border-bottom: 2px solid black; border-top: 2px solid black;" width="20px">Rp.</td>
                  <td style="text-align:right; border-collapse: collapse; border-bottom: 2px solid black; border-top: 2px solid black;" width="60px">{{ number_format($total_terima,0,',','.')}}</td>
                </tr>
              </table>
            </td>
            <td></td>
            <td>
              <table width="100%">
                <tr style="font-size:11px;">
                  <td style="text-align:left; border-collapse: collapse; border-bottom: 2px solid black; border-top: 2px solid black;">Total Potongan</td>
                  <td style="text-align:right; border-collapse: collapse; border-bottom: 2px solid black; border-top: 2px solid black;" width="20px">Rp.</td>
                  <td style="text-align:right; border-collapse: collapse; border-bottom: 2px solid black; border-top: 2px solid black;" width="60px">{{ number_format($total_potong,0,',','.')}}</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <br>
        <table width="100%">
          <tr>
            <td>
              <table width="80%">
                <tr style="font-size:11px;">
                  <td style="text-align:left;">Take Home Pay</td>
                  <td></td>
                  <td width="80px" style="border-bottom: 2px solid black;text-align:right;">Rp. {{ number_format($total_terima - $total_potong,0,',','.')}}</td>
                </tr>
                <tr height="15px">
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr style="font-size:11px;">
                  <td style="text-align:left;">Pembayaran</td>
                  @if ($slip["tipe_pembayaran"] == 1)
                    <td>Transfer {{ $slip["bank"] }}</td>
                    <td>{{ $slip["no_rekening"] }}</td>
                  @else
                    <td>CASH</td>
                    <td></td>
                  @endif
                </tr>
              </table>
            </td>
            <td width="10%"></td>
            <td>
              <table width="100%" style="text-align:center; font-size:11px;">
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>Mengetahui :</td>
                </tr>
                <tr style="line-height:50px">
                  <td heigth="40%">&nbsp;</td>
                </tr>
                <tr>
                  <td>Fikri Reza</td>
                </tr>
                <tr>
                  <td>FINANCE</td>
                </tr>
              </table>
            </td>
            <td>
              <table width="100%" style="text-align:center; font-size:11px;">
                <tr>
                  <td>Jakarta, {{ date('d-m-Y') }}</td>
                </tr>
                <tr>
                  <td>Diterima Oleh:</td>
                </tr>
                <tr style="line-height:50px">
                  <td heigth="40%">&nbsp;</td>
                </tr>
                <tr>
                  <td>{{ $slip["nama_pegawai"] }}</td>
                </tr>
                <tr>
                  <td>{{ $slip["jabatan"] }}</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </section>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      @endforeach
    </div>
  </body>
</html>
