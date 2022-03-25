<?php

namespace App\Http\Controllers\Back\Dokumen;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Dokumen\Dokumen;
use App\Models\Refactored\Dokumen\DokumenKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DokumenKategoriController extends Controller
{
    public function index(){
        return view('back.dokumen.kat-list');
    }

    public function list(){
        DB::statement(DB::raw('set @rownum=0'));
        $dokumen = DokumenKategori::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'idkategori',
            'keterangan'
        ]);

        if(!empty(request()->q)){
            $nama = request()->q;
            $dokumen = $dokumen->where('keterangan', 'like', '%'.$nama.'%');
        }

        $dokumen = $dokumen->get();

        return \Yajra\DataTables\Facades\DataTables::of($dokumen)
            ->addColumn('aksi', function(DokumenKategori $data){
                return '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white" onclick="getDetail('.$data['idkategori'].')">Edit</button>
                        <button class="button button--sm w-24 mr-1 mb-2 bg-theme-6 text-white" onclick="hapusKategori('.$data['idkategori'].')">Hapus</button>';
            })
            ->rawColumns(['status', 'role', 'aksi'])
            ->make(true);
    }

    public function getKategori($id){
        $data = DokumenKategori::where('idkategori', $id)->first();
        if(!empty($data)){
            return response()->json([
                'status'=>200,
                'data'=>[
                    'idkategori'=>$data->idkategori,
                    'ket'=>$data->keterangan,
                ]
            ]);
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Kategori tidak ditemukan'
            ]);
        }
    }

    public function getLastId(){
        $last = DokumenKategori::max('idkategori');
        return !empty($last)? $last+1:1;
    }

    public function store(Request $request){
        $input = $request->all();
        if(!empty($input['ket'])){
            $data_kategori = [
                'idkategori'=>$this->getLastId(),
                'keterangan'=>$input['ket']
            ];
            DB::beginTransaction();
            try {
                DB::table('dokumen_kategori')->insert($data_kategori);
                DB::commit();
                $oke = true;
            } catch (\Exception $th) {
                DB::rollback();
                $oke = false;
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil menyimpan kategori dokumen'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menyimpan kategori dokumen'
                ]);
            }
        }else{
            return repsonse()->json([
                'status'=>500,
                'msg'=>'Nama Kategori harus diisi'
            ]);
        }
    }

    public function update(Request $request, $id){
        $input = $request->all();
        if(!empty($input['ket'])){
            $data_kategori = [
                'keterangan'=>$input['ket']
            ];
            DB::beginTransaction();
            try {
                DB::table('dokumen_kategori')->where('idkategori', $id)->update($data_kategori);
                DB::commit();
                $oke = true;
            } catch (\Exception $th) {
                DB::rollback();
                $oke = false;
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil mengupdate kategori dokumen'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengupdate kategori dokumen'
                ]);
            }
        }else{
            return repsonse()->json([
                'status'=>500,
                'msg'=>'Nama Kategori harus diisi'
            ]);
        }
    }

    public function delete($id){
        $data = DokumenKategori::where('idkategori', $id)->first();
        if(!empty($data)){
            DB::beginTransaction();
            try {
                DB::table('dokumen_kategori')->where('idkategori', $id)->delete();
                DB::commit();
                $oke = true;
            } catch (\Exception $th) {
                DB::rollback();
                $oke = false;
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil menghapus kategori dokumen'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal menghapus kategori dokumen'
                ]);
            }
        }else{
            return repsonse()->json([
                'status'=>500,
                'msg'=>'Kategori tidak ditemukan'
            ]);
        }
    }
}
