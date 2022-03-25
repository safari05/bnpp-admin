<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Desa\Desakelurahan;
use App\Models\Kecamatan\Kecamatan;
use App\Models\Refactored\Utils\UtilsDesa;
use App\Models\Refactored\Utils\UtilsKecamatan;
use App\Models\Refactored\Utils\UtilsKota;
use App\Models\Refactored\Utils\UtilsProvinsi;
use App\Models\Wilayah\Kabupatenkota;
use App\Models\Wilayah\Provinsi;
use Illuminate\Http\Request;

class UtilsController extends Controller
{
    public function listProvinsi(){
        $data = UtilsProvinsi::select(['id', 'name'])->where('active', 1)->get()->toArray();
        return response()->json($data);
    }

    public function listKota(){
        $data = UtilsKota::select(['id', 'provinsiid', 'name'])->where('active', 1);
        if(request()->provid){
            $data = $data->where('provinsiid', request()->provid)->whereHas('provinsi', function($q){
                $q->where('active', 1);
            });
        }
        $data = $data->get()->toArray();
        return response()->json($data);
    }

    public function listKecamatan(){
        $data = UtilsKecamatan::select(['id', 'kotaid', 'name'])->where('active', 1);
        if(request()->kotaid){
            $data = $data->where('kotaid', request()->kotaid)->whereHas('kota', function($q){
                $q->where('active', 1);
            });
        }
        $data = $data->get()->toArray();
        return response()->json($data);
    }

    public function listDesa(){
        $data = UtilsDesa::select(['id', 'kecamatanid', 'name'])->where('active', 1);
        if(request()->kecid){
            $data = $data->where('kecamatanid', request()->kecid)->whereHas('kecamatan', function($q){
                $q->where('active', 1);
            });
        }
        $data = $data->get()->toArray();
        return response()->json($data);
    }
}
