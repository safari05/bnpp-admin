<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InfrastrukturGrafikPPKTController extends Controller
{
    public function chartKecamatan($id)
    {
        $query = "SELECT a.id, COALESCE(a.total, 0) AS berpenghuni, COALESCE(b.total, 0) AS tidak FROM (
                        SELECT id, COUNT(jenis) AS total, jenis FROM kecamatan_ppkt
                        WHERE jenis = 1
                    ) a
                    LEFT JOIN (
                        SELECT id, COUNT(jenis) AS total, jenis FROM kecamatan_ppkt
                        WHERE jenis = 2
                    ) b ON a.id = b.id
                    WHERE a.id = '$id'";

        $pulau = @DB::select($query)[0];

        $chart = [
            [
                'label'=>'Berpenghuni',
                'data'=>''.@$pulau->berpenghuni??0,
                'backgroundColor'=>'rgba(143, 247, 45, 0.4)',
                'borderColor'=>'rgba(143, 247, 45, 1)',
                'borderWidth'=>'1'
            ],
            [
                'label'=> 'Tidak Berpenguni',
                'data'=>''.@$pulau->tidak??0,
                'backgroundColor'=>'rgba(252, 198, 3, 0.4)',
                'borderColor'=>'rgba(252, 198, 3, 1)',
                'borderWidth'=>'1'
            ]
        ];

        $data['data'] = $chart;

        return response()->json($data);
    }
}
