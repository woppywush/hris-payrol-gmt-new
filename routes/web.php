<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {return view('pages/login');})->name('index');

Route::get('dashboard', 'DashboardController@gotodashboard')->name('dashboard');

//----- Master Pegawai -----//
Route::resource('masterpegawai', 'MasterPegawaiController');
Route::post('masterpegawai', 'MasterPegawaiController@store')->name('masterpegawai.store');
Route::get('datatables', ['as'=>'datatables.data', 'uses'=>'MasterPegawaiController@getDataForDataTable']);
Route::get('masterpegawai/changestatus/{id}', 'MasterPegawaiController@changestatus');

Route::post('addkeluarga', 'MasterPegawaiController@addKeluarga');
Route::get('masterpegawai/hapuskeluarga/{id}', 'MasterPegawaiController@hapusKeluarga');
Route::get('masterpegawai/getkeluarga/{id}', 'MasterPegawaiController@getDataKeluargaByID');
Route::post('masterpegawai/savekeluarga', 'MasterPegawaiController@saveChangesKeluarga');
Route::post('masterpegawai/savedarurat', 'MasterPegawaiController@saveChangesDarurat');
Route::get('masterpegawai/getdarurat/{id}', 'MasterPegawaiController@bindDarurat');

Route::post('addpendidikan', 'MasterPegawaiController@addPendidikan');
Route::get('masterpegawai/hapuspendidikan/{id}', 'MasterPegawaiController@hapusPendidikan');
Route::get('masterpegawai/getpendidikan/{id}', 'MasterPegawaiController@getPendidikanByID');
Route::post('masterpegawai/savependidikan', 'MasterPegawaiController@saveChangesPendidikan');

Route::post('addpengalaman', 'MasterPegawaiController@addPengalaman');
Route::get('masterpegawai/hapuspengalaman/{id}', 'MasterPegawaiController@hapusPengalaman');
Route::get('masterpegawai/getpengalaman/{id}', 'MasterPegawaiController@getPengalamanByID');
Route::post('masterpegawai/savepengalaman', 'MasterPegawaiController@saveChangesPengalaman');

Route::post('addkomputer', 'MasterPegawaiController@addKomputer');
Route::get('masterpegawai/hapuskomputer/{id}', 'MasterPegawaiController@hapusKomputer');
Route::get('masterpegawai/getkomputer/{id}', 'MasterPegawaiController@getKomputerByID');
Route::post('masterpegawai/savekomputer', 'MasterPegawaiController@saveChangesKomputer');

Route::post('addbahasa', 'MasterPegawaiController@addBahasa');
Route::get('masterpegawai/hapusbahasa/{id}', 'MasterPegawaiController@hapusBahasa');
Route::get('masterpegawai/getbahasa/{id}', 'MasterPegawaiController@getBahasaByID');
Route::post('masterpegawai/savebahasa', 'MasterPegawaiController@saveChangesBahasa');

Route::post('addkesehatan', 'MasterPegawaiController@addKesehatan');
Route::get('masterpegawai/hapuskesehatan/{id}', 'MasterPegawaiController@hapusKesehatan');
Route::post('masterpegawai/savekesehatan', 'MasterPegawaiController@saveChangesKesehatan');
Route::post('masterpegawai/setkondisikesehatan', 'MasterPegawaiController@setKondisiKesehatan')->name('kesehatan.set');

Route::post('addpenyakit', 'MasterPegawaiController@addPenyakit');
Route::get('masterpegawai/hapuspenyakit/{id}', 'MasterPegawaiController@hapusPenyakit');
Route::get('masterpegawai/getpenyakit/{id}', 'MasterPegawaiController@getPenyakitByID');
Route::post('masterpegawai/savepenyakit', 'MasterPegawaiController@saveChangesPenyakit');

Route::post('adddokumen', 'MasterPegawaiController@addDokumen');
Route::get('masterpegawai/hapusdokumen/{id}', 'MasterPegawaiController@hapusDokumen');
Route::get('uploaddokumen/hapusdokumen/{id}', 'UploadDocumentController@hapusDokumen');
Route::get('masterpegawai/getdokumen/{id}', 'MasterPegawaiController@getdokumen');
Route::post('masterpegawai/editdokumenpegawai', 'MasterPegawaiController@editdokumenpegawai');
Route::post('masterpegawai/savepegawai', 'MasterPegawaiController@saveChangesPegawai');

