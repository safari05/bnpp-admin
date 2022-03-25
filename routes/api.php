<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BerandaController;
use App\Http\Controllers\Api\InfrastrukturPetaController;
use App\Http\Controllers\Api\InfrastrukturDataController;
use App\Http\Controllers\Api\InfrastrukturDataMobilitasController;
use App\Http\Controllers\Api\InfrastrukturDataAsetController;
use App\Http\Controllers\Api\InfrastrukturDataPPKTController;
use App\Http\Controllers\Api\InfrastrukturDataPondesController;
use App\Http\Controllers\Api\InfrastrukturDataPendudukController;
use App\Http\Controllers\Api\InfrastrukturDataKepegawaianController;
use App\Http\Controllers\Api\InfrastrukturGrafikMobilitasController;
use App\Http\Controllers\Api\InfrastrukturGrafikAsetController;
use App\Http\Controllers\Api\InfrastrukturGrafikPPKTController;
use App\Http\Controllers\Api\InfrastrukturGrafikPondesController;
use App\Http\Controllers\Api\InfrastrukturGrafikPendudukController;
use App\Http\Controllers\Api\InfrastrukturGrafikKepegawaianController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/** Beranda **/
Route::get('get-grafik', [BerandaController::class, 'getGrafik'])->name('home.grafik');
/** Beranda **/

/** Infrastruktur Data **/
Route::name('data.kecamatan.')->prefix('datatable-kecamatan')->group(function () {
    Route::get('/', [InfrastrukturDataController::class, 'datatableKecamatan'])->name('index');
    Route::get('mobilitas/{id}', [InfrastrukturDataMobilitasController::class, 'datatableKecamatan'])->name('mobilitas');
    Route::get('aset/{id}', [InfrastrukturDataAsetController::class, 'datatableKecamatan'])->name('aset');
    Route::get('ppkt/{id}', [InfrastrukturDataPPKTController::class, 'datatableKecamatan'])->name('ppkt');
    Route::get('penduduk/{id}', [InfrastrukturDataPendudukController::class, 'datatableKecamatan'])->name('penduduk');
    Route::get('kepeg/{id}', [InfrastrukturDataKepegawaianController::class, 'datatableKecamatan'])->name('kepeg');
});

Route::name('data.kelurahan.')->prefix('datatable-kelurahan')->group(function () {
    Route::get('/', [InfrastrukturDataController::class, 'datatableKelurahan'])->name('index');
    Route::get('mobilitas/{id}', [InfrastrukturDataMobilitasController::class, 'datatableKelurahan'])->name('mobilitas');
    Route::get('aset/{id}', [InfrastrukturDataAsetController::class, 'datatableKelurahan'])->name('aset');
    Route::get('pondes/{id}', [InfrastrukturDataPondesController::class, 'datatableKelurahan'])->name('pondes');
    Route::get('penduduk/{id}', [InfrastrukturDataPendudukController::class, 'datatableKelurahan'])->name('penduduk');
    Route::get('kepeg/{id}', [InfrastrukturDataKepegawaianController::class, 'datatableKelurahan'])->name('kepeg');
});
/** End Infrastruktur Data **/

/** Infrastruktur Grafik **/
Route::name('grafik.kecamatan.')->prefix('chart-kecamatan')->group(function () {
    Route::get('mobilitas/{id}', [InfrastrukturGrafikMobilitasController::class, 'chartKecamatan'])->name('mobilitas');
    Route::get('aset/{id}', [InfrastrukturGrafikAsetController::class, 'chartKecamatan'])->name('aset');
    Route::get('ppkt/{id}', [InfrastrukturGrafikPPKTController::class, 'chartKecamatan'])->name('ppkt');
    Route::get('penduduk/{id}', [InfrastrukturGrafikPendudukController::class, 'chartKecamatan'])->name('penduduk');
    Route::get('penduduk-gender/{id}', [InfrastrukturGrafikPendudukController::class, 'chartKecamatanGender'])->name('penduduk.gender');
    Route::get('kepeg/{id}', [InfrastrukturGrafikKepegawaianController::class, 'chartKecamatan'])->name('kepeg');
    Route::get('kepeg-asn/{id}', [InfrastrukturGrafikKepegawaianController::class, 'chartKecamatanAsn'])->name('kepeg.asn');
    Route::get('kepeg-lembaga/{id}', [InfrastrukturGrafikKepegawaianController::class, 'chartKecamatanLembaga'])->name('kepeg.lembaga');
});

Route::name('grafik.kelurahan.')->prefix('chart-kelurahan')->group(function () {
    Route::get('mobilitas/{id}', [InfrastrukturGrafikMobilitasController::class, 'chartKelurahan'])->name('mobilitas');
    Route::get('aset/{id}', [InfrastrukturGrafikAsetController::class, 'chartKelurahan'])->name('aset');
    Route::get('pondes/{id}', [InfrastrukturGrafikPondesController::class, 'chartKelurahan'])->name('pondes');
    Route::get('penduduk/{id}', [InfrastrukturGrafikPendudukController::class, 'chartKelurahan'])->name('penduduk');
    Route::get('penduduk-gender/{id}', [InfrastrukturGrafikPendudukController::class, 'chartKelurahanGender'])->name('penduduk.gender');
    Route::get('kepeg/{id}', [InfrastrukturGrafikKepegawaianController::class, 'chartKelurahan'])->name('kepeg');
    Route::get('kepeg-asn/{id}', [InfrastrukturGrafikKepegawaianController::class, 'chartKelurahanAsn'])->name('kepeg.asn');
    Route::get('kepeg-lembaga/{id}', [InfrastrukturGrafikKepegawaianController::class, 'chartKelurahanLembaga'])->name('kepeg.lembaga');
});
/** End Infrastruktur Data **/

/** Infrastruktur Peta **/
Route::name('map.')->prefix('map')->group(function () {
    Route::get('coords/desa', [InfrastrukturPetaController::class, 'desaCoords'])->name('coord.desa');
    Route::get('coords/kec', [InfrastrukturPetaController::class, 'kecamatanCoords'])->name('coord.kec');
    Route::get('coords/plb', [InfrastrukturPetaController::class, 'plbCoords'])->name('coord.plb');
    Route::get('pin/{tipe}/{id}', [InfrastrukturPetaController::class, 'getDetailTempat'])->name('pin.detail');
});
/** End Infrastruktur Peta **/
