<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan\Kecamatan;
use App\Models\Refactored\Kecamatan\KecamatanPenduduk;
use App\Models\Refactored\Master\PendudukJenis;
use App\Models\Refactored\Utils\UtilsKecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataKecamatanController extends Controller
{
    public function index(){
        return view('front.infra.data.kecamatan');
    }

    public function list(){
        DB::statement(DB::raw('set @rownum=0'));
        $prov = UtilsKecamatan::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'kotaid',
            'name',
            'active',
        ])
        ->where('active', 1)
        ->whereHas('kota', function($q){
            $q->where('active', 1)->whereHas('provinsi', function($r){
                $r->where('active', 1);
            });
        });

        if(!empty(request()->q)){
            $prov = $prov->where('name', 'like', '%'.request()->q.'%');
        }

        if(!empty(request()->prov)){
            $id = request()->prov;
            $prov = $prov->whereHas('kota', function($q) use($id){
                $q->where('provinsiid', $id);
            });
        }else{
            $prov = $prov->where('kotaid', 'like', '11%');
        }

        if(!empty(request()->kota)){
            $prov = $prov->where('kotaid', request()->kota);
        }

        if(!empty(request()->tipe)){
            $tipe = request()->tipe;
            $prov = $prov->whereHas('detail', function($q) use($tipe){
                $q->where('typeid', 'like', '%'.$tipe.'%');
            });
        }

        if(!empty(request()->lokpri)){
            $lokpri = request()->lokpri;
            $prov = $prov->whereHas('detail', function($q) use($lokpri){
                $q->where('lokpriid', 'like', '%'.$lokpri.'%');
            });
        }

        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->addColumn('provinsi', function(UtilsKecamatan $data){
                return @$data->kota->provinsi->name;
            })
            ->addColumn('kota', function(UtilsKecamatan $data){
                return @$data->kota->name;
            })
            ->addColumn('aksi', function(UtilsKecamatan $data){
                return '<button class="btn btn-sm btn-detail"'.
                            'data-kec="'.$data['id'].'"'.
                            '">Detail</button>';
            })
            ->addIndexColumn()
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function detail(){
        define('kec', request()->kec);

        if(!empty(kec)){
            $kecamatan = UtilsKecamatan::where('active', 1)
                                    ->where('id', kec)
                                    ->first();

            if(!empty($kecamatan)){
                $data['data'] = $kecamatan;
                $age = KecamatanPenduduk::where('id', kec)->whereIn('idjenis', ['1', '2'])->orderBy('idjenis', 'asc')->get();
                $query = "SELECT COALESCE(SUM(jumlah),0) AS jumlah FROM kecamatan_penduduk
                            WHERE id = '".kec."'
                                AND idjenis NOT IN (1,2)";
                $total = DB::select($query)[0];
                $data['total'] = $total->jumlah??'-';
                $data['kk'] = $kecamatan->detail->jumlah_kk??'-';
                $data['pria'] = $age[0]->jumlah??'-';
                $data['wanita'] = $age[1]->jumlah??'-';

                $data['penduduk'] = [];
                $pend = KecamatanPenduduk::where('id', kec)->whereNotIn('idjenis', ['1', '2'])->get();
                $jenispend = PendudukJenis::whereNotIn('idjenis', ['1', '2'])->get();
                foreach ($jenispend as $key => $value) {
                    array_push($data['penduduk'], [
                        'ket'=>$value->nama,
                        'jumlah'=>0,
                    ]);
                    foreach ($pend as $kuy => $valey) {
                        if($value->idjenis == $valey->idjenis){
                            $data['penduduk'][count($data['penduduk']) - 1] = [
                                'ket'=>$value->nama,
                                'jumlah'=>$valey->jumlah,
                            ];
                        }
                    }
                }

                $data['kepeg_asn'] = $this->getASN(kec);
                $data['kepeg_opr'] = $this->getOperasional(kec);
                $data['kepeg_leb'] = $this->getLembaga(kec);

                return view('front.infra.data.kecamatan-detail', $data);
            }else{
                return back()->with('error', 'Kecamatan tidak ditemukan');
            }
        }else{
            return back()->with('error', 'Kecamatan tidak ditemukan');
        }
    }

    private function getASN($id){
        $query =    "SELECT a.id, COALESCE(SUM(a.jumlah),0) AS asn, COALESCE(SUM(b.jumlah),0) AS non FROM (
            SELECT * FROM kecamatan_kepegawaian
            WHERE jenis_asn = 1
        ) a
        LEFT JOIN
        (
            SELECT * FROM kecamatan_kepegawaian
            WHERE jenis_asn = 2
        ) b ON a.id = b.id AND a.operasional = b.operasional AND a.kelembagaan = b.kelembagaan
        WHERE a.id = '$id'";

        $kepeg = DB::select($query)[0];

        return $kepeg;
    }

    private function getOperasional($id){
        $query = "  SELECT b.keterangan, COALESCE(SUM(jumlah)) AS jumlah FROM kecamatan_kepegawaian a
                    INNER JOIN kepegawaian_operasional b ON a.operasional = b.idoperasional
                    WHERE id = '$id'
                    GROUP BY operasional";

        $kepeg = DB::select($query);

        return $kepeg;
    }

    private function getLembaga($id){
        $query = "  SELECT b.keterangan, COALESCE(SUM(jumlah)) AS jumlah FROM kecamatan_kepegawaian a
                    INNER JOIN kepegawaian_operasional b ON a.operasional = b.idoperasional
                    WHERE id = '$id'
                    GROUP BY kelembagaan";

        $kepeg = DB::select($query);

        return $kepeg;
    }

    public function chart(){
        define('prov', request()->prov);
        define('kota', request()->kota);
        define('kec', request()->kec);

        if(!empty(prov) && !empty(kota) && !empty(kec)){
            $kecamatan = Kecamatan::where('active', 1)
                                    ->where([['provinsiID', prov], ['kabupatenkotaID', kota], ['id', kec]])
                                    ->first();

            if(!empty($kecamatan)){
                $data['data'] = $kecamatan;
                $data['chart_umur'] = json_encode([
                    [
                        'label'=>'0 - 5 Tahun',
                        'data'=>$kecamatan->adm_jumlah_penduduk_u0,
                        'bg'=>'rgba(255, 99, 132, 0.2)',
                        'border'=>'rgba(255, 99, 132, 1)',
                    ],
                    [
                        'label'=>'5 - 10 Tahun',
                        'data'=>$kecamatan->adm_jumlah_penduduk_u5,
                        'bg'=>'rgba(120, 99, 132, 0.2)',
                        'border'=>'rgba(120, 99, 132, 1)',
                    ],
                    [
                        'label'=>'10 - 15 Tahun',
                        'data'=>$kecamatan->adm_jumlah_penduduk_u10,
                        'bg'=>'rgba(255, 40, 132, 0.2)',
                        'border'=>'rgba(255, 40, 132, 1)',
                    ],
                    [
                        'label'=>'15 - 20 Tahun',
                        'data'=>$kecamatan->adm_jumlah_penduduk_u15,
                        'bg'=>'rgba(99, 56, 132, 0.2)',
                        'border'=>'rgba(99, 56, 132, 1)',
                    ],
                    [
                        'label'=>'20 - 25 Tahun',
                        'data'=>$kecamatan->adm_jumlah_penduduk_u20,
                        'bg'=>'rgba(90, 99, 180, 0.2)',
                        'border'=>'rgba(90, 99, 180, 1)',
                    ],
                    [
                        'label'=>'25 - 30 Tahun',
                        'data'=>$kecamatan->adm_jumlah_penduduk_u25,
                        'bg'=>'rgba(80, 99, 55, 0.2)',
                        'border'=>'rgba(80, 99, 55, 1)',
                    ],
                    [
                        'label'=>'30 - 35 Tahun',
                        'data'=>$kecamatan->adm_jumlah_penduduk_u30,
                        'bg'=>'rgba(255, 99, 25, 0.2)',
                        'border'=>'rgba(255, 99, 25, 1)',
                    ],
                    [
                        'label'=>'35 - 40 Tahun',
                        'data'=>$kecamatan->adm_jumlah_penduduk_u35,
                        'bg'=>'rgba(15, 99, 132, 0.2)',
                        'border'=>'rgba(15, 99, 132, 1)',
                    ],
                    [
                        'label'=>'40 - 45 Tahun',
                        'data'=>$kecamatan->adm_jumlah_penduduk_u40,
                        'bg'=>'rgba(80, 99, 120, 0.2)',
                        'border'=>'rgba(80, 99, 120, 1)',
                    ],
                    [
                        'label'=>'45 - 50 Tahun',
                        'data'=>$kecamatan->adm_jumlah_penduduk_u45,
                        'bg'=>'rgba(80, 99, 132, 0.2)',
                        'border'=>'rgba(80, 99, 132, 1)',
                    ],
                    [
                        'label'=>'50 - 55 Tahun',
                        'data'=>$kecamatan->adm_jumlah_penduduk_u50,
                        'bg'=>'rgba(255, 99, 255, 0.2)',
                        'border'=>'rgba(255, 99, 255, 1)',
                    ],
                    [
                        'label'=>'55 - 60 Tahun',
                        'data'=>$kecamatan->adm_jumlah_penduduk_u55,
                        'bg'=>'rgba(255, 99, 132, 0.2)',
                        'border'=>'rgba(255, 99, 132, 1)',
                    ],
                    [
                        'label'=>'60 - 65 Tahun',
                        'data'=>$kecamatan->adm_jumlah_penduduk_u60,
                        'bg'=>'rgba(99, 255, 132, 0.2)',
                        'border'=>'rgba(99, 255, 132, 1)',
                    ],
                    [
                        'label'=>'65 - 70 Tahun',
                        'data'=>$kecamatan->adm_jumlah_penduduk_u65,
                        'bg'=>'rgba(99, 99, 132, 0.2)',
                        'border'=>'rgba(99, 99, 132, 1)',
                    ],
                    [
                        'label'=>'70 - 75 Tahun',
                        'data'=>$kecamatan->adm_jumlah_penduduk_u70,
                        'bg'=>'rgba(132, 99, 132, 0.2)',
                        'border'=>'rgba(132, 99, 132, 1)',
                    ],
                    [
                        'label'=>'> 75 Tahun',
                        'data'=>$kecamatan->adm_jumlah_penduduk_u75,
                        'bg'=>'rgba(99, 255, 132, 0.2)',
                        'border'=>'rgba(99, 255, 132, 1)',
                    ],
                ]);
                return view('front.infra.data.kecamatan-chart', $data);
            }else{
                return back()->with('error', 'Kecamatan tidak ditemukan');
            }
        }else{
            return back()->with('error', 'Kecamatan tidak ditemukan');
        }
    }

    public function map(){
        return view('front.infra.peta.map');
    }


}
