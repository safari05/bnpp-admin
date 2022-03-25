<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Kecamatan\KecamatanLokpri;
use App\Models\Refactored\Kecamatan\KecamatanType;
use App\Models\Refactored\Utils\UtilsDesa;
use App\Models\Refactored\Utils\UtilsKecamatan;
use Illuminate\Support\Facades\DB;

class InfrastrukturDataController extends Controller
{
    public function datatableKecamatan()
    {
        DB::statement(DB::raw('set @rownum=0'));
        $prov = UtilsKecamatan::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'kotaid',
            'name',
            'active',
        ])
            ->where('active', 1)
            ->whereHas('kota', function($q){
                $q->where('active', 1)->whereHas('provinsi', function($r){
                    $r->where('active', 1);
                });
            });

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

        if(!empty(request()->tipe)){
            $tipe = request()->tipe;
            $prov = $prov->whereHas('detail', function($q) use($tipe){
                $q->where('typeid', 'like', '%'.$tipe.'%');
            });
        }

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
            ->addColumn('tipe', function(UtilsKecamatan $data){
                $cur_types = explode(',', $data->detail->typeid);

                $tipe = KecamatanType::select(['typeid', 'nickname'])->whereIn('typeid', $cur_types)->get()->toArray();
                $badges = '';
                foreach ($tipe as $key => $value) {
                    if ($value['typeid'] == 1) {
                        $badges .= '<span class="badge badge-success p-2 mx-1">'.$value['nickname'].'</span>';
                    }else if ($value['typeid'] == 2) {
                        $badges .= '<span class="badge badge-warning p-2 mx-1">'.$value['nickname'].'</span>';
                    }else {
                        $badges .= '<span class="badge badge-danger p-2 mx-1">'.$value['nickname'].'</span>';
                    }
                }
                return !empty($badges)? $badges:'<span class="badge badge-light p-2 mx-1">Data tidak tersedia</span>';
            })
            ->addColumn('lokpri', function(UtilsKecamatan $data){
                $cur_lokpri = explode(',', $data->detail->lokpriid);

                $tipe = KecamatanLokpri::select('lokpriid', 'nickname')->whereIn('lokpriid', $cur_lokpri)->get()->toArray();
                $badges = '';
                foreach ($tipe as $key => $value) {
                    if ($value['lokpriid'] == 1) {
                        $badges .= '<span class="badge badge-success p-2 mx-1">'.$value['nickname'].'</span>';
                    }else if ($value['lokpriid'] == 2) {
                        $badges .= '<span class="badge badge-warning p-2 mx-1">'.$value['nickname'].'</span>';
                    }else {
                        $badges .= '<span class="badge badge-danger p-2 mx-1">'.$value['nickname'].'</span>';
                    }
                }
                return !empty($badges)? $badges:'<span class="badge badge-light p-2 mx-1">Data tidak tersedia</span>';
            })
            ->addColumn('kota', function(UtilsKecamatan $data){
                return $data->kota->name;
            })
            ->addColumn('aksi', function(UtilsKecamatan $data){
                return '<a class="btn btn-primary btn-sm text-white mr-1" data-toggle="tooltip" data-placement="bottom" title="Lihat Data" href="'.url('infrastruktur-data/kecamatan/'.$data['id']).'"><i class="fa fa-table text-white"></i></a>'
                . '<a class="btn btn-warning btn-sm text-white" data-toggle="tooltip" data-placement="bottom" title="Lihat Grafik" href="'.url('infrastruktur-grafik/kecamatan/'.$data['id']).'"><i class="fa fa-bar-chart-o text-white"></i></a>';
            })
            ->rawColumns(['tipe', 'lokpri', 'aksi'])
            ->make(true);
    }

    public function datatableKelurahan()
    {
        DB::statement(DB::raw('set @rownum=0'));
        $prov = UtilsDesa::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'kecamatanid',
            'name',
            'active'
        ])->where('active', '1');

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
                return '<a class="btn btn-primary btn-sm text-white mr-1" data-toggle="tooltip" data-placement="bottom" title="Lihat Data" href="'.url('infrastruktur-data/kelurahan/'.$data['id']).'"><i class="fa fa-table text-white"></i></a>'
                . '<a class="btn btn-warning btn-sm text-white" data-toggle="tooltip" data-placement="bottom" title="Lihat Grafik" href="'.url('infrastruktur-grafik/kelurahan/'.$data['id']).'"><i class="fa fa-bar-chart-o text-white"></i></a>';

            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
