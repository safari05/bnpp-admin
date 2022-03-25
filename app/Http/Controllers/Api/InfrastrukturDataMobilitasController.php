<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Refactored\Desa\DesaMobilitas;
use App\Models\Refactored\Kecamatan\KecamatanMobilitas;
use App\Models\Refactored\Utils\UtilsDesa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InfrastrukturDataMobilitasController extends Controller
{
    public function datatableKecamatan($id)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $prov = KecamatanMobilitas::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'idmobilitas',
            'jumlah',
            'foto',
        ])->where('id', $id);

        if(!empty(request()->q)){
            $nama = request()->q;
            $prov = $prov->whereHas('mobilitas', function($q) use($nama){
                $q->where('nama', 'like', '%'.$nama.'%');
            });
        }

        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->addColumn('nama', function(KecamatanMobilitas $data){
                return $data->item->nama;
            })
            ->editColumn('jumlah', function(KecamatanMobilitas $data){
                return number_format($data->jumlah, 0, ',', '.');
            })
            ->editColumn('foto', function(KecamatanMobilitas $data){
                if(empty($data['foto'])){
                    return 'Tidak tersedia';
                }else{
                    return '<button class="btn btn-info btn-sm btn-foto-mobil" data-toggle="tooltip" data-placement="bottom" title="Lihat Gambar" data-url="'.asset('upload/mobilitas').'/'.$data['foto'].'"><i class="fa fa-image text-white"></i></button>';
                }
                return number_format($data->jumlah, 0, ',', '.');
            })
            ->rawColumns(['foto'])
            ->make(true);
    }

    public function datatableKelurahan($id)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $prov = DesaMobilitas::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'idmobilitas',
            'jumlah',
            'foto',
        ])
            ->where('id', $id);

        if(!empty(request()->q)){
            $nama = request()->q;
            $prov = $prov->whereHas('mobilitas', function($q) use($nama){
                $q->where('nama', 'like', '%'.$nama.'%');
            });
        }

        $prov = $prov->get();

        return \Yajra\DataTables\Facades\DataTables::of($prov)
            ->addColumn('nama', function(DesaMobilitas $data){
                return $data->item->nama;
            })
            ->editColumn('jumlah', function(DesaMobilitas $data){
                return number_format($data->jumlah, 0, ',', '.');
            })
            ->editColumn('foto', function(DesaMobilitas $data){
                if(empty($data['foto'])){
                    return 'Tidak tersedia';
                }else{
                    return '<button class="btn btn-info btn-sm btn-foto-mobil" data-toggle="tooltip" data-placement="bottom" title="Lihat Gambar" data-url="'.asset('upload/mobilitas').'/'.$data['foto'].'"><i class="fa fa-image text-white"></i></button>';
                }
                return number_format($data->jumlah, 0, ',', '.');
            })
            ->rawColumns(['foto'])
            ->make(true);
    }
}
