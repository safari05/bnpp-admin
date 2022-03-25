<?php

namespace App\Http\Controllers\Back\Desa;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Desa\DesaDetail;
use App\Models\Refactored\Desa\DesaPenduduk;
use App\Models\Refactored\Master\PendudukJenis;
use App\Models\Refactored\Utils\UtilsDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DesaPendudukController extends Controller
{
    public function detail($id){
        $data['desa'] = $desa = UtilsDesa::where('id', $id)->first();
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == @$desa->kecamatanid) {
            return view('back.desa.civil.desa-civil', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
        }
    }

    public function dataDetail($id){
        $data = DesaDetail::where('id', $id)->first();
        $age = DesaPenduduk::where('id', $id)->whereIn('idjenis', ['1', '2'])->orderBy('idjenis', 'asc')->get();
        $query = "SELECT COALESCE(SUM(jumlah),0) AS jumlah FROM desa_penduduk
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
        $prov = DesaPenduduk::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'idjenis',
            'jumlah',
        ])
        ->whereNotIn('idjenis', ['1','2'])
        ->where('id', $id);

        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->editColumn('jumlah', function(DesaPenduduk $data){
                return number_format($data['jumlah'], 0, ',', '.').' Orang';
            })
            ->addColumn('ket', function(DesaPenduduk $data){
                return $data->jenis->nama;
            })
            ->addColumn('aksi', function(DesaPenduduk $data){
                $aksi = '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white btn-edit-sipil" data-id="'.$data['idjenis'].'">Edit</button>';
                return $aksi;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function chartUmur($id){
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

    public function chartGender($id){
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

    public function createDetail($id){
        $data['desa'] = $desa = UtilsDesa::where('id', $id)->first();
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == @$desa->kecamatanid) {
            $data['mode'] = 'atur';
            $data['detail'] = DesaDetail::where('id', $id)->first();
            $gender = DesaPenduduk::where('id', $id)->whereIn('idjenis', ['1','2'])->orderBy('idjenis', 'asc')->get();
            $data['sipil'] = [
                'pria'=>@$gender[0]->jumlah ?? 0,
                'wanita'=>@$gender[1]->jumlah ?? 0,
            ];
            $age = DesaPenduduk::where('id', $id)->whereIn('idjenis', ['1', '2'])->orderBy('idjenis', 'asc')->get();
            $query = "SELECT COALESCE(SUM(jumlah),0) AS jumlah FROM desa_penduduk
                        WHERE id = '$id'
                            AND idjenis NOT IN (1,2)";
            $data['total'] = DB::select($query)[0]->jumlah;
            return view('back.desa.civil.create-detail', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
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
            'id'=>'Desa',
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

            $exist_detail = count(DesaDetail::where('id', $input['id'])->get()->toArray()) > 0;
            $exist_pria = count(DesaPenduduk::where([['id', $input['id']], ['idjenis', 1]])->get()->toArray()) > 0;
            $exist_wanita = count(DesaPenduduk::where([['id', $input['id']], ['idjenis', 2]])->get()->toArray()) > 0;

            DB::beginTransaction();
            try {
                if($exist_detail){
                    DB::table('desa_detail')->where('id', $input['id'])->update([
                        // 'jumlah_penduduk'=>$input['jumlah'],
                        'jumlah_kk'=>$input['kk'],
                    ]);
                }else{
                    DB::table('desa_detail')->insert($data_detail);
                }

                if($exist_pria){
                    DB::table('desa_penduduk')->where([['id', $input['id']], ['idjenis', 1]])->update([
                        'jumlah'=>$input['pria']
                    ]);
                }else{
                    DB::table('desa_penduduk')->insert($data_sipil[0]);
                }

                if($exist_wanita){
                    DB::table('desa_penduduk')->where([['id', $input['id']], ['idjenis', 2]])->update([
                        'jumlah'=>$input['wanita']
                    ]);
                }else{
                    DB::table('desa_penduduk')->insert($data_sipil[1]);
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
                    'msg'=>'Berhasil menyimpan detail Penduduk Desa',
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menyimpan detail Penduduk Desa',
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
        $data['desa'] = $desa = UtilsDesa::where('id', $id)->first();
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == @$desa->kecamatanid) {
            $data['mode'] = 'add';
            $data['ages'] = PendudukJenis::whereNotIn('idjenis', ['1','2'])->orderBy('idjenis', 'asc')->get();
            return view('back.desa.civil.create-ages', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
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
            'id'=>'Desa',
            'idjenis'=>'Kategori Umur',
            'jumlah'=>'Jumlah Penduduk',
        ]);

        if(!$valid->fails()){
            $data_sipil = [
                'id'=>$input['id'],
                'idjenis'=>$input['idjenis'],
                'jumlah'=>$input['jumlah']
            ];

            $data_exist = DesaPenduduk::where([['id', $input['id']], ['idjenis', $input['idjenis']]])->first();

            DB::beginTransaction();
            try {
                if(!empty($data_exist)){
                    DB::table('desa_penduduk')->where([['id', $input['id']], ['idjenis', $input['idjenis']]])->update([
                        'jumlah'=>($input['jumlah']+$data_exist->jumlah)
                    ]);
                }else{
                    DB::table('desa_penduduk')->insert($data_sipil);
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
                    'msg'=>'Berhasil menyimpan data Penduduk Desa',
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menyimpan data Penduduk Desa',
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
        $data['desa'] = $desa = UtilsDesa::where('id', $id)->first();
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == @$desa->kecamatanid) {
            $data['mode'] = 'edit';
            $data['ages'] = PendudukJenis::where('idjenis', $idjenis)->orderBy('idjenis', 'asc')->get();
            $data['penduduk'] = DesaPenduduk::where([['id', $id],['idjenis', $idjenis]])->first();
            return view('back.desa.civil.create-ages', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
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
            'id'=>'Desa',
            'idjenis'=>'Kategori Umur',
            'jumlah'=>'Jumlah Penduduk',
        ]);

        if(!$valid->fails()){
            DB::beginTransaction();
            try {
                DB::table('desa_penduduk')->where([['id', $input['id']], ['idjenis', $input['idjenis']]])->update([
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
                    'msg'=>'Berhasil mengupdate data Penduduk Desa',
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengupdate data Penduduk Desa',
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
