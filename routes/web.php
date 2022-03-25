<?php

use App\Http\Controllers\Back\Auth\LoginController;
use App\Http\Controllers\Back\AuthController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\HomeController;
use App\Http\Controllers\Back\Kecamatan\KecamatanAsetController;
use App\Http\Controllers\Back\Kecamatan\KecamatanController;
use App\Http\Controllers\Back\Kecamatan\KecamatanKepegController;
use App\Http\Controllers\Back\Kecamatan\KecamatanMobilitasController;
use App\Http\Controllers\Back\Kecamatan\KecamatanPendudukController;
use App\Http\Controllers\Back\Kecamatan\KecamatanppktController;
use App\Http\Controllers\Back\Kecamatan\KecamatanWilayahController;
use App\Http\Controllers\Back\Master\AsetMasterController;
use App\Http\Controllers\Back\Master\DesaManagerController;
use App\Http\Controllers\Back\Master\KecamatanManagerController;
use App\Http\Controllers\Back\Master\KotaManagerController;
use App\Http\Controllers\Back\Master\MasterPegKelembagaan;
use App\Http\Controllers\Back\Master\MasterPegOperasional;
use App\Http\Controllers\Back\Master\MobilitasMasterController;
use App\Http\Controllers\Back\Master\PotensiDesaMasterController;
use App\Http\Controllers\Back\Master\ProvinsiManagerController;
use App\Http\Controllers\Back\PageController;
use App\Http\Controllers\Back\UtilityController;
use App\Http\Controllers\Back\Desa\DesaAsetController;
use App\Http\Controllers\Back\Desa\DesaController;
use App\Http\Controllers\Back\Desa\DesaKepegController;
use App\Http\Controllers\Back\Desa\DesaMobilitasController;
use App\Http\Controllers\Back\Desa\DesaPendudukController;
use App\Http\Controllers\Back\Desa\DesaPondesController;
use App\Http\Controllers\Back\Desa\DesaWilayahController;
use App\Http\Controllers\Back\Dokumen\DokumenController;
use App\Http\Controllers\Back\Dokumen\DokumenKategoriController;
use App\Http\Controllers\Back\Dokumen\PengajuanDokumenController;
use App\Http\Controllers\Back\Konten\BeritaController as KontenBeritaController;
use App\Http\Controllers\Back\Konten\KontenController;
use App\Http\Controllers\Back\Monev\DetailMonevController;
use App\Http\Controllers\Back\Monev\DetailPertanyaanController;
use App\Http\Controllers\Back\Monev\MonevController;
use App\Http\Controllers\Back\Peta\DashPetaController;
use App\Http\Controllers\Back\PLB\PLBLogController;
use App\Http\Controllers\Back\PLB\PLBMasterController;
use App\Http\Controllers\Back\User\ProfilController;
use App\Http\Controllers\Back\User\UserManagerController;
use App\Http\Controllers\Front\BerandaController;
use App\Http\Controllers\Front\BeritaController;
use App\Http\Controllers\Front\ProfilLatarBelakangController;
use App\Http\Controllers\Front\ProfilMaksudTujuanController;
use App\Http\Controllers\Front\InfrastrukturDataController;
use App\Http\Controllers\Front\InfrastrukturPetaController;
use App\Http\Controllers\Front\InfrastrukturGrafikController;
use App\Http\Controllers\Front\DownloadDokumenController;
use App\Http\Controllers\Front\DataKecamatanController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\PetaController;
use App\Http\Controllers\Front\UtilsController;
// use App\Models\Refactored\Desa\DesaDetail;
// use App\Models\Refactored\Utils\UtilsDesa;
// use Dotenv\Parser\Value;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

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
#region Front Page
Route::get('/', [BerandaController::class, 'index'])->name('home');
Route::get('/data-grafix-beranda', [BerandaController::class, 'getGrafik'])->name('home.grafik');
Route::resource('/berita', BeritaController::class)->only(['index', 'show']);
Route::resource('/download-dokumen', DownloadDokumenController::class)->only(['index', 'store', 'create']);

Route::name('profil.')->group(function() {
    Route::get('/profil-latar-belakang', [ProfilLatarBelakangController::class, 'index'])->name('latar-belakang');
    Route::get('/profil-maksud-tujuan', [ProfilMaksudTujuanController::class, 'index'])->name('maksud-tujuan');
});
Route::name('infrastruktur.')->group(function() {
    Route::get('/infrastruktur-data', [InfrastrukturDataController::class, 'index'])->name('data');
    Route::get('/infrastruktur-data/{tipe}/{id}', [InfrastrukturDataController::class, 'show'])->name('data.show');
    Route::get('/infrastruktur-peta', [InfrastrukturPetaController::class, 'index'])->name('peta');
    Route::get('/infrastruktur-peta/coords/kecamatan', [InfrastrukturPetaController::class, 'kecamatanCoords'])->name('peta.kecamatan');
    Route::get('/infrastruktur-peta/coords/desa', [InfrastrukturPetaController::class, 'desaCoords'])->name('peta.desa');
    Route::get('/infrastruktur-peta/coords/plb', [InfrastrukturPetaController::class, 'plbCoords'])->name('peta.plb');
    Route::get('/infrastruktur-grafik', [InfrastrukturGrafikController::class, 'index'])->name('grafik');
    Route::get('/infrastruktur-grafik/{tipe}/{id}', [InfrastrukturGrafikController::class, 'show'])->name('grafik.show');
});

Route::name('infra.')->prefix('infra')->group(function(){
    Route::get('map', [PetaController::class, 'index'])->name('map');
    Route::get('data', [FrontController::class, 'dataOption'])->name('data');
    Route::get('data/kecamatan', [DataKecamatanController::class, 'index'])->name('data.kec');
    Route::get('data/kecamatan/list', [DataKecamatanController::class, 'list'])->name('data.kec.list');
    Route::get('data/kecamatan/detail', [DataKecamatanController::class, 'detail'])->name('data.kec.detail');
    Route::get('data/kecamatan/chart', [DataKecamatanController::class, 'chart'])->name('data.kec.chart');
    Route::get('data/kecamatan/map', [DataKecamatanController::class, 'map'])->name('data.kec.map');

    #region JSON Kecamatan
    Route::get('data/utils/list-prov', [UtilsController::class, 'listProvinsi'])->name('utils.prov');
    Route::get('data/utils/list-kota', [UtilsController::class, 'listKota'])->name('utils.kota');
    Route::get('data/utils/list-kec', [UtilsController::class, 'listKecamatan'])->name('utils.kec');
    Route::get('data/utils/list-desa', [UtilsController::class, 'listDesa'])->name('utils.desa');
    #endregion
});

Route::name('option.')->prefix('option')->group(function(){
    Route::get('list-prov', [UtilsController::class, 'listProvinsi'])->name('prov');
    Route::get('list-kota', [UtilsController::class, 'listKota'])->name('kota');
    Route::get('list-kec', [UtilsController::class, 'listKecamatan'])->name('kec');
    Route::get('list-desa', [UtilsController::class, 'listDesa'])->name('desa');
});
#endregion

#region Route Dashboard Admin
Route::middleware('role:semua')->group(function(){
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('role:semua');
    Route::get('masterGetLokpri', [DashboardController::class, 'masterGetLokpri'])->name('masterGetLokpri')->middleware('role:master,admin,usercontrol');
    Route::get('masterGetTipe', [DashboardController::class, 'masterGetTipe'])->name('masterGetTipe')->middleware('role:master,admin,usercontrol');
    Route::get('masterGetDesa', [DashboardController::class, 'masterGetDesaByProv'])->name('masterGetDesaByProv')->middleware('role:master,admin,usercontrol');
    Route::get('masterGetKecamatan', [DashboardController::class, 'masterGetKecByProv'])->name('masterGetKecByProv')->middleware('role:master,admin,usercontrol');
    Route::get('camatGetPondes', [DashboardController::class, 'camatPondes'])->name('camatGetPondes')->middleware('role:camat');
    Route::get('camatListDesa', [DashboardController::class, 'camatListDesa'])->name('camatListDesa')->middleware('role:camat');
    Route::get('contentGetBerita', [DashboardController::class, 'contentListBerita'])->name('contentGetBerita')->middleware('role:content');
});

Route::middleware('role:master,admin')->group(function(){
    Route::get('master/provinsi', [ProvinsiManagerController::class, 'index'])->name('master.prov');
    Route::get('master/provinsi/list', [ProvinsiManagerController::class, 'list'])->name('master.prov.list');
    Route::post('master/provinsi/change', [ProvinsiManagerController::class, 'changeActive'])->name('master.prov.change');

    Route::get('master/kota', [KotaManagerController::class, 'index'])->name('master.kota');
    Route::get('master/kota/list', [KotaManagerController::class, 'list'])->name('master.kota.list');
    Route::post('master/kota/change', [KotaManagerController::class, 'changeActive'])->name('master.kota.change');

    Route::get('master/aset', [AsetMasterController::class, 'index'])->name('master.aset');
    Route::get('master/aset/list', [AsetMasterController::class, 'list'])->name('master.aset.list');
    Route::post('master/aset/store', [AsetMasterController::class, 'store'])->name('master.aset.store');
    Route::delete('master/aset/delete/{id}', [AsetMasterController::class, 'delete'])->name('master.aset.delete');

    Route::get('master/mobilitas', [MobilitasMasterController::class, 'index'])->name('master.mobilitas');
    Route::get('master/mobilitas/list', [MobilitasMasterController::class, 'list'])->name('master.mobilitas.list');
    Route::post('master/mobilitas/store', [MobilitasMasterController::class, 'store'])->name('master.mobilitas.store');
    Route::delete('master/mobilitas/delete/{id}', [MobilitasMasterController::class, 'delete'])->name('master.mobilitas.delete');

    Route::get('master/pondes', [PotensiDesaMasterController::class, 'index'])->name('master.pondes');
    Route::get('master/pondes/list', [PotensiDesaMasterController::class, 'list'])->name('master.pondes.list');
    Route::post('master/pondes/store', [PotensiDesaMasterController::class, 'store'])->name('master.pondes.store');
    Route::delete('master/pondes/delete/{id}', [PotensiDesaMasterController::class, 'delete'])->name('master.pondes.delete');
    Route::get('master/pondes/source', [PotensiDesaMasterController::class, 'srcAutocomplete'])->name('master.pondes.source');

    Route::get('kepdata/lembaga', [MasterPegKelembagaan::class, 'index'])->name('master.kep.lembaga');
    Route::get('kepdata/lembaga/list', [MasterPegKelembagaan::class, 'list'])->name('master.kep.lembaga.list');
    Route::post('kepdata/lembaga/store', [MasterPegKelembagaan::class, 'store'])->name('master.kep.lembaga.store');
    Route::delete('kepdata/lembaga/delete/{id}', [MasterPegKelembagaan::class, 'delete'])->name('master.kep.lembaga.delete');

    Route::get('kepdata/operasional', [MasterPegOperasional::class, 'index'])->name('master.kep.operasional');
    Route::get('kepdata/operasional/list', [MasterPegOperasional::class, 'list'])->name('master.kep.operasional.list');
    Route::post('kepdata/operasional/store', [MasterPegOperasional::class, 'store'])->name('master.kep.operasional.store');
    Route::delete('kepdata/operasional/delete/{id}', [MasterPegOperasional::class, 'delete'])->name('master.kep.operasional.delete');
});


