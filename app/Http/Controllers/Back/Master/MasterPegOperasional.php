<?php

namespace App\Http\Controllers\Back\Master;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Kepegawaian\KepegawaianOperasional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterPegOperasional extends Controller
{

    public function index(){
        return view('back.master.operasional');
    }

    public function list(){
        DB::statement(DB::raw('set @rownum=0'));
        $aset = KepegawaianOperasional::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'idoperasional',
            'keterangan',
            'canDelete'
        ]);

        if(!empty(request()->q)){
            $aset = $aset->where('keterangan', 'like', '%'.request()->q.'%');
        }

        $aset = $aset->get();

        return \Yajra\DataTables\Facades\DataTables::of($aset)
            ->addColumn('aksi', function(KepegawaianOperasional $data){
                if ($data['canDelete']== 1) {
                    return '<button class="button w-24 mr-1 mb-2 bg-theme-6 col-span-2 text-white" onclick="hapusAset('.$data['idoperasional'].')">Hapus</button>';
                }else{
                    return 'Tidak tersedia';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    private function getLastId(){
        $last = KepegawaianOperasional::max('idoperasional');
        return !empty($last)? $last+1:1;
    }

    public function store(Request $request){
        $input = $request->all();
        if(!empty($input['keterangan'])){
            $data_aset = [
                'idoperasional'=>$this->getLastId(),
                'keterangan'=>$input['keterangan'],
                'canDelete'=>1,
            ];

            $exist = KepegawaianOperasional::where('keterangan', $input['keterangan'])->first();
            DB::beginTransaction();
            try {
                if (empty($exist)) {
                    DB::table('kepegawaian_operasional')->insert($data_aset);
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
                    'msg'=>'Berhasil menambahkan Jenis Kelembagaan'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menambahkan Jenis Kelembagaan'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Nama Kelembagaan harus diisi'
            ]);
        }
    }

    public function delete($id){
        $aset = KepegawaianOperasional::where([['idoperasional', $id], ['canDelete', 1]])->first();
        if(!empty($aset)){
            DB::beginTransaction();
            try {
                DB::table('kepegawaian_operasional')->where('idoperasional', $id)->delete();
                DB::commit();
                $oke = true;
            } catch (\Exception $th) {
                DB::rollback();
                $oke = false;
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil menghapus Jenis Kelembagaan'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menghapus Jenis Kelembagaan'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Jenis Kelembagaan tidak ditemukan'
            ]);
        }
    }
}
