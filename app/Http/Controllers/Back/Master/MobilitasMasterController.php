<?php

namespace App\Http\Controllers\Back\Master;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Master\MobilitasItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MobilitasMasterController extends Controller
{

    public function index(){
        return view('back.master.mobilitas');
    }

    public function list(){
        DB::statement(DB::raw('set @rownum=0'));
        $aset = MobilitasItem::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'idmobilitas',
            'nama',
        ]);

        if(!empty(request()->q)){
            $aset = $aset->where('nama', 'like', '%'.request()->q.'%');
        }

        $aset = $aset->get();

        return \Yajra\DataTables\Facades\DataTables::of($aset)
            ->addColumn('aksi', function(MobilitasItem $data){
                return '<button class="button w-24 mr-1 mb-2 bg-theme-6 col-span-2 text-white" onclick="hapusAset('.$data['idmobilitas'].')">Hapus</button>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    private function getLastId(){
        $last = MobilitasItem::max('idmobilitas');
        return !empty($last)? $last+1:1;
    }

    public function store(Request $request){
        $input = $request->all();
        if(!empty($input['nama'])){
            $data_aset = [
                'idmobilitas'=>$this->getLastId(),
                'nama'=>$input['nama'],
                'ishapus'=>0,
            ];

            $exist = MobilitasItem::where('nama', $input['nama'])->first();
            DB::beginTransaction();
            try {
                if (empty($exist)) {
                    DB::table('mobilitas_item')->insert($data_aset);
                }
                DB::commit();
                $oke = true;
            } catch (\Exception $th) {
                DB::rollback();
                $oke = false;
                dd($th);
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil menambahkan Mobilitas'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menambahkan Mobilitas'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Nama Mobilitas harus diisi'
            ]);
        }
    }

    public function delete($id){
        $aset = MobilitasItem::where('idmobilitas', $id)->first();
        if(!empty($aset)){
            DB::beginTransaction();
            try {
                DB::table('mobilitas_item')->where('idmobilitas', $id)->delete();
                DB::commit();
                $oke = true;
            } catch (\Exception $th) {
                DB::rollback();
                $oke = false;
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil menghapus Mobilitas'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menghapus Mobilitas'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Mobilitas tidak ditemukan'
            ]);
        }
    }
}