Route::resource('uploaddocument', 'UploadDocumentController');
Route::get('upload/view-document', 'UploadDocumentController@getDocforDataTables')->name('datatables.doc');
Route::get('upload/bind-data/{id}', 'UploadDocumentController@bindData');
Route::post('upload/edit', 'UploadDocumentController@editDokumen')->name('upload.edit');

Route::post('historipegawai/create', 'MasterPegawaiController@addhistoripegawai')->name('historipegawai.create');
Route::get('historipegawai/bind-data/{id}', 'MasterPegawaiController@bindhistoriperingatan');
Route::post('historipegawai/update', 'MasterPegawaiController@updatehistoripegawai')->name('historipegawai.update');
Route::get('historipegawai/delete/{id}', 'MasterPegawaiController@hapusRiwayatPekerjaan');
//----- End Master Pegawai -----//


//----- Start PKWT -----//
Route::get('pkwt', 'PkwtController@index')->name('pkwt.index');
Route::get('pkwt/add', 'PkwtController@create')->name('pkwt.create');
Route::post('pkwt/add', 'PkwtController@store')->name('pkwt.store');
Route::get('pkwt-detail/{id}', 'PkwtController@detail')->name('pkwt.detail');
Route::get('pkwt/edit/{id}', 'PkwtController@bind');
Route::post('pkwt/edit/', 'PkwtController@saveChangesPKWT')->name('pkwt.edit');
Route::post('terminatepkwt', 'PkwtController@terminatePKWT')->name('pkwt.terminate');
Route::get('datatablespkwt', 'PkwtController@getPKWTforDataTables')->name('datatables.pkwt');
Route::get('datatablespkwtdash', 'PkwtController@getPKWTforDashboard')->name('datatables.dash');

Route::post('data-peringatan/create', 'DataPeringatanController@create')->name('dataperingatan.create');
Route::get('masterpegawai/hapusperingatan/{id}', 'DataPeringatanController@hapusPeringatan');
Route::post('masterpegawai/editperingatan', 'DataPeringatanController@editPeringatan')->name('dataperingatan.update');
Route::get('masterpegawai/bind-peringatan/{id}', 'DataPeringatanController@bindPeringatan');
//----- End PKWT -----//


//----- Start Supervisi Manajemen -----//
Route::get('supervisi', 'SpvController@index')->name('supervisi.index');
Route::post('supervisi', 'SpvController@proses')->name('supervisi.getSupervisi');
Route::post('supervisi/edit', 'SpvController@edit')->name('supervisi.edit');
//----- End Supervisi Manajemen -----//


//----- Master Jabatan -----//
Route::get('masterjabatan', 'MasterJabatanController@create')->name('masterjabatan.create');
Route::post('masterjabatan', 'MasterJabatanController@store')->name('masterjabatan.store');
Route::get('masterjabatan/{id}', 'MasterJabatanController@edit')->name('masterjabatan.edit');
Route::patch('masterjabatan/{id}', 'MasterJabatanController@update')->name('masterjabatan.update');
Route::get('masterjabatan/hapusjabatan/{id}', 'MasterJabatanController@hapusJabatan')->name('masterjabatan.hapusjabatan');
//----- Master Jabatan -----//


//----- Start Laporan -----//
Route::get('laporan-pegawai', 'LaporanPegawaiController@index')->name('laporanpegawai.index');
Route::post('laporan-pegawai', 'LaporanPegawaiController@proses')->name('laporanpegawai.proses');
Route::get('laporan-pegawai/cetak/{id}', 'LaporanPegawaiController@downloadExcel')->name('laporanpegawai.cetak');
Route::get('report/{kode_client}/{token}', 'LaporanPegawaiController@reportforclient')->name('reportforclient');
//----- End Laporan -----//


//----- Start Master Client -----//
Route::get('masterclient', 'MasterClientController@index')->name('masterclient.index');
Route::get('masterclient/create', 'MasterClientController@create')->name('masterclient.tambah');
Route::post('masterclient/create', 'MasterClientController@store')->name('masterclient.store');

Route::get('masterclient/cabang/{id}','MasterClientController@cabang_client_show')->name('masterclient.cabang');
Route::get('masterclient/{id}/edit', 'MasterClientController@edit')->name('masterclient.edit');
Route::post('clientcabang', 'MasterClientCabangController@store')->name('clientcabang.store');
Route::get('clientcabang/{id}/edit', 'MasterClientCabangController@edit')->name('clientcabang.edit');
Route::patch('clientcabang/{id}', 'MasterClientCabangController@update')->name('clientcabang.update');

