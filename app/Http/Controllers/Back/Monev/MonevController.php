<?php

namespace App\Http\Controllers\Back\Monev;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Monev\DataMonevs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonevController extends Controller
{
    public function index(){
        return view('back.monev.monev-list');
    }

    public function list(){
        DB::statement(DB::raw('set @rownum=0'));
            
        $monev = DataMonevs::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id', 'nama', 'jabatan', 'provinsi', 'kabupaten', 'kecamatan', 'rata_rata_ciq', 'rata_rata_pap', 'created_at', 'updated_at',
            'alamat_kantor', 'email', 'no_hp', 'lokpri_batas_darat', 'lokpri_batas_laut', 'lokpri_pksn_darat', 'lokpri_pksn_laut', 'lokpri_ppkt'
        ])->whereHas('detail');

        if(!empty(request()->tahun)){
            $monev  = $monev->where('created_at', 'like', request()->tahun.'%');
        }

        if(!empty(request()->q)){
            $monev = $monev->where('kecamatan', 'LIKE', '%'.request()->q.'%');
        }

        $monev = $monev->get();

        return \Yajra\DataTables\Facades\DataTables::of($monev)
            ->editColumn('created_at', function(DataMonevs $data){
                return Carbon::parse($data['created_at'])->locale('id')->translatedFormat('d M Y @ H:i:s');
            })
            ->editColumn('lokpri_batas_darat', function(DataMonevs $data){ return ($data['lokpri_batas_darat'] == 1)? 'Ya':'Tidak'; })
            ->editColumn('lokpri_batas_laut', function(DataMonevs $data){ return ($data['lokpri_batas_laut'] == 1)? 'Ya':'Tidak'; })
            ->editColumn('lokpri_pksn_darat', function(DataMonevs $data){ return ($data['lokpri_pksn_darat'] == 1)? 'Ya':'Tidak'; })
            ->editColumn('lokpri_pksn_laut', function(DataMonevs $data){ return ($data['lokpri_pksn_laut'] == 1)? 'Ya':'Tidak'; })
            ->editColumn('lokpri_ppkt', function(DataMonevs $data){ return ($data['lokpri_ppkt'] == 1)? 'Ya':'Tidak'; })
            ->addColumn('aksi', function(DataMonevs $data){ 
                return '<a href="'.url('monev/detail').'/'.$data['id'].'"><button class="button px-2 mr-1 mb-2 bg-theme-9 text-white tooltip" title="Lihat Detail Monev"> <span class="w-5 h-5 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg> 
                        </span> </button></a>';
            })
            ->rawColumns(['aksi'])
            ->make(true);

    }
}
