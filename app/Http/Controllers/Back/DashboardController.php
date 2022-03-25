<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Konten\Content;
use App\Models\Refactored\Utils\UtilsDesa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        if(in_array(Auth::user()->idrole, ['1', '2', '3'])){
            return view('back.dashboard.master');
        }else if(in_array(Auth::user()->idrole, ['4'])){
            return view('back.dashboard.content');
        }else if(in_array(Auth::user()->idrole, ['5'])){
            return view('back.dashboard.camat');
        }
    }

    public function masterGetLokpri(){
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
    public function masterGetKecByProv(){
        $query = "SELECT p.name, COALESCE(a.jumlah, 0) jumlah_kecamatan FROM utils_provinsi p
                    LEFT JOIN (
                        SELECT COUNT(aa.id) AS jumlah, ac.provinsiid FROM utils_kecamatan aa
                        INNER JOIN utils_kota ac ON aa.kotaid = ac.id
                        LEFT JOIN kecamatan_detail ab ON aa.id = ab.id
                        WHERE aa.active = 1
                        AND ac.active = 1
                        GROUP BY ac.provinsiid
                    ) a ON a.provinsiid = p.id
                    WHERE p.active = 1";
        $res = DB::select(DB::raw($query));

        $data = [
            'label'=>[],
            'jumlah'=>[],
        ];

        foreach ($res as $key => $value) {
            array_push($data['label'], $value->name);
            array_push($data['jumlah'], $value->jumlah_kecamatan);
        }
        return response()->json([
            'data'=>$data,
        ]);
    }
    public function masterGetDesaByProv(){
        $query = "SELECT p.name, COALESCE(a.jumlah, 0) jumlah_desa FROM utils_provinsi p
        LEFT JOIN (
            SELECT COUNT(aa.id) AS jumlah, ac.provinsiid FROM utils_desa aa
            INNER JOIN utils_kecamatan ad ON ad.id = aa.kecamatanid
            INNER JOIN utils_kota ac ON ad.kotaid = ac.id
            LEFT JOIN kecamatan_detail ab ON aa.id = ab.id
            WHERE aa.active = 1
            AND ad.active = 1
            AND ac.active = 1
            GROUP BY ac.provinsiid
        ) a ON a.provinsiid = p.id
        WHERE p.active = 1";
        $res = DB::select(DB::raw($query));

        $data = [
            'label'=>[],
            'jumlah'=>[],
        ];

        foreach ($res as $key => $value) {
            array_push($data['label'], $value->name);
            array_push($data['jumlah'], $value->jumlah_desa);
        }
        return response()->json([
            'data'=>$data,
        ]);
    }
    public function masterGetTipe(){
        $query = "SELECT p.name, COALESCE(a.jumlah,0) AS tipe778, COALESCE(b.jumlah,0) AS tipe562, COALESCE(c.jumlah,0) AS tipe231 FROM utils_provinsi p
                LEFT JOIN(
                    SELECT COUNT(aa.id) AS jumlah, ac.id, ac.provinsiid FROM utils_kecamatan aa
                    INNER JOIN utils_kota ac ON aa.kotaid = ac.id
                    LEFT JOIN kecamatan_detail ab ON aa.id = ab.id
                    WHERE aa.active = 1 AND ab.typeid LIKE '%1%'
                    AND ac.active = 1
                    GROUP BY ac.provinsiid
                ) a ON a.provinsiid = p.id
                LEFT JOIN (
                    SELECT COUNT(aa.id) AS jumlah, ac.id, ac.provinsiid FROM utils_kecamatan aa
                    INNER JOIN utils_kota ac ON aa.kotaid = ac.id
                    LEFT JOIN kecamatan_detail ab ON aa.id = ab.id
                    WHERE aa.active = 1 AND ab.typeid LIKE '%2%'
                    AND ac.active = 1
                    GROUP BY ac.provinsiid
                ) b ON b.provinsiid = p.id
                LEFT JOIN (
                    SELECT COUNT(aa.id) AS jumlah, ac.id, ac.provinsiid FROM utils_kecamatan aa
                    INNER JOIN utils_kota ac ON aa.kotaid = ac.id
                    LEFT JOIN kecamatan_detail ab ON aa.id = ab.id
                    WHERE aa.active = 1 AND ab.typeid LIKE '%3%'
                    AND ac.active = 1
                    GROUP BY ac.provinsiid
                ) c ON c.provinsiid = p.id
                WHERE p.active = 1";
        $res = DB::select(DB::raw($query));

        $data = [
            'label'=>[],
            'tipe778'=>[],
            'tipe562'=>[],
            'tipe231'=>[],
        ];

        foreach ($res as $key => $value) {
            array_push($data['label'], $value->name);
            array_push($data['tipe778'], $value->tipe778);
            array_push($data['tipe562'], $value->tipe562);
            array_push($data['tipe231'], $value->tipe231);
        }
        return response()->json([
            'data'=>$data,
        ]);
    }
    public function camatPondes(){
        $idkecamatan = Auth::user()->kecamatan->idkecamatan;
        $query = "SELECT az.idjenis, az.keterangan, COALESCE(zz.jumlah_pondes, 0) AS jumlah FROM pondes_jenis az
                LEFT JOIN (
                    SELECT c.idjenis, COALESCE(SUM(jumlah), 0) AS jumlah_pondes, c.keterangan FROM pondes_jenis c
                    LEFT JOIN desa_pondes a ON a.jenis_pondes = c.idjenis
                    LEFT JOIN utils_desa b ON a.id = b.id
                    WHERE b.kecamatanid = $idkecamatan
                    GROUP BY jenis_pondes
                ) zz ON az.idjenis = zz.idjenis";
        $res = DB::select(DB::raw($query));

        $data = [
            'label'=>[],
            'pondes'=>[],
        ];

        foreach ($res as $key => $value) {
            array_push($data['label'], $value->keterangan);
            array_push($data['pondes'], $value->jumlah);
        }
        return response()->json([
            'data'=>$data,
        ]);
    }
    public function camatListDesa(){
        $idcamat = Auth::user()->kecamatan->idkecamatan;
     
        DB::statement(DB::raw('set @rownum=0'));
        $prov = UtilsDesa::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'kecamatanid',
            'name',
            'active'
        ])->where('active', '1')
        ->where('kecamatanid', $idcamat);

        if(!empty(request()->q)){
            $prov = $prov->where('name', 'like', '%'.request()->q.'%');
        }

        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->addColumn('kota', function(UtilsDesa $data){
                return $data->kecamatan->kota->name.', '.$data->kecamatan->kota->provinsi->name;
            })
            ->addColumn('kec', function(UtilsDesa $data){
                return $data->kecamatan->name;
            })
            ->addColumn('aksi', function(UtilsDesa $data){
                return '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white btn-desa-detail" data-id="'.$data['id'].'">Detail</button>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
   
    }
    public function contentListBerita(){
        DB::statement(DB::raw('set @rownum=0'));
        $dokumen = Content::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'idcontent',
            'judul',
            'created_at',
            'status',
            'idkategori',
            'idauthor'
        ])->where('status', 1);

        $dokumen = $dokumen->get();

        return \Yajra\DataTables\Facades\DataTables::of($dokumen)
            ->editColumn('created_at', function(Content $data){
                return Carbon::parse($data['created_at'])->locale('id')->translatedFormat('d M Y @ H:i:s');
            })
            ->editColumn('status', function(Content $data){
                return ($data->status == 1)? 'Sudah Publis':'Draft';
            })
            ->addColumn('penulis', function(Content $data){
                return $data->author->username;
            })
            ->addColumn('kategori', function(Content $data){
                return $data->kategori->nama;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
