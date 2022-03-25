<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Desa\DesaAset;
use App\Models\Refactored\Kecamatan\KecamatanAset;

class InfrastrukturGrafikAsetController extends Controller
{
    public function chartKecamatan($id)
    {
        $aset = KecamatanAset::where('id', $id)->get();
        $data['warna_baik'] = 'rgba(143, 247, 45, 0.4)';
        $data['border_baik'] = 'rgba(143, 247, 45, 1)';
        $data['warna_rusak'] = 'rgba(247, 45, 45, 0.4)';
        $data['border_rusak'] = 'rgba(247, 45, 45, 1)';

        $chart = [
            'label'=>[],
            'baik'=>[],
            'rusak'=>[],
        ];
        foreach ($aset as $key => $value) {
            array_push($chart['label'], $value->item->nama);
            array_push($chart['baik'], $value->jumlah_baik);
            array_push($chart['rusak'], $value->jumlah_rusak);
        }

        $data['chart'] = $chart;

        return response()->json($data);
    }

    public function chartKelurahan($id)
    {
        $aset = DesaAset::where('id', $id)->get();
        $data['warna_baik'] = 'rgba(143, 247, 45, 0.4)';
        $data['border_baik'] = 'rgba(143, 247, 45, 1)';
        $data['warna_rusak'] = 'rgba(247, 45, 45, 0.4)';
        $data['border_rusak'] = 'rgba(247, 45, 45, 1)';

        $chart = [
            'label'=>[],
            'baik'=>[],
            'rusak'=>[],
        ];
        foreach ($aset as $key => $value) {
            array_push($chart['label'], $value->item->nama);
            array_push($chart['baik'], $value->jumlah_baik);
            array_push($chart['rusak'], $value->jumlah_rusak);
        }

        $data['chart'] = $chart;

        return response()->json($data);
    }
}