Route::middleware('role:master,admin')->group(function(){
    Route::get('master/kecamatan', [KecamatanManagerController::class, 'index'])->name('master.kec');
    Route::get('master/kecamatan/list', [KecamatanManagerController::class, 'list'])->name('master.kec.list');
    Route::post('master/kecamatan/change', [KecamatanManagerController::class, 'changeActive'])->name('master.kec.change');
    Route::get('master/kecamatan/list-kota', [KecamatanManagerController::class, 'listKota'])->name('master.kec.kota');
    Route::post('master/kecamatan/tipe-change', [KecamatanManagerController::class, 'changeType'])->name('master.kec.tipe.change');
    Route::post('master/kecamatan/lokpri-change', [KecamatanManagerController::class, 'changeLokpri'])->name('master.kec.lokpri.change');
    Route::get('master/kecamatan/detail/{id}', [KecamatanManagerController::class, 'getDetail'])->name('master.kec.detail');
});

Route::middleware('role:master,admin,camat')->group(function(){
    Route::get('master/desa', [DesaManagerController::class, 'index'])->name('master.desa');
    Route::get('master/desa/list', [DesaManagerController::class, 'list'])->name('master.desa.list');
    Route::post('master/desa/change', [DesaManagerController::class, 'changeActive'])->name('master.desa.change');
    Route::get('master/desa/list-kota', [DesaManagerController::class, 'listKota'])->name('master.desa.kota');
    Route::get('master/desa/list-kec', [DesaManagerController::class, 'listKecamatan'])->name('master.desa.kec');
});

Route::prefix('kecamatan')->name('kec.')->middleware('role:master,admin,camat')->group(function(){
    Route::get('/', [KecamatanController::class, 'index'])->name('index');
    Route::get('list', [KecamatanController::class, 'list'])->name('list');
    Route::get('detail/{id}', [KecamatanController::class, 'detail'])->name('detail');
    Route::get('camat/{id}', [KecamatanController::class, 'getCamat'])->name('camat');
    Route::put('camat/{id}/update', [KecamatanController::class, 'updateCamat'])->name('camat.update');
    Route::get('kantor/{id}', [KecamatanController::class, 'getKantor'])->name('kantor');
    Route::put('kantor/{id}/update', [KecamatanController::class, 'updateKantor'])->name('kantor.update');
    Route::get('balai/{id}', [KecamatanController::class, 'getBalai'])->name('balai');
    Route::put('balai/{id}/update', [KecamatanController::class, 'updateBalai'])->name('balai.update');

    Route::get('aset/{id}', [KecamatanAsetController::class, 'detail'])->name('aset');
    Route::get('aset/{id}/list', [KecamatanAsetController::class, 'listAset'])->name('aset.list');
    Route::get('aset/{id}/chart', [KecamatanAsetController::class, 'chartAset'])->name('aset.chart');
    Route::get('aset/{id}/create', [KecamatanAsetController::class, 'create'])->name('aset.create');
    Route::get('src-aset', [KecamatanAsetController::class, 'srcAutocomplete'])->name('aset.src-auto');
    Route::post('store/aset', [KecamatanAsetController::class, 'store'])->name('aset.store');
    Route::get('aset/{id}/edit/{idaset}', [KecamatanAsetController::class, 'edit'])->name('aset.edit');
    Route::put('update/aset', [KecamatanAsetController::class, 'update'])->name('aset.update');

    Route::get('mobilitas/{id}/list', [KecamatanMobilitasController::class, 'listMobil'])->name('mobilitas.list');
    Route::get('mobilitas/{id}/chart', [KecamatanMobilitasController::class, 'chartMobil'])->name('mobilitas.chart');
    Route::get('mobilitas/{id}/create', [KecamatanMobilitasController::class, 'create'])->name('mobilitas.create');
    Route::get('src-mobilitas', [KecamatanMobilitasController::class, 'srcAutocomplete'])->name('mobilitas.src-auto');
    Route::post('store/mobilitas', [KecamatanMobilitasController::class, 'store'])->name('mobilitas.store');
    Route::get('mobilitas/{id}/edit/{mobilitas}', [KecamatanMobilitasController::class, 'edit'])->name('mobilitas.edit');
    Route::put('update/mobilitas', [KecamatanMobilitasController::class, 'update'])->name('mobilitas.update');

    Route::get('kepeg/{id}', [KecamatanKepegController::class, 'detail'])->name('kepeg');
    Route::get('kepeg/{id}/list', [KecamatanKepegController::class, 'listKepeg'])->name('kepeg.list');
    Route::get('kepeg/{id}/create', [KecamatanKepegController::class, 'create'])->name('kepeg.create');
    Route::post('store/kepeg', [KecamatanKepegController::class, 'store'])->name('kepeg.store');
    Route::get('kepeg/{id}/edit/{series}', [KecamatanKepegController::class, 'edit'])->name('kepeg.edit');
    Route::put('update/kepeg', [KecamatanKepegController::class, 'update'])->name('kepeg.update');
    Route::get('kepeg/{id}/c/peg', [KecamatanKepegController::class, 'chartPeg'])->name('kepeg.chart.peg');
    Route::get('kepeg/{id}/c/asn', [KecamatanKepegController::class, 'chartAsn'])->name('kepeg.chart.asn');
    Route::get('kepeg/{id}/c/lembaga', [KecamatanKepegController::class, 'chartLembaga'])->name('kepeg.chart.lembaga');

    Route::get('sipil/{id}', [KecamatanPendudukController::class, 'detail'])->name('sipil');
    Route::get('sipil/{id}/data-detail', [KecamatanPendudukController::class, 'dataDetail'])->name('sipil.data.detail');
    Route::get('sipil/{id}/list', [KecamatanPendudukController::class, 'listSipil'])->name('sipil.list');
    Route::get('sipil/{id}/detail/create', [KecamatanPendudukController::class, 'createDetail'])->name('sipil.create.detail');
    Route::post('store/detail', [KecamatanPendudukController::class, 'storeDetail'])->name('sipil.store.detail');
    Route::get('sipil/{id}/ages/create', [KecamatanPendudukController::class, 'createSipilUmur'])->name('sipil.create.ages');
    Route::post('store/ages', [KecamatanPendudukController::class, 'storeUmur'])->name('sipil.store.ages');
    Route::get('sipil/{id}/edit/{sipil}', [KecamatanPendudukController::class, 'editUmur'])->name('sipil.edit.ages');
    Route::put('update/sipil', [KecamatanPendudukController::class, 'updateUmur'])->name('sipil.update.ages');
    Route::get('sipil/{id}/c/gender', [KecamatanPendudukController::class, 'chartGender'])->name('sipil.chart.gender');
    Route::get('sipil/{id}/c/age', [KecamatanPendudukController::class, 'chartUmur'])->name('sipil.chart.age');

    Route::get('wil/{id}', [KecamatanWilayahController::class, 'index'])->name('wil');
    Route::get('wil/{id}/pin', [KecamatanWilayahController::class, 'pin'])->name('wil.pin');
    Route::post('store/coord', [KecamatanWilayahController::class, 'setCoord'])->name('wil.pin.store');
    Route::get('wil/{id}/atur/{mode}', [KecamatanWilayahController::class, 'atur'])->name('wil.atur');
    Route::post('store/atur', [KecamatanWilayahController::class, 'storeWilayah'])->name('wil.atur.store');

    Route::get('wil/{id}/ppkt/create', [KecamatanPpktController::class, 'create'])->name('wil.ppkt.create');
    Route::post('store/ppkt', [KecamatanPpktController::class, 'store'])->name('wil.ppkt.store');
    Route::get('wil/{id}/ppkt/list', [KecamatanPpktController::class, 'listppkt'])->name('wil.ppkt.list');
    Route::delete('wil/{id}/ppkt/delete/{idppkt}', [KecamatanPpktController::class, 'delete'])->name('wil.ppkt.delete');
    Route::get('wil/{id}/ppkt/chart', [KecamatanPpktController::class, 'chartppkt'])->name('wil.ppkt.chart');
});

