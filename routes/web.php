<?php

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/', ['as'	=> 'home.index','uses'	=> 'HomeController@index']);
Route::get('/home', ['as'	=> 'home','uses'	=> 'HomeController@index']);

Route::group(['prefix' => 'elearning'], function(){
	Route::group(['prefix' => 'soal'], function(){
		Route::get('ubah/{id}', ['as'		=> 'soal.ubah','uses'	=> 'SoalController@ubahSoal']);
	});
});

// reute group for crud
Route::group(['prefix' => 'crud'], function(){
	Route::post('simpan-soal', 'SoalController@simpanSoal');
	Route::post('update-profil', 'CrudController@updateProfil');
	Route::post('simpan-materi', 'CrudController@simpanMateri');
	Route::post('terbit-soal', 'CrudController@terbitSoal');
	Route::post('simpan-detail-soal', 'SoalController@simpanDetailSoal');
	Route::post('simpan-detail-soal-via-excel', 'SoalController@simpanDetailSoalExcel');
	Route::post('simpan-gambar-materi', 'CrudController@simpanGambarMateri');
	Route::post('hapus-gambar-materi', 'CrudController@hapusGambarMateri');
	Route::post('simpan-gambar-user', 'CrudController@simpanGambarUser');
	Route::post('update-profil-sekolah', 'CrudController@updateProfilSekolah');
	Route::post('simpan-guru', 'CrudController@simpanGuru');
	Route::post('update-siswa', 'CrudController@updateSiswa');
	Route::post('update-guru', 'CrudController@updateGuru');
});

Route::group(['prefix' => 'pengaturan'], function(){
	Route::get('/', ['as'		=> 'pengaturan','uses'	=> 'HomeController@pengaturan']);
});

Route::group(['prefix' => 'master'], function(){
	// route master guru
	Route::group(['prefix'=>'guru'], function(){
		Route::get('/', ['as'		=> 'master.guru','uses'	=> 'GuruController@index']);
		Route::get('data-guru', 'GuruController@dataGuru')->name('master.data_guru');
		Route::get('detail/{id}', 'GuruController@detailGuru');
		Route::get('ubah/{id}', 'GuruController@ubahGuru');
	});
	// route master kelas
	Route::get('kelas', ['as'	=> 'master.kelas','uses'	=> 'KelasController@index']);
	Route::get('data-kelas', ['as'	=> 'master.data_kelas','uses'	=> 'KelasController@dataKelas']);
	Route::get('kelas/detail/{id}', ['as'		=> 'master.detail_kelas','uses'	=> 'KelasController@detailKelas']);
	Route::get('detail-kelas/', ['as'		=> 'master.detail_kelas_siswa','uses'	=> 'KelasController@detailKelasSiswa']);
	// route master siswa
	Route::group(['prefix'=>'siswa'], function(){
		Route::get('/', 'SiswaController@index');
		Route::get('data-siswa', 'SiswaController@dataSiswa')->name('master.data_siswa');
		Route::get('detail/{id}', 'SiswaController@detailSiswa');
		Route::get('ubah/{id}', 'SiswaController@ubahSiswa');
	});

});

Route::group(['prefix' => 'elearning'], function() {
	Route::group(['prefix' => 'materi'], function() {
		Route::get('/', ['as' => 'elearning.materi', 'uses' => 'MateriController@index']);
		Route::get('/get-materi-guru', ['as' => 'elearning.dataMateriGuru', 'uses' => 'MateriController@dataMateriGuru']);
		Route::get('/detail/{id}', ['as' => 'elearning.detailMateri', 'uses' => 'MateriController@detail']);
		Route::get('/ubah/{id}', ['as' => 'elearning.detailMateri', 'uses' => 'MateriController@ubah']);
	});
	Route::group(['prefix' => 'laporan'], function() {
		Route::get('/', ['as' => 'elearning.laporan', 'uses' => 'LaporanController@index']);
		Route::get('/detail-kelas/{id}', ['as' => 'elearning.laporan', 'uses' => 'LaporanController@detailKelas']);
		Route::get('data-paket-soal', ['as' => 'elearning.laporan.data_paket_soal', 'uses' => 'LaporanController@data_paket_soal']);
		Route::get('detail-kelas/{id_kelas}/paket-soal/{id_soal}', 'LaporanController@detailPaketSoalPerKelas');
		Route::get('data-kelas-paket-soal', ['as' => 'elearning.laporan.data_kelas_paket_soal', 'uses' => 'LaporanController@dataKelasPaketSoal']);
		Route::get('{id_soal}/{id_user}', ['as' => 'elearning.detailLaporanSiswa', 'uses' => 'LaporanController@detailLaporanSiswa']);
		Route::get('hasil-siswa', ['as' => 'elearning.hasilSiswa', 'uses' => 'LaporanController@hasilSiswa']);
	});
	Route::group(['prefix' => 'soal'], function() {
		Route::get('/', 'SoalController@index')->name('soal');
		Route::get('/detail/{id}', 'SoalController@detail')->name('elearning.detail-soal');
		Route::get('/get-soal', 'SoalController@dataSoal')->name('elearning.get-soal');
		Route::get('/get-soal-home', 'SoalController@dataSoalHome')->name('elearning.get-soal-home');
		Route::get('/get-detail-soal', 'SoalController@dataDetailSoal')->name('elearning.get-detail-soal');
		Route::get('/detail/ubah/{id}', 'SoalController@ubahDetailSoal')->name('elearning.ubah-detail-soal');
		Route::get('/detail/data-soal/{id}', 'SoalController@detailDataSoal')->name('elearning.detail-data-soal');
	});
});
Route::get('/download-file-format/{filename}', 'DownloadController@download')->name('download');
Route::group(['prefix' => 'cetak'], function() {
	Route::get('/kartu-ujian', 'SoalController@index')->name('soal');
	Route::get('/berita-acara', 'SoalController@index')->name('soal');
	Route::get('/excel/hasil-ujian-perkelas/{soal}/{kelas}', 'LaporanController@excelHasilUjianPerkelas');
	Route::get('/pdf/hasil-ujian-persiswa/{siswa}/{soal}', 'LaporanController@pdfHasilUjianPersiswa');
});
Route::get('/activity', 'HomeController@activity');

Route::group(['prefix'=>'siswa'], function() {
	Route::get('data-materi', 'SiswaController@dataMateri')->name('siswa.materi');
	Route::get('materi/detail/{id}', 'SiswaController@detailMateri');
	Route::get('materi', 'SiswaController@materi');
	Route::get('ujian', 'SiswaController@ujian');
	Route::get('ujian/detail/{id}', 'SiswaController@detailUjian');
});
Auth::routes();

Route::get('/home', 'HomeController@index');
