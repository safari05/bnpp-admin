<?php

namespace App\Http\Controllers\Back\Master;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Kecamatan\KecamatanDetail;
use App\Models\Refactored\Kecamatan\KecamatanLokpri;
use App\Models\Refactored\Kecamatan\KecamatanType;
use App\Models\Refactored\Utils\UtilsKecamatan;
use App\Models\Refactored\Utils\UtilsKota;
use App\Models\Refactored\Utils\UtilsProvinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KecamatanManagerController extends Controller
{
    public function index(){
        $data['provinces'] = UtilsProvinsi::get();
        $data['tipe'] = KecamatanType::all();
        $data['lokpri'] = KecamatanLokpri::all();
        return view('back.master.kecamatan', $data);
    }

    public function listKota(){
        $kota = UtilsKota::select(['id', 'name']);
        if(!empty(request()->provid)){
            $kota = $kota->where('provinsiid', request()->provid);
        }else{
            $kota = $kota->where('provinsiid', '11');
        }

        $kota = $kota->get()->toArray();
        return response()->json($kota);
    }

    public function list(){
        DB::statement(DB::raw('set @rownum=0'));
        $prov = UtilsKecamatan::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'kotaid',
            'name',
            'active'
        ])->whereIn('active', ['0','1']);

        if(!empty(request()->q)){
            $prov = $prov->where('name', 'like', '%'.request()->q.'%');
        }

        if(!empty(request()->provid)){
            $id = request()->provid;
            $prov = $prov->whereHas('kota', function($q) use($id){
                $q->where('provinsiid', $id);
            });
        }else{
            $prov = $prov->where('kotaid', 'like', '11%');
        }

        if(!empty(request()->kotaid)){
            $prov = $prov->where('kotaid', request()->kotaid);
        }

        if(!empty(request()->active) || request()->active == '0'){
            $prov = $prov->where('active', request()->active);
        }

        // if(!empty(request()->tipe)){
        //     $tipe = request()->tipe;
        //     $prov = $prov->whereHas('detail', function($q) use($tipe){
        //         $q->where('typeid', 'like', '%'.$tipe.'%');
        //     });
        // }

        if(!empty(request()->lokpri)){
            $lokpri = request()->lokpri;
            $prov = $prov->whereHas('detail', function($q) use($lokpri){
                $q->where('lokpriid', 'like', '%'.$lokpri.'%');
            });
        }

        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->addColumn('provinsi', function(UtilsKecamatan $data){
                return $data->kota->provinsi->name;
            })
            ->addColumn('kota', function(UtilsKecamatan $data){
                return $data->kota->name;
            })
            ->addColumn('aksi', function(UtilsKecamatan $data){
                $tipe = $data->kecamatan->typeid??'';
                // $aksi = '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white btn-type" onclick="ubahTipe(\''.$data['id'].'\')">Tipe</button>';
                $aksi = '<button class="button button--sm w-24 mr-1 mb-2 bg-theme-1 text-white btn-lokpri" onclick="ubahLokpri(\''.$data['id'].'\')">Lokpri</button>';
                if($data['active'] == 1){
                    return $aksi.'<button class="button button--sm w-24 mr-1 mb-2 bg-theme-6 text-white btn-deactive" data-id="'.$data['id'].'">Deaktifasi</button>';
                }else{
                    return $aksi.'<button class="button button--sm w-24 mr-1 mb-2 bg-theme-9 text-white btn-active" data-id="'.$data['id'].'">Aktivasi</button>';
                }
            })
            ->addColumn('status', function(UtilsKecamatan $data){
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
                DB::table('utils_kecamatan')->where('id', $input['id'])->update([
                    'active'=>$input['active']
                ]);
                DB::table('kecamatan_detail')->updateOrInsert(
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
                    'msg'=>'Berhasil mengubah status kecamatan'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengubah status kecamatan'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Provinsi tidak ditemukan'
            ]);
        }
    }

    public function changeType(Request $request){
        $input = $request->all();
        if(!empty($input['id'])){
            DB::beginTransaction();
            try {
                DB::table('kecamatan_detail')->updateOrInsert(
                    ['id' => $input['id']],
                    ['id' => $input['id'], 'typeid'=>$input['tipe']]
                );
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
                    'msg'=>'Berhasil mengubah tipe kecamatan'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengubah tipe kecamatan'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Provinsi tidak ditemukan'
            ]);
        }
    }

    public function changeLokpri(Request $request){
        $input = $request->all();
        if(!empty($input['id'])){
            DB::beginTransaction();
            try {
                DB::table('kecamatan_detail')->updateOrInsert(
                    ['id' => $input['id']],
                    ['id' => $input['id'], 'lokpriid'=>$input['lokpri']]
                );
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
                    'msg'=>'Berhasil mengubah lokpri kecamatan'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'msg'=>'Gagal mengubah lokpri kecamatan'
                ]);
            }
        }else{
            return response()->json([
                'status'=>500,
                'msg'=>'Provinsi tidak ditemukan'
            ]);
        }
    }

    public function getDetail($id){
        $kec = KecamatanDetail::where('id', $id)->first();
        $data = [
            'tipe' => [],
            'lokpri' => []
        ];

        if (!empty($kec)) {
            $data = [
                'tipe'=>explode(',', $kec->typeid),
                'lokpri'=>explode(',', $kec->lokpriid),
            ];
        }
        return response()->json($data);
    }
}
