<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Desa\DesaPondes;

class InfrastrukturGrafikPondesController extends Controller
{
    public function chartKelurahan($id)
    {
        $pondes = DesaPondes::where('id', $id)->get();
        $chart = [];
        foreach ($pondes as $key => $value) {
            $color = rand(0, 255).','.rand(0, 255).','.rand(0, 255);
            $temp = [
                'label'=>''.$value->jenis->keterangan,
                'data'=>[''.$value->jumlah],
                'backgroundColor'=>['rgba('.$color.', 0.4)'],
                'borderColor'=>['rgba('.$color.', 1)'],
                'borderWidth'=>'1'
            ];
            array_push($chart, $temp);
        }

        $data['data'] = $chart;

        return response()->json($data);
    }
}
