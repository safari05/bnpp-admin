<?php

namespace App\Http\Controllers\Back\Master;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Utils\UtilsProvinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvinsiManagerController extends Controller
{
    public function index(){
        return view('back.master.provinsi');
    }

    public function list(){
        DB::statement(DB::raw('set @rownum=0'));
        $prov = UtilsProvinsi::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'name',
            'active'
        ])->whereIn('active', ['0','1']);

        if(!empty(request()->q)){
            $prov = $prov->where('name', 'like', '%'.request()->q.'%');
        }
        if(!empty(request()->active) || request()->active == '0'){
            $prov = $prov->where('active', request()->active);
        }

        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->addColumn('aksi', function(UtilsProvinsi $data){
                if($data['active'] == 1){
                    return '<button class="button w-24 mr-1 mb-2 bg-theme-6 text-white btn-deactive" data-id="'.$data['id'].'">Deaktifasi</button>';
                }else{
                    return '<button class="button w-24 mr-1 mb-2 bg-theme-9 text-white btn-active" data-id="'.$data['id'].'">Aktivasi</button>';
                }
            })
            ->addColumn('status', function(UtilsProvinsi $data){
                if($data['active'] == 1){
                    return '<span class="text-theme-9">Aktif</span>';
                }else{
                    return '<button class="text-theme-6">Tidak Aktif</button>';
                }
            })
            ->rawColumns(['status', 'aksi'])
            ->make(true);

    }

    public function changeActive(Request $request){
        $input = $request->all();
        if(!empty($input['id']) && (!empty($input['active'] || $input['active'] == 0))){
            DB::beginTransaction();
            try {
                DB::table('utils_provinsi')->where('id', $input['id'])->update([
                    'active'=>$input['active']
                ]);
                DB::commit();
                $oke = true;
            } catch (\Exception $th) {
                DB::rollback();
                $oke = false;
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil mengubah status provinsi'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengubah status provinsi'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Provinsi tidak ditemukan'
            ]);
        }
    }
}