Route::prefix('desa')->name('desa.')->middleware('role:master,admin,camat')->group(function(){
    Route::get('/', [DesaController::class, 'index'])->name('index');
    Route::get('list', [DesaController::class, 'list'])->name('list');
    Route::get('detail/{id}', [DesaController::class, 'detail'])->name('detail');
    Route::get('kades/{id}', [DesaController::class, 'getKades'])->name('kades');
    Route::put('kades/{id}/update', [DesaController::class, 'updateKades'])->name('kades.update');
    Route::get('kantor/{id}', [DesaController::class, 'getKantor'])->name('kantor');
    Route::put('kantor/{id}/update', [DesaController::class, 'updateKantor'])->name('kantor.update');
    Route::get('balai/{id}', [DesaController::class, 'getKantor'])->name('balai');
    Route::put('balai/{id}/update', [DesaController::class, 'updateBalai'])->name('balai.update');

    Route::get('aset/{id}', [DesaAsetController::class, 'detail'])->name('aset');
    Route::get('aset/{id}/list', [DesaAsetController::class, 'listAset'])->name('aset.list');
    Route::get('src-aset', [DesaAsetController::class, 'srcAutocomplete'])->name('aset.src-auto');
    Route::get('aset/{id}/create', [DesaAsetController::class, 'create'])->name('aset.create');
    Route::post('aset/store', [DesaAsetController::class, 'store'])->name('aset.store');
    Route::get('aset/{id}/edit/{iditem}', [DesaAsetController::class, 'edit'])->name('aset.edit');
    Route::put('aset/update', [DesaAsetController::class, 'update'])->name('aset.update');
    Route::get('aset/{id}/chart', [DesaAsetController::class, 'chartAset'])->name('aset.chart');

    Route::get('mobilitas/{id}', [DesaMobilitasController::class, 'detail'])->name('mobilitas');
    Route::get('mobilitas/{id}/list', [DesaMobilitasController::class, 'listMobil'])->name('mobilitas.list');
    Route::get('src-mobilitas', [DesaMobilitasController::class, 'srcAutocomplete'])->name('mobilitas.src-auto');
    Route::get('mobilitas/{id}/create', [DesaMobilitasController::class, 'create'])->name('mobilitas.create');
    Route::post('mobilitas/store', [DesaMobilitasController::class, 'store'])->name('mobilitas.store');
    Route::get('mobilitas/{id}/edit/{iditem}', [DesaMobilitasController::class, 'edit'])->name('mobilitas.edit');
    Route::put('mobilitas/update', [DesaMobilitasController::class, 'update'])->name('mobilitas.update');
    Route::get('mobilitas/{id}/chart', [DesaMobilitasController::class, 'chartMobil'])->name('mobilitas.chart');

    Route::get('kepeg/{id}', [DesaKepegController::class, 'detail'])->name('kepeg');
    Route::get('kepeg/{id}/list', [DesaKepegController::class, 'listKepeg'])->name('kepeg.list');
    Route::get('kepeg/{id}/create', [DesaKepegController::class, 'create'])->name('kepeg.create');
    Route::post('store/kepeg', [DesaKepegController::class, 'store'])->name('kepeg.store');
    Route::get('kepeg/{id}/edit/{series}', [DesaKepegController::class, 'edit'])->name('kepeg.edit');
    Route::put('update/kepeg', [DesaKepegController::class, 'update'])->name('kepeg.update');
    Route::get('kepeg/{id}/c/peg', [DesaKepegController::class, 'chartPeg'])->name('kepeg.chart.peg');
    Route::get('kepeg/{id}/c/asn', [DesaKepegController::class, 'chartAsn'])->name('kepeg.chart.asn');
    Route::get('kepeg/{id}/c/lembaga', [DesaKepegController::class, 'chartLembaga'])->name('kepeg.chart.lembaga');

    Route::get('sipil/{id}', [DesaPendudukController::class, 'detail'])->name('sipil');
    Route::get('sipil/{id}/data-detail', [DesaPendudukController::class, 'dataDetail'])->name('sipil.data.detail');
    Route::get('sipil/{id}/list', [DesaPendudukController::class, 'listSipil'])->name('sipil.list');
    Route::get('sipil/{id}/detail/create', [DesaPendudukController::class, 'createDetail'])->name('sipil.create.detail');
    Route::post('store/detail', [DesaPendudukController::class, 'storeDetail'])->name('sipil.store.detail');
    Route::get('sipil/{id}/ages/create', [DesaPendudukController::class, 'createSipilUmur'])->name('sipil.create.ages');
    Route::post('store/ages', [DesaPendudukController::class, 'storeUmur'])->name('sipil.store.ages');
    Route::get('sipil/{id}/edit/{sipil}', [DesaPendudukController::class, 'editUmur'])->name('sipil.edit.ages');
    Route::put('update/sipil', [DesaPendudukController::class, 'updateUmur'])->name('sipil.update.ages');
    Route::get('sipil/{id}/c/gender', [DesaPendudukController::class, 'chartGender'])->name('sipil.chart.gender');
    Route::get('sipil/{id}/c/age', [DesaPendudukController::class, 'chartUmur'])->name('sipil.chart.age');

    Route::get('wil/{id}', [DesaWilayahController::class, 'index'])->name('wil');
    Route::get('wil/{id}/pin', [DesaWilayahController::class, 'pin'])->name('wil.pin');
    Route::post('store/coord', [DesaWilayahController::class, 'setCoord'])->name('wil.pin.store');
    Route::get('wil/{id}/atur/{mode}', [DesaWilayahController::class, 'atur'])->name('wil.atur');
    Route::post('store/atur', [DesaWilayahController::class, 'storeWilayah'])->name('wil.atur.store');

    Route::get('pondes/{id}', [DesaPondesController::class, 'detail'])->name('pondes');
    Route::get('pondes/{id}/list', [DesaPondesController::class, 'listPondes'])->name('pondes.list');
    Route::get('src-pondes', [DesaPondesController::class, 'srcAutocomplete'])->name('pondes.src-auto');
    Route::get('pondes/{id}/create', [DesaPondesController::class, 'create'])->name('pondes.create');
    Route::post('pondes/store', [DesaPondesController::class, 'store'])->name('pondes.store');
    Route::get('pondes/{id}/edit/{iditem}', [DesaPondesController::class, 'edit'])->name('pondes.edit');
    Route::put('pondes/update', [DesaPondesController::class, 'update'])->name('pondes.update');
    Route::get('pondes/{id}/chart', [DesaPondesController::class, 'chartPondes'])->name('pondes.chart');
});

Route::name('users.')->prefix('users')->middleware('role:master,admin,usercontrol')->group(function(){
    Route::get('/', [UserManagerController::class, 'index'])->name('index');
    Route::get('list', [UserManagerController::class, 'list'])->name('list');
    Route::get('manage/create', [UserManagerController::class, 'create'])->name('create');
    Route::post('manage/store', [UserManagerController::class, 'store'])->name('store');
    Route::get('manage/edit/{id}', [UserManagerController::class, 'edit'])->name('edit');
    Route::put('manage/update', [UserManagerController::class, 'update'])->name('update');
    Route::get('manage/get-status/{id}', [UserManagerController::class, 'getStatusUser'])->name('get-status');
    Route::put('manage/update-status', [UserManagerController::class, 'ubahStatusUser'])->name('update-status');
});

