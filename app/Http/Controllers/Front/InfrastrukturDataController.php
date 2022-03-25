<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Desa\DesaPenduduk;
use App\Models\Refactored\Desa\DesaWilayah;
use App\Models\Refactored\Kecamatan\KecamatanLokpri;
use App\Models\Refactored\Kecamatan\KecamatanPenduduk;
use App\Models\Refactored\Kecamatan\KecamatanType;
use App\Models\Refactored\Kecamatan\KecamatanWilayah;
use App\Models\Refactored\Utils\UtilsDesa;
use App\Models\Refactored\Utils\UtilsKecamatan;
use App\Models\Refactored\Utils\UtilsProvinsi;
use App\Traits\KecDetail;
use Illuminate\Support\Facades\DB;

class InfrastrukturDataController extends Controller
{
    use KecDetail;

    public function index(){
        $data['provinces'] = UtilsProvinsi::where('active', 1)->get();
        $data['tipe'] = KecamatanType::all();
        $data['lokpri'] = KecamatanLokpri::all();

        return view('front.infrastruktur-data.index', $data);
    }

    public function show($type, $id){
        if($type == 'kecamatan'){
            $data = $this->getKecamatan($id);
            return view('front.infrastruktur-data.show', $data);
        }elseif($type == 'kelurahan'){
            $data = $this->getDesa($id);
            return view('front.infrastruktur-data.show', $data);
        }else{
            return abort(404);
        }
    }

    public function getKecamatan($id){
        $data['title'] = 'Kecamatan';

        $kecamatan = UtilsKecamatan::where('id', $id)->first();
        $data['kec'] = $kecamatan;
        $data['detail'] = $kecamatan->detail;
        $data['camat'] = $kecamatan->detail->camat;

        switch (@$kecamatan->detail->camat->kondisi_kantor) {
            case 1:
                $data['camat']['kon_kan'] = 'Baik';
                break;
            case 2:
                $data['camat']['kon_kan'] = 'Rusak';
                break;
            case 0:
                $data['camat']['kon_kan'] = 'Tidak Ada';
                break;
            default:
                $data['camat']['kon_kan'] = 'Tidak Ada';
                break;
        }
        $data['camat']['sta_kan'] = (@$kecamatan->detail->camat->status_kantor==1)?'Ada':'Tidak Ada';

        switch (@$kecamatan->detail->camat->kondisi_balai) {
            case 1:
                $data['camat']['kon_bal'] = 'Baik';
                break;
            case 2:
                $data['camat']['kon_bal'] = 'Rusak';
                break;
            case 0:
                $data['camat']['kon_bal'] = 'Tidak Ada';
                break;
            default:
                $data['camat']['kon_bal'] = 'Tidak Ada';
                break;
        }
        $data['camat']['sta_bal'] = (@$kecamatan->detail->camat->status_balai==1)?'Ada':'Tidak Ada';

        $data['camat']['foto_kantor'] = (!empty($kecamatan->detail->camat->foto_kantor))?asset('upload/camat/kantor').'/'.$kecamatan->detail->camat->foto_kantor:asset('assets/back/images/preview-3.jpg');
        $data['camat']['foto_balai'] = (!empty($kecamatan->detail->camat->foto_balai))?asset('upload/camat/balai').'/'.$kecamatan->detail->camat->foto_balai:asset('assets/back/images/preview-3.jpg');

        $data['tipelokpri'] = $this->getDetailKecamatan($id);
        $data['wilayah'] = KecamatanWilayah::where('id', $id)->first();

        $age = KecamatanPenduduk::where('id', $id)->whereIn('idjenis', ['1', '2'])->orderBy('idjenis', 'asc')->get();
        $query = "SELECT COALESCE(SUM(jumlah),0) AS jumlah FROM kecamatan_penduduk
                    WHERE id = '$id'
                        AND idjenis NOT IN (1,2)";
        $total = DB::select($query)[0];
        $data['penduduk'] = [
            'total'=>$total->jumlah??'-',
            'kk'=>$data['detail']->jumlah_kk??'-',
            'pria'=>$age[0]->jumlah??'-',
            'wanita'=>$age[1]->jumlah??'-',
        ];

        return $data;
    }

    public function getDesa($id){
        $data['title'] = 'Desa';

        $data['desa'] = $desa = UtilsDesa::where('id', $id)->first();
        $data['detail'] = @$desa->detail;
        $data['kades'] = @$desa->detail->kades;

        switch (@$desa->detail->kades->kondisi_kantor) {
            case 1:
                $data['kades']['kon_kan'] = 'Baik';
                break;
            case 2:
                $data['kades']['kon_kan'] = 'Rusak';
                break;
            case 0:
                $data['kades']['kon_kan'] = 'Tidak Ada';
                break;
            default:
                $data['kades']['kon_kan'] = 'Tidak Ada';
                break;
        }
        $data['kades']['sta_kan'] = (@$desa->detail->kades->status_kantor==1)?'Ada':'Tidak Ada';

        switch (@$desa->detail->kades->kondisi_balai) {
            case 1:
                $data['kades']['kon_bal'] = 'Baik';
                break;
            case 2:
                $data['kades']['kon_bal'] = 'Rusak';
                break;
            case 0:
                $data['kades']['kon_bal'] = 'Tidak Ada';
                break;
            default:
                $data['kades']['kon_bal'] = 'Tidak Ada';
                break;
        }
        $data['kades']['sta_bal'] = (@$desa->detail->kades->status_balai==1)?'Ada':'Tidak Ada';

        $data['kades']['foto_kantor'] = (!empty($desa->detail->kades->foto_kantor))?asset('upload/desa/kantor').'/'.$desa->detail->kades->foto_kantor:asset('assets/back/images/preview-3.jpg');
        $data['kades']['foto_balai'] = (!empty($desa->detail->kades->foto_balai))?asset('upload/desa/balai').'/'.$desa->detail->kades->foto_balai:asset('assets/back/images/preview-3.jpg');

        $data['wilayah'] = DesaWilayah::where('id', $id)->first();

        $age = DesaPenduduk::where('id', $id)->whereIn('idjenis', ['1', '2'])->orderBy('idjenis', 'asc')->get();
        $query = "SELECT COALESCE(SUM(jumlah),0) AS jumlah FROM desa_penduduk
                    WHERE id = '$id'
                        AND idjenis NOT IN (1,2)";
        $total = DB::select($query)[0];
        $data['penduduk'] = [
            'total'=>$total->jumlah??'-',
            'kk'=>$data['detail']->jumlah_kk??'-',
            'pria'=>$age[0]->jumlah??'-',
            'wanita'=>$age[1]->jumlah??'-',
        ];

        return $data;
    }
}
