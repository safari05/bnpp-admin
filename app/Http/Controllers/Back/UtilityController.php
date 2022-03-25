<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Plb\Plb;
use App\Models\Refactored\Utils\UtilsDesa;
use App\Models\Refactored\Utils\UtilsKecamatan;
use App\Models\Refactored\Utils\UtilsKota;
use App\Models\Refactored\Utils\UtilsProvinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UtilityController extends Controller
{
    public function getActiveProvinsi(){
        $data = UtilsProvinsi::select(['id', 'name'])->where('active', 1);
        if(@Auth::user()->idrole == 5){
            $data = $data->where('id', @Auth::user()->kecamatan->kecamatan->kota->provinsiid);
        }
        $data = $data->get()->toArray();
        return response()->json($data);
    }

    public function getActiveKota(){
        $data = UtilsKota::select(['id', 'provinsiid', 'name'])->where('active', 1);
        if(request()->provid){
            $data = $data->where('provinsiid', request()->provid)->whereHas('provinsi', function($q){
                $q->where('active', 1);
            });
        }

        if(@Auth::user()->idrole == 5){
            $data = $data->where('id', @Auth::user()->kecamatan->kecamatan->kotaid);
        }

        $data = $data->get()->toArray();
        return response()->json($data);
    }

    public function getActiveKecamatan(){
        $data = UtilsKecamatan::select(['id', 'kotaid', 'name'])->where('active', 1);
        if(request()->kotaid){
            $data = $data->where('kotaid', request()->kotaid)->whereHas('kota', function($q){
                $q->where('active', 1);
            });
        }

        if(!empty(request()->tipe)){
            $tipe = request()->tipe;
            $data = $data->whereHas('detail', function($q) use($tipe){
                $q->where('typeid', 'like', '%'.$tipe.'%');
            });
        }

        if(!empty(request()->lokpri)){
            $lokpri = request()->lokpri;
            $data = $data->whereHas('detail', function($q) use($lokpri){
                $q->where('lokpriid', 'like', '%'.$lokpri.'%');
            });
        }

        if(@Auth::user()->idrole == 5){
            $data = $data->where('id', @Auth::user()->kecamatan->idkecamatan);
        }

        $data = $data->get()->toArray();
        return response()->json($data);
    }

    public function getActiveDesa(){
        $data = UtilsDesa::select(['id', 'kecamatanid', 'name'])->where('active', 1);

        if(@Auth::user()->idrole == 5){
            $data = $data->where('kecamatanid', @Auth::user()->kecamatan->idkecamatan)->whereHas('kecamatan', function($q){
                $q->where('active', 1);
            });
        }else{
            if(request()->kecid){
                $data = $data->where('kecamatanid', request()->kecid)->whereHas('kecamatan', function($q){
                    $q->where('active', 1);
                });
            }
        }

        $data = $data->get()->toArray();
        return response()->json($data);
    }

    public function getActivePLB(){
        $data = Plb::select(['idplb', 'kecamatanid', 'nama_plb', 'jenis_plb']);

        if(!empty(request()->tipe)){
            $tipe = request()->tipe;
            $data = $data->where('jenis_plb', $tipe);
        }

        if(@Auth::user()->idrole == 5){
            $data = $data->where('kecamatanid', @Auth::user()->kecamatan->idkecamatan)->whereHas('kecamatan', function($q){
                $q->where('active', 1);
            });
        }else{
            if(request()->kecid){
                $data = $data->where('kecamatanid', request()->kecid)->whereHas('kecamatan', function($q){
                    $q->where('active', 1);
                });
            }
        }

        $data = $data->get()->toArray();
        return response()->json($data);
    }
}
