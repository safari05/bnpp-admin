<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Desa\DesaPenduduk;
use App\Models\Refactored\Kecamatan\KecamatanPenduduk;

class InfrastrukturGrafikPendudukController extends Controller
{
    public function chartKecamatan($id)
    {
        $temp_data = KecamatanPenduduk::where('id', $id)->whereNotIn('idjenis', ['1','2'])->orderBy('idjenis', 'asc')->get();

        $chart = [];
        foreach ($temp_data as $key => $value) {
            $color = rand(0, 255).','.rand(0, 255).','.rand(0, 255);
            $temp = [
                'label'=>[$value->jenis->nama],
                'data'=>[$value->jumlah],
                'backgroundColor'=>'rgba('.$color.', 0.4)',
                'borderColor'=>'rgba('.$color.', 1)',
                'borderWidth'=>'1'
            ];
            array_push($chart, $temp);
        }

        $data['data'] = $chart;

        return response()->json($data);
    }
    public function chartKecamatanGender($id)
    {
        $temp_data = KecamatanPenduduk::where('id', $id)->whereIn('idjenis', ['1','2'])->orderBy('idjenis', 'asc')->get();

        $chart = [
            'label'=>[],
            'data'=>[],
            'backgroundColor'=>[],
            'borderColor'=>[],
            'borderWidth'=>'1'
        ];

        foreach ($temp_data as $key => $value) {
            $color = rand(0, 255).','.rand(0, 255).','.rand(0, 255);
            array_push($chart['label'], $value->jenis->nama);
            array_push($chart['data'], $value->jumlah);
            array_push($chart['backgroundColor'], 'rgba('.$color.', 0.4)');
            array_push($chart['borderColor'], 'rgba('.$color.', 1)');
        }

        $data['chart'] = $chart;

        return response()->json($data);
    }

    public function chartKelurahan($id)
    {
        $temp_data = DesaPenduduk::where('id', $id)->whereNotIn('idjenis', ['1','2'])->orderBy('idjenis', 'asc')->get();

        $chart = [];
        foreach ($temp_data as $key => $value) {
            $color = rand(0, 255).','.rand(0, 255).','.rand(0, 255);
            $temp = [
                'label'=>[$value->jenis->nama],
                'data'=>[$value->jumlah],
                'backgroundColor'=>'rgba('.$color.', 0.4)',
                'borderColor'=>'rgba('.$color.', 1)',
                'borderWidth'=>'1'
            ];
            array_push($chart, $temp);
        }

        $data['data'] = $chart;

        return response()->json($data);
    }

    public function chartKelurahanGender($id)
    {
        $temp_data = DesaPenduduk::where('id', $id)->whereIn('idjenis', ['1','2'])->orderBy('idjenis', 'asc')->get();

        $chart = [
            'label'=>[],
            'data'=>[],
            'backgroundColor'=>[],
            'borderColor'=>[],
            'borderWidth'=>'1'
        ];

        foreach ($temp_data as $key => $value) {
            $color = rand(0, 255).','.rand(0, 255).','.rand(0, 255);
            array_push($chart['label'],$value->jenis->nama);
            array_push($chart['data'],$value->jumlah);
            array_push($chart['backgroundColor'],'rgba('.$color.', 0.4)');
            array_push($chart['borderColor'],'rgba('.$color.', 1)');
        }

        $data['chart'] = $chart;

        return response()->json($data);
    }
}
