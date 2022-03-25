<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Utils\UtilsProvinsi;
use Illuminate\Support\Facades\DB;

class BerandaController extends Controller
{
    public function getGrafik(){
        $provinsi = UtilsProvinsi::where('active', 1)->whereHas('kota', function($qKota){
            $qKota->where('active', 1);
            $qKota->whereHas('kecamatan', function($qKec){
                $qKec->where('active', 1);
            });
        })->orderBy('name', 'asc')->get()->pluck('name')->toArray();
        $data['provinsi'] = UtilsProvinsi::where('active', 1)->orderBy('name', 'asc')->get()->pluck('name')->toArray();

        $dataLokpri = DB::table('utils_provinsi')->select([
            DB::raw('utils_provinsi.name'),
            DB::raw('count(utils_kecamatan.id) as total_lokpri')
        ])->join('utils_kota', 'utils_provinsi.id', 'utils_kota.provinsiid')
            ->join('utils_kecamatan', 'utils_kota.id', 'utils_kecamatan.kotaid')
            ->join('kecamatan_detail', 'kecamatan_detail.id', 'utils_kecamatan.id')
            ->where('utils_provinsi.active', 1)
            ->where('utils_kota.active', 1)
            ->where('utils_kecamatan.active', 1)
            ->where('lokpriid', 'like', '%1%')
            ->orderBy('utils_provinsi.name', 'asc')->get()->pluck('total_lokpri')->toArray();

        $dataPksn = DB::table('utils_provinsi')->select([
            DB::raw('utils_provinsi.name'),
            DB::raw('count(utils_kecamatan.id) as total_pksn')
        ])->join('utils_kota', 'utils_provinsi.id', 'utils_kota.provinsiid')
            ->join('utils_kecamatan', 'utils_kota.id', 'utils_kecamatan.kotaid')
            ->join('kecamatan_detail', 'kecamatan_detail.id', 'utils_kecamatan.id')
            ->where('utils_provinsi.active', 1)
            ->where('utils_kota.active', 1)
            ->where('utils_kecamatan.active', 1)
            ->where('lokpriid', 'like', '%2%')
            ->orderBy('utils_provinsi.name', 'asc')->get()->pluck('total_pksn')->toArray();

        $dataPpkt = DB::table('utils_provinsi')->select([
            DB::raw('utils_provinsi.name'),
            DB::raw('count(utils_kecamatan.id) as total_ppkt')
        ])->join('utils_kota', 'utils_provinsi.id', 'utils_kota.provinsiid')
            ->join('utils_kecamatan', 'utils_kota.id', 'utils_kecamatan.kotaid')
            ->join('kecamatan_detail', 'kecamatan_detail.id', 'utils_kecamatan.id')
            ->where('utils_provinsi.active', 1)
            ->where('utils_kota.active', 1)
            ->where('utils_kecamatan.active', 1)
            ->where('lokpriid', 'like', '%3%')
            ->orderBy('utils_provinsi.name', 'asc')->get()->pluck('total_ppkt')->toArray();

        return response()->json([
            'labels' => $provinsi,
            'dataLokpri' => $dataLokpri,
            'dataPksn' => $dataPksn,
            'dataPpkt' => $dataPpkt,
        ]);
    }
}
