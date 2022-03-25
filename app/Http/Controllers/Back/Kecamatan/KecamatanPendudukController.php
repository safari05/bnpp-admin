<?php

namespace App\Http\Controllers\Back\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Kecamatan\KecamatanDetail;
use App\Models\Refactored\Kecamatan\KecamatanLokpri;
use App\Models\Refactored\Kecamatan\KecamatanPenduduk;
use App\Models\Refactored\Kecamatan\KecamatanType;
use App\Models\Refactored\Master\PendudukJenis;
use App\Models\Refactored\Utils\UtilsKecamatan;
use App\Traits\KecDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KecamatanPendudukController extends Controller
{
    use KecDetail;
    public function detail($id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $data['kec'] = UtilsKecamatan::where('id', $id)->first();

            $data['detail'] = $this->getDetailKecamatan($id);

            return view('back.kecamatan.civil.kec-civil', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut');
        }
    }

    public function dataDetail($id){
        $data = KecamatanDetail::where('id', $id)->first();
        $age = KecamatanPenduduk::where('id', $id)->whereIn('idjenis', ['1', '2'])->orderBy('idjenis', 'asc')->get();
        $query = "SELECT COALESCE(SUM(jumlah),0) AS jumlah FROM kecamatan_penduduk
                    WHERE id = '$id'
                        AND idjenis NOT IN (1,2)";
        $total = DB::select($query)[0];
        $ret = [
            'total'=>$total->jumlah??'-',
            'kk'=>$data['jumlah_kk']??'-',
            'pria'=>$age[0]->jumlah??'-',
            'wanita'=>$age[1]->jumlah??'-',
        ];

        return response()->json([
            'status'=>200,
            'data'=>$ret
        ]);
    }

    public function listSipil($id){
        DB::statement(DB::raw('set @rownum=0'));
        $prov = KecamatanPenduduk::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'idjenis',
            'jumlah',
        ])
        ->whereNotIn('idjenis', ['1','2']);

        if(Auth::user()->idrole != 5) $prov = $prov->where('id', $id);
        else $prov = $prov->where('id', @Auth::user()->kecamatan->idkecamatan);

        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->editColumn('jumlah', function(KecamatanPenduduk $data){
                return number_format($data['jumlah'], 0, ',', '.').' Orang';
            })
            ->addColumn('ket', function(KecamatanPenduduk $data){
                return $data->jenis->nama;
            })
            ->addColumn('aksi', function(KecamatanPenduduk $data){
                $aksi = '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white btn-edit-sipil" data-id="'.$data['idjenis'].'">Edit</button>';
                return $aksi;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function chartUmur($id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
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
    }

    public function chartGender($id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
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
    }

    public function createDetail($id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $kecamatan = UtilsKecamatan::where('id', $id)->first();
            $data['kec'] = $kecamatan;
            $data['mode'] = 'atur';
            $data['detail'] = KecamatanDetail::where('id', $id)->first();
            $gender = KecamatanPenduduk::where('id', $id)->whereIn('idjenis', ['1','2'])->orderBy('idjenis', 'asc')->get();
            $data['sipil'] = [
                'pria'=>@$gender[0]->jumlah ?? 0,
                'wanita'=>@$gender[1]->jumlah ?? 0,
            ];
            $age = KecamatanPenduduk::where('id', $id)->whereIn('idjenis', ['1', '2'])->orderBy('idjenis', 'asc')->get();
            $query = "SELECT COALESCE(SUM(jumlah),0) AS jumlah FROM kecamatan_penduduk
                        WHERE id = '$id'
                            AND idjenis NOT IN (1,2)";
            $data['total'] = DB::select($query)[0]->jumlah;
            return view('back.kecamatan.civil.create-detail', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut');
        }
    }

    public function storeDetail(Request $request){
        $input = $request->all();
        // dd($input);
        $valid = Validator::make($input,
        [
            'id'=>'required',
            // 'jumlah'=>'required',
            'kk'=>'required',
            'pria'=>'required',
            'wanita'=>'required'
        ],
        [
            'required'=>':attribute harus diisi!',
        ],
        [
            'id'=>'Kecamatan',
            // 'jumlah'=>'Jumlah Keseluruhan Penduduk',
            'kk'=>'Jumlah Kepala Keluarga',
            'pria'=>'Jumlah Penduduk Pria',
            'wanita'=>'Jumlah Penduduk Wanita',
        ]);

        if(!$valid->fails()){
            $data_detail = [
                'id'=>$input['id'],
                // 'jumlah_penduduk'=>$input['jumlah'],
                'jumlah_kk'=>$input['kk'],
            ];

            $data_sipil = [
                [
                    'id'=>$input['id'],
                    'idjenis'=>1,
                    'jumlah'=>$input['pria']
                ],
                [
                    'id'=>$input['id'],
                    'idjenis'=>2,
                    'jumlah'=>$input['wanita']
                ],
            ];

            $exist_detail = count(KecamatanDetail::where('id', $input['id'])->get()->toArray()) > 0;
            $exist_pria = count(KecamatanPenduduk::where([['id', $input['id']], ['idjenis', 1]])->get()->toArray()) > 0;
            $exist_wanita = count(KecamatanPenduduk::where([['id', $input['id']], ['idjenis', 2]])->get()->toArray()) > 0;

            DB::beginTransaction();
            try {
                if($exist_detail){
                    DB::table('kecamatan_detail')->where('id', $input['id'])->update([
                        // 'jumlah_penduduk'=>$input['jumlah'],
                        'jumlah_kk'=>$input['kk'],
                    ]);
                }else{
                    DB::table('kecamatan_detail')->insert($data_detail);
                }

                if($exist_pria){
                    DB::table('kecamatan_penduduk')->where([['id', $input['id']], ['idjenis', 1]])->update([
                        'jumlah'=>$input['pria']
                    ]);
                }else{
                    DB::table('kecamatan_penduduk')->insert($data_sipil[0]);
                }

                if($exist_wanita){
                    DB::table('kecamatan_penduduk')->where([['id', $input['id']], ['idjenis', 2]])->update([
                        'jumlah'=>$input['wanita']
                    ]);
                }else{
                    DB::table('kecamatan_penduduk')->insert($data_sipil[1]);
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
                    'msg'=>'Berhasil menyimpan detail Penduduk Kecamatan',
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menyimpan detail Penduduk Kecamatan',
                ]);
            }

        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first()
            ]);
        }
    }

    public function createSipilUmur($id){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $kecamatan = UtilsKecamatan::where('id', $id)->first();
            $data['kec'] = $kecamatan;
            $data['mode'] = 'add';
            $data['ages'] = PendudukJenis::whereNotIn('idjenis', ['1','2'])->orderBy('idjenis', 'asc')->get();
            return view('back.kecamatan.civil.create-ages', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut');
        }
    }

    public function storeUmur(Request $request){
        $input = $request->all();
        // dd($input);
        $valid = Validator::make($input,
        [
            'id'=>'required',
            'idjenis'=>'required',
            'jumlah'=>'required',
        ],
        [
            'required'=>':attribute harus diisi!',
        ],
        [
            'id'=>'Kecamatan',
            'idjenis'=>'Kategori Umur',
            'jumlah'=>'Jumlah Penduduk',
        ]);

        if(!$valid->fails()){
            $data_sipil = [
                'id'=>$input['id'],
                'idjenis'=>$input['idjenis'],
                'jumlah'=>$input['jumlah']
            ];

            $data_exist = KecamatanPenduduk::where([['id', $input['id']], ['idjenis', $input['idjenis']]])->first();

            DB::beginTransaction();
            try {
                if(!empty($data_exist)){
                    DB::table('kecamatan_penduduk')->where([['id', $input['id']], ['idjenis', $input['idjenis']]])->update([
                        'jumlah'=>($input['jumlah']+$data_exist->jumlah)
                    ]);
                }else{
                    DB::table('kecamatan_penduduk')->insert($data_sipil);
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
                    'msg'=>'Berhasil menyimpan data Penduduk Kecamatan',
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menyimpan data Penduduk Kecamatan',
                ]);
            }

        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first()
            ]);
        }
    }

    public function editUmur($id, $idjenis){
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == $id) {
            $kecamatan = UtilsKecamatan::where('id', $id)->first();
            $data['kec'] = $kecamatan;
            $data['mode'] = 'edit';
            $data['ages'] = PendudukJenis::where('idjenis', $idjenis)->orderBy('idjenis', 'asc')->get();
            $data['penduduk'] = KecamatanPenduduk::where([['id', $id],['idjenis', $idjenis]])->first();
            return view('back.kecamatan.civil.create-ages', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut');
        }
    }

    public function updateUmur(Request $request){
        $input = $request->all();
        // dd($input);
        $valid = Validator::make($input,
        [
            'id'=>'required',
            'idjenis'=>'required',
            'jumlah'=>'required',
        ],
        [
            'required'=>':attribute harus diisi!',
        ],
        [
            'id'=>'Kecamatan',
            'idjenis'=>'Kategori Umur',
            'jumlah'=>'Jumlah Penduduk',
        ]);

        if(!$valid->fails()){
            DB::beginTransaction();
            try {
                DB::table('kecamatan_penduduk')->where([['id', $input['id']], ['idjenis', $input['idjenis']]])->update([
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
                    'msg'=>'Berhasil mengupdate data Penduduk Kecamatan',
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengupdate data Penduduk Kecamatan',
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
