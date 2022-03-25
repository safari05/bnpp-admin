<?php

namespace App\Http\Controllers\Back\Desa;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Desa\DesaAset;
use App\Models\Refactored\Master\AsetItem;
use App\Models\Refactored\Utils\UtilsDesa;
use App\Models\Refactored\Utils\UtilsProvinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DesaAsetController extends Controller
{
    public function detail($id){
        $data['desa'] = $desa = UtilsDesa::where('id', $id)->first();
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == @$desa->kecamatanid) {
            return view('back.desa.aset.desa-detail', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
        }
    }

    public function srcAutocomplete(){
        $data = AsetItem::get()->pluck('nama')->toArray();
        return response()->json($data);
    }

    public function listAset($id){
        DB::statement(DB::raw('set @rownum=0'));
        $prov = DesaAset::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'iditem',
            'jumlah_baik',
            'jumlah_rusak',
        ])
        ->where('id', $id);

        if(!empty(request()->q)){
            $nama = request()->q;
            $prov = $prov->whereHas('aset', function($q) use($nama){
                $q->where('nama', 'like', $nama);
            });
        }

        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->addColumn('nama', function(DesaAset $data){
                return $data->item->nama;
            })
            ->editColumn('jumlah_baik', function(DesaAset $data){
                return number_format($data->jumlah_baik, 0, ',', '.');
            })
            ->editColumn('jumlah_rusak', function(DesaAset $data){
                return number_format($data->jumlah_rusak, 0, ',', '.');
            })
            ->addColumn('aksi', function(DesaAset $data){
                $aksi = '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white btn-edit-aset" data-id="'.$data['iditem'].'">Edit</button>';
                return $aksi;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function chartAset($id){
        $aset = DesaAset::where('id', $id)->get();
        $data['warna_baik'] = 'rgba(143, 247, 45, 0.4)';
        $data['border_baik'] = 'rgba(143, 247, 45, 1)';
        $data['warna_rusak'] = 'rgba(247, 45, 45, 0.4)';
        $data['border_rusak'] = 'rgba(247, 45, 45, 1)';

        $chart = [
            'label'=>[],
            'baik'=>[],
            'rusak'=>[],
        ];
        foreach ($aset as $key => $value) {
            array_push($chart['label'], $value->item->nama);
            array_push($chart['baik'], $value->jumlah_baik);
            array_push($chart['rusak'], $value->jumlah_rusak);
        }

        $data['chart'] = $chart;

        return response()->json($data);
    }

    public function create($id){
        $data['desa'] = $desa = UtilsDesa::where('id', $id)->first();
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == @$desa->kecamatanid) {
            $data['mode'] = 'add';
            return view('back.desa.aset.create-aset', $data);
        }else{
            return back()->with('error', 'Anda tidak memiliki akses ke halaman tersebut!');
        }
    }

    private function getLastIdItem(){
        $last = AsetItem::max('iditem');
        return !empty($last)? $last+1:1;
    }

    public function store(Request $request){
        $input = $request->all();

        $valid = Validator::make($input,
        [
            'id'=>'required',
            'nama'=>'required',
            'baik'=>'required',
            'rusak'=>'required'
        ],
        [
            'required'=>':attribute harus diisi!',
        ],
        [
            'id'=>'Desa',
            'nama'=>'Nama Item',
            'rusak'=>'Jumlah Item Rusak',
            'baik'=>'Jumlah Item Baik'
        ]);

        if(!$valid->fails()){
            $exist = AsetItem::where('nama', $input['nama'])->first();
            $data_master = [
                'iditem'=>@$exist->iditem
            ];

            if(empty($exist)){
                $iditem = $this->getLastIdItem();
                $data_master = [
                    'iditem'=>$iditem,
                    'nama'=>$input['nama'],
                    'ishapus'=>'0',
                ];
            }

            $data_aset = [
                'id'=>$input['id'],
                'iditem'=>$data_master['iditem'],
                'jumlah_baik'=>(int)$input['baik'],
                'jumlah_rusak'=>(int)$input['rusak']
            ];

            $aset_exist = DesaAset::where([['id', $input['id']], ['iditem', $data_master['iditem']]])->first();

            if(!empty($aset_exist)){
                $data_aset['jumlah_baik'] += (int)$aset_exist['jumlah_baik'];
                $data_aset['jumlah_rusak'] += (int)$aset_exist['jumlah_rusak'];
            }

            DB::beginTransaction();
            try {
                if(empty($exist)){
                    DB::table('aset_item')->insert($data_master);
                }

                if (empty($aset_exist)) {
                    DB::table('desa_aset')->insert($data_aset);
                }else{
                    DB::table('desa_aset')->where([['id', $input['id']], ['iditem', $data_master['iditem']]])->update($data_aset);
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
                    'msg'=>'Berhasil menambahkan Aset Desa',
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menambahkan Aset Desa',
                ]);
            }

        }else{
            return response()->json([
                'status'=>500,
                'msg'=>$valid->errors()->first()
            ]);
        }
    }

    public function edit($id, $iditem){
        $data['desa'] = $desa = UtilsDesa::where('id', $id)->first();
        if (Auth::user()->idrole != 5 || @Auth::user()->kecamatan->idkecamatan == @$desa->kecamatanid) {
            $aset = DesaAset::where([['id', $id], ['iditem', $iditem]])->first();
            if(!empty($aset)){
                $data['aset'] = $aset;
                $data['mode'] = 'edit';

                return view('back.desa.aset.create-aset', $data);
            }else{
                return back()->with('error', 'Aset Desa tidak ditemukan');
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
            'iditem'=>'required',
            'baik'=>'required',
            'rusak'=>'required'
        ],
        [
            'required'=>':attribute harus diisi!',
        ],
        [
            'id'=>'Desa',
            'iditem'=>'Aset Item',
            'rusak'=>'Jumlah Item Rusak',
            'baik'=>'Jumlah Item Baik'
        ]);

        if(!$valid->fails()){
            $data_aset = [
                'jumlah_baik'=>(int)$input['baik'],
                'jumlah_rusak'=>(int)$input['rusak']
            ];

            DB::beginTransaction();
            try {
                DB::table('desa_aset')->where([['id', $input['id']], ['iditem', $input['iditem']]])->update($data_aset);
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
                    'msg'=>'Berhasil mengupdate Aset Desa',
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengupdate Aset Desa',
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
