<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Desa\DesaMobilitas;
use App\Models\Refactored\Kecamatan\KecamatanMobilitas;

class InfrastrukturGrafikMobilitasController extends Controller
{
    public function chartKecamatan($id)
    {
        $aset = KecamatanMobilitas::where('id', $id)->get();
        $data['warna_baik'] = 'rgba(143, 247, 45, 0.4)';
        $data['border_baik'] = 'rgba(143, 247, 45, 1)';
        $data['warna_rusak'] = 'rgba(247, 45, 45, 0.4)';
        $data['border_rusak'] = 'rgba(247, 45, 45, 1)';

        $chart = [
            'label'=>[],
            'jumlah'=>[],
        ];
        foreach ($aset as $key => $value) {
            array_push($chart['label'], $value->item->nama);
            array_push($chart['jumlah'], $value->jumlah);
        }

        $data['chart'] = $chart;

        return response()->json($data);
    }

    public function chartKelurahan($id)
    {
        $aset = DesaMobilitas::where('id', $id)->get();
        $data['warna_baik'] = 'rgba(143, 247, 45, 0.4)';
        $data['border_baik'] = 'rgba(143, 247, 45, 1)';
        $data['warna_rusak'] = 'rgba(247, 45, 45, 0.4)';
        $data['border_rusak'] = 'rgba(247, 45, 45, 1)';

        $chart = [
            'label'=>[],
            'jumlah'=>[],
        ];
        foreach ($aset as $key => $value) {
            array_push($chart['label'], $value->item->nama);
            array_push($chart['jumlah'], $value->jumlah);
        }

        $data['chart'] = $chart;

        return response()->json($data);
    }
}
