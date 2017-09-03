<html>

    <table>
      <tr>
        <th colspan="8"><h3>PT. GANDA MADY INDOTAMA - Proses Payroll Periode {{ $getbatch->tanggal_proses}} s/d {{ $getbatch->tanggal_proses_akhir}}</h3></th>
      </tr>
    </table>
    <table style="border-collapse: collapse; border: 1px solid black;">
      <tr>
        <td style="background-color: #000000; color: #ffffff;"><b>No</b></td>
        <td style="background-color: #000000; color: #ffffff;"><b>NIP</b></td>
        <td style="background-color: #000000; color: #ffffff;"><b>NAMA</b></td>
        <td style="background-color: #000000; color: #ffffff;"><b>DAYS</b></td>
        <td style="background-color: #000000; color: #ffffff;"><b>JABATAN</b></td>
        @foreach ($getkomponengaji as $komponenGaji)
        @if($komponenGaji->tipe_komponen == "D")
        <td style="background-color: #2d96ff; color: #ffffff;border: 1px solid black;"><b>{{ $komponenGaji->nama_komponen}}</b></td>
        @endif
        @endforeach
        <td style="background-color: #cccdce;"><b>JUMLAH GAJI</b></td>
        @foreach ($getkomponengaji as $komponenGaji)
        @if($komponenGaji->tipe_komponen == "P")
        <td style="background-color: #c62121; color: #ffffff;border: 1px solid black;"><b>{{ $komponenGaji->nama_komponen}}</b></td>
        @endif
        @endforeach
        <td style="background-color: #cccdce;"><b>TOTAL GAJI</b></td>
      </tr>


    @php
      $TOT_Jumlah_Workday = 0;
      $TOT_Jumlah_Gaji_Pokok = 0;
      $TOT_Jumlah_Tunjangan_Jabatan = 0;
      $TOT_Jumlah_Tunjangan_Insentif = 0;
      $TOT_Jumlah_Tunjangan_Lembur = 0;
      $TOT_Jumlah_Kekurangan_Bulan_Lalu = 0;
      $TOT_Jumlah_Tunjangan_Transport_Makan = 0;
      $TOT_Jumlah_Ketua_Regu = 0;
      $TOT_Jumlah_Pengembalian_Seragam = 0;
      $TOT_Jumlah_Tunjangan_Makan_Lembur = 0;
      $TOT_Jumlah_Salary = 0;
      $TOT_Jumlah_Shift_Pagi_Siang = 0;
      $TOT_Jumlah_Tunjangan_Makan_Transport = 0;
      $TOT_Grand_Jumlah_Gaji = 0;
      $TOT_Jumlah_BPJS_Kesehatan = 0;
      $TOT_Jumlah_BPJS_Ketenagakerjaan = 0;
      $TOT_Jumlah_BPJS_Pensiun = 0;
      $TOT_Jumlah_Potongan_Kas = 0;
      $TOT_Jumlah_Potongan_Pinjaman = 0;
      $TOT_Jumlah_Potongan_Seragam = 0;
      $TOT_Jumlah_Potongan_Consumable = 0;
      $TOT_Grand_Total_Gaji = 0;
    @endphp
    @foreach ($getCabangClient as $client)
      @php
      $no = 1;
      $grandJumlahGaji = 0;
      $grandTotalGaji = 0;
      $Jumlah_Workday = 0;
      $Jumlah_GAJI_POKOK = 0;
      $Jumlah_TUNJANGAN_JABATAN = 0;
      $Jumlah_TUNJANGAN_INSENTIF = 0;
      $Jumlah_TUNJANGAN_LEMBUR = 0;
      $Jumlah_KEKURANGAN_BULAN_LALU = 0;
      $Jumlah_TUNJANGAN_TRANSPORT_MAKAN = 0;
      $Jumlah_KETUA_REGU = 0;
      $Jumlah_PENGEMBALIAN_SERAGAM = 0;
      $Jumlah_TUNJANGAN_MAKAN_LEMBUR = 0;
      $Jumlah_SALARY = 0;
      $Jumlah_SHIFT_PAGI_SIANG = 0;
      $Jumlah_TUNJANGAN_MAKAN_TRANSPORT = 0;
      $Jumlah_POTONGAN_KAS = 0;
      $Jumlah_BPJS_KESEHATAN = 0;
      $Jumlah_BPJS_KETENAGAKERJAAN = 0;
      $Jumlah_BPJS_PENSIUN = 0;
      $Jumlah_POTONGAN_PINJAMAN = 0;
      $Jumlah_POTONGAN_SERAGAM = 0;
      $Jumlah_POTONGAN_CONSUMABLE = 0;
      @endphp
      <tr style="border: 1px solid black;">
        <td style="background-color: #cccdce;" colspan="26">{{ $client->nama_client}} - {{ $client->nama_cabang}}</td>
      </tr>
      @foreach($hasilQuery as $key)
        @if($key->Cabang == $client->id)
          <tr style="border: 1px solid black;">
            <td style="border: 1px solid black;">{{ $no}}</td>
            <td style="border: 1px solid black;">{{$key->nip}}</td>
            <td style="border: 1px solid black;">{{$key->nama_pegawai}}</td>
            @foreach ($totalkerjabulan as $totalkerja)
              @if ($totalkerja->id_pegawai == $key->id)
              <td style="border: 1px solid black;">{{$totalkerja->jumlah_kerja}}</td>
              @php
                $hasilgajihari = $key->Jumlah_GAJI_POKOK / $totalkerja->workday;
                $hasilgajihari = $hasilgajihari;
                $dapatgaji = $hasilgajihari * $totalkerja->jumlah_kerja;
              @endphp
              @endif
            @endforeach
            <td style="border: 1px solid black;">{{$key->Jabatan}}</td>
            <td style="border: 1px solid black;">{{ number_format($dapatgaji) }}</td>
            <td style="border: 1px solid black;">{{number_format($key->Jumlah_TUNJANGAN_JABATAN)}}</td>
            <td style="border: 1px solid black;">{{number_format($key->Jumlah_TUNJANGAN_INSENTIF)}}</td>
            <td style="border: 1px solid black;">{{number_format($key->Jumlah_TUNJANGAN_LEMBUR)}}</td>
            <td style="border: 1px solid black;">{{number_format($key->Jumlah_KEKURANGAN_BULAN_LALU)}}</td>
            @foreach ($totalkerjabulan as $totalkerja)
              @if ($totalkerja->id_pegawai == $key->id)
              <td style="border: 1px solid black;">{{ number_format($totalkerja->jumlah_kerja * $key->Jumlah_TUNJANGAN_TRANSPORT_MAKAN)}}</td>
                @php
                  $transportmakan = $totalkerja->jumlah_kerja * $key->Jumlah_TUNJANGAN_TRANSPORT_MAKAN;
                  $transportmakan = floor($transportmakan);
                  $totalkerjanya = $totalkerja->jumlah_kerja;
                @endphp
              @endif
            @endforeach
            <td style="border: 1px solid black;">{{number_format($key->Jumlah_KETUA_REGU)}}</td>
            <td style="border: 1px solid black;">{{number_format($key->Jumlah_PENGEMBALIAN_SERAGAM)}}</td>
            <td style="border: 1px solid black;">{{number_format($key->Jumlah_TUNJANGAN_MAKAN_LEMBUR)}}</td>
            <td style="border: 1px solid black;">{{number_format($key->Jumlah_SALARY)}}</td>
            <td style="border: 1px solid black;">{{number_format($key->Jumlah_SHIFT_PAGI_SIANG)}}</td>
            <td style="border: 1px solid black;">{{number_format($key->Jumlah_TUNJANGAN_MAKAN_TRANSPORT)}}</td>
            @php
              $Jumlah_Workday += $totalkerjanya;
              $Jumlah_GAJI_POKOK += $dapatgaji;
              $Jumlah_TUNJANGAN_JABATAN += $key->Jumlah_TUNJANGAN_JABATAN;
              $Jumlah_TUNJANGAN_INSENTIF += $key->Jumlah_TUNJANGAN_INSENTIF;
              $Jumlah_TUNJANGAN_LEMBUR += $key->Jumlah_TUNJANGAN_LEMBUR;
              $Jumlah_KEKURANGAN_BULAN_LALU += $key->Jumlah_KEKURANGAN_BULAN_LALU;
              $Jumlah_TUNJANGAN_TRANSPORT_MAKAN += $transportmakan;
              $Jumlah_KETUA_REGU += $key->Jumlah_KETUA_REGU;
              $Jumlah_PENGEMBALIAN_SERAGAM += $key->Jumlah_PENGEMBALIAN_SERAGAM;
              $Jumlah_TUNJANGAN_MAKAN_LEMBUR += $key->Jumlah_TUNJANGAN_MAKAN_LEMBUR;
              $Jumlah_SALARY += $key->Jumlah_SALARY;
              $Jumlah_SHIFT_PAGI_SIANG += $key->Jumlah_SHIFT_PAGI_SIANG;
              $Jumlah_TUNJANGAN_MAKAN_TRANSPORT += $key->Jumlah_TUNJANGAN_MAKAN_TRANSPORT;

              $jumlahGajinya = $dapatgaji + $key->Jumlah_TUNJANGAN_JABATAN + $key->Jumlah_TUNJANGAN_INSENTIF + $key->Jumlah_TUNJANGAN_LEMBUR + $key->Jumlah_KEKURANGAN_BULAN_LALU + $transportmakan + $key->Jumlah_KETUA_REGU + $key->Jumlah_PENGEMBALIAN_SERAGAM + $key->Jumlah_TUNJANGAN_MAKAN_LEMBUR + $key->Jumlah_SALARY + $key->Jumlah_SHIFT_PAGI_SIANG + $key->Jumlah_TUNJANGAN_MAKAN_TRANSPORT;

              $grandJumlahGaji += $jumlahGajinya;
            @endphp
            <td style="background-color: #cccdce; border: 1px solid black;">{{ number_format($jumlahGajinya) }}</td>
            <td style="border: 1px solid black;">{{number_format($key->Jumlah_BPJS_KESEHATAN)}}</td>
            <td style="border: 1px solid black;">{{number_format($key->Jumlah_POTONGAN_KAS)}}</td>
            <td style="border: 1px solid black;">{{number_format($key->Jumlah_BPJS_KETENAGAKERJAAN)}}</td>
            <td style="border: 1px solid black;">{{number_format($key->Jumlah_BPJS_PENSIUN)}}</td>
            <td style="border: 1px solid black;">{{number_format($key->Jumlah_POTONGAN_PINJAMAN)}}</td>
            <td style="border: 1px solid black;">{{number_format($key->Jumlah_POTONGAN_SERAGAM)}}</td>
            <td style="border: 1px solid black;">{{number_format($key->Jumlah_POTONGAN_CONSUMABLE)}}</td>
            @php
              $Jumlah_BPJS_KESEHATAN += $key->Jumlah_BPJS_KESEHATAN;
              $Jumlah_POTONGAN_KAS += $key->Jumlah_POTONGAN_KAS;
              $Jumlah_BPJS_KETENAGAKERJAAN += $key->Jumlah_BPJS_KETENAGAKERJAAN;
              $Jumlah_POTONGAN_PINJAMAN += $key->Jumlah_POTONGAN_PINJAMAN;
              $Jumlah_POTONGAN_SERAGAM += $key->Jumlah_POTONGAN_SERAGAM;
              $Jumlah_POTONGAN_CONSUMABLE += $key->Jumlah_POTONGAN_CONSUMABLE;
              $Jumlah_BPJS_PENSIUN += $key->Jumlah_BPJS_PENSIUN;

              $jumlahPotongannya = $key->Jumlah_BPJS_KESEHATAN + $key->Jumlah_POTONGAN_KAS + $key->Jumlah_BPJS_KETENAGAKERJAAN + $key->Jumlah_POTONGAN_PINJAMAN + $key->Jumlah_POTONGAN_SERAGAM + $key->Jumlah_POTONGAN_CONSUMABLE + $key->Jumlah_BPJS_PENSIUN;
              $no++;
              $grandTotalGaji += $jumlahGajinya - $jumlahPotongannya;
            @endphp
            <td style="background-color: #cccdce; border: 1px solid black;">{{ number_format($jumlahGajinya - $jumlahPotongannya,0,'','.') }}</td>
          </tr>
        @endif
      @endforeach
      <tr style="background-color: #cccdce;">
        <td colspan="2" style="border: 1px solid black;"><b>Sub Total</b></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_Workday }}</b></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"><b>{{ number_format($Jumlah_GAJI_POKOK,0,'','.') }}</b></td>
        <td style="border: 1px solid black;"><b>{{ number_format($Jumlah_TUNJANGAN_JABATAN,0,'','.') }}</b></td>
        <td style="border: 1px solid black;"><b>{{ number_format($Jumlah_TUNJANGAN_INSENTIF,0,'','.') }}</b></td>
        <td style="border: 1px solid black;"><b>{{ number_format($Jumlah_TUNJANGAN_LEMBUR,0,'','.') }}</b></td>
        <td style="border: 1px solid black;"><b>{{ number_format($Jumlah_KEKURANGAN_BULAN_LALU,0,'','.') }}</b></td>
        <td style="border: 1px solid black;"><b>{{ number_format($Jumlah_TUNJANGAN_TRANSPORT_MAKAN,0,'','.') }}</b></td>
        <td style="border: 1px solid black;"><b>{{ number_format($Jumlah_KETUA_REGU,0,'','.') }}</b></td>
        <td style="border: 1px solid black;"><b>{{ number_format($Jumlah_PENGEMBALIAN_SERAGAM,0,'','.') }}</b></td>
        <td style="border: 1px solid black;"><b>{{ number_format($Jumlah_TUNJANGAN_MAKAN_LEMBUR,0,'','.') }}</b></td>
        <td style="border: 1px solid black;"><b>{{ number_format($Jumlah_SALARY,0,'','.') }}</b></td>
        <td style="border: 1px solid black;"><b>{{ number_format($Jumlah_SHIFT_PAGI_SIANG,0,'','.') }}</b></td>
        <td style="border: 1px solid black;"><b>{{ number_format($Jumlah_TUNJANGAN_MAKAN_TRANSPORT,0,'','.') }}</b></td>
        <td style="border: 1px solid black;"><b>{{ number_format($grandJumlahGaji,0,'','.') }}</b></td>
        <td style="border: 1px solid black;"><b>{{ number_format($Jumlah_BPJS_KESEHATAN,0,'','.') }}</b></td>
        <td style="border: 1px solid black;"><b>{{ number_format($Jumlah_POTONGAN_KAS,0,'','.') }}</b></td>
        <td style="border: 1px solid black;"><b>{{ number_format($Jumlah_BPJS_KETENAGAKERJAAN,0,'','.') }}</b></td>
        <td style="border: 1px solid black;"><b>{{ number_format($Jumlah_BPJS_PENSIUN,0,'','.') }}</b></td>
        <td style="border: 1px solid black;"><b>{{ number_format($Jumlah_POTONGAN_PINJAMAN,0,'','.') }}</b></td>
        <td style="border: 1px solid black;"><b>{{ number_format($Jumlah_POTONGAN_SERAGAM,0,'','.') }}</b></td>
        <td style="border: 1px solid black;"><b>{{ number_format($Jumlah_POTONGAN_CONSUMABLE,0,'','.') }}</b></td>
        <td style="border: 1px solid black;"><b>{{ number_format($grandTotalGaji,0,'','.') }}</td>
      </tr>
      @php
        $TOT_Jumlah_Workday += $Jumlah_Workday;
        $TOT_Jumlah_Gaji_Pokok += $Jumlah_GAJI_POKOK;
        $TOT_Jumlah_Tunjangan_Jabatan += $Jumlah_TUNJANGAN_JABATAN;
        $TOT_Jumlah_Tunjangan_Insentif += $Jumlah_TUNJANGAN_INSENTIF;
        $TOT_Jumlah_Tunjangan_Lembur += $Jumlah_TUNJANGAN_LEMBUR;
        $TOT_Jumlah_Kekurangan_Bulan_Lalu += $Jumlah_KEKURANGAN_BULAN_LALU;
        $TOT_Jumlah_Tunjangan_Transport_Makan += $Jumlah_TUNJANGAN_TRANSPORT_MAKAN;
        $TOT_Jumlah_Ketua_Regu += $Jumlah_KETUA_REGU;
        $TOT_Jumlah_Pengembalian_Seragam += $Jumlah_PENGEMBALIAN_SERAGAM;
        $TOT_Jumlah_Tunjangan_Makan_Lembur += $Jumlah_TUNJANGAN_MAKAN_LEMBUR;
        $TOT_Jumlah_Salary += $Jumlah_SALARY;
        $TOT_Jumlah_Shift_Pagi_Siang += $Jumlah_SHIFT_PAGI_SIANG;
        $TOT_Jumlah_Tunjangan_Makan_Transport += $Jumlah_TUNJANGAN_MAKAN_TRANSPORT;
        $TOT_Grand_Jumlah_Gaji += $grandJumlahGaji;
        $TOT_Jumlah_BPJS_Kesehatan += $Jumlah_BPJS_KESEHATAN;
        $TOT_Jumlah_BPJS_Ketenagakerjaan += $Jumlah_BPJS_KETENAGAKERJAAN;
        $TOT_Jumlah_BPJS_Pensiun += $Jumlah_BPJS_PENSIUN;
        $TOT_Jumlah_Potongan_Kas += $Jumlah_POTONGAN_KAS;
        $TOT_Jumlah_Potongan_Pinjaman += $Jumlah_POTONGAN_PINJAMAN;
        $TOT_Jumlah_Potongan_Seragam += $Jumlah_POTONGAN_SERAGAM;
        $TOT_Jumlah_Potongan_Consumable += $Jumlah_POTONGAN_CONSUMABLE;
        $TOT_Grand_Total_Gaji += $grandTotalGaji;
      @endphp
    @endforeach
    <tr>
      <td colspan="25">&nbsp;</td>
    </tr>
    <tr style="background-color: #cccdce;">
      <td colspan="2" style="border: 1px solid black;"><b>Grand Total</b></td>
      <td style="border: 1px solid black;"></td>
      <td style="border: 1px solid black;"><b>{{ $TOT_Jumlah_Workday }}</b></td>
      <td style="border: 1px solid black;"></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Jumlah_Gaji_Pokok,0,'','.') }}</b></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Jumlah_Tunjangan_Jabatan,0,'','.') }}</b></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Jumlah_Tunjangan_Insentif,0,'','.') }}</b></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Jumlah_Tunjangan_Lembur,0,'','.') }}</b></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Jumlah_Kekurangan_Bulan_Lalu,0,'','.') }}</b></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Jumlah_Tunjangan_Transport_Makan,0,'','.') }}</b></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Jumlah_Ketua_Regu,0,'','.') }}</b></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Jumlah_Pengembalian_Seragam,0,'','.') }}</b></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Jumlah_Tunjangan_Makan_Lembur,0,'','.') }}</b></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Jumlah_Salary,0,'','.') }}</b></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Jumlah_Shift_Pagi_Siang,0,'','.') }}</b></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Jumlah_Tunjangan_Makan_Transport,0,'','.') }}</b></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Grand_Jumlah_Gaji,0,'','.') }}</b></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Jumlah_BPJS_Kesehatan,0,'','.') }}</b></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Jumlah_Potongan_Kas,0,'','.') }}</b></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Jumlah_BPJS_Ketenagakerjaan,0,'','.') }}</b></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Jumlah_BPJS_Pensiun,0,'','.') }}</b></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Jumlah_Potongan_Pinjaman,0,'','.') }}</b></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Jumlah_Potongan_Seragam,0,'','.') }}</b></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Jumlah_Potongan_Consumable,0,'','.') }}</b></td>
      <td style="border: 1px solid black;"><b>{{ number_format($TOT_Grand_Total_Gaji,0,'','.') }}</b></td>
    </tr>
    </table>

</html>
