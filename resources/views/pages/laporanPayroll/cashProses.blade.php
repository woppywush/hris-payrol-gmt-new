<html>

    <table>
      <tr>
        <th colspan="8"><h3>PT. GANDA MADY INDOTAMA - Salary Cash</h3></th>
      </tr>
    </table>
    <table style="border-collapse: collapse; border: 1px solid black;">
      <tr >
        <th style="background-color: #000000; color: #ffffff;">No.</th>
        <th style="background-color: #000000; color: #ffffff;">Pegawai</th>
        <th style="background-color: #000000; color: #ffffff;">Currency</th>
        <th style="background-color: #000000; color: #ffffff;">Amount</th>
        <th style="background-color: #000000; color: #ffffff;">Periode</th>
      </tr>
      @php
        $no = 1;
        $grandTransfer = 0;
      @endphp
      @foreach ($nilaiTransfer as $nilai)
      <tr style="border: 1px solid black;">
        <td style="border: 1px solid black;">{{ $no }}</td>
        <td style="border: 1px solid black;">{{ $nilai["nama_pegawai"] }}</td>
        <td style="border: 1px solid black;">IDR</td>
        <td style="border: 1px solid black;">{{ number_format($nilai["grandTotalGaji"],0,'','.') }}</td>
        <td style="border: 1px solid black;">{{ $getbatch->tanggal_proses}} s/d {{ $getbatch->tanggal_proses_akhir }}</td>
      </tr>
      @php
        $no++;
        $grandTransfer += $nilai["grandTotalGaji"];
      @endphp
      @endforeach
      <tr style="border: 2px solid black;">
        <td></td>
        <td style="border: 2px solid black;"><b>TOTAL</b></td>
        <td></td>
        <td style="border: 2px solid black;"><b>{{ number_format($grandTransfer,0,'','.') }}</b></td>
        <td></td>
      </tr>
    </table>

</html>