Route::get('departemencabang/{id}', 'MasterClientCabangDepartemenController@show')->name('departemen.show');
Route::post('departemencabang', 'MasterClientCabangDepartemenController@store')->name('departemen.store');
Route::get('departemencabang/{id}/edit', 'MasterClientCabangDepartemenController@edit')->name('departemen.edit');
Route::post('departemen/{id}', 'MasterClientCabangDepartemenController@update')->name('departemen.update');
//----- End Master Client -----//


//----- Start Master User -----//
Route::resource('useraccount', 'UserController');
Route::get('useraccount', 'UserController@index')->name('useraccount.index');
Route::post('useraccount', 'UserController@store')->name('useraccount.store');
Route::get('useraccount/delete/{id}', 'UserController@delete');
Route::get('useraccount/kelola-profile/{id}', 'UserController@kelolaprofile')->name('useraccount.profile');
Route::post('useraccount/update-profile', 'UserController@updateprofile')->name('useraccount.edit');
Route::post('useraccount/update-password', 'UserController@updatepassword')->name('useraccount.editpassword');
//----- End Master User -----//


//----- Start Master Bank -----//
Route::get('masterbank', 'MasterBankController@index')->name('masterbank.index');
Route::post('masterbank', 'MasterBankController@store')->name('masterbank.store');
Route::get('masterbank/{id}/edit', 'MasterBankController@ubah')->name('masterbank.ubah');
Route::post('masterbank/edit', 'MasterBankController@edit')->name('masterbank.edit');
Route::get('masterbank/hapusbank/{id}', ['as'=>'masterbank.hapusbank', 'uses'=>'MasterBankController@hapusBank']);
//----- Start Master Bank -----//



Route::get('import', ['as' => 'import', 'uses' => 'ImportDataController@index']);
Route::post('import-proses', 'ImportDataController@proses');
Route::get('import-template/{type}', 'ImportDataController@downloadExcel');

///// KOMPONEN GAJI VARIABEL//////
Route::get('komponen-gaji', 'KomponenGajiController@index')->name('komgaji.index');
Route::post('komponen-gaji', 'KomponenGajiController@store')->name('komgaji.store');
Route::post('komponen-gaji/update', 'KomponenGajiController@update')->name('komgaji.update');
Route::get('komponen-gaji/delete/{id}', 'KomponenGajiController@delete')->name('komgaji.delete');
Route::get('komponen-gaji/update-nilai/{id}/{nilai}', 'KomponenGajiController@update_nilai')->name('komgaji.updatenilai');
Route::get('komponen-gaji/bind-gaji/{id}', 'KomponenGajiController@bind')->name('komgaji.bind');

///// KOMPONEN GAJI TETAP//////
Route::get('komponen-gaji-tetap', 'KomponenGajiTetapController@index')->name('komgajitetap.index');
Route::post('komponen-gaji-tetap', 'KomponenGajiTetapController@store')->name('komgajitetap.store');
Route::post('komponen-gaji-tetap/update', 'KomponenGajiTetapController@update')->name('komgajitetap.update');
Route::get('komponen-gaji-tetap/delete/{id}', 'KomponenGajiTetapController@delete')->name('komgajitetap.delete');
Route::get('komponen-gaji-tetap/bind-gaji-tetap/{id}', 'KomponenGajiTetapController@bind')->name('komgajitetap.bind');

///// KOMPONEN GAJI TETAP DETAIL CLIENT //////
Route::get('komponen-gaji-tetap-client/{id}', 'KomponenGajiTetapClientController@index')->name('komgajitetapclient.index');
Route::post('komponen-gaji-tetap-client', 'KomponenGajiTetapClientController@store')->name('komgajitetapclient.store');
Route::post('komponen-gaji-tetap-client/update', 'KomponenGajiTetapClientController@update')
		->name('komgajitetapclient.update');
Route::get('komponen-gaji-tetap-client/bind-komponen-gaji-tetap-client/{id}', 'KomponenGajiTetapClientController@bind')
		->name('komgajitetapclient.bind');
Route::get('komponen-gaji-tetap-client/delete/{id1}/{id2}', 'KomponenGajiTetapClientController@delete')
		->name('komgajitetapclient.delete');

///// PERIODE GAJI ///////
Route::get('periode-gaji', 'PeriodeGajiController@index')->name('periodegaji.index');
Route::post('periode-gaji', 'PeriodeGajiController@store')->name('periodegaji.store');
Route::post('periode-gaji/update', 'PeriodeGajiController@update')->name('periodegaji.update');
Route::post('periode-gaji/updateworkday', 'PeriodeGajiController@updateworkday')->name('periodegaji.updateworkday');
Route::get('periode-gaji/delete/{id}', 'PeriodeGajiController@delete')->name('periodegaji.delete');
Route::get('periode-gaji/detail/{id}', 'PeriodeGajiController@detail')->name('periodegaji.detail');
Route::get('periode-gaji/get-detail/periode/{id}', 'PeriodeGajiController@getdatafordatatable')->name('periodegaji.getdata');

