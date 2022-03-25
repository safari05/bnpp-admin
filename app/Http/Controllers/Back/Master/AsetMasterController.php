<?php

namespace App\Http\Controllers\Back\Master;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Master\AsetItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsetMasterController extends Controller
{
    public function index(){
        return view('back.master.aset');
    }

    public function list(){
        DB::statement(DB::raw('set @rownum=0'));
        $aset = AsetItem::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'iditem',
            'nama',
        ]);

        if(!empty(request()->q)){
            $aset = $aset->where('nama', 'like', '%'.request()->q.'%');
        }

        $aset = $aset->get();

        return \Yajra\DataTables\Facades\DataTables::of($aset)
            ->addColumn('aksi', function(AsetItem $data){
                return '<button class="button w-24 mr-1 mb-2 bg-theme-6 col-span-2 text-white" onclick="hapusAset('.$data['iditem'].')">Hapus</button>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    private function getLastId(){
        $last = AsetItem::max('iditem');
        return !empty($last)? $last+1:1;
    }

    public function store(Request $request){
        $input = $request->all();
        if(!empty($input['nama'])){
            $data_aset = [
                'iditem'=>$this->getLastId(),
                'nama'=>$input['nama'],
                'ishapus'=>0,
            ];

            $exist = AsetItem::where('nama', $input['nama'])->first();
            DB::beginTransaction();
            try {
                if (empty($exist)) {
                    DB::table('aset_item')->insert($data_aset);
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
                    'msg'=>'Berhasil menambahkan aset'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menambahkan aset'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Nama Aset harus diisi'
            ]);
        }
    }

    public function delete($id){
        $aset = AsetItem::where('iditem', $id)->first();
        if(!empty($aset)){
            DB::beginTransaction();
            try {
                DB::table('aset_item')->where('iditem', $id)->delete();
                DB::commit();
                $oke = true;
            } catch (\Exception $th) {
                DB::rollback();
                $oke = false;
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil menghapus aset'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menghapus aset'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Aset tidak ditemukan'
            ]);
        }
    }
}
