@extends('layouts.master')

@section('title')
  <title>Lihat Data Pegawai</title>
  <link rel="stylesheet" href="{{asset('plugins/iCheck/all.css')}}">
  <style>
  .datepicker{z-index:1151 !important;}
  </style>
@stop

@section('breadcrumb')
  <h1>
    Lihat Data Pegawai
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    @if (session('level') == 1 || session('level') == 3)
      <li><a href="{{ url('masterpegawai')}}"> Master Pegawai</a></li>
    @elseif (session('level') == 2)
      <li><a href="{{ route('setgaji.index') }}"> Seluruh Data Pegawai</a></li>
    @endif
    <li class="active">Data Pegawai</li>
  </ol>
@stop

@section('content')

  {{-- modal delete keluarga --}}
  <div class="modal modal-default fade" id="hapuskeluarga" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Data Keluarga</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus data keluarga ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
          <a href="#" class="btn btn-primary" id="setkeluarga">Ya, saya yakin.</a>
        </div>
      </div>
    </div>
  </div>

  {{-- modal delete riwayat pekerjaan --}}
  <div class="modal modal-default fade" id="deleteriwayat" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Riwayat Pekerjaan</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus riwayat pekerjaan ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
          <a href="#" class="btn btn-primary" id="setriwayat">Ya, saya yakin.</a>
        </div>
      </div>
    </div>
  </div>

  {{-- modal delete peringatan --}}
  <div class="modal modal-default fade" id="hapusperingatan" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Data Peringatan Kerja</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus data peringatan kerja ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
          <a href="#" class="btn btn-primary" id="setperingatan">Ya, saya yakin.</a>
        </div>
      </div>
    </div>
  </div>

  {{-- modal delete pendidikan --}}
  <div class="modal modal-default fade" id="hapuspendidikan" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Data Pendidikan</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus data pendidikan ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
          <a href="#" class="btn btn-primary" id="setpendidikan">Ya, saya yakin.</a>
        </div>
      </div>
    </div>
  </div>

  {{-- modal delete pengalaman --}}
  <div class="modal modal-default fade" id="hapuspengalaman" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Data Pengalaman</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus data pengalaman ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
          <a href="#" class="btn btn-primary" id="setpengalaman">Ya, saya yakin.</a>
        </div>
      </div>
    </div>
  </div>

  {{-- modal delete komputer --}}
  <div class="modal modal-default fade" id="hapuskomputer" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Data Keahlian Komputer</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus data keahlian komputer ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
          <a href="#" class="btn btn-primary" id="setkomputer">Ya, saya yakin.</a>
        </div>
      </div>
    </div>
  </div>

  {{-- modal delete bahasa --}}
  <div class="modal modal-default fade" id="hapusbahasa" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Data Bahasa Asing</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus data bahasa asing ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
          <a href="#" class="btn btn-primary" id="setbahasa">Ya, saya yakin.</a>
        </div>
      </div>
    </div>
  </div>

  {{-- modal delete dokumen --}}
  <div class="modal modal-default fade" id="hapusdokumen" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Dokumen Pegawai</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus dokumen pegawai ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
          <a href="#" class="btn btn-primary" id="setdokumen">Ya, saya yakin.</a>
        </div>
      </div>
    </div>
  </div>

  {{-- modal delete penyakit --}}
  <div class="modal modal-default fade" id="hapuspenyakit" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Data Riwayat Penyakit</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus data riwayat penyakit ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
          <a href="#" class="btn btn-primary" id="setpenyakit">Ya, saya yakin.</a>
        </div>
      </div>
    </div>
  </div>

  {{-- modal tambah keluarga --}}
  <div class="modal modal-default fade" id="modalkeluarga" role="dialog">
    <div class="modal-dialog" style="width:1000px;">
      <!-- Modal content-->
      <form action="{{url('addkeluarga')}}" method="post">
        {!! csrf_field() !!}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tambah Data Keluarga</h4>
          </div>
          <div class="modal-body">
            <table class="table">
              <tbody>
                <tr>
                  <th>Nama</th>
                  <th>Hubungan</th>
                  <th width="200px;">Tanggal Lahir</th>
                  <th>Pekerjaan</th>
                  <th>Jenis Kelamin</th>
                  <th>Alamat</th>
                </tr>
                <tr>
                  <td>
                    <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->id;
                      }
                    ?>">
                    <input class="form-control" type="hidden" name="nip" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->nip;
                      }
                    ?>">
                    <input class="form-control" type="text" name="nama_keluarga" placeholder="Nama" required>
                  </td>
                  <td>
                    <select class="form-control" name="hubungan_keluarga">
                      <option>-- Pilih --</option>
                      <option value="AYAH">AYAH</option>
                      <option value="IBU">IBU</option>
                      <option value="KAKAK">KAKAK</option>
                      <option value="ADIK">ADIK</option>
                      <option value="LAINNYA">LAINNYA</option>
                    </select>
                  </td>
                  <td>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="tanggal_lahir_keluarga" class="form-control tanggal_lahir_keluarga" required>
                    </div>
                  </td>
                  <td>
                    <select class="form-control" name="pekerjaan_keluarga">
                      <option>-- Pilih --</option>
                      <option value="PEGAWAI NEGERI">PEGAWAI NEGERI</option>
                      <option value="PEGAWAI SWASTA">PEGAWAI SWASTA</option>
                      <option value="WIRAUSAHA">WIRAUSAHA</option>
                      <option value="RUMAH TANGGA">RUMAH TANGGA</option>
                      <option value="MAHASISWA">MAHASISWA</option>
                      <option value="PELAJAR">PELAJAR</option>
                      <option value="LAINNYA">LAINNYA</option>
                    </select>
                  </td>
                  <td>
                    <label>
                      <input type="radio" name="jenis_kelamin_keluarga" class="minimal" value="L">
                    </label>&nbsp;&nbsp;
                    {{-- &nbsp; --}}
                    <label>Pria</label>
                    <br>
                    <label>
                      <input type="radio" name="jenis_kelamin_keluarga" class="minimal" value="P">
                    </label>&nbsp;&nbsp;
                    {{-- &nbsp; --}}
                    <label>Wanita</label>
                  </td>
                  <td>
                    <textarea name="alamat_keluarga" rows="3" class="form-control"></textarea>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
    </form>
    </div>
  </div>

  {{-- modal edit keluarga --}}
  <div class="modal modal-default fade" id="editkeluarga" role="dialog">
    <div class="modal-dialog" style="width:1000px;">
      <!-- Modal content-->
      <form action="{{url('masterpegawai/savekeluarga')}}" method="post">
        {!! csrf_field() !!}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Data Keluarga</h4>
          </div>
          <div class="modal-body">
            <table class="table">
              <tbody>
                <tr>
                  <th>Nama</th>
                  <th>Hubungan</th>
                  <th width="200px;">Tanggal Lahir</th>
                  <th>Pekerjaan</th>
                  <th>Jenis Kelamin</th>
                  <th>Alamat</th>
                </tr>
                <tr>
                  <td>
                    <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->id;
                      }
                    ?>">
                    <input class="form-control" type="hidden" name="nip" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->nip;
                      }
                    ?>">
                    <input class="form-control" type="hidden" name="id_keluarga" id="id_keluarga" required>
                    <input class="form-control" type="text" name="nama_keluarga" placeholder="Nama" id="edit_nama_keluarga" required>
                  </td>
                  <td>
                    <select class="form-control" name="hubungan_keluarga">
                      <option>-- Pilih --</option>
                      <option value="AYAH" id="hub_ayah">AYAH</option>
                      <option value="IBU" id="hub_ibu">IBU</option>
                      <option value="KAKAK" id="hub_kakak">KAKAK</option>
                      <option value="ADIK" id="hub_adik">ADIK</option>
                      <option value="LAINNYA" id="hub_lain">LAINNYA</option>
                    </select>
                  </td>
                  <td>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="tanggal_lahir_keluarga" class="form-control tanggal_lahir_keluarga" id="edit_tanggal_lahir_keluarga" required>
                    </div>
                  </td>
                  <td>
                    <select class="form-control" name="pekerjaan_keluarga">
                      <option>-- Pilih --</option>
                      <option value="PEGAWAI NEGERI" id="kerja_pn">PEGAWAI NEGERI</option>
                      <option value="PEGAWAI SWASTA" id="kerja_ps">PEGAWAI SWASTA</option>
                      <option value="WIRAUSAHA" id="kerja_wira">WIRAUSAHA</option>
                      <option value="RUMAH TANGGA" id="kerja_rt">RUMAH TANGGA</option>
                      <option value="MAHASISWA" id="kerja_maha">MAHASISWA</option>
                      <option value="PELAJAR" id="kerja_pel">PELAJAR</option>
                      <option value="LAINNYA" id="kerja_lain">LAINNYA</option>
                    </select>
                  </td>
                  <td>
                    <label>
                      <input type="radio" name="jenis_kelamin_keluarga" class="minimal" value="L" id="jk_pria">
                    </label>&nbsp;&nbsp;
                    {{-- &nbsp; --}}
                    <label>Pria</label>
                    <br>
                    <label>
                      <input type="radio" name="jenis_kelamin_keluarga" class="minimal" value="P" id="jk_wanita">
                    </label>&nbsp;&nbsp;
                    {{-- &nbsp; --}}
                    <label>Wanita</label>
                  </td>
                  <td>
                    <textarea name="alamat_keluarga" rows="3" class="form-control" id="edit_alamat_keluarga"></textarea>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </div>
        </div>
    </form>
    </div>
  </div>

  {{-- modal tambah pendidikan --}}
  <div class="modal modal-default fade" id="modalpendidikan" role="dialog">
    <div class="modal-dialog" style="width:1000px;">
      <!-- Modal content-->
      <form action="{{url('addpendidikan')}}" method="post">
        {!! csrf_field() !!}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tambah Data Pendidikan</h4>
          </div>
          <div class="modal-body">
            <table class="table">
              <tbody>
                <tr>
                  <th>Jenjang</th>
                  <th>Institusi</th>
                  <th width="200px;">Tahun Masuk</th>
                  <th width="200px;">Tahun Lulus</th>
                  <th>Gelar</th>
                </tr>
                <tr>
                  <td>
                    <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->id;
                      }
                    ?>">
                    <input class="form-control" type="hidden" name="nip" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->nip;
                      }
                    ?>">
                    <select class="form-control" name="jenjang_pendidikan">
                      <option>-- Pilih --</option>
                      <option value="PELATIHAN KEAHLIAN">PELATIHAN KEAHLIAN</option>
                      <option value="S2">S2 Magister</option>
                      <option value="S1">S1 Strata</option>
                      <option value="D3">D3 Akademik</option>
                      <option value="SMK">SMK</option>
                      <option value="SMU">SMU</option>
                      <option value="SMP">SMP</option>
                      <option value="SD">SD</option>
                      <option value="LAINNYA">LAINNYA</option>
                    </select>
                  </td>
                  <td>
                    <input type="text" name="institusi_pendidikan" class="form-control">
                  </td>
                  <td>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="tahun_masuk_pendidikan" class="form-control tahun_masuk_pendidikan" required>
                    </div>
                  </td>
                  <td>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="tahun_lulus_pendidikan" class="form-control tahun_lulus_pendidikan" required>
                    </div>
                  </td>
                  <td>
                    <input type="text" name="gelar_akademik" class="form-control">
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
    </form>
    </div>
  </div>

  {{-- modal edit pendidikan --}}
  <div class="modal modal-default fade" id="editpendidikan" role="dialog">
    <div class="modal-dialog" style="width:1000px;">
      <!-- Modal content-->
      <form action="{{url('masterpegawai/savependidikan')}}" method="post">
        {!! csrf_field() !!}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Data Pendidikan</h4>
          </div>
          <div class="modal-body">
            <table class="table">
              <tbody>
                <tr>
                  <th>Jenjang</th>
                  <th>Institusi</th>
                  <th width="200px;">Tahun Masuk</th>
                  <th width="200px;">Tahun Lulus</th>
                  <th>Gelar</th>
                </tr>
                <tr>
                  <td>
                    <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->id;
                      }
                    ?>">
                    <input class="form-control" type="hidden" name="nip" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->nip;
                      }
                    ?>">
                    <select class="form-control" name="edit_jenjang_pendidikan">
                      <option>-- Pilih --</option>
                      <option value="PELATIHAN KEAHLIAN" id="pend_pelatihan">PELATIHAN KEAHLIAN</option>
                      <option value="S2" id="pend_s2">S2 Magister</option>
                      <option value="S1" id="pend_s1">S1 Strata</option>
                      <option value="D3" id="pend_d3">D3 Akademik</option>
                      <option value="SMK" id="pend_smk">SMK</option>
                      <option value="SMU" id="pend_smu">SMU</option>
                      <option value="SMP" id="pend_smp">SMP</option>
                      <option value="SD" id="pend_sd">SD</option>
                      <option value="LAINNYA" id="pend_lain">LAINNYA</option>
                    </select>
                    <input name="id_pendidikan" type="hidden" class="form-control" id="id_pendidikan">
                  </td>
                  <td>
                    <input type="text" name="institusi_pendidikan" class="form-control" id="edit_institusi_pendidikan">
                  </td>
                  <td>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="tahun_masuk_pendidikan" class="form-control tahun_masuk_pendidikan" id="edit_tahun_masuk_pendidikan" required>
                    </div>
                  </td>
                  <td>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="tahun_lulus_pendidikan" class="form-control tahun_lulus_pendidikan" id="edit_tahun_lulus_pendidikan" required>
                    </div>
                  </td>
                  <td>
                    <input type="text" name="gelar_akademik" class="form-control" id="edit_gelar_akademik">
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
    </form>
    </div>
  </div>

  {{-- modal edit hubungan darurat --}}
  <div class="modal modal-default fade" id="editdarurat" role="dialog">
    <div class="modal-dialog" style="width:1000px;">
      <!-- Modal content-->
      <form action="{{url('masterpegawai/savedarurat')}}" method="post">
        {!! csrf_field() !!}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Data Hubungan Darurat</h4>
          </div>
          <div class="modal-body">
            <table class="table">
              <tbody>
                <tr>
                  <th>Nama</th>
                  <th>Hubungan</th>
                  <th>Alamat</th>
                  <th>Telepon</th>
                </tr>
                <tr>
                  <td>
                    <input type="text" name="nama_darurat" class="form-control" id="edit_nama_darurat">
                  </td>
                  <td>
                    <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->id;
                      }
                    ?>">
                    <input class="form-control" type="hidden" name="nip" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->nip;
                      }
                    ?>">
                    <select class="form-control" name="hubungan_darurat">
                      <option value="">-- Pilih --</option>
                      <option value="AYAH" id="hubdar_ayah">AYAH</option>
                      <option value="IBU" id="hubdar_ibu">IBU</option>
                      <option value="KAKAK" id="hubdar_kakak">KAKAK</option>
                      <option value="ADIK" id="hubdar_adik">ADIK</option>
                      <option value="LAINNYA" id="hubdar_lain">LAINNYA</option>
                    </select>
                  </td>
                  <td>
                    <input type="text" name="alamat_darurat" class="form-control" id="edit_alamat_darurat">
                  </td>
                  <td>
                    <input type="text" name="telepon_darurat" class="form-control" id="edit_telepon_darurat">
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
    </form>
    </div>
  </div>

  {{-- modal tambah pengalaman --}}
  <div class="modal modal-default fade" id="modalpengalaman" role="dialog">
    <div class="modal-dialog" style="width:1000px;">
      <!-- Modal content-->
      <form action="{{url('addpengalaman')}}" method="post">
        {!! csrf_field() !!}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tambah Data Pengalaman Kerja</h4>
          </div>
          <div class="modal-body">
            <table class="table">
              <tbody>
                <tr>
                  <th>Nama Perusahaan</th>
                  <th>Posisi</th>
                  <th width="200px;">Tahun Awal Kerja</th>
                  <th width="200px;">Tahun Akhir Kerja</th>
                </tr>
                <tr>
                  <td>
                    <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->id;
                      }
                    ?>">
                    <input class="form-control" type="hidden" name="nip" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->nip;
                      }
                    ?>">
                    <input type="text" name="nama_perusahaan" class="form-control">
                  </td>
                  <td>
                    <input type="text" name="posisi_perusahaan" class="form-control">
                  </td>
                  <td>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="tahun_awal_kerja" class="form-control tahun_awal_kerja" required>
                    </div>
                  </td>
                  <td>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="tahun_akhir_kerja" class="form-control tahun_akhir_kerja" required>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
    </form>
    </div>
  </div>

  {{-- modal edit pengalaman --}}
  <div class="modal modal-default fade" id="editpengalaman" role="dialog">
    <div class="modal-dialog" style="width:1000px;">
      <!-- Modal content-->
      <form action="{{url('masterpegawai/savepengalaman')}}" method="post">
        {!! csrf_field() !!}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Data Pengalaman Kerja</h4>
          </div>
          <div class="modal-body">
            <table class="table">
              <tbody>
                <tr>
                  <th>Nama Perusahaan</th>
                  <th>Posisi</th>
                  <th width="200px;">Tahun Awal Kerja</th>
                  <th width="200px;">Tahun Akhir Kerja</th>
                </tr>
                <tr>
                  <td>
                    <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->id;
                      }
                    ?>">
                    <input class="form-control" type="hidden" name="nip" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->nip;
                      }
                    ?>">
                    <input type="hidden" name="id_pengalaman" class="form-control" id="id_pengalaman">
                    <input type="text" name="nama_perusahaan" class="form-control" id="edit_nama_perusahaan">
                  </td>
                  <td>
                    <input type="text" name="posisi_perusahaan" class="form-control" id="edit_posisi_perusahaan">
                  </td>
                  <td>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="tahun_awal_kerja" class="form-control tahun_awal_kerja" id="edit_tahun_awal_kerja" required>
                    </div>
                  </td>
                  <td>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="tahun_akhir_kerja" class="form-control tahun_akhir_kerja" id="edit_tahun_akhir_kerja" required>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </div>
        </div>
    </form>
    </div>
  </div>

  {{-- modal tambah komputer --}}
  <div class="modal modal-default fade" id="modalkomputer" role="dialog">
    <div class="modal-dialog" style="width:600px;">
      <!-- Modal content-->
      <form action="{{url('addkomputer')}}" method="post">
        {!! csrf_field() !!}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tambah Data Keahlian Komputer</h4>
          </div>
          <div class="modal-body">
            <table class="table">
              <tbody>
                <tr>
                  <th>Nama Program</th>
                  <th>Nilai</th>
                </tr>
                <tr>
                  <td>
                    <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->id;
                      }
                    ?>">
                    <input class="form-control" type="hidden" name="nip" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->nip;
                      }
                    ?>">
                    <input type="text" name="nama_program" class="form-control">
                  </td>
                  <td>
                    <select class="form-control" name="nilai_komputer">
                      <option>-- Pilih --</option>
                      <option value="1">BAIK</option>
                      <option value="2">CUKUP</option>
                      <option value="3">KURANG</option>
                    </select>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
    </form>
    </div>
  </div>

  {{-- modal edit komputer --}}
  <div class="modal modal-default fade" id="editkomputer" role="dialog">
    <div class="modal-dialog" style="width:600px;">
      <!-- Modal content-->
      <form action="{{url('masterpegawai/savekomputer')}}" method="post">
        {!! csrf_field() !!}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Data Keahlian Komputer</h4>
          </div>
          <div class="modal-body">
            <table class="table">
              <tbody>
                <tr>
                  <th>Nama Program</th>
                  <th>Nilai</th>
                </tr>
                <tr>
                  <td>
                    <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->id;
                      }
                    ?>">
                    <input class="form-control" type="hidden" name="nip" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->nip;
                      }
                    ?>">
                    <input type="hidden" name="id_komputer" class="form-control" id="id_komputer">
                    <input type="text" name="nama_program" class="form-control" id="edit_nama_program">
                  </td>
                  <td>
                    <select class="form-control" name="nilai_komputer">
                      <option>-- Pilih --</option>
                      <option value="1" id="komp_baik">BAIK</option>
                      <option value="2" id="komp_cukup">CUKUP</option>
                      <option value="3" id="komp_kurang">KURANG</option>
                    </select>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
    </form>
    </div>
  </div>

  {{-- modal tambah bahasa --}}
  <div class="modal modal-default fade" id="modalbahasa" role="dialog">
    <div class="modal-dialog" style="width:1000px;">
      <!-- Modal content-->
      <form action="{{url('addbahasa')}}" method="post">
        {!! csrf_field() !!}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tambah Data Bahasa Asing</h4>
          </div>
          <div class="modal-body">
            <table class="table">
              <tbody>
                <tr>
                  <th>Bahasa</th>
                  <th>Berbicara</th>
                  <th>Menulis</th>
                  <th>Mengerti</th>
                </tr>
                <tr>
                  <td>
                    <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->id;
                      }
                    ?>">
                    <input class="form-control" type="hidden" name="nip" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->nip;
                      }
                    ?>">
                    <input type="text" name="bahasa" class="form-control">
                  </td>
                  <td>
                    <select class="form-control" name="berbicara">
                      <option>-- Pilih --</option>
                      <option value="1">BAIK</option>
                      <option value="2">CUKUP</option>
                      <option value="3">KURANG</option>
                    </select>
                  </td>
                  <td>
                    <select class="form-control" name="menulis">
                      <option>-- Pilih --</option>
                      <option value="1">BAIK</option>
                      <option value="2">CUKUP</option>
                      <option value="3">KURANG</option>
                    </select>
                  </td>
                  <td>
                    <select class="form-control" name="mengerti">
                      <option>-- Pilih --</option>
                      <option value="1">BAIK</option>
                      <option value="2">CUKUP</option>
                      <option value="3">KURANG</option>
                    </select>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
    </form>
    </div>
  </div>

  {{-- modal edit bahasa --}}
  <div class="modal modal-default fade" id="editbahasa" role="dialog">
    <div class="modal-dialog" style="width:1000px;">
      <!-- Modal content-->
      <form action="{{url('masterpegawai/savebahasa')}}" method="post">
        {!! csrf_field() !!}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Data Bahasa Asing</h4>
          </div>
          <div class="modal-body">
            <table class="table">
              <tbody>
                <tr>
                  <th>Bahasa</th>
                  <th>Berbicara</th>
                  <th>Menulis</th>
                  <th>Mengerti</th>
                </tr>
                <tr>
                  <td>
                    <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->id;
                      }
                    ?>">
                    <input class="form-control" type="hidden" name="nip" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->nip;
                      }
                    ?>">
                    <input type="hidden" name="id_bahasa" class="form-control" id="id_bahasa">
                    <input type="text" name="bahasa" class="form-control" id="edit_bahasa">
                  </td>
                  <td>
                    <select class="form-control" name="berbicara">
                      <option>-- Pilih --</option>
                      <option value="1" id="bicara_baik">BAIK</option>
                      <option value="2" id="bicara_cukup">CUKUP</option>
                      <option value="3" id="bicara_kurang">KURANG</option>
                    </select>
                  </td>
                  <td>
                    <select class="form-control" name="menulis">
                      <option>-- Pilih --</option>
                      <option value="1" id="menulis_baik">BAIK</option>
                      <option value="2" id="menulis_cukup">CUKUP</option>
                      <option value="3" id="menulis_kurang">KURANG</option>
                    </select>
                  </td>
                  <td>
                    <select class="form-control" name="mengerti">
                      <option>-- Pilih --</option>
                      <option value="1" id="mengerti_baik">BAIK</option>
                      <option value="2" id="mengerti_cukup">CUKUP</option>
                      <option value="3" id="mengerti_kurang">KURANG</option>
                    </select>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
    </form>
    </div>
  </div>

  {{-- modal tambah riwayat penyakit --}}
  <div class="modal modal-default fade" id="modalpenyakit" role="dialog">
    <div class="modal-dialog" style="width:600px;">
      <!-- Modal content-->
      <form action="{{url('addpenyakit')}}" method="post">
        {!! csrf_field() !!}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tambah Data Riwayat Pendidikan</h4>
          </div>
          <div class="modal-body">
            <table class="table">
              <tbody>
                <tr>
                  <th>Nama Penyakit</th>
                  <th>Keterangan</th>
                </tr>
                <tr>
                  <td>
                    <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->id;
                      }
                    ?>">
                    <input class="form-control" type="hidden" name="nip" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->nip;
                      }
                    ?>">
                    <input type="text" name="nama_penyakit" class="form-control">
                  </td>
                  <td>
                    <textarea name="keterangan_penyakit" rows="5" class="form-control"></textarea>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
    </form>
    </div>
  </div>

  {{-- modal tambah data peringatan --}}
  <div class="modal modal-default fade" id="modalperingatan" role="dialog">
    <div class="modal-dialog" style="width:600px;">
      <!-- Modal content-->
      <form class="form-horizontal" action="{{route('dataperingatan.create')}}" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tambah Data Peringatan Kerja</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <div class="col-sm-1"></div>
              <label class="col-sm-2">Tanggal Peringatan</label>
              <div class="col-sm-8">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                    foreach ($DataPegawai as $k) {
                      echo $k->id;
                    }
                  ?>">
                  <input class="form-control" type="hidden" name="nip" value="<?php
                    foreach ($DataPegawai as $k) {
                      echo $k->nip;
                    }
                  ?>">
                  <input type="text" name="tanggal_peringatan" class="form-control" id="tanggal_peringatan">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-1"></div>
              <label class="col-sm-2">Jenis Peringatan</label>
              <div class="col-sm-8">
                <input type="text" name="jenis_peringatan" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-1"></div>
              <label class="col-sm-2">Keterangan Peringatan</label>
              <div class="col-sm-8">
                <textarea name="keterangan_peringatan" rows="4" cols="40" class="form-control"></textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-1"></div>
              <label class="col-sm-2">Upload Dokumen</label>
              <div class="col-sm-8">
                <input type="file" name="dokumen_peringatan" class="form-control">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  {{-- modal tambah edit peringatan --}}
  <div class="modal modal-default fade" id="editperingatan" role="dialog">
    <div class="modal-dialog" style="width:600px;">
      <!-- Modal content-->
      <form class="form-horizontal" action="{{route('dataperingatan.update')}}" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tambah Data Peringatan Kerja</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <div class="col-sm-1"></div>
              <label class="col-sm-2">Tanggal Peringatan</label>
              <div class="col-sm-8">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                    foreach ($DataPegawai as $k) {
                      echo $k->id;
                    }
                  ?>">
                  <input class="form-control" type="hidden" name="nip" value="<?php
                    foreach ($DataPegawai as $k) {
                      echo $k->nip;
                    }
                  ?>">
                  <input type="hidden" name="id" class="form-control" id="edit_id_peringatan">
                  <input type="text" name="tanggal_peringatan" class="form-control" id="edit_tanggal_peringatan">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-1"></div>
              <label class="col-sm-2">Jenis Peringatan</label>
              <div class="col-sm-8">
                <input type="text" name="jenis_peringatan" class="form-control" id="edit_jenis_peringatan">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-1"></div>
              <label class="col-sm-2">Keterangan Peringatan</label>
              <div class="col-sm-8">
                <textarea name="keterangan_peringatan" rows="4" cols="40" class="form-control" id="edit_keterangan_peringatan"></textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-1"></div>
              <label class="col-sm-2">Upload Dokumen</label>
              <div class="col-sm-8">
                <input type="file" name="dokumen_peringatan" class="form-control">
                <span style="color:#001f3f;">* Biarkan kosong jika tidak ingin diganti.</span>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  {{-- modal edit riwayat penyakit --}}
  <div class="modal modal-default fade" id="editpenyakit" role="dialog">
    <div class="modal-dialog" style="width:600px;">
      <!-- Modal content-->
      <form action="{{url('masterpegawai/savepenyakit')}}" method="post">
        {!! csrf_field() !!}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Data Riwayat Pendidikan</h4>
          </div>
          <div class="modal-body">
            <table class="table">
              <tbody>
                <tr>
                  <th>Nama Penyakit</th>
                  <th>Keterangan</th>
                </tr>
                <tr>
                  <td>
                    <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->id;
                      }
                    ?>">
                    <input class="form-control" type="hidden" name="nip" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->nip;
                      }
                    ?>">
                    <input type="hidden" name="id_penyakit" class="form-control" id="id_penyakit">
                    <input type="text" name="nama_penyakit" class="form-control" id="edit_nama_penyakit">
                  </td>
                  <td>
                    <textarea name="keterangan_penyakit" rows="5" class="form-control" id="edit_keterangan_penyakit"></textarea>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
    </form>
    </div>
  </div>

  {{-- -- modal set kesehatan -- --}}
  <div class="modal modal-default fade" id="modalsetkesehatan" role="dialog">
    <div class="modal-dialog" style="width:1000px;">
      <!-- Modal content-->
      <form action="{{ route('kesehatan.set') }}" method="post">
        {!! csrf_field() !!}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Data Kondisi Kesehatan</h4>
          </div>
          <div class="modal-body">
            <table class="table">
              <tbody>
                <tr>
                  <th>Tinggi Badan</th>
                  <th>Berat Badan</th>
                  <th>Warna Rambut</th>
                  <th>Warna Mata</th>
                  <th>Berkacamata</th>
                  <th>Merokok</th>
                </tr>
                <tr>
                  <td>
                    <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->id;
                      }
                    ?>">
                    <input class="form-control" type="hidden" name="nip" value="<?php
                      foreach ($DataPegawai as $k) {
                        echo $k->nip;
                      }
                    ?>">
                    <input type="hidden" name="id_kesehatan" class="form-control">
                    <input type="text" name="tinggi_badan" class="form-control" >
                  </td>
                  <td>
                    <input type="text" name="berat_badan" class="form-control">
                  </td>
                  <td>
                    <input type="text" name="warna_rambut" class="form-control">
                  </td>
                  <td>
                    <input type="text" name="warna_mata" class="form-control">
                  </td>
                  <td>
                    <label>
                      <input type="radio" name="berkacamata" class="minimal" value="1">
                    </label>&nbsp;&nbsp;
                    {{-- &nbsp; --}}
                    <label>Ya</label>
                    <br>
                    <label>
                      <input type="radio" name="berkacamata" class="minimal" value="0">
                    </label>&nbsp;&nbsp;
                    {{-- &nbsp; --}}
                    <label>Tidak</label>
                  </td>
                  <td>
                    <label>
                      <input type="radio" name="merokok" class="minimal" value="1">
                    </label>&nbsp;&nbsp;
                    {{-- &nbsp; --}}
                    <label>Ya</label>
                    <br>
                    <label>
                      <input type="radio" name="merokok" class="minimal" value="0">
                    </label>&nbsp;&nbsp;
                    {{-- &nbsp; --}}
                    <label>Tidak</label>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
    </form>
    </div>
  </div>

  {{-- modal edit kesehatan --}}
  <div class="modal modal-default fade" id="modalkesehatan" role="dialog">
    <div class="modal-dialog" style="width:1000px;">
      <!-- Modal content-->
      <form action="{{url('masterpegawai/savekesehatan')}}" method="post">
        {!! csrf_field() !!}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Data Kondisi Kesehatan</h4>
          </div>
          <div class="modal-body">
            <table class="table">
              <tbody>
                <tr>
                  <th>Tinggi Badan</th>
                  <th>Berat Badan</th>
                  <th>Warna Rambut</th>
                  <th>Warna Mata</th>
                  <th>Berkacamata</th>
                  <th>Merokok</th>
                </tr>
                <tr>
                  @foreach($DataKesehatan as $kes)
                    <td>
                      <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                        foreach ($DataPegawai as $k) {
                          echo $k->id;
                        }
                      ?>">
                      <input class="form-control" type="hidden" name="nip" value="<?php
                        foreach ($DataPegawai as $k) {
                          echo $k->nip;
                        }
                      ?>">
                      <input type="hidden" name="id_kesehatan" class="form-control" value="{{ $kes->id }}">
                      <input type="text" name="tinggi_badan" class="form-control" value="{{ $kes->tinggi_badan }}">
                    </td>
                    <td>
                      <input type="text" name="berat_badan" class="form-control" value="{{ $kes->berat_badan }}">
                    </td>
                    <td>
                      <input type="text" name="warna_rambut" class="form-control" value="{{ $kes->warna_rambut }}">
                    </td>
                    <td>
                      <input type="text" name="warna_mata" class="form-control" value="{{ $kes->warna_mata }}">
                    </td>
                    <td>
                      @if($kes->berkacamata==1)
                        <label>
                          <input type="radio" name="berkacamata" class="minimal" value="1" checked="true">
                        </label>&nbsp;&nbsp;
                        {{-- &nbsp; --}}
                        <label>Ya</label>
                        <br>
                        <label>
                          <input type="radio" name="berkacamata" class="minimal" value="0">
                        </label>&nbsp;&nbsp;
                        {{-- &nbsp; --}}
                        <label>Tidak</label>
                      @else
                        <label>
                          <input type="radio" name="berkacamata" class="minimal" value="1">
                        </label>&nbsp;&nbsp;
                        {{-- &nbsp; --}}
                        <label>Ya</label>
                        <br>
                        <label>
                          <input type="radio" name="berkacamata" class="minimal" value="0" checked="true">
                        </label>&nbsp;&nbsp;
                        {{-- &nbsp; --}}
                        <label>Tidak</label>
                      @endif
                    </td>
                    <td>
                      @if($kes->merokok==1)
                        <label>
                          <input type="radio" name="merokok" class="minimal" value="1" checked="true">
                        </label>&nbsp;&nbsp;
                        {{-- &nbsp; --}}
                        <label>Ya</label>
                        <br>
                        <label>
                          <input type="radio" name="merokok" class="minimal" value="0">
                        </label>&nbsp;&nbsp;
                        {{-- &nbsp; --}}
                        <label>Tidak</label>
                      @else
                        <label>
                          <input type="radio" name="merokok" class="minimal" value="1">
                        </label>&nbsp;&nbsp;
                        {{-- &nbsp; --}}
                        <label>Ya</label>
                        <br>
                        <label>
                          <input type="radio" name="merokok" class="minimal" value="0" checked="true">
                        </label>&nbsp;&nbsp;
                        {{-- &nbsp; --}}
                        <label>Tidak</label>
                      @endif
                    </td>
                  @endforeach
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
    </form>
    </div>
  </div>

  {{-- modal add dokumen pegawai --}}
  <div class="modal modal-default fade" id="modaldokumenpegawai" role="dialog">
    <div class="modal-dialog" style="width:70%">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Tambah Data Dokumen Pegawai</h4>
        </div>
        <form action="{{ url('adddokumen') }}" method="post" enctype="multipart/form-data">
          {!! csrf_field() !!}
          <div class="modal-body">
            <div class="tab-content">
              <div class="tab-pane active" id="tab_Dokumen">
                <div class="box-body">
                  <table class="table">
                    <tbody>
                      <tr>
                        <th width="500px">Nama Dokumen</th>
                        <th width="700px">Unggah Dokumen</th>
                      </tr>
                      <tr>
                        <td>
                          <div>
                            <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                              foreach ($DataPegawai as $k) {
                                echo $k->id;
                              }
                            ?>">
                            <input class="form-control" type="hidden" name="nip" value="<?php
                              foreach ($DataPegawai as $k) {
                                echo $k->nip;
                              }
                            ?>">
                            <input type="text" name="namadokumen" class="form-control" placeholder="Nama Dokumen">
                          </div>
                        </td>
                        <td>
                          <div>
                            <input type="file" name="unggahdokumen" class="form-control">
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- modal edit dokumen pegawai --}}
  <div class="modal modal-default fade" id="editdokumenpegawai" role="dialog">
    <div class="modal-dialog" style="width:70%">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Data Dokumen Pegawai</h4>
        </div>
        <form action="{{ url('masterpegawai/editdokumenpegawai') }}" method="post" enctype="multipart/form-data">
          {!! csrf_field() !!}
          <div class="modal-body">
            <div class="tab-content">
              <div class="tab-pane active" id="tab_Dokumen">
                <div class="box-body">
                  <table class="table">
                    <tbody>
                      <tr>
                        <th width="500px">Nama Dokumen</th>
                        <th width="700px">Unggah Dokumen</th>
                      </tr>
                      <tr>
                        <td>
                          <div>
                            <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                              foreach ($DataPegawai as $k) {
                                echo $k->id;
                              }
                            ?>">
                            <input class="form-control" type="hidden" name="nip" value="<?php
                              foreach ($DataPegawai as $k) {
                                echo $k->nip;
                              }
                            ?>">
                            <input type="hidden" name="id" id="iddokumen">
                            <input type="text" name="namadokumen" class="form-control" placeholder="Nama Dokumen" id="editnamadokumen">
                          </div>
                        </td>
                        <td>
                          <div>
                            <input type="file" name="unggahdokumen" class="form-control" id="editunggahdokumen">
                            <span style="color:#001f3f;">* Biarkan kosong jika tidak ingin diganti.</span>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Modal Tambah Histori Pekerjaan --}}
  <div class="modal modal-default fade" id="modalhistoripegawai" role="dialog">
    <div class="modal-dialog" style="width:600px;">
      <!-- Modal content-->
      <form class="form-horizontal" action="{{route('historipegawai.create')}}" method="post">
        {!! csrf_field() !!}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tambah Histori Pekerjaan</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <div class="col-sm-1"></div>
              <div class="col-sm-8">
                <div class="input-group">
                  <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                    foreach ($DataPegawai as $k) {
                      echo $k->id;
                    }
                  ?>">
                  <input class="form-control" type="hidden" name="nip" value="<?php
                    foreach ($DataPegawai as $k) {
                      echo $k->nip;
                    }
                  ?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-1"></div>
              <label class="col-sm-2">Keterangan</label>
              <div class="col-sm-8">
                <textarea name="keterangan" rows="4" cols="40" class="form-control"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  {{-- Modal Edit Histori Pekerjaan --}}
  <div class="modal modal-default fade" id="edithistoripegawai" role="dialog">
    <div class="modal-dialog" style="width:600px;">
      <!-- Modal content-->
      <form class="form-horizontal" action="{{route('historipegawai.update')}}" method="post">
        {!! csrf_field() !!}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Ubah Histori Pekerjaan</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <div class="col-sm-1"></div>
              <div class="col-sm-8">
                <div class="input-group">
                  <input class="form-control" type="hidden" name="id_pegawai" value="<?php
                    foreach ($DataPegawai as $k) {
                      echo $k->id;
                    }
                  ?>">
                  <input class="form-control" type="hidden" name="nip" value="<?php
                    foreach ($DataPegawai as $k) {
                      echo $k->nip;
                    }
                  ?>">
                  <input type="hidden" name="id" id="idhistoripekerjaan">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-1"></div>
              <label class="col-sm-2">Keterangan Peringatan</label>
              <div class="col-sm-8">
                <textarea name="keterangan" rows="4" cols="40" class="form-control" id="edit_keterangan"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="row">
    <script>
      window.setTimeout(function() {
        $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
      }, 2000);
    </script>

    <div class="col-md-12">
      @if(Session::has('message'))
        <div class="alert alert-success">
          <h4>Berhasil!</h4>
          <p>{{ Session::get('message') }}</p>
        </div>
      @endif
    </div>

    <div class="col-md-4">
      <!-- Data Pegawai -->
      <div class="box box-primary">
        <div class="box-body box-profile">
          @foreach($DataPegawai as $pegawai)
          <img class="profile-user-img img-responsive img-circle" src="{{ asset('dist/img/user2-160x160.jpg')}}" alt="User profile picture">
          <h3 class="profile-username text-center">{{$pegawai->nama}}</h3>
          <form action="{{url('masterpegawai/savepegawai')}}" method="post">
            {!! csrf_field() !!}
          <table class="table table-condensed">
            <tbody>
              <tr id="tdtextnama">
                <td>Nama</td>
                <td>:</td>
                <td id="tdlabelnama"><b>{{ $pegawai->nama}}</b></td>
                <td class="{{ $errors->has('nama') ? 'has-error' : ''}}">
                    <input type="text" class="form-control" name="nama"
                    @if($errors->has('nama'))
                      value="{{ old('nama')}}"
                    @else value="{{ $pegawai->nama }}"
                    @endif >
                    @if($errors->has('nama'))
                     <span class="help-block">
                       <strong>{{ $errors->first('nama')}}
                       </strong>
                     </span>
                    @endif
                </td>
              </tr>
              <tr>
                <td>NIP</td>
                <td>:</td>
                <td id="tdlabelnip"><b>{{ $pegawai->nip}}</b></td>
                <td id="tdtextnip" class="{{ $errors->has('nip') ? 'has-error' : '' }}">
                  <input type="text" class="form-control" name="nip"
                    @if($errors->has('nip'))
                      value="{{old('nip')}}"
                    @else
                      value="{{$pegawai->nip}}"
                    @endif
                  >
                  @if($errors->has('nip'))
                   <span class="help-block">
                     <strong>{{ $errors->first('nip')}}
                     </strong>
                   </span>
                  @endif
                </td>
              </tr>
              <tr>
                <td>NIP Lama</td>
                <td>:</td>
                <td id="tdlabelniplama"><b>{{ $pegawai->nip_lama}}</b></td>
                <td id="tdtextniplama" class="{{ $errors->has('niplama') ? 'has-error' : '' }}">
                  <input type="text" class="form-control" name="niplama"
                    @if($errors->has('niplama'))
                      value="{{old('niplama')}}"
                    @else
                      value="{{$pegawai->nip_lama}}"
                    @endif
                  >
                  @if($errors->has('niplama'))
                   <span class="help-block">
                     <strong>{{ $errors->first('niplama')}}
                     </strong>
                   </span>
                  @endif
                </td>
              </tr>
              <tr>
                <td>Tanggal Lahir</td>
                <td>:</td>
                <td id="tdlabeltgllahir"><b>{{ $pegawai->tanggal_lahir}}</b></td>
                <td id="tdtexttgllahir" class="{{ $errors->has('tgllahir') ? 'has-error' : '' }}">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control" name="tgllahir" id="tanggal_lahir"
                      @if($errors->has('tgllahir'))
                        value="{{old('tgllahir')}}"
                      @else
                        value="{{$pegawai->tanggal_lahir}}"
                      @endif
                    >
                    @if($errors->has('tgllahir'))
                     <span class="help-block">
                       <strong>{{ $errors->first('tgllahir')}}
                       </strong>
                     </span>
                    @endif
                  </div><!-- /.input group -->
                </td>
              </tr>
              <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td id="tdlabeljk"><b>@if($pegawai->jenis_kelamin == 'L')
                 Pria
               @else
                 Wanita
               @endif</b></td>
               <td id="tdtextjk">
                 @if($pegawai->jenis_kelamin=="L")
                   <label>
                     <input type="radio" name="jenis_kelamin" class="minimal" value="L" checked="true">
                   </label>
                   <label>Pria</label>
                   &nbsp;&nbsp;&nbsp;
                   <label>
                     <input type="radio" name="jenis_kelamin" class="minimal" value="P">
                   </label>
                   <label>Wanita</label>
                 @else
                   <label>
                     <input type="radio" name="jenis_kelamin" class="minimal" value="L">
                   </label>
                   <label>Pria</label>
                   &nbsp;&nbsp;&nbsp;
                   <label>
                     <input type="radio" name="jenis_kelamin" class="minimal" value="P" checked="true">
                   </label>
                   <label>Wanita</label>
                 @endif
                 @if($errors->has('jenis_kelamin'))
                  <span class="help-block">
                    <strong>{{ $errors->first('jenis_kelamin')}}
                    </strong>
                  </span>
                 @endif
               </td>
              </tr>
              <tr>
                <td>E-mail</td>
                <td>:</td>
                <td id="tdlabelemail"><b>{{ $pegawai->email}}</b></td>
                <td id="tdtextemail" class="{{ $errors->has('email') ? 'has-error' : '' }}">
                  <input type="email" class="form-control" name="email"
                    @if($errors->has('email'))
                      value="{{old('email')}}"
                    @else
                      value="{{$pegawai->email}}"
                    @endif
                  >
                  @if($errors->has('email'))
                   <span class="help-block">
                     <strong>{{ $errors->first('email')}}
                     </strong>
                   </span>
                  @endif
                </td>
              </tr>
              <tr>
                <td>Agama</td>
                <td>:</td>
                <td id="tdlabelagama"><b data-value="{{$pegawai->agama}}" id="valagama">{{ $pegawai->agama }}</b></td>
                <td id="tdtextagama" class="{{ $errors->has('agama') ? 'has-error' : '' }}">
                  <select class="form-control" name="agama">
                    <option>-- Pilih --</option>
                    <option value="Islam" id="valislam" {{(old('agama')=="Islam") ? 'selected' : ''}}>Islam</option>
                    <option value="Kristen" id="valkristen" {{(old('agama')=="Kristen") ? 'selected' : ''}}>Kristen</option>
                    <option value="Hindu" id="valhindu" {{(old('agama')=="Hindu") ? 'selected' : ''}}>Hindu</option>
                    <option value="Budha" id="valbudha" {{(old('agama')=="Budha") ? 'selected' : ''}}>Budha</option>
                    <option value="Lainnya" id="vallain" {{(old('agama')=="Lainnya") ? 'selected' : ''}}>Lainnya</option>
                  </select>
                  @if($errors->has('agama'))
                   <span class="help-block">
                     <strong>{{ $errors->first('agama')}}
                     </strong>
                   </span>
                  @endif
                </td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td>:</td>
                <td id="tdlabelalamat"><b>{{ $pegawai->alamat}}</b></td>
                <td id="tdtextalamat" class="{{ $errors->has('alamat') ? 'has-error' : '' }}">
                  <textarea name="alamat" class="form-control" rows="3">{{$errors->has('alamat') ? old('alamat') : $pegawai->alamat}}</textarea>
                  @if($errors->has('alamat'))
                   <span class="help-block">
                     <strong>{{ $errors->first('alamat')}}
                     </strong>
                   </span>
                  @endif
                </td>
              </tr>
              <tr>
                <td>No Telp</td>
                <td>:</td>
                <td id="tdlabeltelp"><b>{{ $pegawai->no_telp}}</b></td>
                <td id="tdtexttelp" class="{{ $errors->has('telp') ? 'has-error' : '' }}">
                  <input type="text" name="telp" class="form-control"
                  @if($errors->has('telp'))
                    value="{{old('telp')}}"
                  @else
                    value="{{$pegawai->no_telp}}"
                  @endif
                  >
                  @if($errors->has('telp'))
                   <span class="help-block">
                     <strong>{{ $errors->first('telp')}}
                     </strong>
                   </span>
                  @endif
                </td>
              </tr>
              <tr>
                <td>No KTP</td>
                <td>:</td>
                <td id="tdlabelktp"><b>{{ $pegawai->no_ktp}}</b></td>
                <td id="tdtextktp" class="{{ $errors->has('ktp') ? 'has-error' : '' }}">
                  <input type="text" name="ktp" class="form-control"
                    @if($errors->has('ktp'))
                      value="{{old('ktp')}}"
                    @else
                      value="{{$pegawai->no_ktp}}"
                    @endif
                  >
                  @if($errors->has('ktp'))
                   <span class="help-block">
                     <strong>{{ $errors->first('ktp')}}
                     </strong>
                   </span>
                  @endif
                </td>
              </tr>
              <tr>
                <td>No KK</td>
                <td>:</td>
                <td id="tdlabelkk"><b>{{ $pegawai->no_kk}}</b></td>
                <td id="tdtextkk" class="{{ $errors->has('kk') ? 'has-error' : '' }}">
                  <input type="text" name="kk" class="form-control"
                    @if($errors->has('kk'))
                      value="{{old('kk')}}"
                    @else
                      value="{{$pegawai->no_kk}}"
                    @endif
                  >
                  @if($errors->has('kk'))
                   <span class="help-block">
                     <strong>{{ $errors->first('kk')}}
                     </strong>
                   </span>
                  @endif
                </td>
              </tr>
              <tr>
                <td>No NPWP</td>
                <td>:</td>
                <td id="tdlabelnpwp"><b>{{ $pegawai->no_npwp}}</b></td>
                <td id="tdtextnpwp" class="{{ $errors->has('npwp') ? 'has-error' : '' }}">
                  <input type="text" name="npwp" class="form-control"
                    @if($errors->has('npwp'))
                      value="{{old('npwp')}}"
                    @else
                      value="{{$pegawai->no_npwp}}"
                    @endif
                  >
                  @if($errors->has('npwp'))
                   <span class="help-block">
                     <strong>{{ $errors->first('npwp')}}
                     </strong>
                   </span>
                  @endif
                </td>
              </tr>
              <tr>
                <td>BPJS Ketenagakerjaan</td>
                <td>:</td>
                <td id="tdlabelbpjskerja"><b>{{ $pegawai->bpjs_ketenagakerjaan}}</b></td>
                <td id="tdtextbpjskerja" class="{{ $errors->has('bpjskerja') ? 'has-error' : '' }}">
                  <input type="text" name="bpjskerja" class="form-control"
                    @if($errors->has('bpjskerja'))
                      value="{{old('bpjskerja')}}"
                    @else
                      value="{{$pegawai->bpjs_ketenagakerjaan}}"
                    @endif
                  >
                  @if($errors->has('bpjskerja'))
                   <span class="help-block">
                     <strong>{{ $errors->first('bpjskerja')}}
                     </strong>
                   </span>
                  @endif
                </td>
              </tr>
              <tr>
                <td>BPJS Kesehatan</td>
                <td>:</td>
                <td id="tdlabelbpjssehat"><b>{{ $pegawai->bpjs_kesehatan}}</b></td>
                <td id="tdtextbpjssehat" class="{{ $errors->has('bpjssehat') ? 'has-error' : '' }}">
                  <input type="text" name="bpjssehat" class="form-control"
                    @if($errors->has('bpjssehat'))
                      value="{{old('bpjssehat')}}"
                    @else
                      value="{{$pegawai->bpjs_kesehatan}}"
                    @endif
                  >
                  @if($errors->has('bpjssehat'))
                   <span class="help-block">
                     <strong>{{ $errors->first('bpjssehat')}}
                     </strong>
                   </span>
                  @endif
                </td>
              </tr>
              <tr>
                <td>Bank</td>
                <td>:</td>
                <td id="tdlabelbank"><b data-value="{{$pegawai->bank}}" id="valbank">{{ $pegawai->bank}}</b></td>
                <td id="tdtextbank" class="{{ $errors->has('bank') ? 'has-error' : '' }}">
                  <select class="form-control" name="bank">
                    <option value="-- Pilih --">-- Pilih --</option>
                    @if(count($errors)>0)
                      @foreach($DataBank as $key)
                        @if(old('bank')==$key->id)
                          <option value="{{$key->id}}" selected>{{$key->nama_bank}}</option>
                        @else
                          <option value="{{$key->id}}">{{$key->nama_bank}}</option>
                        @endif
                      @endforeach
                    @else
                      @foreach($DataBank as $key)
                        @if($pegawai->bank==$key->nama_bank)
                          <option value="{{$key->id}}" selected>{{$key->nama_bank}}</option>
                        @else
                          <option value="{{$key->id}}">{{$key->nama_bank}}</option>
                        @endif
                      @endforeach
                    @endif
                  </select>
                  @if($errors->has('bank'))
                   <span class="help-block">
                     <strong>{{ $errors->first('bank')}}
                     </strong>
                   </span>
                  @endif
                </td>
              </tr>
              <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td id="tdlabeljabatan"><b data-value="{{$pegawai->jabatan}}" id="valbank">{{ $pegawai->nama_jabatan}}</b></td>
                <td id="tdtextjabatan" class="{{ $errors->has('jabatan') ? 'has-error' : '' }}">
                  <select class="form-control" name="jabatan">
                    <option value="-- Pilih --">-- Pilih --</option>
                    @if(count($errors)>0)
                      @foreach($DataJabatan as $key)
                        @if(old('nama_jabatan')==$key->id)
                          <option value="{{$key->id}}" selected>{{$key->nama_jabatan}}</option>
                        @else
                          <option value="{{$key->id}}">{{$key->nama_jabatan}}</option>
                        @endif
                      @endforeach
                    @else
                      @foreach($DataJabatan as $key)
                        @if($pegawai->nama_jabatan==$key->nama_jabatan)
                          <option value="{{$key->id}}" selected>{{$key->nama_jabatan}}</option>
                        @else
                          <option value="{{$key->id}}">{{$key->nama_jabatan}}</option>
                        @endif
                      @endforeach
                    @endif
                  </select>
                  @if($errors->has('jabatan'))
                   <span class="help-block">
                     <strong>{{ $errors->first('jabatan')}}
                     </strong>
                   </span>
                  @endif
                </td>
              </tr>
              <tr>
                <td>No Rekening</td>
                <td>:</td>
                <td id="tdlabelrekening"><b>{{ $pegawai->no_rekening}}</b></td>
                <td id="tdtextrekening" class="{{ $errors->has('rekening') ? 'has-error' : '' }}">
                  <input type="text" name="rekening" class="form-control"
                    @if($errors->has('rekening'))
                      value="{{old('rekening')}}"
                    @else
                      value="{{$pegawai->no_rekening}}"
                    @endif
                  >
                  @if($errors->has('rekening'))
                   <span class="help-block">
                     <strong>{{ $errors->first('rekening')}}
                     </strong>
                   </span>
                  @endif
                </td>
              </tr>
              <tr>
                <td>Kewarganegaraan</td>
                <td>:</td>
                <td id="tdlabelwarga"><b data-value="{{$pegawai->kewarganegaraan}}" id="valwarga">{{ $pegawai->kewarganegaraan}}</b></td>
                <td id="tdtextwarga" class="{{ $errors->has('warga') ? 'has-error' : '' }}">
                  <select class="form-control" name="warga">
                    <option>-- Pilih --</option>
                    <option value="WNI" id="valwni" {{(old('warga')=="WNI") ? 'selected' : ''}}>WNI</option>
                    <option value="WNA" id="valwna" {{(old('warga')=="WNA") ? 'selected' : ''}}>WNA</option>
                  </select>
                  @if($errors->has('warga'))
                   <span class="help-block">
                     <strong>{{ $errors->first('warga')}}
                     </strong>
                   </span>
                  @endif
                  <input type="hidden" name="id_pegawai" class="form-control" value="{{$pegawai->id}}">
                </td>
              </tr>
               <tr>
                <td>Jam Training</td>
                <td>:</td>
                <td id="tdlabeljamtraining"><b>{{ $pegawai->jam_training}}</b></td>
                <td id="tdtextjamtraining" class="{{ $errors->has('jam_training') ? 'has-error' : '' }}">
                  <input type="text" name="jam_training" class="form-control"
                    @if($errors->has('jam_training'))
                      value="{{old('jam_training')}}"
                    @else
                      value="{{$pegawai->jam_training}}"
                    @endif
                  >
                  @if($errors->has('jam_training'))
                   <span class="help-block">
                     <strong>{{ $errors->first('jam_training')}}
                     </strong>
                   </span>
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
          @if (session('level') == 1)
            <a class="btn btn-xs bg-yellow pull-right" id="editpegawai"><i class="fa fa-edit"></i> Edit Data Pegawai</a>
          @endif
          <button type="submit" class="btn btn-xs bg-blue pull-right" id="btnsavepegawai"><i class="fa fa-check"></i> Simpan Perubahan</button>
        </form>
          @endforeach
        </div><!-- /.box-body -->
      </div>
      <!-- End Data Pegawai -->
    </div>
    <!-- End Row 3 -->
    <div class="col-md-8">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tabKeluarga" data-toggle="tab">Data Utama</a></li>
          <li><a href="#dPengalaman" data-toggle="tab">Data Tambahan</a></li>
          <li><a href="#dKesehatan" data-toggle="tab">Data Kesehatan</a></li>
          <li><a href="#dPendukung" data-toggle="tab">Dokumen Pendukung</a></li>
          <li><a href="#dRiwayatKerja" data-toggle="tab">Riwayat Kerja</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="tabKeluarga">
            <h3>Data Keluarga</h3>
            @if (session('level') == 1)
              <button class="btn btn-xs bg-maroon" data-toggle="modal" data-target="#modalkeluarga"><i class="fa fa-plus"></i> Tambah Data Keluarga</button>
            @endif
            <table class="table table-bordered">
              <tbody>
                <tr class="bg-navy">
                  <th>Nama</th>
                  <th>Hubungan</th>
                  <th>Tanggal Lahir</th>
                  <th>Pekerjaan</th>
                  <th>Jenis Kelamin</th>
                  <th>Alamat</th>
                  @if (session('level') == 1)
                    <th>Aksi</th>
                  @endif
                </tr>
                @if(count($DataKeluarga)!=0)
                  @foreach($DataKeluarga as $keluarga)
                    <tr>
                      <td>{{ $keluarga->nama_keluarga }}</td>
                      <td>{{ $keluarga->hubungan_keluarga }}</td>
                      <td>{{ $keluarga->tanggal_lahir_keluarga }}</td>
                      <td>{{ $keluarga->pekerjaan_keluarga }}</td>
                      <td>@if($keluarga->jenis_kelamin_keluarga == 'L')
                        Pria
                      @else
                        Wanita
                      @endif</td>
                      <td>{{ $keluarga->alamat_keluarga }}</td>
                      @if (session('level') == 1)
                        <td>
                          <span data-toggle="tooltip" title="Hapus Data">
                            <a href="" class="btn btn-xs btn-danger hapuskeluarga" data-toggle="modal" data-target="#hapuskeluarga" data-value="{{$keluarga->id}}"><i class="fa fa-remove"></i></a>
                          </span>
                          <span data-toggle="tooltip" title="Edit Data">
                            <a href="" class="btn btn-xs btn-warning editkeluarga" data-toggle="modal" data-target="#editkeluarga" data-value="{{$keluarga->id}}"><i class="fa fa-edit"></i></a>
                          </span>
                        </td>
                      @endif
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="7" align="center" class="text-muted"><i>Data tidak tersedia.</i></td>
                  </tr>
                @endif
              </tbody>
            </table>

            <h3>Pendidikan</h3>
            @if (session('level') == 1)
              <button class="btn btn-xs bg-maroon" data-toggle="modal" data-target="#modalpendidikan"><i class="fa fa-plus"></i> Tambah Data Pendidikan</button>
            @endif
            <table class="table table-bordered">
              <tbody>
                <tr class="bg-navy">
                  <th>Jenjang</th>
                  <th>Institusi</th>
                  <th>Tahun Masuk</th>
                  <th>Tahun Lulus</th>
                  <th>Gelar</th>
                  @if (session('level') == 1)
                    <th>Aksi</th>
                  @endif
                </tr>
                @if(count($DataPendidikan)!=0)
                  @foreach($DataPendidikan as $pendidikan)
                    <tr>
                      <td>{{ $pendidikan->jenjang_pendidikan }}</td>
                      <td>{{ $pendidikan->institusi_pendidikan }}</td>
                      <td>{{ $pendidikan->tahun_masuk_pendidikan }}</td>
                      <td>{{ $pendidikan->tahun_lulus_pendidikan }}</td>
                      <td>{{ $pendidikan->gelar_akademik }}</td>
                      @if (session('level') == 1)
                        <td>
                          <span data-toggle="tooltip" title="Hapus Data">
                            <a href="" class="btn btn-xs btn-danger hapuspendidikan" data-toggle="modal" data-target="#hapuspendidikan" data-value="{{$pendidikan->id}}"><i class="fa fa-remove"></i></a>
                          </span>
                          <span data-toggle="tooltip" title="Edit Data">
                            <a href="" class="btn btn-xs btn-warning editpendidikan" data-toggle="modal" data-target="#editpendidikan" data-value="{{$pendidikan->id}}"><i class="fa fa-edit"></i></a>
                          </span>
                        </td>
                      @endif
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="6" align="center" class="text-muted"><i>Data tidak tersedia.</i></td>
                  </tr>
                @endif
              </tbody>
            </table>

            <h3>Hubungan Darurat</h3>
            <table class="table table-bordered">
              <tbody>
                <tr class="bg-navy">
                  <th>Nama</th>
                  <th>Hubungan Darurat</th>
                  <th>Alamat</th>
                  <th>Telepon</th>
                  @if (session('level') == 1)
                    <th>Aksi</th>
                  @endif
                </tr>
                @if(count($DataPegawai)!=0)
                  @foreach($DataPegawai as $darurat)
                    <tr>
                      <td>
                        @if ($darurat->nama_darurat!="")
                          {{ $darurat->nama_darurat }}
                        @else
                          -
                        @endif
                      </td>
                      <td>
                        @if ($darurat->hubungan_darurat!="")
                          {{ $darurat->hubungan_darurat }}
                        @else
                          -
                        @endif
                      </td>
                      <td>
                        @if ($darurat->alamat_darurat!="")
                          {{ $darurat->alamat_darurat }}
                        @else
                          -
                        @endif
                      </td>
                      <td>
                        @if ($darurat->telepon_darurat!="")
                          {{ $darurat->telepon_darurat }}
                        @else
                          -
                        @endif
                      </td>
                      @if (session('level') == 1)
                        <td>
                          <span data-toggle="tooltip" title="Edit Data">
                            <a href="" class="btn btn-xs btn-warning editdarurat" data-toggle="modal" data-target="#editdarurat" data-value="{{$darurat->id}}"><i class="fa fa-edit"></i></a>
                          </span>
                        </td>
                      @endif
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="5" align="center" class="text-muted"><i>Data tidak tersedia.</i></td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div><!-- /.End Keluarga -->
          <div class="tab-pane" id="dPengalaman">
            <h3>Pengalaman Kerja</h3>
            @if (session('level') == 1)
              <button class="btn btn-xs bg-maroon" data-toggle="modal" data-target="#modalpengalaman"><i class="fa fa-plus"></i> Tambah Data Pengalaman Kerja</button>
            @endif
            <table class="table table-bordered">
              <tbody>
                <tr class="bg-navy">
                  <th>Nama Perusahaan</th>
                  <th>Posisi</th>
                  <th>Tahun Awal Kerja</th>
                  <th>Tahun Akhir Kerja</th>
                  @if (session('level') == 1)
                    <th>Aksi</th>
                  @endif
                </tr>
                @if(count($DataPengalaman)!=0)
                  @foreach($DataPengalaman as $pengalaman)
                    <tr>
                      <td>{{ $pengalaman->nama_perusahaan }}</td>
                      <td>{{ $pengalaman->posisi_perusahaan }}</td>
                      <td>{{ $pengalaman->tahun_awal_kerja }}</td>
                      <td>{{ $pengalaman->tahun_akhir_kerja }}</td>
                      @if (session('level') == 1)
                        <td>
                          <span data-toggle="tooltip" title="Hapus Data">
                            <a href="" class="btn btn-xs btn-danger hapuspengalaman" data-toggle="modal" data-target="#hapuspengalaman" data-value="{{$pengalaman->id}}"><i class="fa fa-remove"></i></a>
                          </span>
                          <span data-toggle="tooltip" title="Edit Data">
                            <a href="" class="btn btn-xs btn-warning editpengalaman" data-toggle="modal" data-target="#editpengalaman" data-value="{{$pengalaman->id}}"><i class="fa fa-edit"></i></a>
                          </span>
                        </td>
                      @endif
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="5" align="center" class="text-muted"><i>Data tidak tersedia.</i></td>
                  </tr>
                @endif
              </tbody>
            </table>

            <h3>Keahlian Komputer</h3>
            @if (session('level') == 1)
              <button class="btn btn-xs bg-maroon" data-toggle="modal" data-target="#modalkomputer"><i class="fa fa-plus"></i> Tambah Data Keahlian Komputer</button>
            @endif
            <table class="table table-bordered">
              <tbody>
                <tr class="bg-navy">
                  <th>Nama Program</th>
                  <th>Nilai</th>
                  @if (session('level') == 1)
                    <th>Aksi</th>
                  @endif
                </tr>
                @if(count($DataKomputer)!=0)
                  @foreach($DataKomputer as $komputer)
                    <tr>
                      <td>{{ $komputer->nama_program }}</td>
                      <td>@if($komputer->nilai_komputer == '1')
                        Baik
                      @elseif($komputer->nilai_komputer == '2')
                        Cukup
                      @else
                        Kurang
                      @endif</td>
                      @if (session('level') == 1)
                        <td>
                          <span data-toggle="tooltip" title="Hapus Data">
                            <a href="" class="btn btn-xs btn-danger hapuskomputer" data-toggle="modal" data-target="#hapuskomputer" data-value="{{$komputer->id}}"><i class="fa fa-remove"></i></a>
                          </span>
                          <span data-toggle="tooltip" title="Edit Data">
                            <a href="" class="btn btn-xs btn-warning editkomputer" data-toggle="modal" data-target="#editkomputer" data-value="{{$komputer->id}}"><i class="fa fa-edit"></i></a>
                          </span>
                        </td>
                      @endif
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="3" align="center" class="text-muted"><i>Data tidak tersedia.</i></td>
                  </tr>
                @endif
              </tbody>
            </table>

            <h3>Bahasa Asing</h3>
            @if (session('level') == 1)
              <button class="btn btn-xs bg-maroon" data-toggle="modal" data-target="#modalbahasa"><i class="fa fa-plus"></i> Tambah Data Bahasa Asing</button>
            @endif
            <table class="table table-bordered">
              <tbody>
                <tr class="bg-navy">
                  <th>Bahasa</th>
                  <th>Berbicara</th>
                  <th>Menulis</th>
                  <th>Mengerti</th>
                  @if (session('level') == 1)
                    <th>Aksi</th>
                  @endif
                </tr>
                @if(count($DataBahasa)!=0)
                  @foreach($DataBahasa as $bahasa)
                    <tr>
                      <td>{{ $bahasa->bahasa }}</td>
                      <td>@if($bahasa->berbicara == '1')
                        Baik
                      @elseif($bahasa->berbicara == '2')
                        Cukup
                      @else
                        Kurang
                      @endif</td>
                      <td>@if($bahasa->menulis == '1')
                        Baik
                      @elseif($bahasa->menulis == '2')
                        Cukup
                      @else
                        Kurang
                      @endif</td>
                      <td>@if($bahasa->mengerti == '1')
                        Baik
                      @elseif($bahasa->mengerti == '2')
                        Cukup
                      @else
                        Kurang
                      @endif</td>
                      @if (session('level') == 1)
                        <td>
                          <span data-toggle="tooltip" title="Hapus Data">
                            <a type="button" class="btn btn-xs btn-danger hapusbahasa" data-toggle="modal" data-target="#hapusbahasa" data-value="{{$bahasa->id}}"><i class="fa fa-remove"></i></a>
                          </span>
                          <span data-toggle="tooltip" title="Edit Data">
                            <a href="" class="btn btn-xs btn-warning editbahasa" data-toggle="modal" data-target="#editbahasa" data-value="{{$bahasa->id}}"><i class="fa fa-edit"></i></a>
                          </span>
                        </td>
                      @endif
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="5" align="center" class="text-muted"><i>Data tidak tersedia.</i></td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div><!-- /.End Pengalaman -->
          <div class="tab-pane" id="dKesehatan">
            <h3>Kondisi Kesehatan</h3>
            @if (session('level') == 1)
              @if (count($DataKesehatan)==0)
                <button class="btn btn-xs bg-maroon" data-toggle="modal" data-target="#modalsetkesehatan"><i class="fa fa-plus"></i> Set Data Kondisi Kesehatan</button>
              @endif
            @endif
            <table class="table table-bordered">
              <tbody>
                <tr class="bg-navy">
                  <th>Tinggi Badan</th>
                  <th>Berat Badan</th>
                  <th>Warna Rambut</th>
                  <th>Warna Mata</th>
                  <th>Berkacamata</th>
                  <th>Merokok</th>
                  @if (session('level') == 1)
                    <th>Aksi</th>
                  @endif
                </tr>
                @if(count($DataKesehatan)!=0)
                  @foreach($DataKesehatan as $kesehatan)
                    <tr>
                      <td>
                        @if ($kesehatan->tinggi_badan!="0")
                          {{ $kesehatan->tinggi_badan }} CM
                        @else
                          -
                        @endif
                      </td>
                      <td>
                        @if ($kesehatan->berat_badan!="0")
                          {{ $kesehatan->berat_badan }} KG
                        @else
                          -
                        @endif
                      </td>
                      <td>
                        @if ($kesehatan->warna_rambut!="")
                          {{ $kesehatan->warna_rambut }}
                        @else
                          -
                        @endif
                      </td>
                      <td>
                        @if ($kesehatan->warna_mata!="")
                          {{ $kesehatan->warna_mata }}
                        @else
                          -
                        @endif
                      </td>
                      <td>
                        @if (!is_null($kesehatan->berkacamata))
                          @if($kesehatan->berkacamata == '0')
                            Tidak
                          @elseif ($kesehatan->berkacamata == '1')
                            Ya
                          @endif
                        @else
                          -
                        @endif
                        </td>
                      <td>
                        @if (!is_null($kesehatan->merokok))
                          @if($kesehatan->merokok == '0')
                            Tidak
                          @elseif ($kesehatan->merokok == '1')
                            Ya
                          @endif
                        @else
                          -
                        @endif
                      @if (session('level') == 1)
                        <td>
                          <span data-toggle="tooltip" title="Edit Data">
                            <a href="" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modalkesehatan" data-value="{{$kesehatan->id}}"><i class="fa fa-edit"></i></a>
                          </span>
                        </td>
                      @endif
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="7" align="center" class="text-muted"><i>Data tidak tersedia.</i></td>
                  </tr>
                @endif
              </tbody>
            </table>

            <h3>Riwayat Penyakit</h3>
            @if (session('level') == 1)
              <button class="btn btn-xs bg-maroon" data-toggle="modal" data-target="#modalpenyakit"><i class="fa fa-plus"></i> Tambah Data Riwayat Penyakit</button>
            @endif
            <table class="table table-bordered">
              <tbody>
                <tr class="bg-navy">
                  <th>Nama Penyakit</th>
                  <th>Keterangan</th>
                  @if (session('level') == 1)
                    <th>Aksi</th>
                  @endif
                </tr>
                @if(count($DataPenyakit)!=0)
                  @foreach($DataPenyakit as $penyakit)
                    <tr>
                      <td>{{ $penyakit->nama_penyakit }}</td>
                      <td>{{ $penyakit->keterangan_penyakit }}</td>
                      @if (session('level') == 1)
                        <td>
                          <span data-toggle="tooltip" title="Hapus Data">
                            <a href="" class="btn btn-xs btn-danger hapuspenyakit" data-toggle="modal" data-target="#hapuspenyakit" data-value="{{$penyakit->id}}"><i class="fa fa-remove"></i></a>
                          </span>
                          <span data-toggle="tooltip" title="Edit Data">
                            <a href="" class="btn btn-xs btn-warning editpenyakit" data-toggle="modal" data-target="#editpenyakit" data-value="{{$penyakit->id}}"><i class="fa fa-edit"></i></a>
                          </span>
                        </td>
                      @endif
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="3" align="center" class="text-muted"><i>Data tidak tersedia.</i></td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div><!-- /.End Kesehatan -->
          <div class="tab-pane" id="dPendukung">
            <h3>Dokumen Pegawai</h3>
            @if (session('level') == 1)
              <button class="btn btn-xs bg-maroon" data-toggle="modal" data-target="#modaldokumenpegawai"><i class="fa fa-plus"></i> Tambah Dokumen Pegawai</button>
            @endif
            <table class="table table-bordered">
              <tbody>
                <tr class="bg-navy">
                  <th>Nama Dokumen</th>
                  <th>Dokumen</th>
                  @if (session('level') == 1)
                    <th>Aksi</th>
                  @endif
                </tr>
                @if(count($DokumenPegawai)!=0)
                  @foreach($DokumenPegawai as $key)
                    <tr>
                      <td>{{$key->nama_dokumen}}</td>
                      <td>
                        <a href="{{url('documents')}}/{{$key->file_dokumen}}" download>
                          <img src="{{asset('dist/img/jpg.png')}}" width="10%"/>
                        </a>
                      </td>
                      @if (session('level') == 1)
                        <td>
                          <span data-toggle="tooltip" title="Hapus Data">
                            <a href="" class="btn btn-xs btn-danger hapusdokumen" data-toggle="modal" data-target="#hapusdokumen" data-value="{{$key->id}}"><i class="fa fa-remove"></i></a>
                          </span>
                          <span data-toggle="tooltip" title="Edit Data">
                            <a href="" class="btn btn-xs btn-warning editdokumen" data-toggle="modal" data-target="#editdokumenpegawai" data-value="{{$key->id_pegawai}}"><i class="fa fa-edit"></i></a>
                          </span>
                        </td>
                      @endif
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="3" align="center" class="text-muted"><i>Data tidak tersedia.</i></td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
          <div class="tab-pane" id="dRiwayatKerja">
            <h3>Riwayat Area Bekerja</h3>
            <table class="table table-bordered">
              <tbody>
                <tr class="bg-navy">
                  <th>#</th>
                  <th>Nama Client</th>
                  <th>Cabang Client</th>
                  <th>Tahun Awal</th>
                  <th>Tahun Akhir</th>
                  <th>Status PKWT</th>
                </tr>
                @if(count($DataPKWT)!=0)
                  <?php $i = 1; ?>
                  @foreach($DataPKWT as $key)
                    <tr>
                      <td>{{$i}}</td>
                      <td>{{$key->nama_client}}</td>
                      <td>{{$key->nama_cabang}}</td>
                      <td>{{$key->tahun_awal}}</td>
                      <td>{{$key->tahun_akhir}}</td>
                      <td>
                        @if($key->status_karyawan_pkwt=="1")
                          Kontrak
                        @elseif($key->status_karyawan_pkwt=="2")
                          Freelance
                        @elseif($key->status_karyawan_pkwt=="3")
                          Tetap
                        @endif
                      </td>
                    </tr>
                    <?php $i++; ?>
                  @endforeach
                @else
                  <tr>
                    <td colspan="6" align="center" class="text-muted"><i>Data tidak tersedia.</i></td>
                  </tr>
                @endif
              </tbody>
            </table>

            <h3>Riwayat Peringatan</h3>
            @if (session('level') == 1)
              <button class="btn btn-xs bg-maroon" data-toggle="modal" data-target="#modalperingatan"><i class="fa fa-plus"></i> Tambah Data Peringatan Kerja</button>
            @endif
            <table class="table table-bordered">
              <tbody>
                <tr class="bg-navy">
                  <th>#</th>
                  <th>Tanggal</th>
                  <th>Jenis Peringatan</th>
                  <th>Keterangan</th>
                  <th>Dokumen</th>
                  @if (session('level') == 1)
                    <th>Aksi</th>
                  @endif
                </tr>
                @if(count($DataPeringatan)!=0)
                  <?php $i=1; ?>
                  @foreach($DataPeringatan as $key)
                    <tr>
                      <td>{{$i}}</td>
                      <td>{{$key->tanggal_peringatan}}</td>
                      <td>{{$key->jenis_peringatan}}</td>
                      <td>{{$key->keterangan_peringatan}}</td>
                      <td>
                        @if($key->dokumen_peringatan!=null)
                          <a href="{{url('/')}}/documents/{{$key->dokumen_peringatan}}" download>
                            {{$key->dokumen_peringatan}}
                          </a>
                        @else
                          -
                        @endif
                      </td>
                      @if (session('level') == 1)
                        <td>
                          <span data-toggle="tooltip" title="Hapus Data">
                            <a href="" class="btn btn-xs btn-danger hapusperingatan" data-toggle="modal" data-target="#hapusperingatan" data-value="{{$key->id}}"><i class="fa fa-remove"></i></a>
                          </span>
                          <span data-toggle="tooltip" title="Edit Data">
                            <a href="" class="btn btn-xs btn-warning editperingatan" data-toggle="modal" data-target="#editperingatan" data-value="{{$key->id}}"><i class="fa fa-edit"></i></a>
                        </td>
                      @endif
                      </tr>
                    @endforeach
                @else
                  <tr>
                    <td colspan="6" align="center" class="text-muted"><i>Data tidak tersedia.</i></td>
                  </tr>
                @endif
              </tbody>
            </table>

            <h3>Riwayat Pekerjaan</h3>
            @if (session('level') == 1)
              <button class="btn btn-xs bg-maroon" data-toggle="modal" data-target="#modalhistoripegawai"><i class="fa fa-plus"></i> Tambah Riwayat Pekerjaan</button>
            @endif
            <table class="table table-bordered">
              <tbody>
                <tr class="bg-navy">
                  <th>#</th>
                  <th>Keterangan</th>
                  @if (session('level') == 1)
                    <th>Aksi</th>
                  @endif
                </tr>
                @if(count($DataHistoriPegawai)!=0)
                  <?php $i=1; ?>
                  @foreach($DataHistoriPegawai as $key)
                    <tr>
                      <td>{{$i++}}</td>
                      <td>{{$key->keterangan}}</td>
                      @if (session('level') == 1)
                        <td>
                          <span data-toggle="tooltip" title="Edit Data">
                            <a href="" class="btn btn-xs btn-warning edithistoripegawai" data-toggle="modal" data-target="#edithistoripegawai" data-value="{{$key->id}}"><i class="fa fa-edit"></i></a>
                          </span>
                          <span data-toggle="tooltip" title="Hapus Data">
                            <a href="" class="btn btn-xs btn-danger deleteriwayat" data-toggle="modal" data-target="#deleteriwayat" data-value="{{$key->id}}"><i class="fa fa-close"></i></a>
                          </span>
                        </td>
                      @endif
                      </tr>
                    @endforeach
                @else
                  <tr>
                    <td colspan="3" align="center" class="text-muted"><i>Data tidak tersedia.</i></td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>

        </div><!-- /.tab-content -->
      </div><!-- /.nav-tabs-custom -->
    </div>
  </div>


  <!-- jQuery 2.1.4 -->
  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <!-- Bootstrap 3.3.5 -->
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <!-- FastClick -->
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('dist/js/demo.js')}}"></script>

  <!-- iCheck -->
  <script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>

  <!-- date time -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
  <script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>

  <script type="text/javascript">
    $('#editkeluarga').on('hidden.bs.modal', function () {
     location.reload();
    });
    $('#hapuskeluarga').on('hidden.bs.modal', function () {
     location.reload();
    });

    $('#editpendidikan').on('hidden.bs.modal', function () {
     location.reload();
    });
    $('#hapuspendidikan').on('hidden.bs.modal', function () {
     location.reload();
    });

    $('#editdarurat').on('hidden.bs.modal', function () {
     location.reload();
    });

    $('#editpengalaman').on('hidden.bs.modal', function () {
     location.reload();
    });
    $('#hapuspengalaman').on('hidden.bs.modal', function () {
     location.reload();
    });

    $('#editkomputer').on('hidden.bs.modal', function () {
     location.reload();
    });
    $('#hapuskomputer').on('hidden.bs.modal', function () {
     location.reload();
    });

    $('#editbahasa').on('hidden.bs.modal', function () {
     location.reload();
    });
    $('#hapusbahasa').on('hidden.bs.modal', function () {
     location.reload();
    });

    $('#modalkesehatan').on('hidden.bs.modal', function () {
     location.reload();
    });

    $('#editpenyakit').on('hidden.bs.modal', function () {
     location.reload();
    });
    $('#hapuspenyakit').on('hidden.bs.modal', function () {
     location.reload();
    });

    $('#editdokumen').on('hidden.bs.modal', function () {
     location.reload();
    });
    $('#hapusdokumen').on('hidden.bs.modal', function () {
     location.reload();
    });


    $('#editperingatan').on('hidden.bs.modal', function () {
     location.reload();
    });
    $('#hapusperingatan').on('hidden.bs.modal', function () {
     location.reload();
    });

    $('#edithistoripegawai').on('hidden.bs.modal', function () {
     location.reload();
    });
    $('#deleteriwayat').on('hidden.bs.modal', function () {
     location.reload();
    });

  </script>

  <script type="text/javascript">
    $(function(){
      $("#tanggal_peringatan").datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
      });

      $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
      });

      $('#tanggal_lahir').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
      });

      $('#edit_tanggal_peringatan').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
      });

      $('.tanggal_lahir_keluarga').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
      });

      $('.tahun_awal_kerja').datepicker({
        autoclose: true,
        format: 'yyyy',
        startView: "years",
        minViewMode: "years"
      });

      $('.tahun_akhir_kerja').datepicker({
        autoclose: true,
        format: 'yyyy',
        startView: "years",
        minViewMode: "years"
      });

      $('.tahun_masuk_pendidikan').datepicker({
        autoclose: true,
        format: 'yyyy',
        startView: "years",
        minViewMode: "years"
      });

      $('.tahun_lulus_pendidikan').datepicker({
        autoclose: true,
        format: 'yyyy',
        startView: "years",
        minViewMode: "years"
      });

      $('a.hapuskeluarga').click(function(){
        var a = $(this).data('value');
        $('#setkeluarga').attr('href', "{{ url('/') }}/masterpegawai/hapuskeluarga/"+a);
      });

      $('a.deleteriwayat').click(function(){
        var a = $(this).data('value');
        $('#setriwayat').attr('href', "{{ url('/') }}/historipegawai/delete/"+a);
      });

      $('a.hapusperingatan').click(function(){
        var a = $(this).data('value');
        $('#setperingatan').attr('href', "{{ url('/') }}/masterpegawai/hapusperingatan/"+a);
      });

      $('a.hapuspendidikan').click(function(){
        var a = $(this).data('value');
        $('#setpendidikan').attr('href', "{{ url('/') }}/masterpegawai/hapuspendidikan/"+a);
      });

      $('a.hapuskomputer').click(function(){
        var a = $(this).data('value');
        $('#setkomputer').attr('href', "{{ url('/') }}/masterpegawai/hapuskomputer/"+a);
      });

      $('a.hapusbahasa').click(function(){
        var a = $(this).data('value');
        $('#setbahasa').attr('href', "{{ url('/') }}/masterpegawai/hapusbahasa/"+a);
      });

      $('a.hapuspengalaman').click(function(){
        var a = $(this).data('value');
        $('#setpengalaman').attr('href', "{{ url('/') }}/masterpegawai/hapuspengalaman/"+a);
      });

      $('a.hapuskesehatan').click(function(){
        var a = $(this).data('value');
        $('#setkesehatan').attr('href', "{{ url('/') }}/masterpegawai/hapuskesehatan/"+a);
      });

      $('a.hapuspenyakit').click(function(){
        var a = $(this).data('value');
        $('#setpenyakit').attr('href', "{{ url('/') }}/masterpegawai/hapuspenyakit/"+a);
      });

      $('a.hapusdokumen').click(function(){
        var a = $(this).data('value');
        $('#setdokumen').attr('href', "{{ url('/') }}/masterpegawai/hapusdokumen/"+a);
      });

      $('a.editdokumen').click(function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{ url('/') }}/masterpegawai/getdokumen/"+a,
          dataType: 'json',
          success: function(data){
            var namadokumen = data.nama_dokumen;
            var iddokumen = data.id;
            $('#editnamadokumen').attr('value', namadokumen);
            $('#iddokumen').attr('value', iddokumen);
          }
        });
      });

      $('a.edithistoripegawai').click(function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{ url('/') }}/historipegawai/bind-data/"+a,
          dataType: 'json',
          success: function(data){
            var id = data.id;
            var keterangan = data.keterangan;

            $('#idhistoripekerjaan').attr('value', id);
            $('textarea#edit_keterangan').val(keterangan);
          }
        });
      });

      $('a.editperingatan').click(function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{ url('/') }}/masterpegawai/bind-peringatan/"+a,
          dataType: 'json',
          success: function(data){
            var id = data.id;
            var tanggal_peringatan = data.tanggal_peringatan;
            var jenis_peringatan = data.jenis_peringatan;
            var keterangan_peringatan = data.keterangan_peringatan;

            $('#edit_tanggal_peringatan').attr('value', tanggal_peringatan);
            $('#edit_jenis_peringatan').attr('value', jenis_peringatan);
            $('#edit_id_peringatan').attr('value', id);
            $('textarea#edit_keterangan_peringatan').val(keterangan_peringatan);
          }
        });
      });

      $('a.editkeluarga').click(function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{ url('/') }}/masterpegawai/getkeluarga/"+a,
          dataType: 'json',
          success: function(data){
            var id_keluarga = data.id;
            $('#id_keluarga').attr('value', id_keluarga);

            var nama = data.nama_keluarga;
            $('input[type="text"]#edit_nama_keluarga').attr('value', nama);

            var hub = data.hubungan_keluarga;
            if(hub=="AYAH") {
              $('option#hub_ayah').attr('selected', 'true');
            }
            else if (hub=="IBU") {
              $('option#hub_ibu').attr('selected', 'true');
            }
            else if (hub=="KAKAK") {
              $('option#hub_kakak').attr('selected', 'true');
            }
            else if (hub=="ADIK") {
              $('option#hub_adik').attr('selected', 'true');
            }
            else if (hub=="LAINNYA") {
              $('option#hub_lainnya').attr('selected', 'true');
            }

            var tgl = data.tanggal_lahir_keluarga;
            $('input[type="text"]#edit_tanggal_lahir_keluarga').attr('value', tgl);

            var kerja = data.pekerjaan_keluarga;
            if(kerja=="PEGAWAI NEGERI") {
              $('option#kerja_pn').attr('selected', 'true');
            }
            else if (kerja=="PEGAWAI SWASTA") {
              $('option#kerja_ps').attr('selected', 'true');
            }
            else if (kerja=="WIRAUSAHA") {
              $('option#kerja_wira').attr('selected', 'true');
            }
            else if (kerja=="RUMAH TANGGA") {
              $('option#kerja_rt').attr('selected', 'true');
            }
            else if (kerja=="MAHASISWA") {
              $('option#kerja_maha').attr('selected', 'true');
            }
            else if (kerja=="PELAJAR") {
              $('option#kerja_pel').attr('selected', 'true');
            }
            else if (kerja=="LAINNYA") {
              $('option#kerja_lain').attr('selected', 'true');
            }

            var jk = data.jenis_kelamin_keluarga;
            if(jk=="L") {
              $('input[type="radio"]#jk_pria').attr('checked','true');
            }
            else {
              $('input[type="radio"]#jk_wanita').attr('checked','true');
            }

            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
              checkboxClass: 'icheckbox_minimal-blue',
              radioClass: 'iradio_minimal-blue'
            });

            var alamat = data.alamat_keluarga;
            $('textarea#edit_alamat_keluarga').val(alamat);
          }
        });
      });

      $('a.editpendidikan').click(function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{ url('/') }}/masterpegawai/getpendidikan/"+a,
          dataType: 'json',
          success: function(data){
            var id_pendidikan = data.id;
            var jenjang = data.jenjang_pendidikan;
            var institusi = data.institusi_pendidikan;
            var thmasuk = data.tahun_masuk_pendidikan;
            var thlulus = data.tahun_lulus_pendidikan;
            var gelar = data.gelar_akademik;

            // set id_pendidikan
            $('input[type="hidden"]#id_pendidikan').attr('value', id_pendidikan);

            // set jenjang
            if(jenjang=="PELATIHAN KEAHLIAN") {
              $('option#pend_pelatihan').attr('selected','true');
            }
            else if (jenjang=="S2") {
              $('option#pend_s2').attr('selected','true');
            }
            else if (jenjang=="S1") {
              $('option#pend_s1').attr('selected','true');
            }
            else if (jenjang=="D3") {
              $('option#pend_d3').attr('selected','true');
            }
            else if (jenjang=="SMK") {
              $('option#pend_smk').attr('selected','true');
            }
            else if (jenjang=="SMU") {
              $('option#pend_smu').attr('selected','true');
            }
            else if (jenjang=="SMP") {
              $('option#pend_smp').attr('selected','true');
            }
            else if (jenjang=="SD") {
              $('option#pend_sd').attr('selected','true');
            }
            else if (jenjang=="LAINNYA") {
              $('option#pend_lain').attr('selected','true');
            }

            // set institusi
            $('input[type="text"]#edit_institusi_pendidikan').attr('value', institusi);

            // set tahun
            $('input[type=text]#edit_tahun_masuk_pendidikan').attr('value', thmasuk);
            $('input[type=text]#edit_tahun_lulus_pendidikan').attr('value', thlulus);

            // set gelar
            $('input[type=text]#edit_gelar_akademik').attr('value', gelar);
          }
        });
      });

      $('a.editpengalaman').click(function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{ url('/') }}/masterpegawai/getpengalaman/"+a,
          dataType: 'json',
          success: function(data){
            var id_pengalaman = data.id;
            var nama = data.nama_perusahaan;
            var posisi = data.posisi_perusahaan;
            var thawal = data.tahun_awal_kerja;
            var thakhir = data.tahun_akhir_kerja;

            // set id_pengalaman
            $('input[type="hidden"]#id_pengalaman').attr('value', id_pengalaman);

            // set nama
            $('input[type="text"]#edit_nama_perusahaan').attr('value', nama);

            // set posisi
            $('input[type="text"]#edit_posisi_perusahaan').attr('value', posisi);

            // set tahun awal
            $('input[type="text"]#edit_tahun_awal_kerja').attr('value', thawal);

            // set akhir awal
            $('input[type="text"]#edit_tahun_akhir_kerja').attr('value', thakhir);
          }
        });
      });

      $('a.editkomputer').click(function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{ url('/') }}/masterpegawai/getkomputer/"+a,
          dataType: 'json',
          success: function(data){
            var id_komputer = data.id;
            var program = data.nama_program;
            var nilai = data.nilai_komputer;

            // set id
            $('input[type="hidden"]#id_komputer').attr('value', id_komputer);
            $('input[type="text"]#edit_nama_program').attr('value', program);

            if(nilai=="1") {
              $('option#komp_baik').attr('selected', 'true');
            }
            else if (nilai=="2") {
              $('option#komp_cukup').attr('selected', 'true');
            }
            else if (nilai=="3") {
              $('option#komp_kurang').attr('selected', 'true');
            }
          }
        });
      });

      $('a.editbahasa').click(function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{ url('/') }}/masterpegawai/getbahasa/"+a,
          dataType: 'json',
          success: function(data){
            var id = data.id;
            var bahasa = data.bahasa;
            var berbicara = data.berbicara;
            var menulis = data.menulis;
            var mengerti = data.mengerti;

            // set
            $('#id_bahasa').attr('value', id);

            $('input[type="text"]#edit_bahasa').attr('value', bahasa);

            if(berbicara=="1") {
              $('option#bicara_baik').attr('selected', 'true');
            }
            else if (berbicara=="2") {
              $('option#bicara_cukup').attr('selected', 'true');
            }
            else if (berbicara=="3") {
              $('option#bicara_kurang').attr('selected', 'true');
            }

            if(menulis=="1") {
              $('option#menulis_baik').attr('selected', 'true');
            }
            else if (menulis=="2") {
              $('option#menulis_cukup').attr('selected', 'true');
            }
            else if (menulis=="3") {
              $('option#menulis_kurang').attr('selected', 'true');
            }

            if(mengerti=="1") {
              $('option#mengerti_baik').attr('selected', 'true');
            }
            else if (mengerti=="2") {
              $('option#mengerti_cukup').attr('selected', 'true');
            }
            else if (mengerti=="3") {
              $('option#mengerti_kurang').attr('selected', 'true');
            }
          }
        });
      });

      $('a.editpenyakit').click(function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{ url('/') }}/masterpegawai/getpenyakit/"+a,
          dataType: 'json',
          success: function(data){
            var id_penyakit = data.id;
            var nama = data.nama_penyakit;
            var ket = data.keterangan_penyakit;

            // set
            $('#id_penyakit').attr('value', id_penyakit);
            $('#edit_nama_penyakit').attr('value', nama);
            $('textarea#edit_keterangan_penyakit').val(ket);
          }
        });
      });

      $('a.editdarurat').click(function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{ url('/') }}/masterpegawai/getdarurat/"+a,
          dataType: 'json',
          success: function(data){
            var nama = data.nama_darurat;
            var alamat = data.alamat_darurat;
            var telepon = data.telepon_darurat;
            var hub = data.hubungan_darurat;

            // set
            $('#edit_nama_darurat').attr('value', nama);
            $('#edit_alamat_darurat').attr('value', alamat);
            $('#edit_telepon_darurat').attr('value', telepon);

            if(hub=="AYAH") {
              $('option#hubdar_ayah').attr('selected', 'true');
            }
            else if (hub=="IBU") {
              $('option#hubdar_ibu').attr('selected', 'true');
            }
            else if (hub=="KAKAK") {
              $('option#hubdar_kakak').attr('selected', 'true');
            }
            else if (hub=="ADIK") {
              $('option#hubdar_adik').attr('selected', 'true');
            }
            else if (hub=="LAINNYA") {
              $('option#hubdar_lainnya').attr('selected', 'true');
            }
          }
        });
      });


      @if(count($errors)!=0)
        $('#tdlabelnama').hide();
        $('#tdlabelnip').hide();
        $('#tdlabelniplama').hide();
        $('#tdlabeltgllahir').hide();
        $('#tdlabeljk').hide();
        $('#tdlabelemail').hide();
        $('#tdlabelagama').hide();
        $('#tdlabelalamat').hide();
        $('#tdlabeltelp').hide();
        $('#tdlabelktp').hide();
        $('#tdlabelkk').hide();
        $('#tdlabelnpwp').hide();
        $('#tdlabelbpjskerja').hide();
        $('#tdlabelbpjssehat').hide();
        $('#tdlabelrekening').hide();
        $('#tdlabeljamtraining').hide();
        $('#tdlabelwarga').hide();
        $('#tdlabelbank').hide();
        $('#tdlabeljabatan').hide();
        $('#tdlabeljabatan').hide();
        $('a#editpegawai').hide();

        $('#tdtextnama').show();
        $('#tdtextnip').show();
        $('#tdtextniplama').show();
        $('#tdtexttgllahir').show();
        $('#tdtextjk').show();
        $('#tdtextemail').show();
        $('#tdtextagama').show();
        $('#tdtextalamat').show();
        $('#tdtexttelp').show();
        $('#tdtextktp').show();
        $('#tdtextkk').show();
        $('#tdtextnpwp').show();
        $('#tdtextbpjskerja').show();
        $('#tdtextbpjssehat').show();
        $('#tdtextrekening').show();
        $('#tdtextjamtraining').show();
        $('#tdtextwarga').show();
        $('#tdtextbank').show();
        $('#tdtextjabatan').show();
      @else
        $('#tdtextnama').hide();
        $('#tdtextnip').hide();
        $('#tdtextniplama').hide();
        $('#tdtexttgllahir').hide();
        $('#tdtextjk').hide();
        $('#tdtextemail').hide();
        $('#tdtextagama').hide();
        $('#tdtextalamat').hide();
        $('#tdtexttelp').hide();
        $('#tdtextktp').hide();
        $('#tdtextkk').hide();
        $('#tdtextnpwp').hide();
        $('#tdtextbpjskerja').hide();
        $('#tdtextbpjssehat').hide();
        $('#tdtextrekening').hide();
        $('#tdtextjamtraining').hide();
        $('#tdtextwarga').hide();
        $('#tdtextbank').hide();
        $('#tdtextjabatan').hide();
        $('#btnsavepegawai').hide();
      @endif

      $('a#editpegawai').click(function(){
        $('#tdlabelnama').hide();
        $('#tdlabelnip').hide();
        $('#tdlabelniplama').hide();
        $('#tdlabeltgllahir').hide();
        $('#tdlabeljk').hide();
        $('#tdlabelemail').hide();
        $('#tdlabelagama').hide();
        $('#tdlabelalamat').hide();
        $('#tdlabeltelp').hide();
        $('#tdlabelktp').hide();
        $('#tdlabelkk').hide();
        $('#tdlabelnpwp').hide();
        $('#tdlabelbpjskerja').hide();
        $('#tdlabelbpjssehat').hide();
        $('#tdlabelrekening').hide();
        $('#tdlabeljamtraining').hide();
        $('#tdlabelwarga').hide();
        $('#tdlabelbank').hide();
        $('#tdlabeljabatan').hide();


        $('#tdtextnama').show();
        $('#tdtextnip').show();
        $('#tdtextniplama').show();
        $('#tdtexttgllahir').show();
        $('#tdtextjk').show();
        $('#tdtextemail').show();
        $('#tdtextagama').show();
        $('#tdtextalamat').show();
        $('#tdtexttelp').show();
        $('#tdtextktp').show();
        $('#tdtextkk').show();
        $('#tdtextnpwp').show();
        $('#tdtextbpjskerja').show();
        $('#tdtextbpjssehat').show();
        $('#tdtextrekening').show();
        $('#tdtextjamtraining').show();
        $('#tdtextwarga').show();
        $('#tdtextbank').show();
        $('#tdtextjabatan').show();


        var a = $('b#valagama').data('value');
        if(a=="Islam") {
          $('option#valislam').attr('selected', 'true');
        }
        else if(a=="Kristen") {
          $('option#valkristen').attr('selected', 'true');
        }
        else if(a=="Hindu") {
          $('option#valhindu').attr('selected', 'true');
        }
        else if(a=="Budha") {
          $('option#valbudha').attr('selected', 'true');
        }
        else if(a=="Lainnya") {
          $('option#vallain').attr('selected', 'true');
        }

        var b = $('b#valwarga').data('value');
        if(b=="WNI") {
          $('option#valwni').attr('selected', 'true');
        } else if (b=="WNA") {
          $('option#valwna').attr('selected', 'true');
        }

        var c = $('b#valbank').data('value');
        if(c=="BCA") {
          $('option#valbca').attr('selected', 'true');
        } else if (c=="BNI") {
          $('option#valbni').attr('selected', 'true');
        } else if (c=="MANDIRI") {
          $('option#valmandiri').attr('selected', 'true');
        }

        $('a#editpegawai').hide();
        $('#btnsavepegawai').show();
      });
    });
  </script>

  <script language="javascript">
    var numA=1;
    function adduploaddocument(tableID) {

        var table = document.getElementById(tableID);

        var rowCount = table.rows.length;

        var row = table.insertRow(rowCount);

        var cell1 = row.insertCell(0);
        cell1.innerHTML = '<input type="checkbox" name="chk[]"/>';

        var cell2 = row.insertCell(1);
        cell2.innerHTML = '<input type="text" name="data_dokumen['+numA+'][nama_dokumen]" class="form-control" placeholder="Nama Dokument"@if(!$errors->has('nama_dokumen'))value="{{ old('nama_dokumen') }}"@endif>@if($errors->has('nama_dokumen'))<span class="help-block"><strong><h6>{{ $errors->first('nama_dokumen')}}</h6></strong></span>@endif';

        var cell3 = row.insertCell(2);
        cell3.innerHTML = '<input type="file" name="data_dokumen['+numA+'][unggah_dokumen]"@if(!$errors->has('unggah_dokumen'))value="{{ old('unggah_dokumen') }}"@endif>@if($errors->has('unggah_dokumen'))<span class="help-block"><strong><h6>{{ $errors->first('unggah_dokumen')}}</h6></strong></span>@endif';

        numA++;
    }

    function deluploaddocument(tableID) {
        try {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;

        for(var i=0; i<rowCount; i++) {
            var row = table.rows[i];
            var chkbox = row.cells[0].childNodes[0];
            if(null != chkbox && true == chkbox.checked) {
                table.deleteRow(i);
                rowCount--;
                i--;
                numA--;
            }
        }
        }catch(e) {
            alert(e);
        }
    }
  </script>
@stop
