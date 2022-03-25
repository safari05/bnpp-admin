<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Dokumen\Dokumen;
use App\Models\Refactored\Kecamatan\KecamatanDetail;
use App\Models\Refactored\Konten\Content;
use App\Models\Refactored\Utils\UtilsDesa;
use App\Models\Refactored\Utils\UtilsKecamatan;
use App\Models\Refactored\Utils\UtilsKota;
use App\Models\Refactored\Utils\UtilsProvinsi;
use Illuminate\Support\Facades\DB;

class BerandaController extends Controller
{
    public function index(){
        $data['berita'] = Content::where('status', 1)->orderBy('idcontent', 'desc')->limit(5)->get();
        $data['kecamatan'] = UtilsKecamatan::where('active', 1)->whereHas('detail.camat', function($q){
            $q->whereNotNull('foto_kantor');
        })->inRandomOrder()->limit(10)->get();
        if($data['kecamatan']->count() == 0){
            $data['kecamatan'] = UtilsKecamatan::where('active', 1)->inRandomOrder()->limit(10)->get();
        }
        $data['desa'] = UtilsDesa::where('active', 1)->whereHas('detail.kades', function($q){
            $q->whereNotNull('foto_kantor');
        })->inRandomOrder()->limit(10)->get();
        if($data['desa']->count() == 0){
            $data['desa'] = UtilsDesa::where('active', 1)->inRandomOrder()->limit(10)->get();
        }
        $data['dokumen'] = Dokumen::where('ispublic', 1)->orderBy('id', 'desc')->limit(3)->get();
        $data['fileExt'] = [
            'pdf' => 'pdf',
            'xls' => 'excel',
            'xlsx' => 'excel',
            'doc' => 'word',
            'docx' => 'word',
            'ppt' => 'powerpoint',
            'pptx' => 'powerpoint',
            'jpg' => 'image',
            'jpeg' => 'image',
            'png' => 'image',
            'mp4' => 'video'
        ];


        $data['count']['lokpri'] = KecamatanDetail::where('lokpriid', 'like', '1%')->count();
        $data['count']['desa'] = UtilsDesa::where('active', 1)->count();
        $data['count']['kecamatan'] = UtilsKecamatan::where('active', 1)->count();
        $data['count']['kota'] = UtilsKota::where('active', 1)->count();
        $data['count']['provinsi'] = UtilsProvinsi::where('active', 1)->count();

        return view('front.beranda.index', $data);
    }

    public function getGrafik(){
        $query = "SELECT p.name, COALESCE(a.jumlah,0) AS lokpri, COALESCE(b.jumlah,0) AS pksn, COALESCE(c.jumlah,0) AS ppkt FROM utils_provinsi p
                    LEFT JOIN(
                        SELECT COUNT(aa.id) AS jumlah, ac.id, ac.provinsiid FROM utils_kecamatan aa
                        INNER JOIN utils_kota ac ON aa.kotaid = ac.id
                        LEFT JOIN kecamatan_detail ab ON aa.id = ab.id
                        WHERE aa.active = 1 AND ab.lokpriid LIKE '%1%'
                        AND ac.active = 1
                        GROUP BY ac.provinsiid
                    ) a ON a.provinsiid = p.id
                    LEFT JOIN (
                        SELECT COUNT(aa.id) AS jumlah, ac.id, ac.provinsiid FROM utils_kecamatan aa
                        INNER JOIN utils_kota ac ON aa.kotaid = ac.id
                        LEFT JOIN kecamatan_detail ab ON aa.id = ab.id
                        WHERE aa.active = 1 AND ab.lokpriid LIKE '%2%'
                        AND ac.active = 1
                        GROUP BY ac.provinsiid
                    ) b ON b.provinsiid = p.id
                    LEFT JOIN (
                        SELECT COUNT(aa.id) AS jumlah, ac.id, ac.provinsiid FROM utils_kecamatan aa
                        INNER JOIN utils_kota ac ON aa.kotaid = ac.id
                        LEFT JOIN kecamatan_detail ab ON aa.id = ab.id
                        WHERE aa.active = 1 AND ab.lokpriid LIKE '%3%'
                        AND ac.active = 1
                        GROUP BY ac.provinsiid
                    ) c ON c.provinsiid = p.id
                    WHERE p.active = 1";
        $res = DB::select(DB::raw($query));

        $data = [
            'label'=>[],
            'lokpri'=>[],
            'pksn'=>[],
            'ppkt'=>[],
        ];

        foreach ($res as $key => $value) {
            array_push($data['label'], $value->name);
            array_push($data['lokpri'], $value->lokpri);
            array_push($data['pksn'], $value->pksn);
            array_push($data['ppkt'], $value->ppkt);
        }
        return response()->json([
            'data'=>$data,
        ]);
    }
}