Route::name('dok.kategori.')->prefix('dokumen/kategori')->middleware('role:master,admin')->group(function(){
    Route::get('/', [DokumenKategoriController::class, 'index'])->name('index');
    Route::get('list', [DokumenKategoriController::class, 'list'])->name('list');
    Route::get('get-kategori/{id}', [DokumenKategoriController::class, 'getKategori'])->name('detail');
    Route::post('store', [DokumenKategoriController::class, 'store'])->name('store');
    Route::put('update/{id}', [DokumenKategoriController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [DokumenKategoriController::class, 'delete'])->name('delete');
});

Route::name('dok.manage.')->prefix('dokumen/manage')->middleware('role:master,admin,camat')->group(function(){
    Route::get('/', [DokumenController::class, 'index'])->name('index');
    Route::get('list', [DokumenController::class, 'list'])->name('list');
    Route::get('get-detail/{id}', [DokumenController::class, 'getDetail'])->name('get-detail');
    Route::get('detail/{id}', [DokumenController::class, 'detail'])->name('detail');
    Route::get('create', [DokumenController::class, 'create'])->name('create');
    Route::post('store', [DokumenController::class, 'store'])->name('store');
    Route::get('edit/{id}', [DokumenController::class, 'edit'])->name('edit');
    Route::put('update/{id}', [DokumenController::class, 'update'])->name('update');
    Route::put('change-akses/{id}', [DokumenController::class, 'ubahPublic'])->name('change-akses');
    Route::delete('delete/{id}', [DokumenController::class, 'delete'])->name('delete');
});

Route::name('konten.berita.')->prefix('konten/berita')->middleware('role:master,admin,content')->group(function(){
    Route::get('/', [KontenBeritaController::class, 'index'])->name('index');
    Route::get('list', [KontenBeritaController::class, 'list'])->name('list');
    Route::get('create', [KontenBeritaController::class, 'create'])->name('create');
    Route::post('store', [KontenBeritaController::class, 'store'])->name('store');
    Route::get('edit/{id}', [KontenBeritaController::class, 'edit'])->name('edit');
    Route::put('update/{id}', [KontenBeritaController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [KontenBeritaController::class, 'delete'])->name('delete');
    Route::get('preview/{id}', [KontenBeritaController::class, 'previewKonten'])->name('preview');

});

Route::name('plb.master.')->prefix('plb/master')->middleware('role:master,admin,camat')->group(function(){
    Route::get('/', [PLBMasterController::class, 'index'])->name('index');
    Route::get('list', [PLBMasterController::class, 'list'])->name('list');
    Route::get('detail/{id}', [PLBMasterController::class, 'detail'])->name('detail');
    Route::get('create', [PLBMasterController::class, 'create'])->name('create');
    Route::post('store', [PLBMasterController::class, 'store'])->name('store');
    Route::get('edit/{id}', [PLBMasterController::class, 'edit'])->name('edit');
    Route::put('update/{id}', [PLBMasterController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [PLBMasterController::class, 'delete'])->name('delete');
    Route::get('pin/{id}', [PLBMasterController::class, 'pin'])->name('pin');
    Route::post('store/coord', [PLBMasterController::class, 'setCoord'])->name('pin.store');
});

Route::name('plb.log.')->prefix('plb/log')->middleware('role:master,admin,camat')->group(function(){
    Route::get('/', [PLBLogController::class, 'index'])->name('index');
    Route::get('list', [PLBLogController::class, 'list'])->name('list');
    Route::get('muatan/jenis-barang', [PLBLogController::class, 'srcAutocomplete'])->name('muatan.jenis-barang');
    Route::get('detail/{idseries}', [PLBLogController::class, 'detail'])->name('detail');
    Route::get('create', [PLBLogController::class, 'create'])->name('create');
    Route::post('store', [PLBLogController::class, 'store'])->name('store');
    // Route::get('edit/{id}', [PLBLogController::class, 'edit'])->name('edit');
    // Route::put('update/{id}', [PLBLogController::class, 'update'])->name('update');
    // Route::delete('delete/{id}', [PLBLogController::class, 'delete'])->name('delete');
    Route::get('get/plb-opt', [PLBLogController::class, 'getPlb'])->name('opt.plb');
});

Route::name('dok.pengajuan.')->prefix('dokumen/pengajuan')->middleware('role:master,admin,camat')->group(function(){
    Route::get('/', [PengajuanDokumenController::class, 'index'])->name('index');
    Route::get('list', [PengajuanDokumenController::class, 'list'])->name('list');
    Route::post('minta', [PengajuanDokumenController::class, 'requestAkses'])->name('request');
    Route::post('respon', [PengajuanDokumenController::class, 'respon'])->name('respon');
    Route::get('detail/{series}', [PengajuanDokumenController::class, 'getDetailRespon'])->name('detail');
    Route::get('history', [PengajuanDokumenController::class, 'history'])->name('history');
    Route::get('history/list', [PengajuanDokumenController::class, 'listHistory'])->name('history.list');
});

Route::name('konten.static.')->prefix('konten/static')->middleware('role:master,admin')->group(function(){
    Route::get('/', [KontenController::class, 'index'])->name('index');
    Route::get('editor/latar', [KontenController::class, 'editorLatarBelakang'])->name('edit.lt');
    Route::post('store/latar', [KontenController::class, 'storeLatarBelakang'])->name('store.lt');
    Route::get('editor/maksud', [KontenController::class, 'editorMaksud'])->name('edit.maksud');
    Route::post('store/maksud', [KontenController::class, 'storeMaksud'])->name('store.maksud');
    Route::get('editor/tujuan', [KontenController::class, 'editorTujuan'])->name('edit.tujuan');
    Route::post('store/tujuan', [KontenController::class, 'storeTujuan'])->name('store.tujuan');
});

Route::name('profile.')->prefix('profile')->middleware('role:semua')->group(function(){
    Route::get('/', [ProfilController::class, 'index'])->name('index');
    Route::get('edit', [ProfilController::class, 'editProfile'])->name('edit');
    Route::post('update', [ProfilController::class, 'updateProfile'])->name('update');
    Route::post('repass', [ProfilController::class, 'updatePassword'])->name('repass');
});

Route::name('dash.map.')->prefix('dash/map')->middleware('role:master,admin,camat')->group(function(){
    Route::get('/', [DashPetaController::class, 'index'])->name('index');
    Route::get('coords/desa', [DashPetaController::class, 'desaCoords'])->name('coord.desa');
    Route::get('coords/kec', [DashPetaController::class, 'kecamatanCoords'])->name('coord.kec');
    Route::get('coords/plb', [DashPetaController::class, 'plbCoords'])->name('coord.plb');
    Route::get('pin/{tipe}/{id}', [DashPetaController::class, 'getDetailTempat'])->name('pin.detail');
});

Route::name('monev.')->prefix('monev')->middleware('role:master,admin')->group(function(){
    Route::get('/', [MonevController::class, 'index'])->name('index');
    Route::get('list', [MonevController::class, 'list'])->name('list');
    Route::get('detail/{id}', [DetailMonevController::class, 'index'])->name('detail');
});

Route::get('back/option/prov', [UtilityController::class, 'getActiveProvinsi'])->name('opt.prov');
Route::get('back/option/kota', [UtilityController::class, 'getActiveKota'])->name('opt.kota');
Route::get('back/option/kec', [UtilityController::class, 'getActiveKecamatan'])->name('opt.kec');
Route::get('back/option/desa', [UtilityController::class, 'getActiveDesa'])->name('opt.desa');
Route::get('back/option/plb', [UtilityController::class, 'getActivePLB'])->name('opt.plb');
#endregion

Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

#region IMPORT PURPOSE

// Route::get('import-kec', function(){
//     $ids =  "1108050	1172020	1172010	1173020	1218070	1219060	1409031	1409040	1409041	1473011	1473012	1408022	1408050	1408031	1408030	1408040	1410051	1410052	1410040	1410031	1410030	2101034	2101033	2101032	2101030	2101031	2101024	2101010	2171010	2171060	2171070	2171080	2171081	2171051	2171050	2102050	2102051	2102061	2102063	2105080	2105010	2105020	2105030	2105090	2105040	2105070	2103041	2103042	2103050	2103051	2103053	2103040	2103043	2103061	2103060	2103062	6101090	6101080	6102081	6102080	6105220	6105210	6107210	6107200	6108190	6108200	6108210	6108220	6108230	6108080	6411050	6411040	6405041	6501050	6501040	6501060	6501020	6501030	6504020	6504010	6504110	6504100	6504030	6504090	6504080	6504120	6504150	6504140	6504160	6504130	6504011	6504021	6504022	5307030	5307020	5307042	5307021	5307040	5307050	5307014	5306070	5306072	5306071	5306080	5306081	5306050	5306052	5321120	5321070	5321110	5321020	5321010	5305041	5305026	5305025	5305023	5305024	5305010	5305013	5303192	5314061	5314060	5314050	5314070	5314010	5314041	5314030	5320060	5320030	5320020	5320010	7104011	7104010	7104081	7104080	7104030	7103091	7103090	7103100	7103102	7103110	7103101	7108070	7106060	7107060	7505030	7206060	7206061	7206020	8108070	8108060	8108020	8108010	8108012	8108013	8108011	8108030	8108081	8108042	8108041	8108021	8105021	8105022	8105011	8105030	8105033	8101040	8101043	8101041	8101054	8101053	8101050	8101051	8102022	8102020	8102021	8102024	8207040	8207050	8207020	8207010	8207030	8202043	9108071	9108070	9109050	9412022	9401012	9401011	9401010	9401020	9401041	9401040	9401051	9401045	9401044	9401052	9413010	9413022	9413050	9413023	9413052	9417060	9417010	9417055	9417012	9417051	9417062	9417061	9420030	9420041	9420011	9420010	9420012	9471010	9471040	9419050	9409050	9427021	9427020	9427011	9427030";
//     $penduduk = "20669	20189	22002	39173	41825	30459	36903	79315	18868	15216	38283	14957	41472	13783	33116	82111	16384	18079	20171	19408	20694	20694	27999	46994	50876	10116	6651	18566	20372	143398	30830	61516	112342	177574	73059	22562	17593	14532	7047		5854	2561	3752		12875	11080	4760	2387	26910	5515	3344	8052	3743	3038	5372	3297	30312	11926	8367	9053	19368	40082	22136	30160	2284	6642	5493	5200	26388	22423	3910	4665	3449	1918	1573	1414	1986	2509	3245	1359	19713	61035	4944	8978	8412	10009	7645	13428	7366	6223	1022	1417	2783	9985	25091	3750	6308	8667	53045	10529	26764	7449	15215	13195	8913	26044	5082	6826	40203	19842	24195	19811	10305	5725	6472	7921	5004	16175	7424	8126	5562	14940	14948	9372	24840	6355	30980	9405	11258	19732	35012	4627	6086	819	3597	1670	12796	16661	22732	1628	7416	3491	8979	21131	12140	17546	17851	9449	13479	5270	4631	9253	2048	1680	1438	1992	7771	2107	2279	14508	2838	4979	6132	4474	49565	3317	38097	14390	11790	7574	8581	14887	5433	7402	19.735	12.836	3.854	97.96	11.520	10.804	28.722	13.723	6.479	1.313	1.385	6.470	3.495	4.292	2.728	6.305	4.568	16.279	101.826	4.913	2.264	3.444	6.972	17.922	1.154	1.603	824	1.102	3.995	3.868	3.319	2.935	3.206	1.394	1.310	3.615	3.200	985	1.570	1.476	18.598	96.682	14.769	44.264	2.654	2.631	5.908	9.197";

//     $ids = preg_replace('/[ ]{2,}|[\t]/', ',', trim($ids));
//     $penduduk = preg_replace('/[ ]{2,}|[\t]/', ',', trim($penduduk));
//     $penduduk = str_replace('.', '', $penduduk);
//     $ar = explode(',', $ids);
//     $arpenduduk = explode(',', $penduduk);
//     // dd(count($arpenduduk));
//     DB::beginTransaction();
//     try {
//         foreach ($ar as $key => $value) {
//             DB::table('kecamatan_detail')->updateOrInsert(
//                 [
//                     'id'=>$value 
//                 ], 
//                 [
//                     'id'=>$value,
//                     'lokpriid'=>'1',
//                     'jumlah_penduduk'=>(int) $arpenduduk[$key]
//                 ]);
//         }
//         DB::commit();
//     } catch (\Exception $th) {
//         DB::rollBack();
//         dd($th);
//     }
//     return $ar;
    
// });
// Route::get('import-kota', function(){
//     $ids =  "1108	1172		1173	1218	1219	1409			1473		1408					1410					2101							2171							2102				2105							2103										6101		6102		6105		6107		6108						6411		6405	6501					6504															5307							5306							5321					5305							5303	5314							5320				7104					7103						7108	7106	7107	7505	7206			8108												8105					8101							8102				8207					8202	9108		9109	9412	9401										9413					9417							9420					9471		9419	9409	9427";
    
//     $ids = preg_replace('/[ ]{2,}|[\t]/', ',', trim($ids));
//     $ar = explode(',', $ids);
//     $ar = array_values(array_filter($ar));
//     // dd($ar);
//     // dd(count($arpenduduk));
//     DB::beginTransaction();
//     try {
//         DB::table('utils_kota')->whereIn('id', $ar)->update(['active'=>1]);
//         DB::commit();
//     } catch (\Exception $th) {
//         DB::rollBack();
//         dd($th);
//     }
//     return $ar;
    
// });

// Route::get('import-prov', function(){
//     $ids =  "11				12		14															21																																			61														64			65																				53																																						71														75	72			81																												82						91  94";
    
//     $ids = preg_replace('/[ ]{2,}|[\t]/', ',', trim($ids));
//     $ar = explode(',', $ids);
//     $ar = array_values(array_filter($ar));
//     // dd($ar);
//     // dd(count($arpenduduk));
//     DB::beginTransaction();
//     try {
//         DB::table('utils_provinsi')->whereIn('id', $ar)->update(['active'=>1]);
//         DB::commit();
//     } catch (\Exception $th) {
//         DB::rollBack();
//         dd($th);
//     }
//     return $ar;
    
// });

// Route::get('getiddesa', function(){
//     $kec = "1108050;1172020;1172010;1173020;1218070;1219060;1409031;1409040;1409041;1473011;1473012;1408022;1408050;1408031;1408030;1408040;1410051;1410052;1410040;1410031;1410030;2101034;2101033;2101032;2101030;2101031;2101024;2101010;2171010;2171060;2171070;2171080;2171081;2171051;2171050;2102050;2102051;2102061;2102063;2105080;2105010;2105020;2105030;2105090;2105040;2105070;2103041;2103042;2103050;2103051;2103053;2103040;2103043;2103061;2103060;2103062;6101090;6101080;6102081;6102080;6105220;6105210;6107210;6107200;6108190;6108200;6108210;6108220;6108230;6108080;6411050;6411040;6405041;6501050;6501040;6501060;6501020;6501030;6504020;6504010;6504110;6504100;6504030;6504090;6504080;6504120;6504150;6504140;6504160;6504130;6504011;6504021;6504022;5307030;5307020;5307042;5307021;5307040;5307050;5307014;5306070;5306072;5306071;5306080;5306081;5306050;5306052;5321120;5321070;5321110;5321020;5321010;5305041;5305026;5305025;5305023;5305024;5305010;5305013;5303192;5314061;5314060;5314050;5314070;5314010;5314041;5314030;5320060;5320030;5320020;5320010;7104011;7104010;7104081;7104080;7104030;7103091;7103090;7103100;7103102;7103110;7103101;7108070;7106060;7107060;7505030;7206060;7206061;7206020;8108070;8108060;8108020;8108010;8108012;8108013;8108011;8108030;8108081;8108042;8108041;8108021;8105021;8105022;8105011;8105030;8105033;8101040;8101043;8101041;8101054;8101053;8101050;8101051;8102022;8102020;8102021;8102024;8207040;8207050;8207020;8207010;8207030;8202043;9108071;9108070;9109050;9412022;9401012;9401011;9401010;9401020;9401041;9401040;9401051;9401045;9401044;9401052;9413010;9413022;9413050;9413023;9413052;9417060;9417010;9417055;9417012;9417051;9417062;9417061;9420030;9420041;9420011;9420010;9420012;9471010;9471040;9419050;9409050;9427021;9427020;9427011;9427030";
//     $kec = str_replace(';', ',', $kec);
//     $arkec = explode(',', $kec);
//     $desa = "Meunasah Kulam;Beurandeh;Ie Seum;Meunasah Keude;Lamreh;Meunasah Mon;Paya Kameng;Ruyung;Ladong;Gampong Baro;Durung;Neuheun;Lamnga;Lhok Banie;PB Teungoh;PB Beuramo;Simpang Lhee;Seuriget;Matang Seulimeng;Sungai Pauh;Kuala Langsa;Teulaga Tujuh;Serambi Indah;Sungai Pauh Pusaka;Sungai Paoh Tanjung;Sungai Paoh Firdaus;Iboih;Bate Shoek;Paya Seunara;Krueng Raya;Aneuk Laot;Kuta Timur;Kuta Barat;Kuta Ateuh;Paya;Keuneukai;Beurawang;Jaboi;Balohan;Cot Abeuk;Cot Ba U;Ie Meulee;Ujoeng Kareung;Anoe Itam;Pekan Tanjung Beringin;Nagur;Mangga Dua;Sukajadi;Tebing Tinggi;Pematang Cermai;Pematang Terang;Bagan Kuala;Sei Suka Deras;Simodong;Pematang Jering;Pematang Kuning;Kuala Indah;Kuala Tanjung;Tanjung Gading;Simpang Kopi;Brohol;Kel. Per. Sipare-Pare;Panipahan;Teluk Pulai;Pasir Limau Kapas;Sungai Daun;Panipahan Darat;Panipahan Laut;Pulau Jemur;Kel. Panipahan;Labuhan Tangga Kecil;Labuhan Tangga Besar;Bagan Jawa;Parit Aman;Labuhan Tangga Baru;Bagan Jawa Pesisir;Serusa;Labuhan Tangga Hilir;Bagan Punak Meranti;Bagan Punak Pesisir;Kel. Bagan Punak;Kel. Bagan Kota;Kel. Bagan Hulu;Kel. Bagan Barat;Kel. Bagan Timur;Sinaboi;Sei Bakau;Raja Bejamu;Sungai Nyamuk;Darussalam;Kel. Sinaboi Kota;Kel. Teluk Makmur;Kel. Mundam;Kel. Guntung;Kel. Pelintung;Kel. Lubuk Gaung;Kel. Tanjung Penyebal;Kel. Bangsal Aceh;Kel. Basilam Baru;Kel. Batu Teritip;Parit Satu api-api;Temiang;Api-Api;Tenggayun;Sepahat;Bukit Kerikil;Tanjung Leban;Bantan Tengah;Bantan Air; Bantan Tua;Teluk Pambang;Selat Baru;Teluk Lancar;Kembung Luar;Jangkang;Muntai;Resam Lapis;Berancah;Ulu Pulau;Mentayan;Pampang Pesisir;Sukamaju;Pampang  Baru;Kembung Baru;Pasiran;Bantan Sari;Bantan Timur;Teluk Papal;Muntai Barat;Deluk;Tanjung Medang;Teluk Rhu;Tanjung Punak;Kadur;Titi Akar;Hutan Ayu;Suka Damai;Putri Sembilan;Sungai Cingan;Teluk Lecah;Makeruh;Hutan Panjang;Pangkalan Nyirih;Sukarjo Mesin;Darul Aman;Parit Kebumen;Sri Tanjung;Pancur Jaya;Pangkalan Pinang;Dungun Baru;Kel. Batu Panjang;Kel. Pergam;Kel. Terkul;Kel. Tanjung Kapal;Kelapa Pati;Pedekik;Pangkalan Batang;Sebauk;Teluk Latak;Meskom;Senggoro;Air Putih;Sei Alam;Penampi;Temeran;Penebal;Pematang Duku;Ketam Putih;Kelemantan;Sekodi;Wonosari;Kuala Alam;Kelebuk;Palkun;Sungai Batang;Prapat Tunggal;Simpang Ayam;Senderek;Kelemantan Barat;Damai;Pangkalan Batang Barat;Pematang Duku Timur;Kel. Kota Bengkalis;Kel. Damon;Kel. Rimba Sekampung;Kuala Merbau;Renak Dungun;Baran Melintang;Teluk Ketapang;Semukut;Centai;Tanjung Bunga;Batang Meranti;Pangkalan Balai;Padang Kamal;Ketapang Permai;Tanjung Padang;Putri Puyu;Mekar Delima;Dedap;Kudap;Bandul;Selat Akar;Tanjung Pisang;Mengkopot;Mengkirau;Segomeng;Bantar;Anak Setatah;Lemang;Bokor;Sungai Cina;Melai;Telaga Baru;Bina Maju;Sialang Pasung;Permai;Mekar Baru;Tanjung Kedabu;Beting;Sokop;Telesung;Bungur;Tenggayun Raya;Sendaur;Kayu Ara;Sonde;Kedabu Rapat;Tanah Merah;Tanjung Samak;Tanjung Medang;Gemala Sari;Topang;Penyagun;Repan;Tanjung Bakau;Teluk Samak;Sungai Gayung Kiri;Citra Damai;Dwi Tunggal;Wonosari;Tebun;Tanjung Gemuk;Pangke;Pangke Barat;Kel. Pasir Panjang;Kel. Darussalam;Pongkar;Kel. Tebing;Kel. Teluk Uma;Kel. Kapling;Kel. Pamak;Kel. Harjosari;Kel. Meral Kota;Kel. Baran Barat;Kel. Sei Raya;Kel. Baran Timur;Kel. Sungai Pasir;Kel. Parit Benut;Parit;Tulang;Selat Mendaun;Kel. Tanjung Balai;Kel. Teluk Air;Kel. Sungai Lakam Timur;Kel. Lubuk Semut;Kel. Tanjung Balai Kota;Kel. Sungai Lakam Barat;Tanjung Hutan;Tanjung Batu Kecil;Kel. Buru;Kel. Lubuk Puding;Sebele;Lebuh;Penarah;Sei Asam;Tebias;Degong;Pauh;Sugie;Keban;Selat Mie;Tanjung Pelanduk;Jang;Niur Permai;Rawajaya;Buluh Patah;Pulau Moro;Kel. Moro;Kel. Moro Timur;Kel. Pemping;Kel. Kasu;Kel. Pulau Terung;Kel. Pecong;Kel. Tanjung Sari;Kel. Sekanak Raya;Kel. Sungai Harapan;Kel. Tanjung Pinggir;Kel. Tanjung Riau;Kel. Tiban Indah;Kel. Tiban Baru;Kel. Tiban Lama;Kel. Patam Lestari;Kel. Kampung Pelita;Kel. Lubuk Baja Kota;Kel. Batu Selicin;Kel. Tanjung Uma;Kel. Baloi Indah;Kel. Tanjung Sengkuang;Kel. Sungai Jodoh;Kel. Batu Merah;Kel. Kampung Seraya;Kel. Bengkong Indah;Kel. Bengkong Laut;Kel. Sadai;Kel. Tanjung Buntung;Kel. Baloi Permai;Kel. Taman Baloi;Kel. Teluk Tering;Kel. Belian;Kel. Sukajadi;Kel. Sungai Panas;Kel. Sambau;Kel. Batu Besar;Kel. Kabil;Kel. Ngenang;Lancang Kuning;Kel. Tanjung Uban Kota;Kel. Tanjung Uban Utara;Kel. Tanjung Uban Selatan;Kel. Tanjung Uban Timur;Berakit;Ekang Anculai;Pengudang;Sebong Lagoi;Sebong Pereh;Sri Bintan;Kel. Kota Baru;Gunung Kijang;Malang Rapat;Teluk Bakau;Kel. Kawal;Kelong;Mapur;Numbing;Air Gelubi;Impol;Keramut;Sunggak;Mampok;Rewak;Air Biru;Batu Berapit;Landak;Kel. Letung;Kuala Maras;Ulu Maras;Bukit Padi;Genting Pulur;Kiabu;Telaga;Mengkait;Tiangau;Telaga Kecil;Lingai;Air Bini;Mubur;Piasan;Bayat;Tarempa Barat;Tarempa Selatan;Tarempa Timur;Pesisir Timur;Sri Tanjung ;Tarempa Barat Daya;Kel. Tarempa;Tebang;Ladan;Payalaman;Piabung;Langir;Candi;Putik;Teluk Bayur;Matak;Batu Ampar;Payamaram;Belibak;Kelarik Utara;Kelarik;Kelarik Barat;Kelarik Air Mali;Teluk Buton;Belakang Gunung;Seluan Barat;Gunung Durian;Tanjung Pala;Air Payang;Kadur;Sungai Ulu;Sepempang;Batu Gajah;Kel. Ranai Kota;Tanjung;Ceruk;Kelanga;Pengadah;Sebadai Ulu;Limau Manis;Seleman;Cemaga;Cemaga Selatan (Setengar);Cemaga Utara (Singgang Bulan);Cemaga Tengah;Mekar Jaya;Binjai;Piantengah;Selaut;Kel. Sedanau;Sabang Mawang;Sededap;Tanjung Batang;Serantas;Sabang Mawang Barat;Teluk Labuh;Subi;Subi Besar ;Meliah;Pulau Panjang;Terayak;Pulau Kerdau;Subi Besar Timur;Meliah Selatan;Kampung Hilir;Batu Berlian;Tanjung Setelung;Tanjung Balau;Pangkalan;Jermalik;Kel. Serasan;Arung Ayam;Air Nusa;Air Ringau;Payak ;Sebubus;Nibung;Malek;Tanah Hitam;Matang Danau;Kalimantan ;Temajuk;Mentibar;Kaliau;Sebunga;Santaban;Sanatab;Sungai Bening;Sungkung I;Siding;Hli Buie;Tangguh;Sungkung II;Sungkung III;Tamong ;Tawang;Jagoi;Kumba;Sekida;Gersik;Semunying Jaya;Sinar Baru;Nekan;Semanget;Entikong;Pala Pasang;Suruh Tembawang;Balai Karangan;Pengadang;Sotok;Kenaman;Raut Muara;Engkahan;Bungkang;Lubuk Sabuk;Sangai Tekam;Melenggang;Senaning;Empura;Sebadak;Sepiluk;Sungai Seria;Suak Medang;Nanga Bayan;Rasau;Jasa;Sungai Bugau;Nanga Bugau;Empunak Tapang Keladan;Sebetung Paluk;Muakan Petinggi;";
//     $desa .= "Nanga Sebawang;Sekaih;Bekuan Luyang;Sungai Pisau;Mungguk Entawak;Embaleh;Sebuluh;Riam Sejawak;Engkeruh;Sungai Kelik;Idai;Sungai Mawang;Ujung Kempas;Neraci Jaya;Sejawak;Wirayuda;Tanjung Sari;Panding Jaya;Tirta Karya;Begelang Jaya;Sumber Sari;Panggi Agung;Kerta Sari;Argo Mulyo;Wana Bhakti;Swadaya;Margahayu;Gut Jaya Bhakti;Landau Buaya;Kayu Dujung;Senangan Kecil;Sungai Areh;Mungguk Gelombang;Mungguk Lawang;Nanga Kelapan;Panggi Ruguk*;Bakti Senabung*;Engkitan*;Landau Temiang*;Padung Kumang*;Radin Jaya*;Senangan Jaya*;Kubu Berangan*;Semareh*;Sungai Antu;Merakai Panjang;Kantuk Asam;Kantuk Bunut;Sungai Mawang;Langau;Badau;Janting;Semuntik;Kekurak;Pulau Majang;Seriang;Sebindang;Tinting Seligi;Tajun;Setulang;Sepandan;Sungai Ajung;Sungai Abau;Labian;Mensiau;Melemba;Lanjak Deras;Sungai Senunuk;Labian Ira'ang;Banua Martinus;Menua Sadap;Pulau Manak;Banua Ujung;Saujung Giling Manik;Ulak Pauk;Langan Baru;Batu Lintang;Rantau Prapat;Tamao;Pala Pulau;Sibau Hilir;Padua Mendalam;Datah Dian;Sibau Hulu;Nanga Nyabau;Nanga Awin;Ariung Mendalam;Nanga Sambus;Banua Tanga;Tanjung Beruang;Tanjung Karang;Seluan;Sungai Ulan Palin;Tanjung Lasa;Lauk;Jangkang;Kel. Putussibau Kota;Kel. Hilir Kantor;Sungai Uluk;Jaras;Melapi;Kedamin Darat;Tanjung Jati;Sayut;Urang Unsa;Suka Maju;Cempaka Baru;Beringin Jaya;Bungan Jaya;Tanjung Lokang;Kereho;Ingko' Tambe;Kel. Kedamin Hulu;Kel. Kedamin Hilir;;;Long Penaneh I;Long Keriok;Long Penaneh II;Tiong Ohang;Long Penaneh III;Tiong Buu;Naha Buan;Naha Tifab;Naha Silat;Long Apari;Delang Kerohong;Long Pakaq;Long Lunuk;Long Isun;Naha Aru;Data Naha;Lirung Ubin;Long Pahangai I;Long Pahangai II;Long Tuyoq;Liu Mulang;Long Pakaq Baru;Long Lunuk Baru;Bohe Silian;Payung Payung;Teluk Alulu;Teluk Harapan;Long Pujungan ;Long Ketaman;Long Pua;Long Lame;Long Jelet;Long Aran;Long Paliran;Long Bena;Long Belaka Pitau;Data Dian;Long Pipa;Long Sule;Sungai Anai;Long Metun;Long Uli;Long Alango;Long Berini;Long Tebulo;Apau Ping;Long Kemuat;Long Ampung;Long Uro;Lidung Payau;Sungai Barang;Metulang;Long Nawang;Nawang Baru;Long Temuyat;Long Betaoh;Long Payau;Pa' Padi;Cinglat ;Liang Butan;Pa' Rupai;Ba Sikor;Pa' Nado;Buduk Kinangan;Liang Tuer;Buduk Tumu;Long Berayang;Pa' Api;Pa' Sire;Wa' Yanud;Long Nawang;Long Katung;Long Bawan;Long Matung;Long Rupan;Liang Biadung;Wa' Laya;Pa' Matung;Pa' Terutun;Pa' Putuk;Long Pasia;Liang Lunuk;Pa' Ibang;Pa' Amai;Pa' Kaber;Pa' Tera;Pa' Sing;Pa' Dalan;Long Birar;Pa' Upan;Long Budung;Long Pupung;Pa' Urang;Kel. Selisun;Kel. Nunukan Selatan;Kel. Mansapa;Kel. Tanjung Harapan;Binusan;Kel. Nunukan Timur;Kel. Nunukan Barat;Kel. Nunukan Utara;Kel. Nunukan Tengah;Payang;Suyadon;Bulu Mengelom;Tukulon;Ubol Sulok;Batung;Ubol Alung;Nansapan;Samunti;Semata;Sungoi;Salan;Sinampila I;Paluan;Sedalit;Tembalang Hilir;Tadungus;Sinampila II;Kalambuku;Jukup;Long Bulu;Sumentobol;Linsayung;Tumantalas;Sanal;Limpakon;Labuk;Nantukidan;Labang;Sumantipal;Ngawol;Bululaun Hilir;Lagas;Panas;Langgason;Tambalang Hulu;Kuyo;Bokok;Tau Lumbis;Bululaun Hulu;Kalisun;Mamasin;Sibalu;Duyan;Tuntulibing;Tetagas;Kabungolor;Lipaga;Tantalujuk;Srinanti;Tabur Lestari;Samaenre Semaja;Sekaduyan Taka;Sanur;Makmur;Semunad;Sekikilan;Kalunsayan;Tembalang;Salang;Tinampak I;Tinampak II;Naputi;Tau Baru;Balatikon;Liang Bunyu;Binalawan;Setabu;Bambangan;Sungai Limau;Maspul;Aji Kuning;Bukit Harapan;Sungai Nyamuk;Tanjung Harapan;Bukit Aru Indah;Tanjung Aru;Sungai Pancang;Lapri;Seberang;Tanjung Karang;Balansiku;Sungai Manurung;Padaidi;Tang Paye;Longan Rungan;Long Kelupang;Long Padi;Tang Badui;Binuang;Long Mutan;Pa' Milau;Ba' Liku;Long Rian;Pa' Yalau;Pa Betung;Long Sepayang;Pa Pawan;Pa Melade;Pa Kebuan;Pa Umung;Pa' Rangeb;Long Umung;Long Tenem;Long Nuat;Pa' Pala;Sinar Baru;Pa' Lidung;Pa' Raye;Bungayan;Wa' Yagung;Kampung Baru;Pa' Mulak;Long Puak;Long Mangan;Buduk Kubul;Long Kabid;Pa' Inan;Lembudud;Long Tugul;Pa' Butal;Pa' Delung;Pa' Urud;Pa' Kemut;Pa' Kidang;Lembada;Pa' Kayak;Pa' Pirit;Liang Aliq;Sembudud;Liang Turan;Liang Bua;Lepatar;Pa Mering;Pa' Pani;Pa' Lutut;Ma' Libu;Kelaisi Barat;Sidabui;Padang Alang;Kuneman;Silapui;Kelaisi Tengah;Kiraman;Maikang;Malaipea;Tamanapui;Lella;Manmas;Subo;Kel. Kelaisi Timur;Probur;Tribur;Wakapsir;Morba;Pintu Mas;Wolwal;Halerman;Kafelulang;Moramam;Pailelang;Wolwal Barat;Wolwal Tengah;Wolwal Selatan;Probur Utara;Manatang;Orgen;Wakapsir Timur;Kuifana ;Margeta;Kel. Moru;Langkuru;Purnama;Kailesa;Langkuru Utara;Mataru Selatan;Mataru Utara;Lakatuli;Mataru Timur;Kamaifui;Mataru Barat;Taman Mataru;Tanglapui;Kolana Selatan;Padang Panjang;Maritaing;Elok;Tanglapui Timur;Mausamang;Belemana;Maukuru;Kel. Kolana Utara;Lendola;Fanating;Motongbang;Air Kenari;Teluk Kenari;Adang Buom;Kel. Kalabahi Barat;Kel. Kalabahi Kota;Kel. Kalabahi Tengah;Kel. Kalabahi Timur;Kel. Binongko;Kel. Nusa Kenari;Kel. Welai Barat;Kel. Welai Timur;Kel. Mutiara;Kel. Wetabua;Tude;Mauta;Muriabang;Tubbe (Tube);Tamakh;Bagang;Toang;Eka Jaya;Aramba;Delaki;Silawan;Tulakadi;Sadi;Umaklaran;Manleten;Fatuba'a;Dafala;Takirin;Bauho;Sarabau;Tialai;Halimodok;Lasiolat;Maneikun;Lakan Mau;Dualasi Rai Ulun;Dualasi;Fatulotu;Baudaok;Asumananu;Tohe;Maumutin;Raifatus;Aitoun;Tohe Leten;Kewar;Fulur;Duarato;Makir;Lamaksenulu;Dirun;Leowalu;Maudemu;Mahuitas;Ekin;Loonuna;Nualain;Lakmaras;Henes;Debululik;Sisi Fatuberal;Lutho Rato;Tukuneno;Naekasa;Lookeu;Derokfaturene;Bakustulama;Rinbesihat;Naitimu;Lawalutolus;Dubesi;Nanaet;Fohoeka;Nanaenoe;Alas Utara;Kota Biru;Alas;Alas Selatan;Bakiruk;Barada;Barene;Bereliku;Fahiluka;Harekakae;";
//     $desa .= "Kakaniuk;Kamanasa;Kateri;Kletek;Lawalu;Naimana;Railor Tahak;Suai;Umakatahan;Umanen Lawalu;Wehali;Babulu;Babulu Selatan;Lakekun;Lakekun Barat;Lakekun Utara;Litamali;Rainawe;Sisi;Besikama;Fafoe;Lasaen;Loofun;Maktihan;Motaain;Motaulun;Naas;Oan Mane;Rabasa;Rabasa Haerain;Rabasahain;Raimataus;Sikun;Umalor;Umatoos;Alkani;Badarai;Biris;Halibasar;Lamea ;Lorotulus;Rabasa Biris;Seserai;Webriamata;Weoe;Waseben;Weulun;Fatumtasa;Oesoko;Humusu Sainiup;Humusu Oekolo;Kel. Humusu C;Manamas;Benus;Bakitolas;Sunsea;Faenake;Banain A;Banain B;Banain C;Sainoni;Tes;Napan;Haumeni;Baas;Buk;Oenenu;Nimasi;Oelbonak;Kuenak;Oenino;Oenenu Utara;Oenenu Selatan;Sono;Inbate;Sunkaen;Nainaban;Haumeni Ana;Nilulat;Tubu;Noepesu;Fatuneno;Suanae;Lemon;Fatunisuan;Haulasi;Neotoko;Fatutasu;Manusasi;Saenam;Sa' Tab;Kel. Eban;Kel. Sallu;Tasinifu;Naekake A;Naekake B;Noelelo;Nunuanah;Kifu;Netemnanu Selatan;Netemnanu Utara;Netemnanu;Bolatena;Lifuleo;Sotimori;Daeurendale;Daimana;Pukuafu;Tena Lai;Mukekuku;Faifua;Hundihopo;Serubeba;Lakamola;Matasio;Pengudua;Batefalu;Papela;Matanae;Kel. Olafuliha;Nusakdale;Batulilok;Lenupetu;Sonimanu;Oebau;Oeledo;Keoen;Edalode;Tungganamo;Tesa Bela;Lekona;Oenggae;Fatelilo;Ofalangga;Sedeoen;Nemberala;Oenggaut;Bo'a;Oenitas;Oelolok;Mbueain;Oeseli;Oebou;Lalukoen;Oehandi;Oetefu;Batutua;Meoain;Oebafok;Oebatu;Mbokak;Lekik;Dolasi;Oelasin;Landu;Lentera;Sanggadolu;Sakubatun;Fuafuni;Dalek Esa;Lenguselu;Daleholu;Dodaek;Tebole;Inaoe;Nggelodae;Pilasue;Kuli;Bebalain;Kolobolon;Helebeik;Sanggaoen;Holoama;Tuanatuk;Oelunggu;Oematamboli;Suelain;Baadale;Lekunik;Loleoen;Kuli Aisele;Oelaka;Kel. Namodale;Kel. Mokdale;Kel. Metina;Lobodei;Bodae;Keduru;Kuji Ratu;Loborai;Huwaga;Eiada;Keliha;Kel. Bolou;Kel. Limangga;Raerobo;Mehona;Waduwalla;Ledake;Eilogo;Deme;Kotahawu;Dainao;Eikare;Loborui;Halla Paji;Ledatalo;Lobohede;Molie;Daieko;Pedarro;Tanajawa;Ledaae;Wadumaddi;Lederaga;Gurimonearu;Ramedaue;Bolua;Kolorae;Ballu;Kel. Ledeke;Kel. Ledeunu;Peret;Ighik;Birang;Akas;Damau;Damau Bowone;Taduwale;Akas Balane;Pangeran;Bulude;Patunge;Kabaruan;Mangaran;Kordakel;Rarange;Taduna;Kabaruan Timur;Patunge Timur;Pannulan;Balude Selatan;P.Miangas;Kakorotan;Marampit;Lalahe;Dampulis;Karatung;Karatung Tengah;Karatung Selatan;Dampulis Selatan;Marampit Timur;Mala;Kiama;Tarun;Sawang;Ambela;Tarun Selatan;Kiama Barat;Maredaren Utara;Sawang Utara;Mala Timur;Kel. Melonguane;Kel. Melonguane Timur;Kel. Melonguane Barat;Kel. Lesa;Kel. Enengpahembang;Kel. Tapuang;Kel. Tidore;Kel. Tona I;Kel. Tona II;Kel. Dumuhung;Kel. Batulewehe;Kel. Sawang Bendar;Kel. Soataloara I;Kel. Apengsembeka;Kel. Mahena;Kel.Bungalawang;Kel. Santiago;Kel. Manete;Kel. Soataloara II;Kalasuge;Bahu;Mala;Kalekube;Naha;Beha;Utaurano;Lenganeng;Tarolang;Tola;Kalurae;Bengketang;Petta;Bowongkulu;Pusunge;Moade;Raku;Petta Timur;Petta Barat;Petta Selatan;Likuang;Kalekube I;Bowongkulu I;Naha I;Marore;Kawio;Matutuang;Kendahe I;Kendahe II;Talawid;Tariang Lama;Pempalaraeng;Mohong Sawang;Lipang;Kawaluso;Nanedakele;Nusa;Bukide;Bukide Timur;Nanusa;Peling Sawang;Kanawong;Bumbiha;Pehe;Lehi;Peling;Makalehi;Makalehi Utara;Makalehi Timur ;Kel. Paseng;Kel. Paniki;Kel. Ondong;Tiwoho;Wori;Kima Bajo;Talawaan Bantik;Talawan Atas;Budo;Darunu;Mantehage III Tinongko;Nain;Mantehage/Buhias;Mantegahe/Bango;Mantegahe II Tangkasi;Kulu;Bulo;Lansa;Lantung;Pontoh;Minaesa;Nain Tatampi;Nain Satu;Komus I;Tuntung;Batu Tajam;Dalapuli;Buko;Dengi;Tombulang;Tuntulow;Kayu Ogu;Tanjung Sidupa;Buko Selatan;Busato;Batu Bantayo;Padango;Tuntulow Utara;Dalapuli Timur;Dalapuli Barat;Buko Utara;Tambulang Timur;Tambulang Pantai;Tuntung Timur;Duini;Ilangata;Tolongio;Tolango;Popalo;Dudepo;Mootilango;Langge;Tutuwoto;Hiyalooile;Ibarat;Iloheluma;Ilodulunga;Putiana;Heluma;Datahu;Santigi;Laulalang;Salumpaga;Diule;Pinjan;Binontoan;Lakuantolitoli;Timbolo;Teluk Jaya;Gio;Galumpang;Dungingis;Kapas;Lingadan;Banangan;Kabinuang;Ogotua;Tompoh;Bambapula;Malambigu;Simatang Tanjung;Simatang Utara;Sese;Ogolali;Balaroa;Stadong;Tepa;Imroing;Tela;Yaltubung;Wanuwui;Letsiara;Lewah;Hertuti;Sinairusi;Luang Barat;Luang Timur;Elo;Rumkisar;Lelang;Mahaleta;Romdara;Rotnama;Batu Gajah;Pupliora;Regoha;Wonreli;boven ;Kota Lama;Abusur;Oirata Timur;Oirata Barat;Ilwaki;Ilputih;Mahuan;Masapun;Amau;Hiay;Nabar;Elsulith;Naumatang;Lurang;Uhak;Eray;Moning;Arwala;Ilway;Kahilin;Ilpokil;Tomliapat;Telemar;Karbubu;Ustutun;Klishatu;Ilmamau;Laitututun;Batumiau;Tutukey;Tomra;Nuwewang;Tutuwaru;Luhuely;Latalola Besar;Serili;Latalola Kecil;Telalora;Marsela;Babiotang;Iblatmuntah;Ilbutung;Lawawang;Nura;Bululora;Ketty;Letoda;Sera;Yamluli;Lolotuara;Klis;Patti;Wakarleli;Kaiwatu;Werwaru;Tounwawan;Moain;Kel. Tiakur;Purpura;Nomaha;Labelau;Koijabi;";
//     $desa .= "Balatan;Warloy;Warjukur;Kobror;Basada;Wailay;Kaiwabar;Ponom;Lola;Mariri;Dosinamalau;Karawai;Longgar;Apara;Bemun;Mesiang;Gomo-gomo;Jambu Air;Warabal;Meror;Dosimar;Batugoyang;Salarem;Siya;Beltubur;Karey;Jorang;Gomar Sungai;Gomar Meti;Ujir;Nafar;Kobraur;Lau-Lau;Gorar;Tungu;Tunguwatu;Jabulenga;Wokam;Karangguli;Durjela;Wangel;Samang;Kel. Galai Dubu;Kel. Siwa Lima;Waifual;Wafan;Langhalau;Gomsey;Leiting;Bardefan;Mohongsel;Kolaha;Goda-Goda;Wowonda;Ilngei;Kabiarat;Lauran;Sifnana;Olilit Raya;Lermatang;Latdalam;Bomaki;Matakus;Kel. Saumlaki;Kel. Saumlaki Utara;Adaut;Namtabung;Kandar;Lingat;Fursuy;Werain;Eliasa;Tumbur;Lorulun;Atubul Dol;Amdasa;Sangliat Krawain;Arui Bab;Arui Das;Sangliat Dol;Atubul Da;Lumasebu;Kilmasa;Meyano Bab;Alusi Krawain;Alusi Kelaan;Alusi Bukjalim;Alusi Tamrian;Alusi Batjasi;Lorwembun;Meyano Das;Arma;Watumuri;Manglusi;Tutukembong;Waturu;Lelingluan;Ritabel;Ridool;Watidal;Kilobar;Kelaan;Lamdesar Barat;Lamdesar Timur;Romean;Rumngeur;Awear;Sofyanin;Walerang;Adodo Fordata;Weduar;Nerong;Larat;Tamangil Nuhuten;Tamangil Nuhuyanat;Kilwat;Sather;Tutrean;Ohoirenan;Soindat;Werka;Waur;Ohoinangan;Ler Ohoilim;Rahareng;Elat;Depur;Ohoilim;El Ralang;Reyamru;Fako;Yamtel;Wau Tahit;Ngefuit;Ohoiel;Ohoiwait;Ohoiwang;Fangamas;Ohoinangan Atas;Harangur;Udar;Daftel;Karkarit;Rahareng Atas;Wulurat;Wakol;Ngurdu;Soinrat;Wermaf;Bombay;Watsin;Sirbante;Ngat;Nabaheng;Ngefuit Atas;Watuar;Mataholat;Hollat;Ohoiraut;Harr Ohoimel;Langgar Haar;Banda Eli;Watlaar;Ohoifau;Kilwair;Renfan;Hollar Solair;Hoko;Hollay;Soin;Haar Ohoimur GPM;Haar Ohoimur RK;Haar Ohoiwait;Haar Wassar;Haar Renrahantel;Ur;Ohoimajang;Banda Efruan;Banda Suku Tigapuluh;Tuburlay;Ohoifaruan;Ohoiwirin;Tuburngil;Yamtimur;Renfaan Islam;Renfaan GPM;Fanwav;Hoat;Ngafan;Feer;Rerean;Ngurko;Hoko;Weduar Fer;Uat;Ngan;Watkidat;Ohoilean;Wafol;Rahangiar;Pangeo;Sopi;Bere-Bere Kecil;Titigogoli;Hapo;Libano;Aru;Towara;Cendana;Podimor Padange;Sopi Majiko;Gorugo;Loleo;Cempaka;Bere Bere;Sakita;Tawakali;Yao;Bido;Gorua;Korago;Lusuo;Kenari;Loleo Jaya;Maba;Tanjung Saleh;Goa Hira;Gorua Selatan;Buho Buho;Wewemo;Mira;Lifao;Rahmat;Sambaiki Tua;Sangowo;Sambiki Baru;Sangowo Barat;Sangowo Timur;Seseli Jaya;Hino;Gosoma Maluku;Gamlamo;Doku Mira;Gotalamo;Daruba;Darame;Wawama;Padanga;Juanga;Totoduku;Momojiu;Sabatai Baru;Sabatai Tua;Daeo;Dehegila;Pilowo;Galo-Galo;Koloray;Yayasan;Joubela;Aha;Muhajirin;Mandiri;Falila;Sabala;Daeo Majiko;Morodadi;Nakamura;Wayabula;Tiley;Ngele-Ngele Kecil;Cucumare;Aru Irian;Waringin;Tutuhu;Cio Gerong;Posi-Posi;Aru Burung;Lou Madoro;Leo-Leo;Sami Nyamau;Ngele-Ngele Besar;Raja;Cio Dalam;Usbar Pantai;Tiley Pantai;Cio Maloleo;Bobula;Gemia;Tepeleo;Bilifitu;Tepeleo Batudua;Pantua Jaya;Maliforo;Abidon;Rutum;Reni;Kapadiri;Dorekhar;Yenkawir;Boiseran;Runi;Yenkanfan;Sausapor;Emaos;Jokte;Uigwem;Sungguwan;Sau Uram;Naggou;Bondek;Bondonggwan;Syurauw;Ayuka;Amamapare;Ohotya;Omawita;Fanamo;Tabonji;Wanggambi;Bamol I;Suam;Yamuka;Iromoro;Konjombando;Yeraha;Bamol II;Konorau;Waan;Tor;Kladar;Sabon;Sibenda;Wetau;Kawe;Pembri;Wantarma;Dafnawanga;Kimaam;Komolom;Kumbis;Kalilam;Teri;Mambum;Kiworo;Woner;Deka;Tuniram;Sabudom;Purawenderu;Umanderu;Webu;Okaba;Wambi;Makaling;Alatep;Iwol;Dufmiraf;Alaku;Sanggase;Es Wambi;Matara;Waninggap  Naggo;Urumb;Sido Mulyo;Kuprik;Kuper;Semangga Jaya;Marga Mulya;Muram Sari;Waninggap Kai;Nasem;Wasur;Bokem;Buti;Nggolar;Kel. Samkai;Kel. Karang Indah;Kel. Mandala;Kel. Maro;Kel. Kelapa Lima;Kel. Rimba Jaya;Kel. Bambu Pemali;Kel. Seringgu Jaya;Kel. Kamundu;Kel. Kamahedonga;Kel. Muli;Bupul;Tanas;Kweel;Sipias;Metaat Makmur;Enggal Jaya;Gerisar;Bupul Indah;Tof-Tof;Bunggay;Bouwer;Bumun;Kuler (Tunas Baru);Onggaya;Tomer;Tomerau;Kondo;Sota ;Yanggandur;Rawa Biru;Toray;Erambu;Selil;Kindiki;Kumaaf;Nggayu;Kafyamke;Mandekman;Rawahayu;Belbelan;Kir Ely;Kandrakay;Baidu;Getentiri;Anggai;Butiptiri;Asiki;Kapogu;Miri;Kombut;Moukbiran;Kawangtet;Amuan;Woropko;Winiktit;Kanggewot;Jetekun / Yetetkun;Inggembit;Wametkapa;Wombon;Upkim;Ikcan;Sesnuk;Anggamburan;Kanggup;Yomkondo;Amboran;Ninati;Upyetetko;Yafufla;Ugo;Dema;Batom;Oksip;Mongham;Sabi;Neep;Muara;Batom Dua;Akyako;Peteng;Belomo;Abukerom;Iwur;Kurumklin;Walapkubun;Dinmot Arim;Ewenkatop;Ulkubi;Dipol;Nenginum;Narnger;Kamyoim;Okma;Oktae;Tinibil;Okdilam;Autpahik;Tomka;Okpa;Okhaka;Honkuding;Bomding;Okdunam;Paune;Tarup;Marang Tiking;Imsin;Bitingpding;Onkor;Betan Dua;Omor;Okyop;Oketur;Ehipten;Wantem;Dikdon;Okyako;Okyaop;Tatam;Okhik;Mot / Moot;Milki;";
//     $desa .= "Yubu;Muara Asbi;Tual;Bias;Bumi;Tero;Delemo;Banda;Pund;Kalifam;Yuwainda;Kalimala;Ampas;Bompai;Sack;Yetti;Kriku;Skofro;Kibay;Sangke;Suskun;Amyu;Kikere;Petewi;Towe Hitam;Towe Atas;Terfones;Tefalma;Bias;Milki;Lules;Jember;Niliti;Pris;Dubu;Umuraf;Semografi;Embi;Yamraf Dua;Tatakra;Yabanda;Yuruf;Amgotro;Jifanggri;Monggoafi;Fafenumbu;Akarinda;Skouw Mabo;Skouw Yambe;Skouw Sae;Holtekamp;Koya Tengah;Mosso;Kel. Koya Barat;Kel. Koya Timur;Kayo Batu;Kel. Gurabesi;Kel. Bayangkara;Kel. Trikora;Kel. Imbi;Kel.Tanjung Ria;Kel. Mandala;Kel. Angkaspura;Sarmo;Liki;Sawar;Bagaiserwar;Armo;Bagaiserwar II;Pulau Armo;Lembah Neidam;Tefarewar;Kel. Mararena;Kel. Sarmi Kota;Mnubabo;Swapodibo;Mokmer;Inggiri;Parai;Samau;Insrom;Anggaraidi;Manswam;Sanumi;Manggandisapi;Karyendi;Kababur;Babrinbo;Inggupi;Kel. Sorido;Kel. Waupnor;Kel. Saramon;Kel. Burokop;Kel. Fandoi;Kel. Mandala;Kel. Yenures;Waryei;Koiryakam;Wayori;Amyas;Napisndi;Masyai;Mapia;Warsa;Warbor;Kobari Jaya;Fanjur;Puweri;Rayori;Mburwandi;Manggonswan ;Wongkeina;Yamnaisu;Aruri;Imbirsbari;Ineki;Insumbrei;Yawerma;Wombonda;Marsram;Duber;Sauyas;Wafor;Sorendidori;Waryesi;Syurdori;Douwbo;";
    
//     $desa = str_replace('Kel. ', '', $desa);
//     // $desa = preg_replace('/[^\p{L}\p{N}\s]/u', '', $desa);
//     // $desa = preg_replace('/[ ]{2,}|[\t]/', ',', trim($desa));
//     // $desa2 = preg_replace('/[ ]{2,}|[\t]/', ',', trim($desa2));
//     // $desa3 = preg_replace('/[ ]{2,}|[\t]/', ',', trim($desa3));
//     // $desa4 = preg_replace('/[ ]{2,}|[\t]/', ',', trim($desa4));
//     // $desa5 = preg_replace('/[ ]{2,}|[\t]/', ',', trim($desa5));

//     $ar = array_values(array_filter(explode(';', $desa)));
//     // $ids = [];
//     $not = [];
//     $do = [];
//     foreach ($ar as $key => $value) {
//         $quey = 'SELECT * FROM utils_desa WHERE name = "'.$value.'" AND kecamatanid IN ('.$kec.') AND active = 0';
//         $exist = DB::select(DB::raw($quey));
        
//         if(!empty($exist)){
//             if(count($exist) == 1){
//                 UtilsDesa::where([['id', $exist[0]->id], ['active', '0']])->whereIn('kecamatanid', $arkec)->update(['active'=> 1]);
//                 // array_push($ids, ['id'=>$exist[0]->id, 'name'=>$value]);
//             }else{
//                 array_push($do, $value);
//             }
//         }else{
//             array_push($not, $value);
//         }
//     }
//     dd([
//         'Nama Double'=>$do, 
//         'Tidak Cocok'=>$not
//     ]);
    
// });

// Route::get('createDetail', function(){
//     $id = UtilsDesa::where('active', 1)->get()->pluck('id')->toArray();
//     foreach ($id as $key => $value) {
//         DesaDetail::updateOrCreate(
//             [
//                 'id'=>$value
//             ],
//             [
//                 'id'=>$value,
//                 'jumlah_penduduk'=>null
//             ]
//         );
//     }
// });
#endregion