<?php

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/', 'HomeController@index')->name('home.index');
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'elearning'], function(){
	Route::group(['prefix' => 'soal'], function(){
		Route::get('ubah/{id}', 'SoalController@ubahSoal')->name('soal.ubah');
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
	Route::post('simpan-siswa', 'CrudController@simpanSiswa');
	Route::post('update-siswa', 'CrudController@updateSiswa');
	Route::post('simpan-siswa-via-excel', 'CrudController@simpanSiswaViaExcel');
	Route::post('update-img-siswa', 'CrudController@updateImgSiswa');
	Route::post('delete-siswa', 'CrudController@deleteSiswa');
	Route::post('update-guru', 'CrudController@updateGuru');
	Route::post('delete-guru', 'CrudController@deleteGuru');
	Route::post('simpan-kelas', 'CrudController@simpanKelas');
	Route::post('delete-kelas', 'CrudController@deleteKelas');
	Route::post('reset-ujian', 'CrudController@resetUjian');
});

Route::group(['prefix' => 'pengaturan'], function(){
	Route::get('/', 'HomeController@pengaturan')->name('pengaturan');
});

Route::group(['prefix' => 'master'], function(){
	// route master guru
	Route::group(['prefix'=>'guru'], function(){
		Route::get('/', 'GuruController@index')->name('master.guru');
		Route::get('data-guru', 'GuruController@dataGuru')->name('master.data_guru');
		Route::get('detail/{id}', 'GuruController@detailGuru');
		Route::get('ubah/{id}', 'GuruController@ubahGuru');
	});
	// route master kelas
	Route::get('kelas', 'KelasController@index')->name('master.kelas');
	Route::get('data-kelas', 'KelasController@dataKelas')->name('master.data_kelas');
	Route::get('kelas/detail/{id}', 'KelasController@detailKelas')->name('master.detail_kelas');
	Route::get('detail-kelas/', 'KelasController@detailKelasSiswa')->name('master.detail_kelas_siswa');
	Route::get('kelas/ubah/{id}', 'KelasController@ubahKelas')->name('master.ubah_kelas');
	// route master siswa
	Route::group(['prefix'=>'siswa'], function(){
		Route::get('/', 'SiswaController@index')->name('siswa');
		Route::get('data-siswa', 'SiswaController@dataSiswa')->name('master.data_siswa');
		Route::get('detail/{id}', 'SiswaController@detailSiswa');
		Route::get('edit/{id}', 'SiswaController@editSiswa');
		Route::get('delete', 'SiswaController@delete');
		Route::get('get-btn-delete/{password}', 'SiswaController@getBtnDelete');
		Route::get('delete-all', 'SiswaController@deleteAll');
	});

});

Route::group(['prefix' => 'elearning'], function() {
	Route::group(['prefix' => 'materi'], function() {
		Route::get('/', 'MateriController@index')->name('elearning.materi');
		Route::get('/get-materi-guru', 'MateriController@dataMateriGuru')->name('elearning.dataMateriGuru');
		Route::get('/detail/{id}', 'MateriController@detail')->name('elearning.detailMateri');
		Route::get('/ubah/{id}', 'MateriController@ubah')->name('elearning.detailMateri');
	});
	Route::group(['prefix' => 'laporan'], function() {
		Route::get('/', 'LaporanController@index')->name('elearning.laporan');
		Route::get('/detail-kelas/{id}', 'LaporanController@detailKelas')->name('elearning.laporan');
		Route::get('data-paket-soal', 'LaporanController@data_paket_soal')->name('elearning.laporan.data_paket_soal');
		Route::get('detail-kelas/{id_kelas}/paket-soal/{id_soal}', 'LaporanController@detailPaketSoalPerKelas');
		Route::get('data-kelas-paket-soal', 'LaporanController@dataKelasPaketSoal')->name('elearning.laporan.data_kelas_paket_soal');
		Route::get('{id_soal}/{id_user}', 'LaporanController@detailLaporanSiswa')->name('elearning.detailLaporanSiswa');
		Route::get('hasil-siswa', 'LaporanController@hasilSiswa')->name('elearning.hasilSiswa');
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
	Route::get('/kartu-ujian', 'ErrorHandleController@e404')->name('soal');
	Route::get('/berita-acara', 'ErrorHandleController@e404')->name('soal');
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
	Route::get('ujian/finish/{id}', 'SiswaController@finishUjian');
	Route::get('ujian/get-soal/{id}', 'SiswaController@getSoal');
	Route::post('ujian/jawab', 'SiswaController@jawab');
	Route::post('ujian/kirim-jawaban', 'SiswaController@kirimJawaban');
});