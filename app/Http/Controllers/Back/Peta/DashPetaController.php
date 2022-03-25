<?php

namespace App\Http\Controllers\Back\Peta;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Desa\DesaCoord;
use App\Models\Refactored\Desa\DesaDetail;
use App\Models\Refactored\Kecamatan\KecamatanCoord;
use App\Models\Refactored\Kecamatan\KecamatanDetail;
use App\Models\Refactored\Kecamatan\KecamatanLokpri;
use App\Models\Refactored\Kecamatan\KecamatanType;
use App\Models\Refactored\Plb\Plb;
use App\Models\Refactored\PLB\PlbCoord;
use App\Models\Refactored\Utils\UtilsDesa;
use App\Models\Refactored\Utils\UtilsKecamatan;
use App\Models\Refactored\Utils\UtilsProvinsi;
use App\Traits\KecDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashPetaController extends Controller
{
    use KecDetail;

    public function index(){
        $data['provinces'] = UtilsProvinsi::where('active', 1);
        if(Auth::user()->idrole == 5){
            $data['provinces'] = $data['provinces']->where('id', @Auth::user()->kecamatan->kecamatan->kota->provinsiid);
        }
        $data['provinces'] = $data['provinces']->get();
        $data['tipe'] = KecamatanType::all();
        $data['lokpri'] = KecamatanLokpri::all();
        return view('back.map.full-map', $data);
    }

    public function kecamatanCoords(){
        $kec = UtilsKecamatan::where('active', 1)->get();

        $data['keccoords'] = [];
        foreach ($kec as $key => $value) {
            if (!empty(@$value->detail->coord)) {
                $temp = [
                    'id'=>$value->id,
                    'lat'=>$value->detail->coord->latitude,
                    'long'=>$value->detail->coord->longitude,
                    'name'=>ucwords(strtolower('Kecamatan '.$value->name)),
                    'lokasi'=>ucwords(strtolower($value->kota->name.', Provinsi '.$value->kota->provinsi->name)),
                ];
                array_push($data['keccoords'], $temp);
            }
        }

        return response()->json([
            'status'=>200,
            'data'=>$data['keccoords']
        ]);
    }

    public function desaCoords(){
        $desa = UtilsDesa::where('active', 1)->whereHas('kecamatan', function($q){
            $q->where('active', 1);
        })->get();

        $data['desacoords'] = [];
        foreach ($desa as $key => $value) {
            if (!empty(@$value->detail->coord)) {
                $temp = [
                    'id'=>$value->id,
                    'lat'=>$value->detail->coord->latitude,
                    'long'=>$value->detail->coord->longitude,
                    'name'=>ucwords(strtolower('Desa '.$value->name)),
                    'lokasi'=>ucwords(strtolower('Kecamatan '.$value->kecamatan->name.', '.$value->kecamatan->kota->name.', Provinsi '.$value->kecamatan->kota->provinsi->name)),
                ];
                array_push($data['desacoords'], $temp);
            }
        }

        return response()->json([
            'status'=>200,
            'data'=>$data['desacoords']
        ]);
    }

    public function plbCoords(){
        $plb = Plb::all();

        $data['plbcoords'] = [];
        foreach ($plb as $key => $value) {
            if (!empty(@$value->coord) && @$value->kecamatan->active == 1 && @$value->desa->active == 1) {
                $temp = [
                    'id'=>$value->idplb,
                    'lat'=>$value->coord->latitude,
                    'long'=>$value->coord->longitude,
                    'name'=>ucwords(strtolower($value->nama_plb)),
                    'lokasi'=>ucwords(strtolower('Kecamatan '.$value->kecamatan->name.', '.$value->kecamatan->kota->name.', Provinsi '.$value->kecamatan->kota->provinsi->name)),
                ];
                array_push($data['plbcoords'], $temp);
            }
        }

        return response()->json([
            'status'=>200,
            'data'=>$data['plbcoords']
        ]);
    }

    public function getDetailTempat($tipe, $id){
        $temp = [];
        $data = [];
        if($tipe == 'kec'){
            $temp = UtilsKecamatan::where('id', $id)->first();
            if(!empty($temp)){
                $detail = $this->getDetailKecamatan($id);
                $data = [
                    'id'=>$temp->id,
                    'name'=>$temp->name,
                    'lokpri'=>$detail['lokpri'],
                    'tipe'=>$detail['tipe'],
                    'lokasi'=>$temp->kota->name.', '.$temp->kota->provinsi->name,
                    'detailurl'=>url('kecamatan/detail').'/'.$id,
                ];
            }
        }else if($tipe == 'desa'){
            $temp = UtilsDesa::where('id', $id)->first();
            if(!empty($temp)){
                $data = [
                    'id'=>$temp->id,
                    'name'=>$temp->name,
                    'kecamatan'=>$temp->kecamatan->name,
                    'lokasi'=>$temp->kecamatan->kota->name.', '.$temp->kecamatan->kota->provinsi->name,
                    'detailurl'=>url('desa/detail').'/'.$id,
                ];
            }
        }else if($tipe == 'plb'){
            $temp = Plb::where('idplb', $id)->first();
            if(!empty($temp)){
                $data = [
                    'id'=>$temp->idplb,
                    'name'=>$temp->nama_plb,
                    'desa'=>$temp->desa->name,
                    'kecamatan'=>$temp->kecamatan->name,
                    'lokasi'=>$temp->kecamatan->kota->name.', '.$temp->kecamatan->kota->provinsi->name,
                    'tipe'=>($temp->jenis_plb==1)? 'NON-PLBN':'PLBN',
                    'detailurl'=>url('plb/master/detail').'/'.$id,
                ];
            }
        }

        if(!empty($data)){
            return response()->json([
                'status'=>200,
                'msg'=>'Data Tempat berhasil ditemukan',
                'data'=>$data
            ]);
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Data tempat tidak ditemukan'
            ]);
        }
    }
}
