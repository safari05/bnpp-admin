<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Utils\UtilsDesa;
use App\Models\Refactored\Utils\UtilsKecamatan;
use App\Traits\KecDetail;

class InfrastrukturGrafikController extends Controller
{
    use KecDetail;

    public function show($type, $id){
        if($type == 'kecamatan'){
            $data = $this->getKecamatan($id);
            return view('front.infrastruktur-grafik.show', $data);
        }elseif($type == 'kelurahan'){
            $data = $this->getDesa($id);
            return view('front.infrastruktur-grafik.show', $data);
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

        $data['camat']['foto_kantor'] = (!empty($kecamatan->detail->camat->foto_kantor))?asset('upload/camat/kantor').'/'.$kecamatan->detail->camat->foto_kantor:asset('assets/front/images/kecamatan.jpg');
        $data['camat']['foto_balai'] = (!empty($kecamatan->detail->camat->foto_balai))?asset('upload/camat/balai').'/'.$kecamatan->detail->camat->foto_balai:asset('assets/front/images/kecamatan.jpg');

        $data['tipelokpri'] = $this->getDetailKecamatan($id);

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

        $data['kades']['foto_kantor'] = (!empty($desa->detail->kades->foto_kantor))?asset('upload/desa/kantor').'/'.$desa->detail->kades->foto_kantor:asset('assets/front/images/desa.jpg');
        $data['kades']['foto_balai'] = (!empty($desa->detail->kades->foto_balai))?asset('upload/desa/balai').'/'.$desa->detail->kades->foto_balai:asset('assets/front/images/desa.jpg');

        return $data;
    }
}
