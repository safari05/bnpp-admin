<?php

namespace App\Http\Controllers\Back\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Kecamatan\KecamatanDetail;
use App\Models\Refactored\Kecamatan\KecamatanKepegawaian;
use App\Models\Refactored\Kecamatan\KecamatanLokpri;
use App\Models\Refactored\Kecamatan\KecamatanType;
use App\Models\Refactored\Kepegawaian\KepegawaianJenisAsn;
use App\Models\Refactored\Kepegawaian\KepegawaianKelembagaan;
use App\Models\Refactored\Kepegawaian\KepegawaianOperasional;
use App\Models\Refactored\Utils\UtilsKecamatan;
use App\Traits\KecDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KecamatanKepegController extends Controller
{
    use KecDetail;

    public function detail($id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $kecamatan = UtilsKecamatan::where('id', $id)->first();
            $data['kec'] = $kecamatan;
            $data['detail'] = $this->getDetailKecamatan($id);
            return view('back.kecamatan.kepeg.kec-kepeg', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut');
        }
    }

    public function listKepeg($id){
        DB::statement(DB::raw('set @rownum=0'));
        $prov = KecamatanKepegawaian::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'jenis_asn',
            'operasional',
            'jumlah',
            'kelembagaan',
        ]);

        if(Auth::user()->idrole != 5) $prov = $prov->where('id', $id);
        else $prov = $prov->where('id', @Auth::user()->kecamatan->idkecamatan);

        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->editColumn('jenis_asn', function(KecamatanKepegawaian $data){
                if($data['jenis_asn'] == 1){
                    return '<span class="px-3 py-2 rounded-full bg-theme-9 text-white mr-1">ASN</span>';
                }else if($data['jenis_asn'] == 2){
                    return '<span class="px-3 py-2 rounded-full bg-theme-12 text-white mr-1">NON ASN</span>';
                }
            })
            ->addColumn('staf', function(KecamatanKepegawaian $data){
                return $data->staff_op->keterangan;
            })
            ->editColumn('lemb', function(KecamatanKepegawaian $data){
                return $data->lembaga->keterangan??'Tidak terikat lembaga';
            })
            ->editColumn('jumlah', function(KecamatanKepegawaian $data){
                return number_format($data['jumlah'], 0,',','.').' Orang';
            })
            ->addColumn('aksi', function(KecamatanKepegawaian $data){
                $series = $data['jenis_asn'].'-'.$data['operasional'].'-'.$data['kelembagaan'];
                $aksi = '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white btn-edit-kepeg" data-id="'.$series.'">Edit</button>';
                return $aksi;
            })
            ->rawColumns(['aksi', 'jenis_asn'])
            ->make(true);
    }

    public function chartPeg($id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
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
    }

    public function chartASN($id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
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
    }

    public function chartLembaga($id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
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

    public function create($id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $kecamatan = UtilsKecamatan::where('id', $id)->first();
            $data['kec'] = $kecamatan;
            $data['mode'] = 'add';
            $data['asn'] = KepegawaianJenisAsn::all();
            $data['oper'] = KepegawaianOperasional::all();
            $data['lembaga'] = KepegawaianKelembagaan::all();
            return view('back.kecamatan.kepeg.create-kepeg', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut');
        }
    }

    public function store(Request $request){
        $input = $request->all();
        // dd($input);
        $valid = Validator::make($input,
        [
            'id'=>'required',
            'asn'=>'required',
            'staf'=>'required',
            'lembaga'=>'required',
            'jumlah'=>'required'
        ],
        [
            'required'=>':attribute harus diisi!',
        ],
        [
            'id'=>'Kecamatan',
            'asn'=>'Jenis ASN',
            'staf'=>'Staf Operasional',
            'lembaga'=>'Kelembagaan',
            'jumlah'=>'Jumlah Pegawai',
        ]);

        if(!$valid->fails()){
            $data_kepeg = [
                'id'=>$input['id'],
                'jenis_asn'=>$input['asn'],
                'operasional'=>$input['staf'],
                'kelembagaan'=> $input['lembaga'],
                'jumlah'=>(int)$input['jumlah'],
            ];

            $kepeg_exist = KecamatanKepegawaian::where([
                ['id', $input['id']],
                ['jenis_asn', $input['asn']],
                ['operasional', $input['staf']],
                ['kelembagaan', $input['lembaga']]
            ])->first();

            if(!empty($kepeg_exist)){
                $data_kepeg['jumlah'] += (int)$kepeg_exist['jumlah'];
            }

            DB::beginTransaction();
            try {

                if (empty($kepeg_exist)) {
                    DB::table('kecamatan_kepegawaian')->insert($data_kepeg);
                }else{
                    DB::table('kecamatan_kepegawaian')->where([
                        ['id', $input['id']],
                        ['jenis_asn', $input['asn']],
                        ['operasional', $input['staf']],
                        ['kelembagaan', $input['lembaga']]
                    ])->update([
                        'jumlah'=>$data_kepeg['jumlah']
                    ]);
                }
                DB::commit();
                $oke = true;
            } catch (\Exception $e) {
                DB::rollback();
                $oke = false;
                dd($e);
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil menambahkan Pegawai Kecamatan',
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menambahkan Pegawai Kecamatan',
                ]);
            }

        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first()
            ]);
        }
    }

    public function edit($id, $series){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $asn = explode('-', $series)[0];
            $staf = explode('-', $series)[1];
            $lembaga = explode('-', $series)[2];

            $kepeg = KecamatanKepegawaian::where([
                ['id', $id],
                ['jenis_asn', $asn],
                ['operasional', $staf],
                ['kelembagaan', $lembaga]
            ])->first();

            if(!empty($kepeg)){
                $kecamatan = UtilsKecamatan::where('id', $id)->first();
                $data['kec'] = $kecamatan;
                $data['kepeg'] = $kepeg;
                $data['mode'] = 'edit';
                $data['series'] = $series;
                $data['asn'] = KepegawaianJenisAsn::all();
                $data['oper'] = KepegawaianOperasional::all();
                $data['lembaga'] = KepegawaianKelembagaan::all();

                return view('back.kecamatan.kepeg.create-kepeg', $data);
            }else{
                return back()->with('error', 'Kepegawaian tidak ditemukan');
            }
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut');
        }
    }

    public function update(Request $request){
        $input = $request->all();
        // dd($input);
        $valid = Validator::make($input,
        [
            'id'=>'required',
            'series'=>'required',
            'jumlah'=>'required'
        ],
        [
            'required'=>':attribute harus diisi!',
        ],
        [
            'id'=>'Kecamatan',
            'series'=>'Kepegawaian',
            'jumlah'=>'Jumlah Pegawai',
        ]);

        if(!$valid->fails()){
            $asn = explode('-', $input['series'])[0];
            $staf = explode('-', $input['series'])[1];
            $lembaga = explode('-', $input['series'])[2];

            DB::beginTransaction();
            try {
                DB::table('kecamatan_kepegawaian')->where([
                    ['id', $input['id']],
                    ['jenis_asn', $asn],
                    ['operasional', $staf],
                    ['kelembagaan', $lembaga]
                ])->update([
                    'jumlah'=>$input['jumlah']
                ]);
                DB::commit();
                $oke = true;
            } catch (\Exception $e) {
                DB::rollback();
                $oke = false;
                dd($e);
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil mengubah Jumlah Pegawai Kecamatan',
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengubah Jumlah Pegawai Kecamatan',
                ]);
            }

        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first()
            ]);
        }
    }
}
