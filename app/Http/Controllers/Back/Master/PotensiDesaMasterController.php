<?php

namespace App\Http\Controllers\Back\Master;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Master\PondesJenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PotensiDesaMasterController extends Controller
{
    public function index(){
        return view('back.master.pondes');
    }

    public function srcAutocomplete(){
        $data = PondesJenis::get()->pluck('keterangan')->toArray();
        return response()->json($data);
    }

    public function list(){
        DB::statement(DB::raw('set @rownum=0'));
        $aset = PondesJenis::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'idjenis',
            'keterangan',
            'canDelete'
        ]);

        if(!empty(request()->q)){
            $aset = $aset->where('keterangan', 'like', '%'.request()->q.'%');
        }

        $aset = $aset->get();

        return \Yajra\DataTables\Facades\DataTables::of($aset)
            ->addColumn('aksi', function(PondesJenis $data){
                if ($data['canDelete']== 1) {
                    return '<button class="button w-24 mr-1 mb-2 bg-theme-6 col-span-2 text-white" onclick="hapusAset('.$data['idjenis'].')">Hapus</button>';
                }else{
                    return 'Tidak tersedia';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    private function getLastId(){
        $last = PondesJenis::max('idjenis');
        return !empty($last)? $last+1:1;
    }

    public function store(Request $request){
        $input = $request->all();
        if(!empty($input['keterangan'])){
            $data_aset = [
                'idjenis'=>$this->getLastId(),
                'keterangan'=>$input['keterangan'],
                'canDelete'=>1,
            ];

            $exist = PondesJenis::where('keterangan', $input['keterangan'])->first();
            DB::beginTransaction();
            try {
                if (empty($exist)) {
                    DB::table('pondes_jenis')->insert($data_aset);
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
                    'msg'=>'Berhasil menambahkan Potensi Desa'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menambahkan Potensi Desa'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Nama Potensi Desa harus diisi'
            ]);
        }
    }

    public function delete($id){
        $aset = PondesJenis::where([['idjenis', $id], ['canDelete', 1]])->first();
        if(!empty($aset)){
            DB::beginTransaction();
            try {
                DB::table('pondes_jenis')->where('idjenis', $id)->delete();
                DB::commit();
                $oke = true;
            } catch (\Exception $th) {
                DB::rollback();
                $oke = false;
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil menghapus Potensi Desa'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menghapus Potensi Desa'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Potensi Desa tidak ditemukan'
            ]);
        }
    }
}
