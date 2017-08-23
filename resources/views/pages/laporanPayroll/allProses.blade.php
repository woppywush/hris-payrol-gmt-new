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
        <td style="background-color: #cccdce;" colspan="25">{{ $client->nama_client}} - {{ $client->nama_cabang}}</td>
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
            $hasilgajihari = round($hasilgajihari);
            $dapatgaji = $hasilgajihari * $totalkerja->jumlah_kerja;
          @endphp
          @endif
        @endforeach
        <td style="border: 1px solid black;">{{$key->Jabatan}}</td>
        <td style="border: 1px solid black;">{{$dapatgaji}}</td>
        <td style="border: 1px solid black;">{{$key->Jumlah_TUNJANGAN_JABATAN}}</td>
        <td style="border: 1px solid black;">{{$key->Jumlah_TUNJANGAN_INSENTIF}}</td>
        <td style="border: 1px solid black;">{{$key->Jumlah_TUNJANGAN_LEMBUR}}</td>
        <td style="border: 1px solid black;">{{$key->Jumlah_KEKURANGAN_BULAN_LALU}}</td>
        @foreach ($totalkerjabulan as $totalkerja)
          @if ($totalkerja->id_pegawai == $key->id)
          <td style="border: 1px solid black;">{{$totalkerja->jumlah_kerja * $key->Jumlah_TUNJANGAN_TRANSPORT_MAKAN}}</td>
            @php
              $transportmakan = $totalkerja->jumlah_kerja * $key->Jumlah_TUNJANGAN_TRANSPORT_MAKAN;
              $totalkerjanya = $totalkerja->jumlah_kerja;
            @endphp
          @endif
        @endforeach
        <td style="border: 1px solid black;">{{$key->Jumlah_KETUA_REGU}}</td>
        <td style="border: 1px solid black;">{{$key->Jumlah_PENGEMBALIAN_SERAGAM}}</td>
        <td style="border: 1px solid black;">{{$key->Jumlah_TUNJANGAN_MAKAN_LEMBUR}}</td>
        <td style="border: 1px solid black;">{{$key->Jumlah_SALARY}}</td>
        <td style="border: 1px solid black;">{{$key->Jumlah_SHIFT_PAGI_SIANG}}</td>
        <td style="border: 1px solid black;">{{$key->Jumlah_TUNJANGAN_MAKAN_TRANSPORT}}</td>
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
        <td style="background-color: #cccdce; border: 1px solid black;">{{ $jumlahGajinya}}</td>
        <td style="border: 1px solid black;">{{$key->Jumlah_BPJS_KESEHATAN}}</td>
        <td style="border: 1px solid black;">{{$key->Jumlah_POTONGAN_KAS}}</td>
        <td style="border: 1px solid black;">{{$key->Jumlah_BPJS_KETENAGAKERJAAN}}</td>
        <td style="border: 1px solid black;">{{$key->Jumlah_BPJS_PENSIUN}}</td>
        <td style="border: 1px solid black;">{{$key->Jumlah_POTONGAN_PINJAMAN}}</td>
        <td style="border: 1px solid black;">{{$key->Jumlah_POTONGAN_SERAGAM}}</td>
        <td style="border: 1px solid black;">{{$key->Jumlah_POTONGAN_CONSUMABLE}}</td>
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
        <td style="background-color: #cccdce; border: 1px solid black;">{{ $jumlahGajinya - $jumlahPotongannya}}</td>
      </tr>
    @endif
    @endforeach
      <tr style="background-color: #cccdce;">
        <td colspan="2" style="border: 1px solid black;"><b>Sub Total</b></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_Workday}}</b></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_GAJI_POKOK }}</b></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_TUNJANGAN_JABATAN}}</b></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_TUNJANGAN_INSENTIF}}</b></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_TUNJANGAN_LEMBUR}}</b></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_KEKURANGAN_BULAN_LALU}}</b></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_TUNJANGAN_TRANSPORT_MAKAN}}</b></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_KETUA_REGU}}</b></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_PENGEMBALIAN_SERAGAM}}</b></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_TUNJANGAN_MAKAN_LEMBUR}}</b></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_SALARY}}</b></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_SHIFT_PAGI_SIANG}}</b></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_TUNJANGAN_MAKAN_TRANSPORT}}</b></td>
        <td style="border: 1px solid black;"><b>{{ $grandJumlahGaji }}</b></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_BPJS_KESEHATAN}}</b></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_POTONGAN_KAS}}</b></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_BPJS_KETENAGAKERJAAN}}</b></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_BPJS_PENSIUN}}</b></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_POTONGAN_PINJAMAN}}</b></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_POTONGAN_SERAGAM}}</b></td>
        <td style="border: 1px solid black;"><b>{{ $Jumlah_POTONGAN_CONSUMABLE}}</b></td>
        <td style="border: 1px solid black;"><b>{{ $grandTotalGaji}}</td>
      </tr>
    @endforeach
    <tr>
      <td colspan="25">&nbsp;</td>
    </tr>
    <tr style="background-color: #cccdce;">
      <td colspan="2" style="border: 1px solid black;"><b>Grand Total</b></td>
      <td style="border: 1px solid black;"></td>
      <td style="border: 1px solid black;"><b>{{ $Jumlah_Workday }}</b></td>
      <td style="border: 1px solid black;"></td>
      <td style="border: 1px solid black;"><b>{{ $Jumlah_GAJI_POKOK }}</b></td>
      <td style="border: 1px solid black;"><b>{{ $hasilQuery->sum('Jumlah_TUNJANGAN_JABATAN')}}</b></td>
      <td style="border: 1px solid black;"><b>{{ $hasilQuery->sum('Jumlah_TUNJANGAN_INSENTIF')}}</b></td>
      <td style="border: 1px solid black;"><b>{{ $hasilQuery->sum('Jumlah_TUNJANGAN_LEMBUR')}}</b></td>
      <td style="border: 1px solid black;"><b>{{ $hasilQuery->sum('Jumlah_KEKURANGAN_BULAN_LALU')}}</b></td>
      <td style="border: 1px solid black;"><b>{{ $Jumlah_TUNJANGAN_MAKAN_TRANSPORT }}</b></td>
      <td style="border: 1px solid black;"><b>{{ $hasilQuery->sum('Jumlah_KETUA_REGU')}}</b></td>
      <td style="border: 1px solid black;"><b>{{ $hasilQuery->sum('Jumlah_PENGEMBALIAN_SERAGAM')}}</b></td>
      <td style="border: 1px solid black;"><b>{{ $hasilQuery->sum('Jumlah_TUNJANGAN_MAKAN_LEMBUR')}}</b></td>
      <td style="border: 1px solid black;"><b>{{ $hasilQuery->sum('Jumlah_SALARY')}}</b></td>
      <td style="border: 1px solid black;"><b>{{ $hasilQuery->sum('Jumlah_SHIFT_PAGI_SIANG')}}</b></td>
      <td style="border: 1px solid black;"><b>{{ $hasilQuery->sum('Jumlah_TUNJANGAN_MAKAN_TRANSPORT')}}</b></td>
      {{-- @php
        $jumlahGajinyaClient = $hasilQuery->sum('Jumlah_GAJI_POKOK') + $hasilQuery->sum('Jumlah_TUNJANGAN_JABATAN') + $hasilQuery->sum('Jumlah_TUNJANGAN_INSENTIF') + $hasilQuery->sum('Jumlah_TUNJANGAN_LEMBUR') + $hasilQuery->sum('Jumlah_KEKURANGAN_BULAN_LALU') + $hasilQuery->sum('Jumlah_TUNJANGAN_TRANSPORT_MAKAN') + $hasilQuery->sum('Jumlah_KETUA_REGU') + $hasilQuery->sum('Jumlah_PENGEMBALIAN_SERAGAM') + $hasilQuery->sum('Jumlah_TUNJANGAN_MAKAN_LEMBUR') + $hasilQuery->sum('Jumlah_SALARY') + $hasilQuery->sum('Jumlah_SHIFT_PAGI_SIANG') + $hasilQuery->sum('Jumlah_TUNJANGAN_MAKAN_TRANSPORT');
      @endphp --}}
      <td style="border: 1px solid black;"><b>{{ $grandJumlahGaji }}</b></td>
      <td style="border: 1px solid black;"><b>{{ $hasilQuery->sum('Jumlah_BPJS_KESEHATAN')}}</b></td>
      <td style="border: 1px solid black;"><b>{{ $hasilQuery->sum('Jumlah_POTONGAN_KAS')}}</b></td>
      <td style="border: 1px solid black;"><b>{{ $hasilQuery->sum('Jumlah_BPJS_KETENAGAKERJAAN')}}</b></td>
      <td style="border: 1px solid black;"><b>{{ $hasilQuery->sum('Jumlah_BPJS_PENSIUN')}}</b></td>
      <td style="border: 1px solid black;"><b>{{ $hasilQuery->sum('Jumlah_POTONGAN_PINJAMAN')}}</b></td>
      <td style="border: 1px solid black;"><b>{{ $hasilQuery->sum('Jumlah_POTONGAN_SERAGAM')}}</b></td>
      <td style="border: 1px solid black;"><b>{{ $hasilQuery->sum('Jumlah_POTONGAN_CONSUMABLE')}}</b></td>
      {{-- @php
        $TotalGajinyaClient = $hasilQuery->sum('Jumlah_BPJS_KESEHATAN') + $hasilQuery->sum('Jumlah_POTONGAN_KAS') + $hasilQuery->sum('Jumlah_BPJS_KETENAGAKERJAAN') + $hasilQuery->sum('Jumlah_POTONGAN_PINJAMAN') + $hasilQuery->sum('Jumlah_POTONGAN_SERAGAM') + $hasilQuery->sum('Jumlah_POTONGAN_CONSUMABLE') + $hasilQuery->sum('Jumlah_BPJS_PENSIUN');
      @endphp --}}
      <td style="border: 1px solid black;"><b>{{ $grandTotalGaji }}</b></td>
    </tr>
    </table>

</html>
