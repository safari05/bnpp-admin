<?php

namespace App\Http\Controllers\Back\Desa;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Desa\DesaPondes;
use App\Models\Refactored\Master\PondesJenis;
use App\Models\Refactored\Utils\UtilsDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DesaPondesController extends Controller
{
    public function detail($id){
        $data['desa'] = $desa = UtilsDesa::where('id', $id)->first();
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == @$desa->kecamatanid) {
            return view('back.desa.pondes.desa-pondes', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
        }
    }

    public function srcAutocomplete(){
        $data = PondesJenis::get()->pluck('keterangan')->toArray();
        return response()->json($data);
    }

    public function listPondes($id){
        DB::statement(DB::raw('set @rownum=0'));
        $prov = DesaPondes::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'jenis_pondes',
            'jumlah',
        ])
        ->where('id', $id);

        if(!empty(request()->q)){
            $nama = request()->q;
            $prov = $prov->whereHas('pondes', function($q) use($nama){
                $q->where('keterangan', 'like', $nama);
            });
        }

        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->addColumn('nama', function(DesaPondes $data){
                return $data->jenis->keterangan;
            })
            ->editColumn('jumlah', function(DesaPondes $data){
                return number_format($data->jumlah, 0, ',', '.');
            })
            ->addColumn('aksi', function(DesaPondes $data){
                $aksi = '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white btn-edit-pondes" data-id="'.$data['jenis_pondes'].'">Edit</button>';
                return $aksi;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function chartPondes($id){
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

    public function create($id){
        $data['desa'] = $desa = UtilsDesa::where('id', $id)->first();
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == @$desa->kecamatanid) {
            $data['mode'] = 'add';
            return view('back.desa.pondes.create-pondes', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
        }
    }

    private function getLastIdItem(){
        $last = PondesJenis::max('idjenis');
        return !empty($last)? $last+1:1;
    }

    public function store(Request $request){
        $input = $request->all();

        $valid = Validator::make($input,
        [
            'id'=>'required',
            'nama'=>'required',
            'jumlah'=>'required',
        ],
        [
            'required'=>':attribute harus diisi!',
        ],
        [
            'id'=>'Desa',
            'nama'=>'Nama Potensi Desa',
            'jumlah'=>'Jumlah Potensi Desa',
        ]);

        if(!$valid->fails()){
            $exist = PondesJenis::where('keterangan', $input['nama'])->first();
            $data_master = [
                'idjenis'=>@$exist->idjenis
            ];

            if(empty($exist)){
                $idjenis = $this->getLastIdItem();
                $data_master = [
                    'idjenis'=>$idjenis,
                    'keterangan'=>$input['nama'],
                    'canDelete'=>'0',
                ];
            }

            $data_pondes = [
                'id'=>$input['id'],
                'jenis_pondes'=>$data_master['idjenis'],
                'jumlah'=>(int)$input['jumlah'],
            ];

            $pondes_exist = DesaPondes::where([['id', $input['id']], ['jenis_pondes', $data_master['idjenis']]])->first();

            if(!empty($pondes_exist)){
                $data_pondes['jumlah'] += (int)$pondes_exist['jumlah'];
            }

            DB::beginTransaction();
            try {
                if(empty($exist)){
                    DB::table('pondes_jenis')->where('jenis_pondes', $data_master['idjenis'])->update(['canDelete'=>'0']);
                    DB::table('aset_item')->insert($data_master);
                }

                if (empty($pondes_exist)) {
                    DB::table('desa_pondes')->insert($data_pondes);
                }else{
                    DB::table('desa_pondes')->where([['id', $input['id']], ['jenis_pondes', $data_master['idjenis']]])->update($data_pondes);
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
                    'msg'=>'Berhasil menambahkan Potensi Desa',
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menambahkan Potensi Desa',
                ]);
            }

        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first()
            ]);
        }
    }

    public function edit($id, $idjenis){
        $data['desa'] = $desa = UtilsDesa::where('id', $id)->first();
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == @$desa->kecamatanid) {
            $pondes = DesaPondes::where([['id', $id], ['jenis_pondes', $idjenis]])->first();
            if(!empty($pondes)){
                $data['pondes'] = $pondes;
                $data['mode'] = 'edit';
                return view('back.desa.pondes.create-pondes', $data);
            }else{
                return back()->with('error', 'Potensi Desa Desa tidak ditemukan');
            }
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
        }
    }

    public function update(Request $request){
        $input = $request->all();

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
            'idjenis'=>'Potensi Desa',
            'jumlah'=>'Jumlah'
        ]);

        if(!$valid->fails()){
            $data_pondes = [
                'jumlah'=>(int)$input['jumlah'],
            ];

            DB::beginTransaction();
            try {
                DB::table('desa_pondes')->where([['id', $input['id']], ['jenis_pondes', $input['idjenis']]])->update($data_pondes);
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
                    'msg'=>'Berhasil mengupdate Potensi Desa',
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengupdate Potensi Desa',
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
