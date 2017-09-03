<html>

    <table>
      <tr>
        <th colspan="8"><h3>PT. GANDA MADY INDOTAMA - Proses Payroll Periode {{ $getbatch->tanggal_proses}} s/d {{ $getbatch->tanggal_proses_akhir }}</h3></th>
      </tr>
    </table>
    <table style="border-collapse: collapse; border: 1px solid black;">
      <tr >
        <th style="background-color: #000000; color: #ffffff;">No.</th>
        <th style="background-color: #000000; color: #ffffff;">Name</th>
        <th style="background-color: #000000; color: #ffffff;">Gross Salary</th>
      </tr>
      @php
        $no = 1;
      @endphp
      @foreach ($nilaiClient as $nilai)
      <tr style="border: 1px solid black;">
        <td style="border: 1px solid black;">{{ $no }}</td>
        <td style="border: 1px solid black;">{{ $nilai["client"] }}</td>
        <td style="border: 1px solid black; text-align:right;">{{ number_format($nilai["grandTotalGaji"],0,'','.') }}</td>
      </tr>
      @php
        $no++;
      @endphp
      @endforeach
      <tr style="border: 1px solid black;">
        <td></td>
        <td style="border: 1px solid black;">TOTAL</td>
        <td style="border: 1px solid black;text-align:right;">{{ number_format($nilaiClient->sum("grandTotalGaji"),0,'','.')}}</td>
      </tr>
    </table>

</html>