///// PEGAWAI TO PERIODE /////
Route::get('periode-pegawai', 'PegawaiToPeriodeController@index')->name('periodepegawai.index');
Route::post('periode-pegawai', 'PegawaiToPeriodeController@store')->name('periodepegawai.store');
Route::post('periode-pegawai-proses', 'PegawaiToPeriodeController@proses')->name('periodepegawai.proses');
Route::get('periode-pegawai/delete/{id}', 'PegawaiToPeriodeController@delete')->name('periodepegawai.delete');

///// SET GAJI PEGAWAI //////
Route::get('set-gaji-pegawai/set-gaji', 'SetGajiController@index')->name('setgaji.index');
Route::get('set-gaji-pegawai/detail-pegawai/{id}', 'SetGajiController@detailpegawai')->name('setgaji.detailpegawai');
Route::get('set-gaji-pegawai/getdata', 'SetGajiController@getdata')->name('setgaji.getdata');
Route::get('set-gaji-pegawai/bind-gaji/{id}', 'SetGajiController@bind')->name('setgaji.bind');
Route::post('set-gaji-pegawai/update-gaji', 'SetGajiController@update')->name('setgaji.update');

///// BATCH PAYROLL ///////
Route::get('batch-payroll', 'BatchPayrollController@index')->name('batchpayroll.index');
Route::post('batch-payroll', 'BatchPayrollController@store')->name('batchpayroll.store');
Route::post('batch-payroll/update', 'BatchPayrollController@update')->name('batchpayroll.update');
Route::get('batch-payroll/bind-batch-payroll/{id}', 'BatchPayrollController@bind')->name('batchpayroll.bind');
Route::get('batch-payroll/delete/{id}', 'BatchPayrollController@delete')->name('batchpayroll.delete');
Route::get('batch-payroll/detail/{id}', 'BatchPayrollController@detail')->name('batchpayroll.detail');
Route::get('batch-payroll/getdata/{id}', 'BatchPayrollController@getdatafordatatable')->name('batchpayroll.getdata');
Route::get('batch-payroll/refreshrowdatatables/{id}', 'BatchPayrollController@refreshrowdatatables')->name('batchpayroll.refreshrow');
Route::get('batch-payroll/process/{idbatch}/{data}', 'BatchPayrollController@process')->name('batchpayroll.process');

///// DETAIL BATCH PAYROLL //////
Route::get('batch-payroll-detail/bind-to-table/{idbatch}/{idpegawai}', 'BatchPayrollDetailController@getdatakomponen')->name('detailbatchpayroll.bindtotable');
Route::get('batch-payroll-detail/add-to-komponen/{idbatch}/{idpegawai}/{idkomponen}/{nilai}', 'BatchPayrollDetailController@addtodetailkomponen')->name('detailbatchpayroll.addkomponen');
Route::get('batch-payroll-detail/cek-komponen-gaji/{idbatch}/{idpegawai}', 'BatchPayrollDetailController@cekkomponen')->name('detailbatchpayroll.cekkomponen');
Route::get('batch-payroll-detail/get-gapok/{idpegawai}', 'BatchPayrollDetailController@getgajipokok')->name('detailbatchpayroll.getgapok');
Route::get('batch-payroll-detail/delete-komponen-gaji/{id}', 'BatchPayrollDetailController@deletekomponengaji')->name('detailbatchpayroll.deletekomponen');
Route::get('batch-payroll-detail/bind-for-absen/{id}', 'BatchPayrollDetailController@bindforabsen')->name('detailbatchpayroll.bindforabsen');
Route::post('batch-payroll-detail/update-for-absen', 'BatchPayrollDetailController@updateforabsen')->name('detailbatchpayroll.updateforabsen');

///// EXPORT IMPORT DETAIL BATCH PAYROLL ////
Route::get('batch-payroll-detail/export/{idbatch}', 'BatchPayrollDetailController@export')->name('detailbatchpayroll.export');
Route::post('batch-payroll-detail/import', 'BatchPayrollDetailController@import')->name('detailbatchpayroll.import');


