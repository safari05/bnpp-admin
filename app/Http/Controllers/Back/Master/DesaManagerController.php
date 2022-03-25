<?php

namespace App\Http\Controllers\Back\Master;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Utils\UtilsDesa;
use App\Models\Refactored\Utils\UtilsKecamatan;
use App\Models\Refactored\Utils\UtilsKota;
use App\Models\Refactored\Utils\UtilsProvinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DesaManagerController extends Controller
{
    public function index(){
        $temp = UtilsProvinsi::get();

        if(Auth::user()->idrole == 5){
            $temp = UtilsProvinsi::where('id', Auth::user()->kecamatan->kecamatan->kota->provinsiid)->get();
        }

        $data['provinces'] = $temp;
        return view('back.master.desa', $data);
    }

    public function listKota(){
        $kota = UtilsKota::select(['id', 'name']);
        if(!empty(request()->provid)){
            $kota = $kota->where('provinsiid', request()->provid);
        }else{
            $kota = $kota->where('provinsiid', '11');
        }

        if(Auth::user()->idrole == 5){
            $kota = $kota->where('id', Auth::user()->kecamatan->kecamatan->kotaid);
        }

        $kota = $kota->get()->toArray();
        return response()->json($kota);
    }

    public function listKecamatan(){
        $kec = UtilsKecamatan::select(['id', 'name']);
        if(!empty(request()->kotaid)){
            $kec = $kec->where('kotaid', request()->kotaid);
        }else{
            $kec = $kec->where('kotaid', '1101');
        }

        if(Auth::user()->idrole == 5){
            $kec = $kec->where('id', Auth::user()->kecamatan->idkecamatan);
        }

        $kec = $kec->get()->toArray();
        return response()->json($kec);
    }

    public function list(){
        DB::statement(DB::raw('set @rownum=0'));
        $prov = UtilsDesa::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'kecamatanid',
            'name',
            'active'
        ])->whereIn('active', ['0','1']);        

        if(Auth::user()->idrole == 5){
            $prov = $prov->where('kecamatanid', Auth::user()->kecamatan->idkecamatan);
        }

        if(!empty(request()->q)){
            $prov = $prov->where('name', 'like', '%'.request()->q.'%');
        }

        if(!empty(request()->provid)){
            $id = request()->provid;
            $prov = $prov->whereHas('kecamatan', function($q) use($id){
                $q->whereHas('kota', function($r) use ($id){
                    $r->where('provinsiid', $id);
                });
            });
        }else{
            $prov = $prov->where('kecamatanid', 'like', '1101%');
        }

        if(!empty(request()->kotaid)){
            $idkota = request()->kotaid;
            $prov = $prov->whereHas('kecamatan', function($q) use($idkota){
                $q->where('kotaid', $idkota);
            });
        }else{
            $prov = $prov->where('kecamatanid', 'like', '1101%');
        }

        if(!empty(request()->kecid)){
            $prov = $prov->where('kecamatanid', request()->kecid);
        }

        if(!empty(request()->active) || request()->active == '0'){
            $prov = $prov->where('active', request()->active);
        }

        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->addColumn('kota', function(UtilsDesa $data){
                return $data->kecamatan->kota->name.', '.$data->kecamatan->kota->provinsi->name;
            })
            ->addColumn('kec', function(UtilsDesa $data){
                return $data->kecamatan->name;
            })
            ->addColumn('aksi', function(UtilsDesa $data){
                $aksi = '';
                if($data['active'] == 1){
                    return $aksi.'<button class="button button--sm w-24 mr-1 mb-2 bg-theme-6 text-white btn-deactive" data-id="'.$data['id'].'">Deaktifasi</button>';
                }else{
                    return $aksi.'<button class="button button--sm w-24 mr-1 mb-2 bg-theme-9 text-white btn-active" data-id="'.$data['id'].'">Aktivasi</button>';
                }
            })
            ->addColumn('status', function(UtilsDesa $data){
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
                DB::table('utils_desa')->where('id', $input['id'])->update([
                    'active'=>$input['active']
                ]);
                DB::table('desa_detail')->updateOrInsert(
                    ['id'=>$input['id']],
                    ['id'=>$input['id']]
                );
                DB::commit();
                $oke = true;
            } catch (\Exception $th) {
                DB::rollback();
                $oke = false;
            }

            if($oke){
                return response()->json([
                    'status'=>200,
                    'msg'=>'Berhasil mengubah status Desa'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengubah status Desa'
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
