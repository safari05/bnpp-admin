<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InfrastrukturGrafikKepegawaianController extends Controller
{
    public function chartKecamatan($id)
    {
        $query =    "SELECT z.id, d.keterangan AS operasional, c.keterangan AS lembaga, COALESCE(a.jumlah,0) AS asn, COALESCE(b.jumlah,0) AS non FROM kecamatan_kepegawaian z
                        LEFT JOIN
                        (
                            SELECT * FROM kecamatan_kepegawaian
                            WHERE jenis_asn = 1
                        ) a ON z.id = a.id AND a.operasional = z.operasional AND a.kelembagaan = z.kelembagaan
                        LEFT JOIN
                        (
                            SELECT * FROM kecamatan_kepegawaian
                            WHERE jenis_asn = 2
                        ) b ON z.id = b.id AND z.operasional = b.operasional AND z.kelembagaan = b.kelembagaan
                        INNER JOIN kepegawaian_kelembagaan c ON z.kelembagaan = c.idkelembagaan
                        INNER JOIN kepegawaian_operasional d ON z.operasional = d.idoperasional
                        WHERE z.id = '$id'";
        $kepeg = DB::select($query);

        $data['warna_asn'] = 'rgba(143, 247, 45, 0.4)';
        $data['border_asn'] = 'rgba(143, 247, 45, 1)';
        $data['warna_non'] = 'rgba(252, 198, 3, 0.4)';
        $data['border_non'] = 'rgba(252, 198, 3, 1)';

        $chart = [
            'label'=>[],
            'asn'=>[],
            'non'=>[],
        ];
        foreach ($kepeg as $key => $value) {
            array_push($chart['label'], $value->operasional.' ('.strtoupper($this->SKU_gen(strtolower($value->lembaga), 3)).')');
            array_push($chart['asn'], $value->asn);
            array_push($chart['non'], $value->non);
        }

        $data['chart'] = $chart;

        return response()->json($data);
    }

    public function chartKecamatanAsn($id)
    {
        $query =    "SELECT c.id, COALESCE(SUM(a.jumlah),0) AS asn, COALESCE(SUM(b.jumlah),0) AS non FROM kecamatan_kepegawaian c
                        LEFT JOIN
                        (
                            SELECT * FROM kecamatan_kepegawaian
                            WHERE jenis_asn = 1
                        ) a ON a.id = c.id AND c.operasional = a.operasional AND c.kelembagaan = a.kelembagaan
                        LEFT JOIN
                        (
                            SELECT * FROM kecamatan_kepegawaian
                            WHERE jenis_asn = 2
                        ) b ON c.id = b.id AND c.operasional = b.operasional AND c.kelembagaan = b.kelembagaan
                        WHERE c.id = '$id'";

        $kepeg = DB::select($query)[0];

        $chart = [
            [
                'label'=>'ASN',
                'data'=>$kepeg->asn,
                'backgroundColor'=>'rgba(143, 247, 45, 0.4)',
                'borderColor'=>'rgba(143, 247, 45, 1)',
                'borderWidth'=>'1'
            ],
            [
                'label'=> 'NON ASN',
                'data'=>$kepeg->non,
                'backgroundColor'=>'rgba(252, 198, 3, 0.4)',
                'borderColor'=>'rgba(252, 198, 3, 1)',
                'borderWidth'=>'1'
            ]
        ];

        $data['data'] = $chart;

        return response()->json($data);
    }

    public function chartKecamatanLembaga($id)
    {
        $query =    "SELECT a.id, c.keterangan AS lembaga, COALESCE(SUM(a.jumlah),0) AS jumlah FROM kecamatan_kepegawaian a
                        INNER JOIN kepegawaian_kelembagaan c ON a.kelembagaan = c.idkelembagaan
                        WHERE a.id = '$id'
                        GROUP BY a.kelembagaan";

        $kepeg = DB::select($query);

        $chart = [];
        foreach ($kepeg as $key => $value) {
            $color = rand(0, 255).','.rand(0, 255).','.rand(0, 255);
            $temp = [
                'label'=>$value->lembaga,
                'data'=>$value->jumlah,
                'backgroundColor'=>'rgba('.$color.', 0.4)',
                'borderColor'=>'rgba('.$color.', 1)',
                'borderWidth'=>'1'
            ];
            array_push($chart, $temp);
        }

        $data['data'] = $chart;

        return response()->json($data);
    }

    public function chartKelurahan($id)
    {
        $query =    "SELECT z.id, d.keterangan AS operasional, c.keterangan AS lembaga, COALESCE(a.jumlah,0) AS asn, COALESCE(b.jumlah,0) AS non FROM desa_kepegawaian z
                    LEFT JOIN
                    (
                        SELECT * FROM desa_kepegawaian
                        WHERE jenis_asn = 1
                    ) a ON z.id = a.id AND a.operasional = z.operasional AND a.kelembagaan = z.kelembagaan
                    LEFT JOIN
                    (
                        SELECT * FROM desa_kepegawaian
                        WHERE jenis_asn = 2
                    ) b ON z.id = b.id AND z.operasional = b.operasional AND z.kelembagaan = b.kelembagaan
                    INNER JOIN kepegawaian_kelembagaan c ON z.kelembagaan = c.idkelembagaan
                    INNER JOIN kepegawaian_operasional d ON z.operasional = d.idoperasional
                    WHERE z.id = '$id'";
        $kepeg = DB::select($query);

        $data['warna_asn'] = 'rgba(143, 247, 45, 0.4)';
        $data['border_asn'] = 'rgba(143, 247, 45, 1)';
        $data['warna_non'] = 'rgba(252, 198, 3, 0.4)';
        $data['border_non'] = 'rgba(252, 198, 3, 1)';

        $chart = [
            'label'=>[],
            'asn'=>[],
            'non'=>[],
        ];
        foreach ($kepeg as $key => $value) {
            array_push($chart['label'], $value->operasional.' ('.strtoupper($this->SKU_gen(strtolower($value->lembaga), 3)).')');
            array_push($chart['asn'], $value->asn);
            array_push($chart['non'], $value->non);
        }

        $data['chart'] = $chart;

        return response()->json($data);
    }

    public function chartKelurahanAsn($id)
    {
        $query =    "SELECT c.id, COALESCE(SUM(a.jumlah),0) AS asn, COALESCE(SUM(b.jumlah),0) AS non FROM desa_kepegawaian c
                    LEFT JOIN
                    (
                        SELECT * FROM desa_kepegawaian
                        WHERE jenis_asn = 1
                    ) a ON a.id = c.id AND c.operasional = a.operasional AND c.kelembagaan = a.kelembagaan
                    LEFT JOIN
                    (
                        SELECT * FROM desa_kepegawaian
                        WHERE jenis_asn = 2
                    ) b ON c.id = b.id AND c.operasional = b.operasional AND c.kelembagaan = b.kelembagaan
                    WHERE c.id = '$id'";

        $kepeg = DB::select($query)[0];

        $chart = [
            [
                'label'=>'ASN',
                'data'=>$kepeg->asn,
                'backgroundColor'=>'rgba(143, 247, 45, 0.4)',
                'borderColor'=>'rgba(143, 247, 45, 1)',
                'borderWidth'=>'1'
            ],
            [
                'label'=> 'NON ASN',
                'data'=>$kepeg->non,
                'backgroundColor'=>'rgba(252, 198, 3, 0.4)',
                'borderColor'=>'rgba(252, 198, 3, 1)',
                'borderWidth'=>'1'
            ]
        ];

        $data['data'] = $chart;

        return response()->json($data);
    }

    public function chartKelurahanLembaga($id)
    {
        $query =    "SELECT a.id, c.keterangan AS lembaga, COALESCE(SUM(a.jumlah),0) AS jumlah FROM desa_kepegawaian a
                    INNER JOIN kepegawaian_kelembagaan c ON a.kelembagaan = c.idkelembagaan
                    WHERE a.id = '$id'
                    GROUP BY a.kelembagaan";

        $kepeg = DB::select($query);

        $chart = [];
        foreach ($kepeg as $key => $value) {
            $color = rand(0, 255).','.rand(0, 255).','.rand(0, 255);
            $temp = [
                'label'=>$value->lembaga,
                'data'=>$value->jumlah,
                'backgroundColor'=>'rgba('.$color.', 0.4)',
                'borderColor'=>'rgba('.$color.', 1)',
                'borderWidth'=>'1'
            ];
            array_push($chart, $temp);
        }

        $data['data'] = $chart;

        return response()->json($data);
    }

    private function SKU_gen($string, $l = 2){
        $results = ''; // empty string
        $vowels = array('a', 'e', 'i', 'o', 'u', 'y'); // vowels
        preg_match_all('/[A-Z][a-z]*/', ucfirst($string), $m); // Match every word that begins with a capital letter, added ucfirst() in case there is no uppercase letter
        foreach($m[0] as $substring){
            $substring = str_replace($vowels, '', strtolower($substring)); // String to lower case and remove all vowels
            $results .= preg_replace('/([a-z]{'.$l.'})(.*)/', '$1', $substring); // Extract the first N letters.
        }
        return $results;
    }
}