///// Export Batch Payrol /////
Route::get('batch-payroll/laporan-proses-spv/{id}', 'BatchPayrollLaporanController@prosesSPV')->name('laporan.prosesSPV');
Route::get('batch-payroll/laporan-proses-all/{id}', 'BatchPayrollLaporanController@prosesAll')->name('laporan.prosesAll');
Route::get('batch-payroll/laporan-proses-client/{id}', 'BatchPayrollLaporanController@prosesClient')->name('laporan.prosesClient');
Route::get('batch-payroll/laporan-proses-bank/{id}', 'BatchPayrollLaporanController@prosesBank')->name('laporan.prosesBank');
Route::get('batch-payroll/laporan-proses-slipgaji/{id}', 'BatchPayrollLaporanController@prosesSlipGaji')->name('laporan.prosesSlipGaji');
Route::get('testslip', function(){
	return view('pages.LaporanPayroll.slipGaji');
});


///// HARI LIBUR //////
Route::get('hari-libur', 'HariLiburController@index')->name('hari.libur.index');
Route::post('hari-libur', 'HariLiburController@store')->name('hari.libur.store');
Route::post('hari-libur/update', 'HariLiburController@update')->name('hari.libur.update');
Route::get('hari-libur/bind-hari-libur/{id}', 'HariLiburController@bind')->name('hari.libur.bind');
Route::get('hari-libur/delete/{id}', 'HariLiburController@delete')->name('hari.libur.delete');

///// BPJS //////
Route::get('bpjs', 'BpjsController@index')->name('bpjs.index');
Route::post('bpjs', 'BpjsController@store')->name('bpjs.store');
Route::post('bpjs/update', 'BpjsController@update')->name('bpjs.update');
Route::get('bpjs/bind-bpjs/{id}', 'BpjsController@bind')->name('bpjs.bind');
Route::get('bpjs/delete/{id}', 'BpjsController@delete')->name('bpjs.delete');

///// HARI KERJA /////
Route::get('hari-kerja', 'HariKerjaController@index')->name('harikerja.index');
Route::post('hari-kerja', 'HariKerjaController@store')->name('harikerja.store');


///// PENGECUALIAN CLIENT /////
Route::get('pengecualian-client', 'PengecualianClientController@index')->name('pengecualian.client.index');
Route::post('pengecualian-client', 'PengecualianClientController@store')->name('pengecualian.client.store');
Route::post('pengecualian-client/delete', 'PengecualianClientController@delete')->name('pengecualian.client.delete');

///// HISTORY GAJI POKOK /////
Route::get('history-gaji-pokok', 'HistoryGajiPokokController@index')->name('historygajipokok.index');
Route::post('history-gaji-pokok', 'HistoryGajiPokokController@store')->name('historygajipokok.store');

///// CUTI //////
Route::get('cuti', 'CutiController@index')->name('cuti.index');
Route::post('cuti', 'CutiController@store')->name('cuti.store');
Route::post('cuti/update', 'CutiController@update')->name('cuti.update');
Route::get('cuti/bind-cuti/{id}', 'CutiController@bind')->name('cuti.bind');
Route::get('cuti/delete/{id}', 'CutiController@delete')->name('cuti.delete');


///// RAPEL GAJI /////
Route::get('rapel-gaji', 'RapelGajiController@index')->name('rapelgaji.index');
Route::get('rapel-gaji/list', 'RapelGajiController@list')->name('rapelgaji.list');
Route::get('rapel-gaji/detail/{id}', 'RapelGajiController@detail')->name('rapelgaji.detail');
Route::post('rapel-gaji/getclienthistory', 'RapelGajiController@getclienthistory')->name('rapelgaji.getclienthistory');
Route::get('rapel-gaji/proses/{id}', 'RapelGajiController@proses')->name('rapelgaji.proses');


///// THR ////
Route::get('batch-thr', 'THRController@index')->name('thr.index');
Route::post('batch-thr/store', 'THRController@store')->name('thr.store');
Route::get('batch-thr/detail/{id}', 'THRController@detail')->name('thr.detail');
Route::get('batch-thr/detail/getdata/{id}', 'THRController@getdata')->name('thr.detail-getdata');
Route::get('batch-thr/process/{id}', 'THRController@process')->name('thr.process');
Route::get('batch-thr/destroy/{id}', 'THRController@destroy')->name('thr.destroy');
Route::get('batch-thr/bind/{id}', 'THRController@bind')->name('thr.bind');
Route::post('batch-thr/update/{id}', 'THRController@update')->name('thr.update');
Route::get('batch-thr/laporan-proses-thr/{id}', 'ThrController@prosesThr')->name('laporan.prosesThr');
