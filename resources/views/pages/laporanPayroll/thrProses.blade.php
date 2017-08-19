<html>

    <table>
      <tr>
        <th colspan="8"><h3>PT. GANDA MADY INDOTAMA - THR Periode {{$batchThr->bulan_awal}} s/d {{$batchThr->bulan_akhir}}</h3></th>
      </tr>
    </table>
    <table style="border-collapse: collapse; border: 1px solid black;">
      <tr >
        <th style="background-color: #000000; color: #ffffff;">No.</th>
        <th style="background-color: #000000; color: #ffffff;">NIP</th>
        <th style="background-color: #000000; color: #ffffff;">Nama</th>
        <th style="background-color: #000000; color: #ffffff;">Bulan Kerja</th>
        <th style="background-color: #000000; color: #ffffff;">Nilai THR</th>
      </tr>
      @php
        $no = 1;
        $grandThr = 0;
      @endphp
      @foreach ($pegawai as $key)
      <tr style="border: 1px solid black;">
        <td style="border: 1px solid black;">{{ $no }}</td>
        <td style="border: 1px solid black;">{{ $key["nip"] }}</td>
        <td style="border: 1px solid black;">{{ $key["nama"] }}</td>
        <td style="border: 1px solid black;">{{ $key['bulan_kerja'] }}</td>
        <td style="border: 1px solid black;">{{ $key["nilai_thr"] }}</td>
      </tr>
      @php
        $no++;
        $grandThr += $key["nilai_thr"];
      @endphp
      @endforeach
      <tr style="border: 2px solid black;">
        <td></td>
        <td style="border: 2px solid black;"><b>TOTAL</b></td>
        <td></td>
        <td></td>
        <td style="border: 2px solid black;"><b>{{ $grandThr }}</b></td>
        <td></td>
      </tr>
    </table>

</html>
